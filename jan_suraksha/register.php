<?php
require_once __DIR__ . '/config.php';
$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    // normalize mobile: remove non-digit characters (accepts formats like +91 98xxxx...)
    $mobile = preg_replace('/\D+/', '', $mobile);
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if(!$name || !preg_match('/^[0-9]{10}$/', $mobile) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6 || $password !== $confirm){
        // Provide a slightly more helpful message for common validation failures
        $err = 'Please fill the form correctly. Ensure mobile is 10 digits, email is valid and password is at least 6 characters.';
    } else {
        // check duplicates
        $stmt = $mysqli->prepare('SELECT id FROM users WHERE email=? OR mobile=?');
        $stmt->bind_param('ss',$email,$mobile);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){ $err = 'Email or mobile already registered.'; }
        else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $mysqli->prepare('INSERT INTO users (name,mobile,email,password_hash,created_at) VALUES (?,?,?,?,NOW())');
            $ins->bind_param('ssss',$name,$mobile,$email,$hash);
            $ins->execute();
            // mysqli_stmt doesn't expose insert_id; use $mysqli->insert_id
            $_SESSION['user_id'] = $mysqli->insert_id;
            $_SESSION['user_name'] = $name;
            header('Location: profile.php'); exit;
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="container py-5">
<h2>Register</h2>
<?php if($err): ?><div class="alert alert-danger"><?=e($err)?></div><?php endif; ?>
<form method="post">
  <div class="mb-3"><label class="form-label">Full Name</label><input class="form-control" name="name" required></div>
  <div class="mb-3"><label class="form-label">Mobile (10 digits)</label><input class="form-control" name="mobile" required></div>
  <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div>
  <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
  <div class="mb-3"><label class="form-label">Confirm Password</label><input class="form-control" type="password" name="confirm" required></div>
  <button class="btn btn-primary">Register</button>
</form>
</body></html>
