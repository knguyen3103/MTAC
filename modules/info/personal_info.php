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

// Lấy thông tin
$userId = $_SESSION['user']['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();
?>

<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="text-primary fw-bold mb-4"><i class="bi bi-person-lines-fill"></i> I. Thông tin chung</h5>
    <div class="row mb-4">
      <div class="col-md-6">
        <p><i class="bi bi-person-vcard"></i> <strong>Mã nhân viên:</strong> <?= htmlspecialchars($info['employee_code'] ?? '') ?></p>
        <p><i class="bi bi-person-fill"></i> <strong>Họ và tên:</strong> <?= htmlspecialchars($info['full_name'] ?? '') ?></p>
        <p><i class="bi bi-gender-ambiguous"></i> <strong>Giới tính:</strong> <?= htmlspecialchars($info['gender'] ?? '') ?></p>
        <p><i class="bi bi-calendar-date"></i> <strong>Ngày sinh:</strong> <?= htmlspecialchars($info['dob'] ?? '') ?></p>
        <p><i class="bi bi-geo-alt-fill"></i> <strong>Nơi sinh:</strong> <?= htmlspecialchars($info['place_of_birth'] ?? '') ?></p>
        <p><i class="bi bi-house-door-fill"></i> <strong>Nguyên quán:</strong> <?= htmlspecialchars($info['hometown'] ?? '') ?></p>
      </div>
      <div class="col-md-6">
        <p><i class="bi bi-heart-fill"></i> <strong>Tình trạng hôn nhân:</strong> <?= htmlspecialchars($info['marital_status'] ?? '') ?></p>
        <p><i class="bi bi-cash-coin"></i> <strong>MST cá nhân:</strong> <?= htmlspecialchars($info['tax_code'] ?? '') ?></p>
        <p><i class="bi bi-building-fill"></i> <strong>TP gia đình:</strong> <?= htmlspecialchars($info['family_city'] ?? '') ?></p>
        <p><i class="bi bi-person-lines-fill"></i> <strong>TP bản thân:</strong> <?= htmlspecialchars($info['personal_city'] ?? '') ?></p>
        <p><i class="bi bi-stars"></i> <strong>Tôn giáo:</strong> <?= htmlspecialchars($info['religion'] ?? '') ?></p>
        <p><i class="bi bi-flag-fill"></i> <strong>Quốc tịch:</strong> <?= htmlspecialchars($info['nationality'] ?? '') ?></p>
      </div>
    </div>

    <h5 class="text-primary fw-bold mb-4"><i class="bi bi-credit-card-2-front-fill"></i> II. CMND / CCCD / Hộ chiếu</h5>
    <div class="row mb-3">
      <div class="col-md-6">
        <p><i class="bi bi-card-text"></i> <strong>Loại giấy tờ:</strong> <?= htmlspecialchars($info['id_type'] ?? '') ?></p>
        <p><i class="bi bi-123"></i> <strong>Số CMND/CCCD:</strong> <?= htmlspecialchars($info['id_number'] ?? '') ?></p>
      </div>
      <div class="col-md-6">
        <p><i class="bi bi-passport-fill"></i> <strong>Số hộ chiếu:</strong> <?= htmlspecialchars($info['passport_number'] ?? '') ?></p>
        <p><i class="bi bi-calendar-check-fill"></i> <strong>Ngày cấp hộ chiếu:</strong> <?= htmlspecialchars($info['passport_issue_date'] ?? '') ?></p>
      </div>
    </div>

    <div class="text-end mt-3">
      <a href="index.php?page=update_personal&section=basic" class="btn btn-primary">
        ✏️ Cập nhật thông tin
      </a>
    </div>
  </div>
</div>
