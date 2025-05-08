<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../../config/db.php';

$userId = $_SESSION['user']['id'] ?? null;

// Lấy dữ liệu người dùng hiện tại
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    
    // Cập nhật tài khoản
    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->execute([$username, $email, $userId]);

    $_SESSION['success'] = "Cập nhật thông tin tài khoản thành công!";
    header("Location: index.php?page=account_info");
    exit;
}
?>

<h5 class="mb-3 fw-bold text-primary">⚙️ Cập nhật thông tin tài khoản</h5>
<form method="POST" class="p-4 border rounded bg-light shadow-sm" style="max-width: 500px;">
  <div class="mb-3">
    <label class="form-label">👤 Tên đăng nhập</label>
    <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($user['username'] ?? '') ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">📧 Email</label>
    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email'] ?? '') ?>">
  </div>

  <div class="col-12 mt-3">
    <button class="btn btn-success" type="submit">💾 Lưu thay đổi</button>
    <a href="index.php?page=module_info&tab=account" class="btn btn-secondary">🔙 Quay lại</a>
  </div>
</form>
