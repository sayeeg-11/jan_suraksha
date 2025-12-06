<?php
require_once __DIR__ . '/config.php';
// The config.php file already starts the session.
if(empty($_SESSION['user_id'])){ header('Location: login.php'); exit; }

// --- YOUR PHP LOGIC (UNCHANGED) ---
$user_id = (int)$_SESSION['user_id'];
// fetch user
$stmt = $mysqli->prepare('SELECT name,email,mobile,created_at FROM users WHERE id=?');
$stmt->bind_param('i',$user_id); $stmt->execute(); $user = $stmt->get_result()->fetch_assoc();
// fetch complaints
$cs = $mysqli->prepare('SELECT id,complaint_code,crime_type,date_filed,status FROM complaints WHERE user_id=? ORDER BY date_filed DESC');
$cs->bind_param('i',$user_id); $cs->execute(); $complaints = $cs->get_result();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile - Jan Suraksha</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            padding-top: 70px; /* For fixed navbar */
        }
        .card-custom {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: none;
        }
        .profile-info-list .list-group-item {
            border: none;
            padding: 0.75rem 0;
        }
        .complaint-card {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }
        .complaint-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        .complaint-id {
            font-weight: 600;
            color: #0d6efd;
        }
        .complaint-meta {
            color: #6c757d;
        }
        /* Footer styles */
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
                <li class="nav-item"><a class="nav-link" href="track-status.php">Track Status</a></li>
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
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                            Namaste, <?= e($user['name']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item active" href="profile.php">My Profile</a></li>
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
        <div class="col-md-10 col-lg-8">
            
            <h1 class="h3 mb-4">My Profile</h1>

            <!-- Profile Information Card -->
            <div class="card card-custom mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">Profile Information</h5>
                    <ul class="list-group list-group-flush profile-info-list">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Name:</strong>
                            <span><?= e($user['name']) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Email:</strong>
                            <span><?= e($user['email']) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Mobile:</strong>
                            <span><?= e($user['mobile']) ?></span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between">
                            <strong>Member Since:</strong>
                            <span><?= date('M d, Y', strtotime(e($user['created_at']))) ?></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Complaint History Card -->
            <div class="card card-custom">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">Complaint History</h5>
                    
                    <?php if ($complaints->num_rows > 0): ?>
                        <?php while($row = $complaints->fetch_assoc()): ?>
                            <div class="complaint-card">
                                <div class="complaint-header">
                                    <span class="complaint-id"><?= e($row['complaint_code']) ?></span>
                                    <?php
                                    $status_text = e($row['status']);
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
                                </div>
                                <div class="complaint-body">
                                    <p class="mb-1"><strong>Crime Type:</strong> <?= e($row['crime_type']) ?></p>
                                    <p class="complaint-meta small mb-0">
                                        Filed On: <?= date('M d, Y', strtotime(e($row['date_filed']))) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">You have not filed any complaints yet.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Footer Section -->
<footer class="footer-section pt-5 pb-4 mt-5">
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

