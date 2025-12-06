<?php
require_once __DIR__ . '/config.php';
$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = trim($_POST['id'] ?? '');
    $password = $_POST['password'] ?? '';
    if(!$id || !$password){ $err = 'Fill both fields.'; }
    else {
        $stmt = $mysqli->prepare('SELECT id,name,password_hash FROM users WHERE email=? OR mobile=?');
        $stmt->bind_param('ss',$id,$id);
        $stmt->execute();
        $res = $stmt->get_result();
        if($row = $res->fetch_assoc()){
            if(password_verify($password, $row['password_hash'])){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                header('Location: profile.php'); exit;
            } else { $err = 'Invalid credentials.'; }
        } else { $err = 'Invalid credentials.'; }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="container py-5">
<h2>Login</h2>
<?php if($err): ?><div class="alert alert-danger"><?=e($err)?></div><?php endif; ?>
<form method="post">
  <div class="mb-3"><label class="form-label">Email or Mobile</label><input class="form-control" name="id" required></div>
  <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
  <button class="btn btn-primary">Login</button>
</form>
</body></html>
