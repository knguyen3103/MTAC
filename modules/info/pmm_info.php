<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

// Hiển thị thông báo
if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
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
<?php endif;

// Lấy thông tin
$userId = $_SESSION['user']['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();
?>

<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="text-primary fw-bold mb-3">🏛️ Thông tin chính trị</h5>
    <p><i class="bi bi-flag"></i> <strong>Đảng phái chính trị:</strong> <?= htmlspecialchars($info['political_party'] ?? '') ?></p>
    <p><i class="bi bi-person-vcard"></i> <strong>Vị trí chính trị:</strong> <?= htmlspecialchars($info['political_position'] ?? '') ?></p>

    <h5 class="text-primary fw-bold mt-4 mb-3">🪖 Thông tin quân sự</h5>
    <p><i class="bi bi-shield-shaded"></i> <strong>Quân đội:</strong> <?= htmlspecialchars($info['military_service'] ?? '') ?></p>
    <p><i class="bi bi-journal-code"></i> <strong>Học vấn quân sự:</strong> <?= htmlspecialchars($info['military_education'] ?? '') ?></p>

    <h5 class="text-primary fw-bold mt-4 mb-3">🏥 Thông tin y tế</h5>
    <p><i class="bi bi-credit-card-2-front"></i> <strong>Bảo hiểm y tế:</strong> <?= htmlspecialchars($info['health_insurance'] ?? '') ?></p>
    <p><i class="bi bi-clipboard-heart"></i> <strong>Tiền sử bệnh lý:</strong> <?= htmlspecialchars($info['medical_history'] ?? '') ?></p>

    <div class="text-end mt-3">
      <a href="index.php?page=update_pmm&section=pmm" class="btn btn-primary btn-sm">
        ✏️ Cập nhật thông tin
      </a>
    </div>
  </div>
</div>
