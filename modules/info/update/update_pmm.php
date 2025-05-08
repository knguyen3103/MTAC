<?php
ob_start();
require_once __DIR__ . '/../../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$userId = $_SESSION['user']['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("UPDATE employees SET 
    political_party = ?, political_position = ?, 
    military_service = ?, military_education = ?, 
    health_insurance = ?, medical_history = ?
    WHERE email = (SELECT email FROM users WHERE id = ?)");

  $stmt->execute([
    $_POST['political_party'], $_POST['political_position'],
    $_POST['military_service'], $_POST['military_education'],
    $_POST['health_insurance'], $_POST['medical_history'],
    $userId
  ]);

  $_SESSION['success'] = "Cập nhật thông tin thành công!";
  header("Location: index.php?page=module_info&tab=pmm");
  exit;
}
?>

<h2 class="mb-4">🛡️ Cập nhật thông tin chính trị / quân sự / y tế</h2>
<form method="POST" class="row g-3">

  <h5 class="text-primary fw-bold">Thông tin chính trị</h5>
  <div class="col-md-6">
    <label>Đảng phái chính trị</label>
    <input name="political_party" class="form-control" value="<?= htmlspecialchars($info['political_party'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Vị trí chính trị</label>
    <input name="political_position" class="form-control" value="<?= htmlspecialchars($info['political_position'] ?? '') ?>">
  </div>

  <h5 class="text-primary fw-bold">Thông tin quân sự</h5>
  <div class="col-md-6">
    <label>Quân đội</label>
    <input name="military_service" class="form-control" value="<?= htmlspecialchars($info['military_service'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Học vấn quân sự</label>
    <input name="military_education" class="form-control" value="<?= htmlspecialchars($info['military_education'] ?? '') ?>">
  </div>

  <h5 class="text-success fw-bold">Thông tin y tế</h5>
  <div class="col-md-6">
    <label>Bảo hiểm y tế</label>
    <input name="health_insurance" class="form-control" value="<?= htmlspecialchars($info['health_insurance'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Tiền sử bệnh lý</label>
    <input name="medical_history" class="form-control" value="<?= htmlspecialchars($info['medical_history'] ?? '') ?>">
  </div>

  <div class="col-12 text-end mt-3">
    <button class="btn btn-success">💾 Lưu thay đổi</button>
    <a href="index.php?page=module_info&tab=pmm" class="btn btn-secondary">🔙 Quay lại</a>
  </div>
</form>
<?php ob_end_flush(); ?>
