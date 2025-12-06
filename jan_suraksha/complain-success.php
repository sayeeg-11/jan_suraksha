<?php
require_once __DIR__ . '/config.php';
$code = isset($_GET['code']) ? $_GET['code'] : '';
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Complaint Submitted</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="container py-5">
<h2>Complaint Submitted</h2>
<?php if($code): ?>
  <div class="alert alert-success">
    Your complaint has been submitted successfully.<br>
    <strong>Complaint ID: <?=e($code)?></strong><br>
    Please save this ID to track your complaint status.
  </div>
<?php else: ?>
  <div class="alert alert-warning">No complaint ID provided.</div>
<?php endif; ?>
<a class="btn btn-primary" href="index.php">Return to Home</a>
</body></html>
