<?php
require_once __DIR__ . '/config.php';
$status = null; $err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $code = trim($_POST['code'] ?? '');
    if(!$code) $err = 'Please enter a Complaint ID.';
    else {
        $stmt = $mysqli->prepare('SELECT complaint_code, crime_type, status, updated_at FROM complaints WHERE complaint_code=?');
        $stmt->bind_param('s',$code); $stmt->execute(); $res = $stmt->get_result();
        if($row = $res->fetch_assoc()) $status = $row; else $err = 'No record found for this Complaint ID.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Track Complaint Status - Jan Suraksha</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            background-image:url(uploads/ppp.jpg);
            padding-top: 70px; /* For fixed navbar */
        }
        .content-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .form-control {
            background-color: #f1f3f5;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.8rem 1rem;
        }
        .form-control:focus {
            background-color: #ffffff;
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
        }
        .details-card {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        .details-row:last-child {
            border-bottom: none;
        }
        .details-label {
            color: #6c757d;
        }
        .details-value {
            font-weight: 500;
        }
        /* Footer styles from homepage */
        .footer-section {
            background-color: #ffffff;
            border-top: 1px solid #dee2e6;
        }
        .footer-section h5 { color: #0d6efd; }
        .footer-section .list-unstyled a { text-decoration: none; color: #6c757d; }
        .footer-section .list-unstyled a:hover { color: #0d6efd; }
        .footer-bottom { background-color: #f8f9fa; }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/">Jan Suraksha</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navs">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navs">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="file-complaint.php">File a Complaint</a></li>
                <li class="nav-item"><a class="nav-link active" href="track-status.php">Track Status</a></li>
                <li class="nav-item"><a class="nav-link" href="about-us.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if(empty($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="btn btn-outline-primary me-2" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary" href="register.php">Sign Up</a></li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Namaste, <?= e($_SESSION['user_name']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="content-container p-4 p-md-5">
                <h1 class="h3 text-center mb-4">Complaint Status</h1>
                
                <?php if($err): ?>
                    <div class="alert alert-warning"><?= e($err) ?></div>
                <?php endif; ?>

                <form method="post" class="mb-4">
                    <div class="mb-3">
                        <label for="code" class="form-label">Enter Your FIR/Complaint ID</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="e.g., IN/2024/12345" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Check Status</button>
                    </div>
                </form>

                <?php if($status): ?>
                    <div class="mt-5">
                        <h2 class="h4 mb-3">Complaint Details</h2>
                        <div class="details-card">
                            <div class="details-row">
                                <span class="details-label">Complaint ID</span>
                                <span class="details-value"><?= e($status['complaint_code']) ?></span>
                            </div>
                            <div class="details-row">
                                <span class="details-label">Current Status</span>
                                <span class="details-value">
                                    <?php
                                    $status_text = e($status['status']);
                                    $badge_class = 'bg-secondary'; // Default
                                    if (stripos($status_text, 'progress') !== false || stripos($status_text, 'pending') !== false) {
                                        $badge_class = 'bg-warning text-dark';
                                    } elseif (stripos($status_text, 'resolved') !== false || stripos($status_text, 'closed') !== false) {
                                        $badge_class = 'bg-success';
                                    } elseif (stripos($status_text, 'submitted') !== false) {
                                        $badge_class = 'bg-info text-dark';
                                    }
                                    ?>
                                    <span class="badge rounded-pill <?= $badge_class ?>"><?= $status_text ?></span>
                                </span>
                            </div>
                            <div class="details-row">
                                <span class="details-label">Last Updated On</span>
                                <span class="details-value"><?= date('Y-m-d', strtotime(e($status['updated_at']))) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Footer Section -->
<footer class="footer-section pt-5 pb-4 mt-auto">
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                <h5 class="text-uppercase fw-bold mb-4">Jan Suraksha</h5>
                <p>A dedicated portal for public safety and grievance redressal. Report incidents, track progress, and stay informed.</p>
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                <h5 class="text-uppercase fw-bold mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="file-complaint.php">File a Complaint</a></li>
                    <li class="mb-2"><a href="track-status.php">Track a Complaint</a></li>
                    <li class="mb-2"><a href="blog.php">Awareness Blog</a></li>
                    <li class="mb-2"><a href="about-us.php">About Us</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                <h5 class="text-uppercase fw-bold mb-4">Legal</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#">Privacy Policy</a></li>
                    <li class="mb-2"><a href="#">Terms of Service</a></li>
                    <li class="mb-2"><a href="admin/index.php">Administrator Login</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h5 class="text-uppercase fw-bold mb-4">Reach Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>Police HQ, Mumbai, MH</li>
                    <li class="mb-2"><i class="bi bi-envelope-fill me-2"></i>contact@jsuraksha.gov.in</li>
                    <li class="mb-2"><i class="bi bi-telephone-fill me-2"></i>+91 22 2345 6789</li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<div class="footer-bottom text-center p-3">
    &copy; <?= date('Y') ?> Jan Suraksha Portal. All Rights Reserved.
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>