<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

$userId = $_SESSION['user']['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();

function show_year($year) {
    return ($year && $year !== '0000') ? $year : '';
}
?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
    <h5 class="text-primary fw-bold mb-4">👨‍👩‍👧‍👦 Thông tin gia đình</h5>
    
    <div class="row mb-4">
      <!-- Cha -->
      <div class="col-md-4 mb-3">
        <p><i class="bi bi-person-fill"></i> <strong>Họ tên cha:</strong> <?= htmlspecialchars($info['father_name'] ?? '') ?></p>
        <p><i class="bi bi-calendar"></i> <strong>Năm sinh:</strong> <?= show_year($info['father_birth'] ?? '') ?></p>
        <p><i class="bi bi-briefcase-fill"></i> <strong>Nghề nghiệp:</strong> <?= htmlspecialchars($info['father_job'] ?? '') ?></p>
        <p><i class="bi bi-telephone-fill"></i> <strong>SĐT:</strong> <?= htmlspecialchars($info['father_phone'] ?? '') ?></p>
      </div>

      <!-- Mẹ -->
      <div class="col-md-4 mb-3">
        <p><i class="bi bi-person-fill"></i> <strong>Họ tên mẹ:</strong> <?= htmlspecialchars($info['mother_name'] ?? '') ?></p>
        <p><i class="bi bi-calendar"></i> <strong>Năm sinh:</strong> <?= show_year($info['mother_birth'] ?? '') ?></p>
        <p><i class="bi bi-briefcase-fill"></i> <strong>Nghề nghiệp:</strong> <?= htmlspecialchars($info['mother_job'] ?? '') ?></p>
        <p><i class="bi bi-telephone-fill"></i> <strong>SĐT:</strong> <?= htmlspecialchars($info['mother_phone'] ?? '') ?></p>
      </div>

      <!-- Anh/chị -->
      <div class="col-md-4 mb-3">
        <p><i class="bi bi-person-vcard"></i> <strong>Họ tên anh/chị:</strong> <?= htmlspecialchars($info['sibling_name'] ?? '') ?></p>
        <p><i class="bi bi-calendar"></i> <strong>Năm sinh:</strong> <?= show_year($info['sibling_birth'] ?? '') ?></p>
        <p><i class="bi bi-briefcase-fill"></i> <strong>Nghề nghiệp:</strong> <?= htmlspecialchars($info['sibling_job'] ?? '') ?></p>
        <p><i class="bi bi-telephone-fill"></i> <strong>SĐT:</strong> <?= htmlspecialchars($info['sibling_phone'] ?? '') ?></p>
      </div>
    </div>

    <div class="row mb-4">
      <!-- Vợ / chồng -->
      <div class="col-md-6 mb-3">
        <p><i class="bi bi-person-hearts"></i> <strong>Họ tên vợ/chồng:</strong> <?= htmlspecialchars($info['spouse_name'] ?? '') ?></p>
        <p><i class="bi bi-calendar"></i> <strong>Năm sinh:</strong> <?= show_year($info['spouse_birth'] ?? '') ?></p>
        <p><i class="bi bi-briefcase-fill"></i> <strong>Nghề nghiệp:</strong> <?= htmlspecialchars($info['spouse_job'] ?? '') ?></p>
        <p><i class="bi bi-telephone-fill"></i> <strong>SĐT:</strong> <?= htmlspecialchars($info['spouse_phone'] ?? '') ?></p>
      </div>

      <!-- Con -->
      <div class="col-md-6 mb-3">
        <p><i class="bi bi-person-bounding-box"></i> <strong>Họ tên con:</strong> <?= htmlspecialchars($info['child_name'] ?? '') ?></p>
        <p><i class="bi bi-calendar"></i> <strong>Năm sinh:</strong> <?= show_year($info['child_birth'] ?? '') ?></p>
        <p><i class="bi bi-mortarboard-fill"></i> <strong>Trường học:</strong> <?= htmlspecialchars($info['child_school'] ?? '') ?></p>
      </div>
    </div>

    <div class="text-end mt-3">
      <a href="index.php?page=update_family&section=family" class="btn btn-primary btn-sm">
        ✏️ Cập nhật thông tin
      </a>
    </div>
  </div>
</div>
