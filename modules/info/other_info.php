<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

if (isset($_SESSION['success'])): ?>
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
<?php unset($_SESSION['success']); endif;

// Lấy thông tin nhân viên
$userId = $_SESSION['user']['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();

// Lấy hợp đồng mới nhất
$stmtContract = $pdo->prepare("
  SELECT c.contract_code, ct.name AS contract_type, c.start_date, c.status
  FROM contracts c
  JOIN contract_types ct ON c.contract_type_id = ct.id
  WHERE c.employee_id = ?
  ORDER BY c.start_date DESC
  LIMIT 1
");
$stmtContract->execute([$info['id']]);
$contractData = $stmtContract->fetch();
?>

<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="text-primary fw-bold mb-3">💉 Thông tin tiêm chủng</h5>
    <div class="row mb-4">
      <div class="col-md-6">
        <p><strong>Loại thuốc tiêm chủng:</strong> <?= htmlspecialchars($info['vaccine_type'] ?? '') ?></p>
        <p><strong>Ngày tiêm:</strong> <?= htmlspecialchars($info['vaccine_date'] ?? '') ?></p>
        <p><strong>Số lần tiêm:</strong> <?= htmlspecialchars($info['vaccine_doses'] ?? '') ?></p>
      </div>
      <div class="col-md-6">
        <p><strong>Nơi tiêm chủng:</strong> <?= htmlspecialchars($info['vaccine_location'] ?? '') ?></p>
        <p><strong>Ghi chú:</strong> <?= htmlspecialchars($info['vaccine_note'] ?? '') ?></p>
      </div>
    </div>

    <h5 class="text-primary fw-bold mb-3">👕 Thông tin đồng phục</h5>
    <div class="row mb-4">
      <div class="col-md-4"><p><strong>Ngày cấp:</strong> <?= htmlspecialchars($info['uniform_date'] ?? '') ?></p></div>
      <div class="col-md-4"><p><strong>Loại đồng phục:</strong> <?= htmlspecialchars($info['uniform_type'] ?? '') ?></p></div>
      <div class="col-md-4"><p><strong>Số lượng:</strong> <?= htmlspecialchars($info['uniform_quantity'] ?? '') ?></p></div>
    </div>

    <h5 class="text-primary fw-bold mb-3">📄 Thông tin công việc</h5>
    <div class="mb-2">
  <strong>📝 Hợp đồng lao động:</strong>
  <?= $contractData ? htmlspecialchars($contractData['contract_type']) : 'Chưa có dữ liệu' ?>
</div>


    <div class="mb-2"><strong>📌 Quá trình công tác:</strong> <?= htmlspecialchars($info['work_process'] ?? '') ?></div>
    <div class="mb-2"><strong>👤 Kiêm nhiệm:</strong> <?= htmlspecialchars($info['position'] ?? '') ?></div>

    <div class="text-end mt-3">
      <a href="index.php?page=update_other&section=other" class="btn btn-primary btn-sm">✏️ Cập nhật thông tin</a>
    </div>
  </div>
</div>
