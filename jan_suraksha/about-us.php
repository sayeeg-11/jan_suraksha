<?php
require_once __DIR__ . '/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Jan Suraksha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f7fbfe; color: #0f1724; font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Noto Sans", Arial; }
        .nav-back { height: 56px; display:flex; align-items:center; }
        .page-title { font-weight:700; font-size:18px; text-align:center; }
        .container-sm-card { max-width:720px; margin: 0 auto; padding: 24px 16px; }
        h2.section-title { font-size:28px; font-weight:800; margin-top:12px; }
        p.lead-muted { color:#64748b; font-size:16px; line-height:1.6; }

        /* Stepper styles */
        .stepper { position:relative; padding-left: 48px; }
        .stepper::before { content: ''; position:absolute; left:21px; top:28px; bottom:0; width:2px; background:#e6eefb; }
        .step { display:flex; gap:16px; margin-bottom:28px; align-items:flex-start; }
        .step .icon { width:44px; height:44px; border-radius:50%; background:#0ea5e9; color:white; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .step h6 { margin:0; font-weight:700; font-size:16px; }
        .step p { margin:4px 0 0; color:#64748b; }

        .privacy { margin-top: 12px; }
        footer.footer-section { background: #ffffff; border-top:1px solid #e6eefb; margin-top: 32px; }
        .footer-bottom { background: #f8fafc; }
        @media (min-width: 768px) {
            .container-sm-card { padding: 40px 24px; }
            .footer-section .list-unstyled a {
            text-decoration: none;
            color: #6c757d;
            transition: color 0.2s;
        }
        }
    </style>
</head>
<body>

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
                <li class="nav-item"><a class="nav-link active" href="about-us.php">About Us</a></li>
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
                            Namaste, <?=htmlspecialchars($_SESSION['user_name'])?>
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

<main style="padding-top:72px;">
    <div class="container-sm-card">
        <section>
            <h2 class="section-title">Our Mission</h2>
            <p class="lead-muted">To empower every citizen of India with a secure and efficient platform for voicing concerns and ensuring accountability from public service providers. We are committed to transparency, responsiveness, and upholding the highest standards of integrity in addressing grievances.</p>
        </section>

        <section class="mt-4">
            <h2 class="section-title">How It Works</h2>
            <div class="stepper mt-3">
                <div class="step">
                    <div class="icon"><i class="bi bi-file-earmark-text"></i></div>
                    <div>
                        <h6>File a Complaint</h6>
                        <p>Submit your complaint with detailed information.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="icon" style="background:#0284c7;"><i class="bi bi-search"></i></div>
                    <div>
                        <h6>Track Your Status</h6>
                        <p>Monitor the progress of your complaint in real-time.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="icon" style="background:#059669;"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <h6>Get Resolution</h6>
                        <p>Receive updates and resolution details directly.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="privacy">
            <h2 class="section-title">Our Commitment to Privacy</h2>
            <p class="lead-muted">We adhere to the highest standards of data privacy, complying with applicable Indian laws and regulations. Your personal information is protected with robust security measures, ensuring confidentiality and integrity throughout the complaint resolution process.</p>
        </section>
    </div>
</main>

<footer class="footer-section pt-5 pb-4">
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
