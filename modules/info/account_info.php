<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

// Lấy thông tin người dùng hiện tại
$userId = $_SESSION['user']['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Xử lý đường dẫn ảnh đại diện
$avatarPath = 'uploads/avatars/' . ($user['avatar'] ?? '');
$avatarSrc = (isset($user['avatar']) && file_exists(__DIR__ . '/../../public/' . $avatarPath))
    ? $avatarPath
    : 'assets/default_avatar.png';
?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <script>
    setTimeout(() => {
      const alert = document.querySelector('.alert');
      if (alert) {
        alert.classList.remove('show');
        alert.classList.add('fade');
      }
    }, 5000);
  </script>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="text-primary fw-bold mb-4">👤 Thông tin tài khoản</h5>
    <div class="row">
      <!-- Avatar -->
      <div class="col-md-3 text-center">
        <img src="<?= $avatarSrc ?>" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px;" alt="Avatar">
        <form action="index.php?page=update_avatar" method="POST" enctype="multipart/form-data" class="mt-2">
          <input type="file" name="avatar" class="form-control form-control-sm mb-2" accept="image/*" required>
          <button class="btn btn-secondary btn-sm" type="submit">🖼️ Cập nhật ảnh</button>
        </form>
      </div>

      <!-- Thông tin tài khoản -->
      <div class="col-md-9">
        <p><strong>🙍‍♂️ Tên đăng nhập:</strong> <?= htmlspecialchars($user['username'] ?? '') ?></p>
        <p><strong>📧 Email:</strong> <?= htmlspecialchars($user['email'] ?? '') ?></p>
        <p><strong>🔐 Vai trò:</strong> <?= ($user['role'] ?? '') === 'employee' ? 'Người dùng' : 'Quản trị viên' ?></p>
        <p><strong>⏰ Thời gian tạo:</strong> <?= htmlspecialchars($user['created_at'] ?? '') ?></p>

        <p>
          <strong>✅ Trạng thái:</strong>
          <?php
            if (!isset($user['status'])) {
              echo '<span class="text-muted">Không rõ</span>';
            } else {
              echo $user['status'] == 1
                ? '<span class="text-success">Hoạt động</span>'
                : '<span class="text-danger">Bị khóa</span>';
            }
          ?>
        </p>

        <div class="text-end mt-4">
          <a href="index.php?page=update_account" class="btn btn-primary btn-sm">
            ✏️ Cập nhật tài khoản
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
