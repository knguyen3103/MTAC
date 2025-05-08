<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

$userId = $_SESSION['user']['id'] ?? null;
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['old_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user || md5($oldPassword) !== $user['password']) {
        $errors[] = "❌ Mật khẩu cũ không đúng.";
    } elseif (strlen($newPassword) < 6) {
        $errors[] = "⚠️ Mật khẩu mới phải có ít nhất 6 ký tự.";
    } elseif ($newPassword !== $confirmPassword) {
        $errors[] = "⚠️ Mật khẩu mới không khớp.";
    } else {
        $hashedPassword = md5($newPassword);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->execute([$hashedPassword, $userId]);
        $success = "✅ Đổi mật khẩu thành công!";
    }
}
?>

<div class="card shadow-sm col-md-6 mx-auto">
  <div class="card-body">
    <h5 class="text-center text-uppercase fw-bold mb-4">🔐 Đổi mật khẩu</h5>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php elseif ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Tên đăng nhập</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?>" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu cũ</label>
        <input type="password" name="old_password" class="form-control password-input" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu mới</label>
        <input type="password" name="new_password" class="form-control password-input" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Nhập lại mật khẩu mới</label>
        <input type="password" name="confirm_password" class="form-control password-input" required>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="togglePassword">
        <label class="form-check-label" for="togglePassword">👁️ Hiển thị mật khẩu</label>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
      </div>
    </form>
  </div>
</div>

<script>
// Toggle hiển thị mật khẩu
document.getElementById('togglePassword').addEventListener('change', function () {
  const inputs = document.querySelectorAll('.password-input');
  inputs.forEach(input => {
    input.type = this.checked ? 'text' : 'password';
  });
});
</script>
