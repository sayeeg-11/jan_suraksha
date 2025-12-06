<?php
require_once __DIR__ . '/../../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['admin_id'])) {
    http_response_code(403);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

$out = [];

// helper to run queries and log DB errors without crashing the API
function run_query_api($sql){
    global $mysqli;
    $res = $mysqli->query($sql);
    if($res === false){
        error_log("API DB query failed: " . $mysqli->error . " -- SQL: " . $sql);
        return false;
    }
    return $res;
}

// 1. Top-Level Metrics
$out['totals'] = [];
$res = run_query_api("SELECT COUNT(*) AS c FROM complaints");
$out['totals']['total'] = $res ? (int) ($res->fetch_assoc()['c'] ?? 0) : 0;
$res = run_query_api("SELECT COUNT(*) AS c FROM complaints WHERE status='Pending'");
$out['totals']['pending'] = $res ? (int) ($res->fetch_assoc()['c'] ?? 0) : 0;
$res = run_query_api("SELECT COUNT(*) AS c FROM complaints WHERE status='Resolved'");
$out['totals']['resolved'] = $res ? (int) ($res->fetch_assoc()['c'] ?? 0) : 0;
$res = run_query_api("SELECT COUNT(*) AS c FROM criminals");
$out['totals']['criminals'] = $res ? (int) ($res->fetch_assoc()['c'] ?? 0) : 0;

// 2. State-wise Crime Hotspots
$out['state_hotspots'] = [];
$state_q = run_query_api("SELECT state, COUNT(*) as count FROM complaints WHERE state IS NOT NULL AND state != '' GROUP BY state ORDER BY count DESC LIMIT 4");
$out['total_state_complaints'] = 0;
$res = run_query_api("SELECT COUNT(*) as c FROM complaints WHERE state IS NOT NULL AND state != ''");
$out['total_state_complaints'] = $res ? (int) ($res->fetch_assoc()['c'] ?? 0) : 0;
if($state_q){ while ($r = $state_q->fetch_assoc()) { $out['state_hotspots'][] = $r; } }

// 3. Daily Reports (Last 30 days)
$out['daily'] = ['labels' => [], 'data' => []];
$daily_q = run_query_api("SELECT DATE(created_at) as report_date, COUNT(*) as count FROM complaints WHERE created_at >= CURDATE() - INTERVAL 30 DAY GROUP BY report_date ORDER BY report_date ASC");
if($daily_q){ while ($r = $daily_q->fetch_assoc()){ $out['daily']['labels'][] = date('M d', strtotime($r['report_date'])); $out['daily']['data'][] = (int) $r['count']; } }

// 4. Crime Category Breakdown
$out['category'] = ['labels' => [], 'data' => []];
$cat_q = run_query_api("SELECT crime_type, COUNT(*) as count FROM complaints GROUP BY crime_type ORDER BY count DESC LIMIT 5");
if($cat_q){ while ($r = $cat_q->fetch_assoc()){ $out['category']['labels'][] = $r['crime_type']; $out['category']['data'][] = (int) $r['count']; } }

// Status distribution
$out['status_counts'] = [];
$status_q = run_query_api("SELECT status, COUNT(*) as count FROM complaints GROUP BY status");
if($status_q){ while ($r = $status_q->fetch_assoc()){ $out['status_counts'][$r['status']] = (int) $r['count']; } }

// 5. Recent Activity Feed
$out['recent_activity'] = [];
$recent_q = run_query_api("SELECT complaint_code, crime_type, created_at FROM complaints ORDER BY created_at DESC LIMIT 5");
if($recent_q){ while ($r = $recent_q->fetch_assoc()) { $out['recent_activity'][] = $r; } }

echo json_encode($out);

?>
