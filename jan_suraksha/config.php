
<?php
// Start a session if one is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration - update with your MySQL credentials
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'jan_suraksha';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if($mysqli->connect_errno){
    die('DB Connection failed: ' . $mysqli->connect_error);
}

// Basic helper function to prevent XSS attacks
if (!function_exists('e')) {
    function e($string){ 
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8'); 
    }
}

// Simple debug logger (writes to logs/debug.log)
// debug helper removed