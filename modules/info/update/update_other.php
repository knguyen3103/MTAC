<?php
ob_start();
require_once __DIR__ . '/../../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$userId = $_SESSION['user']['id'] ?? null;

// Lấy dữ liệu hiện tại
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();

// Lấy hợp đồng hiện tại của nhân viên
$contractStmt = $pdo->prepare("SELECT c.*, ct.name AS contract_type_name 
    FROM contracts c 
    JOIN contract_types ct ON c.contract_type_id = ct.id 
    WHERE c.employee_id = ?");
$contractStmt->execute([$info['id']]);
$contract = $contractStmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cập nhật bảng employees
    $stmt = $pdo->prepare("UPDATE employees SET 
        vaccine_type = ?, vaccine_date = ?, vaccine_doses = ?, vaccine_location = ?, vaccine_note = ?,
        uniform_date = ?, uniform_type = ?, uniform_quantity = ?,
        work_process = ?, concurrent_duty = ?, position = ?
        WHERE id = ?");
    $stmt->execute([
        $_POST['vaccine_type'], $_POST['vaccine_date'], $_POST['vaccine_doses'], $_POST['vaccine_location'], $_POST['vaccine_note'],
        $_POST['uniform_date'], $_POST['uniform_type'], $_POST['uniform_quantity'],
        $_POST['work_process'], $_POST['concurrent_duty'], $_POST['position'], $info['id']
    ]);

    // Cập nhật hợp đồng trong bảng contracts
    if (!empty($contract)) {
        $stmt2 = $pdo->prepare("UPDATE contracts SET contract_type_id = ? WHERE id = ?");
        $stmt2->execute([$_POST['contract_type_id'], $contract['id']]);
    }

    $_SESSION['success'] = "Cập nhật thông tin thành công!";
    header("Location: index.php?page=module_info&tab=other");
    exit;
}

// Lấy danh sách loại hợp đồng
$contractTypes = $pdo->query("SELECT id, name FROM contract_types")->fetchAll();
?>

<h2 class="mb-4">⚙️ Cập nhật thông tin khác</h2>
<form method="POST" class="row g-3">
  <!-- Tiêm chủng -->
  <h5 class="text-primary">💉 Thông tin tiêm chủng</h5>
  <div class="col-md-3"><label>Loại thuốc</label><input name="vaccine_type" class="form-control" value="<?= $info['vaccine_type'] ?? '' ?>"></div>
  <div class="col-md-3"><label>Ngày tiêm</label><input name="vaccine_date" type="date" class="form-control" value="<?= $info['vaccine_date'] ?? '' ?>"></div>
  <div class="col-md-3"><label>Số lần tiêm</label><input name="vaccine_doses" class="form-control" value="<?= $info['vaccine_doses'] ?? '' ?>"></div>
  <div class="col-md-3"><label>Nơi tiêm</label><input name="vaccine_location" class="form-control" value="<?= $info['vaccine_location'] ?? '' ?>"></div>
  <div class="col-md-12"><label>Ghi chú</label><input name="vaccine_note" class="form-control" value="<?= $info['vaccine_note'] ?? '' ?>"></div>

  <!-- Đồng phục -->
  <h5 class="text-primary mt-4">👕 Thông tin đồng phục</h5>
  <div class="col-md-4"><label>Ngày cấp</label><input name="uniform_date" type="date" class="form-control" value="<?= $info['uniform_date'] ?? '' ?>"></div>
  <div class="col-md-4"><label>Loại đồng phục</label><input name="uniform_type" class="form-control" value="<?= $info['uniform_type'] ?? '' ?>"></div>
  <div class="col-md-4"><label>Số lượng</label><input name="uniform_quantity" class="form-control" value="<?= $info['uniform_quantity'] ?? '' ?>"></div>

  <!-- Hợp đồng -->
  <h5 class="text-primary mt-4">📄 Hợp đồng & Công tác</h5>
  <div class="col-md-4">
    <label>Loại hợp đồng</label>
    <select name="contract_type_id" class="form-select">
      <?php foreach ($contractTypes as $ct): ?>
        <option value="<?= $ct['id'] ?>" <?= ($contract['contract_type_id'] ?? '') == $ct['id'] ? 'selected' : '' ?>>
          <?= $ct['name'] ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4"><label>Quá trình công tác</label><input name="work_process" class="form-control" value="<?= $info['work_process'] ?? '' ?>"></div>
  <div class="col-md-4"><label>Kiêm nhiệm</label><input name="concurrent_duty" class="form-control" value="<?= $info['concurrent_duty'] ?? '' ?>"></div>

  <!-- Vị trí -->
  <div class="col-md-6">
    <label>Vị trí</label>
    <input name="position" class="form-control" value="<?= htmlspecialchars($info['position'] ?? '') ?>">
  </div>

  <div class="col-12 text-end mt-3">
    <button class="btn btn-success">💾 Lưu thay đổi</button>
    <a href="index.php?page=module_info&tab=other" class="btn btn-secondary">🔙 Quay lại</a>
  </div>
</form>
<?php ob_end_flush(); ?>
