<?php
require_once __DIR__ . '/../config.php';

$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $aid = $_POST['admin_id'] ?? '';
    $pass = $_POST['password'] ?? '';
    $stmt = $mysqli->prepare('SELECT id,admin_name,password_hash FROM admins WHERE admin_id=?');
    $stmt->bind_param('s',$aid); $stmt->execute(); $res = $stmt->get_result();
    if($row = $res->fetch_assoc()){
        if(password_verify($pass,$row['password_hash'])){
            $_SESSION['admin_id'] = $row['id']; header('Location: dashboard.php'); exit;
        }
    }
    $err = 'Invalid admin credentials.';
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="container py-5">
<h2>Admin Login</h2>
<?php if($err): ?><div class="alert alert-danger"><?=e($err)?></div><?php endif; ?>
<form method="post">
  <div class="mb-3"><label class="form-label">Admin ID</label><input class="form-control" name="admin_id"></div>
  <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password"></div>
  <button class="btn btn-primary">Login</button>
</form>
</body></html>
