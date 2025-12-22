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
<?php include 'header.php'; ?>

<style>
/* Profile hero card with subtle gradient */
.profile-hero {
    background: linear-gradient(135deg, var(--color-primary, #0d6efd) 0%, var(--color-primary-light, #0dcaf0) 100%);
    color: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(13, 110, 253, 0.3);
    overflow: hidden;
}

/* Main cards using theme tokens */
.profile-card {
    background-color: var(--color-surface, #ffffff);
    border: 1px solid var(--color-border, rgba(0,0,0,0.08));
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* Profile info list */
.profile-info-list .list-group-item {
    border: 0;
    padding: 0.75rem 0;
    background-color: transparent;
    color: var(--color-text, #212529);
}

/* Complaint cards use surface vars */
.complaint-card {
    background-color: var(--color-surface-subtle, rgba(0,0,0,0.02));
    border: 1px solid var(--color-border, rgba(0,0,0,0.08));
    border-radius: 10px;
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
    color: var(--color-primary, #0d6efd);
}

.complaint-meta {
    color: var(--color-text-muted, #6c757d);
}

/* Empty state styled as neutral card */
.empty-state-card {
    border-radius: 10px;
    padding: 2rem;
    border: 2px dashed var(--color-border, rgba(0,0,0,0.12));
    background-color: var(--color-surface-subtle, rgba(0,0,0,0.02));
    text-align: center;
}

.empty-state-card i {
    font-size: 3rem;
    color: var(--color-text-muted, #6c757d);
    margin-bottom: 1rem;
}

/* Stats chips (future-ready) */
.stats-chips {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}

.stats-chip {
    background: linear-gradient(135deg, var(--color-primary, #0d6efd), var(--color-primary-light, #0dcaf0));
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
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
        <div class="col-md-10 col-lg-8">
            
            <!-- Profile Hero Card -->
            <div class="profile-hero p-5 text-center mb-5">
                <div class="display-4 mb-4">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h1 class="display-5 fw-bold mb-2">Namaste, <?= e($user['name']) ?>!</h1>
                <p class="lead mb-0 opacity-90">Manage your profile and track complaints</p>
            </div>

            <!-- Stats Chips (Future-ready) -->
            <div class="stats-chips">
                <span class="stats-chip">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    <?= $complaints->num_rows ?> Complaints
                </span>
                <span class="stats-chip">
                    <i class="bi bi-check-circle me-1"></i>
                    0 Resolved
                </span>
                <span class="stats-chip">
                    <i class="bi bi-clock me-1"></i>
                    0 Pending
                </span>
            </div>

            <!-- Profile Information Card -->
            <div class="card profile-card mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-person me-2 text-primary"></i>Profile Information
                    </h5>
                    <ul class="list-group list-group-flush profile-info-list">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Name:</strong>
                            <span class="fw-semibold"><?= e($user['name']) ?></span>
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
                            <span class="text-muted"><?= date('M d, Y', strtotime(e($user['created_at']))) ?></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Complaint History Card -->
            <div class="card profile-card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-list-ul me-2 text-primary"></i>Complaint History
                    </h5>
                    
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
                                    <p class="mb-1">
                                        <strong>Crime Type:</strong> <?= e($row['crime_type']) ?>
                                    </p>
                                    <p class="complaint-meta small mb-0">
                                        <i class="bi bi-calendar me-1"></i>
                                        Filed On: <?= date('M d, Y', strtotime(e($row['date_filed']))) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-state-card mt-3">
                            <i class="bi bi-folder-x"></i>
                            <h6 class="mb-2 fw-semibold text-muted">No complaints yet</h6>
                            <p class="mb-0 text-muted">
                                Once you submit complaints, they will appear here with their status and dates.
                            </p>
                            <div class="mt-3">
                                <a href="file-complaint.php" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>File First Complaint
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
