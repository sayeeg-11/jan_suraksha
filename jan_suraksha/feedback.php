<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$err = ''; 
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$subject || !$message) {
        $err = 'Subject and message are required.';
    } elseif ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = 'Please enter a valid email address.';
    } else {
        $stmt = $mysqli->prepare(
            'INSERT INTO feedback (name,email,subject,message,created_at) VALUES (?,?,?,?,NOW())'
        );
        $stmt->bind_param('ssss', $name, $email, $subject, $message);
        $stmt->execute();
        $success = 'Thank you! Your feedback has been submitted successfully. We appreciate your input.';
    }
}
?>
<?php include 'header.php'; ?>

<style>
/* Feedback hero */
.feedback-hero {
    background: linear-gradient(135deg, var(--color-primary, #0d6efd) 0%, var(--color-primary-light, #0dcaf0) 100%);
    color: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(13, 110, 253, 0.3);
}

/* Form card */
.feedback-card {
    background-color: var(--color-surface, #ffffff);
    border: 1px solid var(--color-border, rgba(0,0,0,0.08));
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
}

/* Inputs */
.form-control {
    border-radius: 12px;
    border: 1px solid var(--color-border, rgba(0,0,0,0.08));
    padding: 0.875rem 1rem;
    background-color: var(--color-surface-subtle, rgba(0,0,0,0.02));
}

.form-control:focus {
    border-color: var(--color-primary, #0d6efd);
    background-color: var(--color-surface, #ffffff);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.form-label i {
    vertical-align: -1px;
}

/* Subject select */
.subject-select {
    border-radius: 12px;
    border: 1px solid var(--color-border, rgba(0,0,0,0.08));
    padding: 0.875rem 1rem;
    background-color: var(--color-surface-subtle, rgba(0,0,0,0.02));
}

.subject-select:focus {
    border-color: var(--color-primary, #0d6efd);
    background-color: var(--color-surface, #ffffff);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.char-counter {
    font-size: 0.875rem;
    color: var(--color-text-muted, #6c757d);
}

.char-limit {
    color: var(--color-danger, #dc3545);
    font-weight: 500;
}
</style>

<style>
/* For pages with custom backgrounds, override body background */
body {
    background-color: var(--color-bg) !important;
    background-image: var(--custom-bg, none) !important;
}

/* Update hardcoded colors to use CSS vars */
.text-primary { color: var(--color-primary) !important; }
.btn-primary { 
    background-color: var(--color-primary); 
    border-color: var(--color-primary); 
}
.btn-primary:hover {
    background-color: color-mix(in srgb, var(--color-primary) 90%, black);
    border-color: color-mix(in srgb, var(--color-primary) 80%, black);
}
</style>

<main id="page-content" class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <?php if ($success): ?>
                <!-- Success State -->
                <div class="feedback-hero text-center p-5 mb-5">
                    <div class="display-4 mb-4">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h1 class="display-5 fw-bold mb-4">Thank You!</h1>
                    <p class="lead mb-0"><?= e($success) ?></p>
                </div>
                <div class="text-center">
                    <a href="index.php" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-house-door me-2"></i>Return Home
                    </a>
                </div>
            <?php else: ?>

                <!-- Hero Intro -->
                <div class="feedback-hero text-center p-5 mb-5">
                    <div class="display-4 mb-4">
                        <i class="bi bi-chat-heart"></i>
                    </div>
                    <h1 class="display-5 fw-bold mb-3">Help Us Improve</h1>
                    <p class="lead mb-0 opacity-90">
                        Your feedback helps us serve citizens better. Every suggestion matters.
                    </p>
                </div>

                <!-- Feedback Form -->
                <div class="feedback-card p-4 p-md-5 mb-5">
                    <?php if ($err): ?>
                        <div class="alert alert-danger mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= e($err) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" id="feedbackForm">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-2 text-primary"></i>Name (optional)
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                maxlength="50"
                                value="<?= isset($_SESSION['user_name']) ? e($_SESSION['user_name']) : '' ?>"
                                placeholder="Your name (optional)"
                            >
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-2 text-primary"></i>Email (optional)
                            </label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                maxlength="100"
                                placeholder="you@example.com"
                            >
                        </div>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label for="subject" class="form-label h6 mb-2">
                                <i class="bi bi-tag me-2 text-primary"></i>Subject <span class="text-danger">*</span>
                            </label>
                            <select
                                class="form-select subject-select fs-5"
                                id="subject"
                                name="subject"
                                required
                            >
                                <option value="">Choose a category...</option>
                                <option value="Service Feedback">Service Feedback</option>
                                <option value="Complaint Experience">Complaint Experience</option>
                                <option value="Website Issue">Website Issue</option>
                                <option value="Feature Suggestion">Feature Suggestion</option>
                                <option value="Praise">Praise</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Message -->
                        <div class="mb-3">
                            <label for="message" class="form-label">
                                <i class="bi bi-chat-text me-2 text-primary"></i>Your Message <span class="text-danger">*</span>
                            </label>
                            <textarea
                                class="form-control"
                                id="message"
                                name="message"
                                rows="6"
                                maxlength="1000"
                                required
                                placeholder="Tell us how we can improve your experience with Jan Suraksha..."
                            ></textarea>
                            <div class="char-counter mt-2">
                                <span id="charCount">0</span> / 1000 characters
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fs-5" id="submitBtn">
                                <span class="btn-text">
                                    <i class="bi bi-send me-2"></i>Send Feedback
                                </span>
                                <span class="btn-loader d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Sending...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const message   = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    const submitBtn = document.getElementById('submitBtn');
    const form      = document.getElementById('feedbackForm');

    if (message && charCount) {
        message.addEventListener('input', function () {
            const len = this.value.length;
            charCount.textContent = len;
            if (len > 900) {
                charCount.classList.add('char-limit');
            } else {
                charCount.classList.remove('char-limit');
            }
        });
    }

    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.querySelector('.btn-text').classList.add('d-none');
            submitBtn.querySelector('.btn-loader').classList.remove('d-none');
        });
    }
});
</script>

<?php include 'footer.php'; ?>
