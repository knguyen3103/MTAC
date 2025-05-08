<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

// Hiển thị thông báo
if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
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
<?php unset($_SESSION['success']); endif;

// Lấy thông tin nhân viên
$userId = $_SESSION['user']['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();
?>

<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-telephone-fill text-dark"></i> Thông tin liên hệ</h5>
    <div class="row mb-4">
      <div class="col-md-6">
        <p><i class="bi bi-phone text-dark"></i> <strong>ĐT di động:</strong> <?= htmlspecialchars($info['phone'] ?? '') ?></p>
        <p><i class="bi bi-building text-dark"></i> <strong>ĐT công ty:</strong> <?= htmlspecialchars($info['company_phone'] ?? '') ?></p>
        <p><i class="bi bi-person-lines-fill text-dark"></i> <strong>ĐT người thân:</strong> <?= htmlspecialchars($info['relative_phone'] ?? '') ?></p>
        <p><i class="bi bi-envelope text-dark"></i> <strong>Email cá nhân:</strong> <?= htmlspecialchars($info['personal_email'] ?? '') ?></p>
        <p><i class="bi bi-envelope-paper text-dark"></i> <strong>Email công ty:</strong> <?= htmlspecialchars($info['company_email'] ?? '') ?></p>
      </div>
      <div class="col-md-6">
        <p><i class="bi bi-envelope-open text-dark"></i> <strong>Email khác:</strong> <?= htmlspecialchars($info['other_email'] ?? '') ?></p>
        <p><i class="bi bi-facebook text-dark"></i> <strong>Facebook:</strong> <?= htmlspecialchars($info['facebook'] ?? '') ?></p>
        <p><i class="bi bi-chat-dots text-dark"></i> <strong>Zalo:</strong> <?= htmlspecialchars($info['zalo'] ?? '') ?></p>
        <p><i class="bi bi-camera-video text-dark"></i> <strong>Tiktok:</strong> <?= htmlspecialchars($info['tiktok'] ?? '') ?></p>
        <p><i class="bi bi-link-45deg text-dark"></i> <strong>Liên hệ khác:</strong> <?= htmlspecialchars($info['other_contact'] ?? '') ?></p>
      </div>
    </div>

    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-house-fill text-dark"></i> Hộ khẩu thường trú</h5>
    <div class="row mb-4">
      <div class="col-md-6">
        <p><i class="bi bi-flag text-dark"></i> <strong>Quốc gia:</strong> <?= htmlspecialchars($info['country'] ?? '') ?></p>
        <p><i class="bi bi-geo-alt text-dark"></i> <strong>Tỉnh/Thành phố:</strong> <?= htmlspecialchars($info['province'] ?? '') ?></p>
        <p><i class="bi bi-signpost text-dark"></i> <strong>Quận/Huyện:</strong> <?= htmlspecialchars($info['district'] ?? '') ?></p>
        <p><i class="bi bi-signpost-2 text-dark"></i> <strong>Phường/Xã:</strong> <?= htmlspecialchars($info['ward'] ?? '') ?></p>
      </div>
      <div class="col-md-6">
        <p><i class="bi bi-journal-check text-dark"></i> <strong>Số hộ khẩu:</strong> <?= htmlspecialchars($info['household_number'] ?? '') ?></p>
        <p><i class="bi bi-person-vcard text-dark"></i> <strong>Mã số gia đình:</strong> <?= htmlspecialchars($info['family_id'] ?? '') ?></p>
        <p><i class="bi bi-person-badge text-dark"></i> <strong>Là chủ hộ:</strong> <?= ($info['is_householder'] ?? 0) == 1 ? 'Có' : 'Không' ?></p>
        <p><i class="bi bi-geo-fill text-dark"></i> <strong>Địa chỉ:</strong> <?= htmlspecialchars($info['address'] ?? '') ?></p>
      </div>
    </div>

    <div class="text-end mt-3">
      <a href="index.php?page=update_contact&section=contact" class="btn btn-primary btn-sm">
        ✏️ Cập nhật thông tin
      </a>
    </div>
  </div>
</div>
