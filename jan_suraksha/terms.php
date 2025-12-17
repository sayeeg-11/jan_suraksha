<?php
require_once __DIR__ . '/config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Terms of Service - Jan Suraksha</title>
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
    .terms-card {
      border-radius: 16px;
      border: none;
      box-shadow: 0 10px 30px rgba(15,23,42,0.08);
      background: #ffffff;
    }
    .terms-card .card-header {
      border-bottom: none;
      background: linear-gradient(135deg, #2563eb 0%, #0f172a 100%);
      color: #fff;
      border-radius: 16px 16px 0 0;
    }
    .terms-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-right: .5rem;
    }
    .terms-section {
      border-left: 3px solid #e5e7eb;
      padding-left: 1rem;
    }
    .terms-section + .terms-section {
      margin-top: 1.5rem;
    }
    @media (max-width: 576px) {
      .terms-section {
        border-left: none;
        border-top: 1px solid #e5e7eb;
        padding-left: 0;
        padding-top: 1rem;
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
  <div class="row justify-content-center">
    <div class="col-lg-9">
      <div class="card terms-card">
        <div class="card-header py-4">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
              <div class="d-flex align-items-center mb-1">
                <div class="terms-icon bg-light bg-opacity-25">
                  <i class="bi bi-file-earmark-text fs-5"></i>
                </div>
                <h1 class="h3 mb-0 ms-1">Terms of Service</h1>
              </div>
              <p class="mb-0 small opacity-75">
                These Terms explain the rules for using the Jan Suraksha portal. By accessing or using this portal, you agree to these terms.
              </p>
            </div>
            <span class="badge bg-light text-dark">
              Last updated: <?= date('F j, Y') ?>
            </span>
          </div>
        </div>
        <div class="card-body p-4 p-md-5">
          
          <section class="terms-section">
            <h2 class="h5 mb-2">1. Purpose and Scope</h2>
            <p class="mb-0">
              The Jan Suraksha portal is designed to help citizens submit and track complaints related to public safety and other supported
              categories. The portal facilitates communication and transparency but does not replace emergency services or formal legal
              procedures.
            </p>
          </section>

          <section class="terms-section">
            <h2 class="h5 mb-2">2. User Responsibilities</h2>
            <p class="mb-1">When using this portal, you agree to:</p>
            <ul class="mb-2">
              <li>Provide accurate, complete, and up-to-date information when registering and submitting complaints.</li>
              <li>Use the portal only for lawful purposes and genuine complaints.</li>
              <li>Respect the privacy and safety of others and avoid sharing unnecessary sensitive personal data.</li>
            </ul>
            <p class="mb-1">You must not:</p>
            <ul class="mb-0">
              <li>Submit false, misleading, or malicious complaints.</li>
              <li>Upload content that is offensive, defamatory, or violates any law or third-party rights.</li>
              <li>Attempt to interfere with the portal’s security, availability, or normal operation.</li>
            </ul>
          </section>

          <section class="terms-section">
            <h2 class="h5 mb-2">3. Complaint Handling</h2>
            <p class="mb-0">
              Complaints submitted through the portal are forwarded to the appropriate officials or departments for review. While efforts are
              made to process complaints promptly, no specific outcome or resolution timeline is guaranteed. You can track the status of your
              complaint using the provided complaint ID.
            </p>
          </section>

          <section class="terms-section">
            <h2 class="h5 mb-2">4. Privacy and Data Usage</h2>
            <p class="mb-0">
              Information you provide, including personal details and complaint content, is handled in accordance with our
              <a href="privacy.php">Privacy Policy</a>. Please review the Privacy Policy to understand how your data is collected, used, and
              protected.
            </p>
          </section>

          <section class="terms-section">
            <h2 class="h5 mb-2">5. Disclaimers and Limitation of Liability</h2>
            <ul class="mb-2">
              <li>The portal is provided on an “as is” and “as available” basis without any warranties of any kind, express or implied.</li>
              <li>We do not guarantee uninterrupted or error-free operation of the portal.</li>
            </ul>
            <p class="mb-1">To the maximum extent permitted by law, the portal operators are not liable for any loss, damage, or consequences arising from:</p>
            <ul class="mb-0">
              <li>Your use or inability to use the portal.</li>
              <li>Delays or failures in complaint processing.</li>
              <li>Actions taken or not taken by authorities in response to complaints.</li>
            </ul>
          </section>

          <section class="terms-section">
            <h2 class="h5 mb-2">6. Suspension and Termination</h2>
            <p class="mb-0">
              We may suspend or terminate your access to the portal, without prior notice, if we believe you have violated these Terms,
              attempted to misuse the system, or created a security or legal risk for the portal or other users.
            </p>
          </section>

          <section class="terms-section">
            <h2 class="h5 mb-2">7. Changes to These Terms</h2>
            <p class="mb-0">
              These Terms may be updated from time to time to reflect changes in the portal or applicable laws. Continued use of the portal
              after changes are posted constitutes acceptance of the updated Terms.
            </p>
          </section>

          <section class="terms-section">
            <h2 class="h5 mb-2">8. Contact and Support</h2>
            <p class="mb-0">
              If you have questions about these Terms or need support related to the portal, you can reach us using the contact details listed
              in the “Reach Us” section of the site footer.
            </p>
          </section>

        </div>
      </div>
    </div>
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
