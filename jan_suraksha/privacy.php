<?php
require_once __DIR__ . '/config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Privacy Policy - Jan Suraksha</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .footer-section {
      background-color: #ffffff;
      border-top: 1px solid #dee2e6;
    }
    .footer-section h5 {
      color: #0d6efd;
    }
    .footer-section .list-unstyled a {
      text-decoration: none;
      color: #6c757d;
      transition: color 0.2s;
    }
    .footer-section .list-unstyled a:hover {
      color: #0d6efd;
    }
    .footer-bottom {
      background-color: #f8f9fa;
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
        <li class="nav-item"><a class="nav-link" href="about-us.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
        <li class="nav-item"><a class="nav-link" href="faq.php">FAQ / Help</a></li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (empty($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="btn btn-outline-primary me-2" href="login.php">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary" href="register.php">Sign Up</a></li>
        <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Namaste, <?= htmlspecialchars($_SESSION['user_name']) ?>
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

<main class="container py-5" style="margin-top: 5rem;">
  <h1 class="mb-3 text-center">Privacy Policy</h1>
  <p class="text-muted text-center mb-4">
    This Privacy Policy explains how the Jan Suraksha portal collects, uses, and protects your information when you use this service.
  </p>

  <div class="row g-4">
    <!-- Info we collect -->
    <div class="col-md-6">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h2 class="h5 card-title">1. Information We Collect</h2>
          <p class="card-text mb-1">We collect the following types of information when you use this portal:</p>
          <ul class="mb-0">
            <li>Account details such as your name, email address, and mobile number when you register.</li>
            <li>Complaint information including titles, descriptions, categories, locations, and any attachments you submit.</li>
            <li>Technical data such as IP address, browser type, and access logs used for security and performance monitoring.</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- How we use it -->
    <div class="col-md-6">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h2 class="h5 card-title">2. How We Use Your Information</h2>
          <ul class="mb-0">
            <li>To create and manage your user account and authenticate your access to the portal.</li>
            <li>To register, process, and track your complaints and provide status updates.</li>
            <li>To improve the portal’s functionality, security, and user experience through analytics and feedback.</li>
            <li>To communicate important notifications related to your account or complaints.</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Sharing -->
    <div class="col-md-6">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h2 class="h5 card-title">3. Information Sharing</h2>
          <p class="card-text mb-1">We do not sell your personal information. We may share your information:</p>
          <ul class="mb-0">
            <li>With authorized officials or departments responsible for handling and resolving complaints.</li>
            <li>With service providers who support hosting, security, or communication, under appropriate safeguards.</li>
            <li>When required by law, court order, or to protect the safety and rights of users or the public.</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Storage & security -->
    <div class="col-md-6">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h2 class="h5 card-title">4. Data Storage &amp; Security</h2>
          <ul class="mb-0">
            <li>Your information is stored in secure databases with access restricted to authorized personnel.</li>
            <li>We use reasonable technical and organizational measures to protect data against loss, misuse, or unauthorized access.</li>
            <li>No system is completely secure, so you should also protect your account credentials and log out after use.</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Rights -->
    <div class="col-md-6">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h2 class="h5 card-title">5. Your Rights &amp; Choices</h2>
          <ul class="mb-0">
            <li>You can view and update your basic account details from your profile page.</li>
            <li>You may request correction of inaccurate information associated with your account or complaints, where applicable.</li>
            <li>If you wish to deactivate your account or have questions about your data, you can contact us using the details below.</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Cookies -->
    <div class="col-md-6">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h2 class="h5 card-title">6. Cookies &amp; Tracking</h2>
          <p class="card-text mb-0">
            The portal may use cookies or similar technologies to maintain sessions, remember preferences, and gather basic usage statistics.
            You can control cookies through your browser settings, but disabling them may affect certain features of the portal.
          </p>
        </div>
      </div>
    </div>

    <!-- Changes -->
    <div class="col-md-6">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h2 class="h5 card-title">7. Changes to This Policy</h2>
          <p class="card-text mb-0">
            We may update this Privacy Policy from time to time to reflect changes in the portal or legal requirements.
            The “Last updated” date will be revised accordingly, and continued use of the portal after changes means you accept the updated policy.
          </p>
        </div>
      </div>
    </div>

    <!-- Contact -->
    <div class="col-md-6">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h2 class="h5 card-title">8. Contact Us</h2>
          <p class="card-text mb-0">
            If you have questions or requests regarding this Privacy Policy, you can reach us using the contact details provided
            in the “Reach Us” section of the site footer.
          </p>
        </div>
      </div>
    </div>
  </div>

  <p class="text-muted small mt-4">Last updated: <?= date('F j, Y') ?></p>
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
          <li class="mb-2"><a href="faq.php">FAQ / Help</a></li>
        </ul>
      </div>
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
        <h5 class="text-uppercase fw-bold mb-4">Legal</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="privacy.php">Privacy Policy</a></li>
          <li class="mb-2"><a href="terms.php">Terms of Service</a></li>
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
