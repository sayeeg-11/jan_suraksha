<?php
require_once __DIR__ . '/../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(empty($_SESSION['admin_id'])){ header('Location: index.php'); exit; }

function run_query($sql){
    global $mysqli;
    $res = $mysqli->query($sql);
    if($res === false){
        error_log("DB query failed: " . $mysqli->error . " -- SQL: " . $sql);
        return false;
    }
    return $res;
}

$current_page = basename($_SERVER['PHP_SELF']);

// 1. Top-Level Metrics
$total = run_query("SELECT COUNT(*) AS c FROM complaints") ? run_query("SELECT COUNT(*) AS c FROM complaints")->fetch_assoc()['c'] ?? 0 : 0;
$pending = run_query("SELECT COUNT(*) AS c FROM complaints WHERE status='Pending'") ? run_query("SELECT COUNT(*) AS c FROM complaints WHERE status='Pending'")->fetch_assoc()['c'] ?? 0 : 0;
$investigating = run_query("SELECT COUNT(*) AS c FROM complaints WHERE status='In Progress'") ? run_query("SELECT COUNT(*) AS c FROM complaints WHERE status='In Progress'")->fetch_assoc()['c'] ?? 0 : 0;
$resolved = run_query("SELECT COUNT(*) AS c FROM complaints WHERE status='Resolved'") ? run_query("SELECT COUNT(*) AS c FROM complaints WHERE status='Resolved'")->fetch_assoc()['c'] ?? 0 : 0;
$criminals = run_query("SELECT COUNT(*) AS c FROM criminals") ? run_query("SELECT COUNT(*) AS c FROM criminals")->fetch_assoc()['c'] ?? 0 : 0;

// 2. Crime Category Breakdown
$category_query = run_query("SELECT crime_type, COUNT(*) as count FROM complaints GROUP BY crime_type ORDER BY count DESC LIMIT 5");
$category_labels = []; $category_data = [];
if($category_query){
    while($row = $category_query->fetch_assoc()){
        $category_labels[] = $row['crime_type'];
        $category_data[] = $row['count'];
    }
}

// 3. Recent Complaints
$recent_complaints = run_query("SELECT c.id, c.complaint_code, c.crime_type, c.status, c.created_at, u.name as complainant 
                                FROM complaints c LEFT JOIN users u ON c.user_id = u.id 
                                ORDER BY c.created_at DESC LIMIT 8");
?>

<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Command Center - Jan Suraksha Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --glass-bg: rgba(37, 99, 235, 0.1);
            --glass-border: rgba(37, 99, 235, 0.2);
        }

        * { font-family: 'Inter', sans-serif; }
        body { 
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px; 
            background: linear-gradient(180deg, #111827 0%, #1f2937 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(55, 65, 81, 0.5);
            box-shadow: 5px 0 25px rgba(0,0,0,0.3);
        }
        .sidebar-header { 
            background: linear-gradient(135deg, #2563eb, #1d4ed8); 
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-nav .nav-link {
            color: #9ca3af; 
            padding: 1rem 2rem; 
            margin: 0.25rem 1rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            font-weight: 500;
        }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(37,99,235,0.2), rgba(29,78,216,0.3));
            color: white;
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(37,99,235,0.3);
        }
        .sidebar-nav .nav-link i {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            width: 24px;
            margin-right: 1rem;
        }

        /* Topbar */
        .topbar { 
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(55, 65, 81, 0.5);
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        /* Metric Cards */
        .metric-card {
            background: linear-gradient(145deg, rgba(31,41,55,0.8), rgba(17,24,39,0.9));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(37,99,235,0.3);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            position: relative;
            overflow: hidden;
        }
        .metric-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 4px;
            background: var(--primary-gradient);
        }
        .metric-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(37,99,235,0.4);
            border-color: rgba(37,99,235,0.6);
        }
        .metric-card .icon {
            font-size: 3rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }
        .metric-badge {
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        /* Quick Actions */
        .quick-action-btn {
            border-radius: 16px;
            padding: 1.25rem 1rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(15px);
        }
        .quick-action-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(0,0,0,0.3); }

        /* Recent Table */
        .recent-table thead th {
            background: rgba(37,99,235,0.2);
            border: none;
            font-weight: 600;
            color: white;
        }
        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        .status-pending { background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }
        .status-progress { background: rgba(16,185,129,0.2); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }
        .status-resolved { background: rgba(34,197,94,0.2); color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }

        /* Charts */
        .chart-container { background: rgba(31,41,55,0.8); border-radius: 20px; padding: 2rem; backdrop-filter: blur(20px); }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Enhanced Sidebar -->
    <aside class="sidebar vh-100" id="adminSidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <i class="bi bi-shield-check fs-3 me-3"></i>
                <div>
                    <h4 class="mb-0 fw-bold">Jan Suraksha</h4>
                    <small class="opacity-75">Command Center</small>
                </div>
            </div>
        </div>
        <nav class="nav flex-column sidebar-nav mt-4">
            <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                <i class="bi bi-house-door-fill"></i> Dashboard
            </a>
            <a class="nav-link" href="cases.php">
                <i class="bi bi-file-earmark-shield-fill"></i> Complaints
            </a>
            <a class="nav-link" href="criminals.php">
                <i class="bi bi-person-lines-fill"></i> Criminals
            </a>
            <a class="nav-link" href="settings.php">
                <i class="bi bi-gear-fill"></i> Settings
            </a>
            <a class="nav-link text-danger" href="logout.php">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-grow-1">
        <!-- Topbar -->
        <header class="topbar px-4 py-3">
            <button class="btn btn-outline-light btn-sm d-lg-none me-3" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div class="d-flex align-items-center ms-auto">
                <span class="badge bg-primary fs-6 me-2">Admin</span>
                <div class="dropdown ms-3">
                    <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5 me-2"></i>
                        <span class="fw-semibold"><?= $_SESSION['admin_name'] ?? 'Admin' ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="p-5">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h1 class="display-5 fw-bold mb-2 text-white">Welcome Back, Admin</h1>
                    <p class="text-secondary mb-0">Here's what's happening with your cases today</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-success fs-6">Online</span>
                </div>
            </div>

            <!-- KPI Metrics -->
            <div class="row g-4 mb-5">
                <div class="col-xl-3 col-md-6">
                    <div class="metric-card h-100">
                        <div class="icon"><i class="bi bi-file-earmark-text"></i></div>
                        <div class="text-secondary mb-2">Total Complaints</div>
                        <h2 class="fw-bold text-white mb-2"><?= number_format($total) ?></h2>
                        <div class="metric-badge bg-primary">+12% vs last week</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="metric-card h-100">
                        <div class="icon"><i class="bi bi-clock-history"></i></div>
                        <div class="text-secondary mb-2">Pending</div>
                        <h2 class="fw-bold text-warning"><?= number_format($pending) ?></h2>
                        <div class="metric-badge status-pending">Needs attention</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="metric-card h-100">
                        <div class="icon"><i class="bi bi-check-circle-fill"></i></div>
                        <div class="text-secondary mb-2">Resolved</div>
                        <h2 class="fw-bold text-success"><?= number_format($resolved) ?></h2>
                        <div class="metric-badge bg-success">95% success</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="metric-card h-100">
                        <div class="icon"><i class="bi bi-people-fill"></i></div>
                        <div class="text-secondary mb-2">Total Criminals</div>
                        <h2 class="fw-bold text-primary"><?= number_format($criminals) ?></h2>
                        <div class="metric-badge bg-info">Database synced</div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-5">
                <div class="col-lg-8">
                    <div class="chart-container h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-semibold"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Crime Category Breakdown</h5>
                            <select class="form-select form-select-sm" style="width: 180px;">
                                <option>Last 30 days</option>
                                <option>Last 7 days</option>
                                <option>Last 90 days</option>
                            </select>
                        </div>
                        <canvas id="categoryChart" height="120"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-container h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-semibold"><i class="bi bi-pie-chart-fill me-2 text-success"></i>Status Distribution</h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <canvas id="statusChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions + Recent Complaints -->
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card metric-card p-4 h-100">
                        <h5 class="mb-4 fw-semibold"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>Quick Actions</h5>
                        <div class="d-grid gap-3">
                            <a href="add-complaint.php" class="quick-action-btn btn-primary">
                                <i class="bi bi-plus-circle-fill me-2"></i>New Complaint
                            </a>
                            <a href="criminals.php" class="quick-action-btn btn-outline-primary">
                                <i class="bi bi-person-plus-fill me-2"></i>Add Criminal
                            </a>
                            <a href="#" class="quick-action-btn btn-success" data-bs-toggle="modal" data-bs-target="#sendAlertModal">
                                <i class="bi bi-bell-fill me-2"></i>Send Alert
                            </a>
                            <a href="reports.php" class="quick-action-btn btn-info">
                                <i class="bi bi-graph-up-arrow me-2"></i>Generate Report
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card p-4" style="background: rgba(31,41,55,0.8); border-radius: 20px; border: 1px solid rgba(55,65,81,0.5);">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-semibold"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Complaints</h5>
                            <div class="d-flex gap-2">
                                <select class="form-select form-select-sm" style="width: 120px;">
                                    <option>All</option>
                                    <option>Pending</option>
                                    <option>Resolved</option>
                                </select>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-funnel"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-dark mb-0">
                                <thead>
                                    <tr>
                                        <th class="fw-semibold">Complaint ID</th>
                                        <th class="fw-semibold">Type</th>
                                        <th class="fw-semibold">Status</th>
                                        <th class="fw-semibold">Complainant</th>
                                        <th class="fw-semibold">Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($complaint = $recent_complaints->fetch_assoc()): ?>
                                    <tr class="align-middle">
                                        <td><span class="fw-semibold">#<?= htmlspecialchars($complaint['complaint_code']) ?></span></td>
                                        <td><?= htmlspecialchars($complaint['crime_type']) ?></td>
                                        <td><span class="status-badge status-<?= strtolower($complaint['status']) ?>">
                                            <?= htmlspecialchars($complaint['status']) ?>
                                        </span></td>
                                        <td><?= htmlspecialchars($complaint['complainant'] ?? 'Anonymous') ?></td>
                                        <td><small class="text-secondary"><?= date('M d, H:i', strtotime($complaint['created_at'])) ?></small></td>
                                        <td>
                                            <a href="view-complaint.php?id=<?= $complaint['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="cases.php" class="text-primary fw-semibold">View All Complaints →</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Alert Modal -->
<div class="modal fade" id="sendAlertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-bell-fill text-warning me-2"></i>Send Alert</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Choose alert type:</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-warning">Emergency Alert</button>
                    <button class="btn btn-success">Status Update</button>
                    <button class="btn btn-info">Public Advisory</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.getElementById('adminSidebar').classList.toggle('active');
});

// Charts
document.addEventListener('DOMContentLoaded', () => {
    // Category Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($category_labels) ?>,
            datasets: [{
                data: <?= json_encode($category_data) ?>,
                backgroundColor: 'linear-gradient(180deg, rgba(37,99,235,0.8) 0%, rgba(37,99,235,0.2) 100%)',
                borderRadius: 12,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#9ca3af' } },
                y: { grid: { color: 'rgba(148,163,184,0.1)' }, ticks: { color: '#9ca3af' } }
            }
        }
    });

    // Status Doughnut
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Resolved'],
            datasets: [{
                data: [<?= $pending ?>, <?= $investigating ?>, <?= $resolved ?>],
                backgroundColor: ['#f87171', '#34d399', '#4ade80'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '75%',
            plugins: { legend: { display: false } }
        }
    });
});
</script>
</body>
</html>
