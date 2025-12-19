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
    <title>Jan Suraksha - Aapki Suraksha, Hamari Zimmedari</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
          --color-bg: #f8f9fa;
          --color-surface: #ffffff;
          --color-surface-soft: #eef2ff;
          --color-text: #0f172a;
          --color-muted: #6b7280;
          --color-primary: #2563eb; /* blue */
          --color-primary-soft: rgba(37, 99, 235, 0.08);
          --color-border: #e5e7eb;
          --shadow-soft: 0 10px 30px rgba(15, 23, 42, 0.06);
          color-scheme: light;
        }

        body {
            background-color: var(--color-bg);
            color: var(--color-text);
            padding-top: 0;
            padding-bottom: 0;
        }
        
        #page-content {
            min-height: 100vh;
}
        /* Hero Section Styling */
        .hero-section {
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), url('uploads/main.jpg') no-repeat center center;
            background-size: cover;
            padding: 120px 0;
            color: var(--color-surface);
            text-align: center;
        }

        .hero-section .btn-light {
            color: var(--color-primary);
            border-color: var(--color-surface);
        }
        .hero-section .btn-light:hover {
            background-color: var(--color-surface);
            color: var(--color-primary);
        }

        /* How It Works - Stepper Styling */
        .how-it-works {
            position: relative;
            padding: 40px 0;
        }
        .stepper-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
            position: relative;
        }
        .stepper-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 40px;
            width: 2px;
            height: calc(100% - 20px);
            background-color: var(--color-primary);
        }
        .stepper-icon {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 0, #93c5fd, var(--color-primary));
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin-right: 20px;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
            z-index: 1;
        }

        /* Public Awareness Card Styling */
        .awareness-section {
            background-color: var(--color-surface);
        }
        .awareness-card .icon-placeholder {
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, var(--color-primary-soft), transparent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--color-muted);
            border-top-left-radius: var(--bs-card-inner-border-radius);
            border-top-right-radius: var(--bs-card-inner-border-radius);
        }
        .awareness-card {
            background-color: var(--color-surface);
            color: var(--color-text);
            border-radius: 1rem;
            overflow: hidden;
            transition:
              transform 0.25s ease,
              box-shadow 0.25s ease,
              border-color 0.25s ease;
            border: 1px solid transparent;
        }
        .awareness-card:hover {
            transform: translateY(-6px) translateZ(0);
            box-shadow: var(--shadow-soft);
            border-color: var(--color-primary-soft);
        }
        
        /* NAVBAR base (for blur effect on scroll if needed) */
        .navbar {
          background: rgba(255, 255, 255, 0.9);
          backdrop-filter: blur(12px);
          -webkit-backdrop-filter: blur(12px);
          border-bottom: 1px solid rgba(148, 163, 184, 0.3);
          box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
          transition:
            background-color 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease,
            transform 0.25s ease;
        }

        .navbar-brand {
          font-weight: 800;
          letter-spacing: 0.08em;
          text-transform: uppercase;
          font-size: 1rem;
          display: flex;
          align-items: center;
          gap: 0.35rem;
          color: var(--color-primary) !important;
        }

        .navbar-brand::before {
          content: "";
          width: 10px;
          height: 10px;
          border-radius: 999px;
          background: radial-gradient(circle at 30% 30%, #bef264, #22c55e);
          box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.3);
        }

        .navbar-nav .nav-link {
          position: relative;
          padding: 0.7rem 1.15rem;
          margin: 0 0.35rem;
          font-size: 1.05rem;
          font-weight: 500;
          color: var(--color-text);
          border-radius: 0.75rem;
          overflow: hidden;
          z-index: 0;
          transition:
            color 0.2s ease,
            background-color 0.2s ease,
            transform 0.2s ease,
            box-shadow 0.2s ease;
        }

        .navbar-nav .nav-link::before {
          content: "";
          position: absolute;
          inset: 0;
          background-color: #1d4ed8;
          opacity: 0;
          transform: scale(0.96, 0.9);
          transition:
            opacity 0.18s ease,
            transform 0.18s ease;
          z-index: -1;
        }

        .navbar-nav .nav-link:hover::before {
          opacity: 1;
          transform: scale(1, 1);
        }

        .navbar-nav .nav-link:hover {
          color: #e5e7eb;
          transform: translateY(-1px);
          box-shadow: 0 8px 18px rgba(15, 23, 42, 0.35);
        }

        .navbar-nav .nav-link::after {
          content: "";
          position: absolute;
          left: 12%;
          right: 12%;
          bottom: 0.12rem;
          height: 2px;
          border-radius: 999px;
          background: linear-gradient(
            90deg,
            transparent,
            rgba(191, 219, 254, 1),
            rgba(96, 165, 250, 1),
            transparent
          );
          transform-origin: center;
          transform: scaleX(0);
          opacity: 0;
          transition:
            transform 0.18s ease,
            opacity 0.18s ease;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link:focus-visible::after {
          transform: scaleX(1);
          opacity: 1;
        }

        .navbar-nav .nav-link.active {
          color: #e5e7eb;
          background-color: #1d4ed8;
          box-shadow: 0 10px 22px rgba(15, 23, 42, 0.45);
        }

        .navbar-nav .nav-link.active::before {
          opacity: 1;
          transform: scale(1, 1);
        }

        .navbar-nav .nav-link.active::after {
          transform: scaleX(1);
          opacity: 1;
        }

        .navbar .btn-primary,
        .navbar .btn-outline-primary {
          border-radius: 999px;
          font-size: 0.88rem;
          padding: 0.42rem 0.95rem;
          box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
          transition:
            transform 0.18s ease,
            box-shadow 0.18s ease;
        }

        .navbar .btn-primary:hover,
        .navbar .btn-outline-primary:hover {
          transform: translateY(-1px);
          box-shadow: 0 10px 26px rgba(37, 99, 235, 0.4);
        }

        .navbar-collapse {
          transition:
            max-height 0.25s ease,
            opacity 0.2s ease,
            transform 0.2s ease;
        }

        /* TOP BAR + DARK MAIN NAV */
        .top-bar {
          background-color: #ffffff;
          border-bottom: 1px solid rgba(148,163,184,0.4);
          padding: 4px 0;
          font-size: 0.9rem;
        }

        .top-bar .brand-logo {
          display: flex;
          align-items: center;
          gap: 0.4rem;
        }

        .top-bar .brand-logo img {
          height: 46px;
        }

        .top-bar .brand-text {
          font-weight: 700;
          font-size: 1.1rem;
          color: var(--color-primary);
          text-transform: uppercase;
        }

        .top-bar .brand-subtitle {
          font-size: 0.78rem;
          letter-spacing: 0.05em;
          text-transform: uppercase;
          color: #4b5563;
        }

        .top-contact {
          display: flex;
          align-items: center;
          justify-content: flex-end;
          gap: 1.5rem;
          flex-wrap: wrap;
        }

        .top-contact-item {
          display: flex;
          align-items: center;
          gap: 0.35rem;
          color: #111827;
          font-weight: 600;
        }

        .top-contact-item small {
          display: block;
          font-size: 0.7rem;
          font-weight: 500;
          color: #6b7280;
          text-transform: uppercase;
        }

        .top-contact-item i {
          color: var(--color-primary);
          font-size: 1.1rem;
        }

        .top-seal img {
          height: 60px;
        }

        .navbar-main {
          background-color: #0f172a;
          padding-top: 0.35rem;
          padding-bottom: 0.35rem;
          border-bottom: 2px solid var(--color-primary);
        }

        .navbar-main .navbar-brand-img {
          height: 52px;
          border-radius: 999px;
          overflow: hidden;
          border: 2px solid var(--color-primary);
        }

        .navbar-main .navbar-brand-img img {
          height: 100%;
          display: block;
        }

        .navbar-main .navbar-nav .nav-link {
          color: #e5e7eb;
        }

        .navbar-main .navbar-nav .nav-link:hover {
          color: #e5e7eb;
        }

        .navbar-main .nav-link,
        .navbar-main .btn {
          font-size: 0.98rem;
        }

        .navbar-main .btn-login {
          border-radius: 999px;
          border: 1px solid var(--color-primary);
          color: var(--color-primary);
          padding: 0.35rem 1rem;
          display: inline-flex;
          align-items: center;
          gap: 0.35rem;
          background: transparent;
        }

        .navbar-main .btn-login:hover {
          background-color: var(--color-primary);
          color: #0f172a;
        }

        .navbar-main .nav-link.home-pill {
          background: linear-gradient(135deg, #60a5fa, var(--color-primary));
          border-radius: 999px;
          padding-inline: 1.35rem;
          color: #0f172a;
          font-weight: 700;
        }

        @media (max-width: 991.98px) {
          .navbar-collapse {
            background-color: #0f172a;
            border-radius: 1rem;
            margin-top: 0.65rem;
            padding: 0.6rem 0.75rem 0.8rem;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.9);
          }
          .navbar-nav .nav-link {
            color: #e5e7eb;
            padding: 0.5rem 0.8rem;
          }
          .navbar-nav.ms-auto {
            margin-top: 0.5rem;
          }
          .navbar-toggler {
            border-radius: 999px;
            padding: 0.3rem 0.55rem;
            border-color: rgba(148, 163, 184, 0.7);
            transition:
              background-color 0.18s ease,
              transform 0.18s ease,
              box-shadow 0.18s ease;
          }
          .navbar-toggler:hover {
            background-color: rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.5);
          }
          .top-contact {
            justify-content: flex-start;
            margin-top: 0.4rem;
          }
          .navbar-main .navbar-collapse {
            background-color: #0f172a;
            border-radius: 0 0 0.75rem 0.75rem;
            padding: 0.5rem 0.75rem 0.75rem;
          }
        }
    </style>
</head>
<body>

<header class="border-bottom fixed-top">
  <!-- Top white bar -->
  <div class="top-bar">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <div class="brand-logo">
          <!-- left small logo -->
          <img src="logo.png" alt="Jan Suraksha">
          <div>
            <div class="brand-text">Jan Suraksha</div>
            <div class="brand-subtitle">Aapki Suraksha, Hamari Zimmedari</div>
          </div>
        </div>
      </div>

      <div class="d-flex align-items-center gap-3">
        <div class="top-contact">
          <div class="top-contact-item">
            <i class="bi bi-whatsapp"></i>
            <div>
              <span>+91-9372693389 / +91-7972409656</span>
              <small>Call / WhatsApp</small>
            </div>
          </div>
          <div class="top-contact-item">
            <i class="bi bi-envelope-fill"></i>
            <div>
              <span>support@jansuraksha.in</span>
              <small>Email Us</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Dark main nav bar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-main">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <span class="navbar-brand-img">
          <!-- circular icon like deity image -->
          <img src="logo.png" alt="Jan Suraksha">
        </span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navs"
              aria-controls="navs" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navs">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link home-pill <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>" href="index.php">
              <i class="bi bi-house-door-fill me-1"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'file-complaint.php' ? 'active' : ''; ?>" href="file-complaint.php">
              <i class="bi bi-flag-fill me-1"></i> File a Complaint
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'track-status.php' ? 'active' : ''; ?>" href="track-status.php">
              <i class="bi bi-search me-1"></i> Track Status
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'about-us.php' ? 'active' : ''; ?>" href="about-us.php">
              <i class="bi bi-info-circle-fill me-1"></i> About Us
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'blog.php' ? 'active' : ''; ?>" href="blog.php">
              <i class="bi bi-journal-text me-1"></i> Blog
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'feedback.php' ? 'active' : ''; ?>" href="feedback.php">
              <i class="bi bi-chat-dots-fill me-1"></i> Feedback
            </a>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto align-items-center">
          <?php if (empty($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="btn btn-login" href="login.php">
                <i class="bi bi-person-fill"></i> Login
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i>
                Namaste, <?= htmlspecialchars($_SESSION['user_name']) ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-badge me-2"></i>My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

<main id="page-content">

<!-- page content -->
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('header.fixed-top');
    const footer = document.querySelector('.footer-main'); // if footer exists

    function adjustLayoutSpacing() {
        let topSpace = 0;
        let bottomSpace = 0;

        if (header) {
            topSpace = header.offsetHeight;
            document.body.style.paddingTop = topSpace + 'px';
        }

        if (footer) {
            bottomSpace = footer.offsetHeight;
            document.body.style.paddingBottom = bottomSpace + 'px';
        }
    }

    adjustLayoutSpacing();
    window.addEventListener('resize', adjustLayoutSpacing);
});
</script>

</body>
</html>
