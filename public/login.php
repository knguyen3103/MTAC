<?php
session_start();
$pdo = require_once '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']); // Mã hóa mật khẩu với MD5

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit();
    } else {
        $error = "❌ Sai tên đăng nhập hoặc mật khẩu.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập - Cổng thông tin nhân viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
    }
    .login-container {
      max-width: 400px;
      margin: 100px auto;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="login-container">
  <h4 class="text-center mb-4 fw-bold text-primary">🔐 Đăng nhập hệ thống</h4>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" novalidate>
    <div class="mb-3">
      <label for="username" class="form-label">👤 Tên đăng nhập</label>
      <input type="text" class="form-control" name="username" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">🔒 Mật khẩu</label>
      <input type="password" class="form-control" name="password" id="password" required>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="showPassword">
      <label class="form-check-label" for="showPassword">👁️ Hiển thị mật khẩu</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">➡️ Đăng nhập</button>
  </form>
</div>

<script>
  document.getElementById('showPassword').addEventListener('change', function () {
    const pwdInput = document.getElementById('password');
    pwdInput.type = this.checked ? 'text' : 'password';
  });
</script>

</body>
</html>
