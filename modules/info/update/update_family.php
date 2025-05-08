<?php
ob_start();
require_once __DIR__ . '/../../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$userId = $_SESSION['user']['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE employees SET 
        father_name = ?, father_birth = ?, father_job = ?, father_phone = ?,
        mother_name = ?, mother_birth = ?, mother_job = ?, mother_phone = ?,
        spouse_name = ?, spouse_birth = ?, spouse_job = ?, spouse_phone = ?,
        child_name = ?, child_birth = ?, child_school = ?,
        sibling_name = ?, sibling_birth = ?, sibling_job = ?, sibling_phone = ?
        WHERE email = (SELECT email FROM users WHERE id = ?)");

    $stmt->execute([
        $_POST['father_name'], $_POST['father_birth'], $_POST['father_job'], $_POST['father_phone'],
        $_POST['mother_name'], $_POST['mother_birth'], $_POST['mother_job'], $_POST['mother_phone'],
        $_POST['spouse_name'], $_POST['spouse_birth'], $_POST['spouse_job'], $_POST['spouse_phone'],
        $_POST['child_name'], $_POST['child_birth'], $_POST['child_school'],
        $_POST['sibling_name'], $_POST['sibling_birth'], $_POST['sibling_job'], $_POST['sibling_phone'],
        $userId
    ]);

    $_SESSION['success'] = "Cập nhật thông tin gia đình thành công!";
    header("Location: index.php?page=module_info&tab=family");
    exit;
}

// Lấy thông tin để hiển thị form
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();

$years = range(date('Y'), 1900);
function selected($val, $compare) {
    return ($val == $compare) ? 'selected' : '';
}
?>


<h2 class="mb-4">👨‍👩‍👧‍👦 Cập nhật thông tin gia đình</h2>
<form method="POST">
<div class="row g-3">
  <!-- Cha -->
  <div class="col-md-4"><label>Họ tên cha</label><input name="father_name" class="form-control" value="<?= htmlspecialchars($info['father_name'] ?? '') ?>"></div>
  <div class="col-md-2"><label>Năm sinh</label>
    <select name="father_birth" class="form-select">
      <option value="">-- Chọn năm --</option>
      <?php foreach ($years as $year): ?>
        <option value="<?= $year ?>" <?= selected($info['father_birth'] ?? '', $year) ?>><?= $year ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4"><label>Nghề nghiệp</label><input name="father_job" class="form-control" value="<?= htmlspecialchars($info['father_job'] ?? '') ?>"></div>
  <div class="col-md-2"><label>SDT</label><input name="father_phone" class="form-control" value="<?= htmlspecialchars($info['father_phone'] ?? '') ?>"></div>

  <!-- Mẹ -->
  <div class="col-md-4"><label>Họ tên mẹ</label><input name="mother_name" class="form-control" value="<?= htmlspecialchars($info['mother_name'] ?? '') ?>"></div>
  <div class="col-md-2"><label>Năm sinh</label>
    <select name="mother_birth" class="form-select">
      <option value="">-- Chọn năm --</option>
      <?php foreach ($years as $year): ?>
        <option value="<?= $year ?>" <?= selected($info['mother_birth'] ?? '', $year) ?>><?= $year ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4"><label>Nghề nghiệp</label><input name="mother_job" class="form-control" value="<?= htmlspecialchars($info['mother_job'] ?? '') ?>"></div>
  <div class="col-md-2"><label>SDT</label><input name="mother_phone" class="form-control" value="<?= htmlspecialchars($info['mother_phone'] ?? '') ?>"></div>

  <!-- Vợ / chồng -->
  <div class="col-md-4"><label>Họ tên vợ/chồng</label><input name="spouse_name" class="form-control" value="<?= htmlspecialchars($info['spouse_name'] ?? '') ?>"></div>
  <div class="col-md-2"><label>Năm sinh</label>
    <select name="spouse_birth" class="form-select">
      <option value="">-- Chọn năm --</option>
      <?php foreach ($years as $year): ?>
        <option value="<?= $year ?>" <?= selected($info['spouse_birth'] ?? '', $year) ?>><?= $year ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4"><label>Nghề nghiệp</label><input name="spouse_job" class="form-control" value="<?= htmlspecialchars($info['spouse_job'] ?? '') ?>"></div>
  <div class="col-md-2"><label>SDT</label><input name="spouse_phone" class="form-control" value="<?= htmlspecialchars($info['spouse_phone'] ?? '') ?>"></div>

  <!-- Con -->
  <div class="col-md-4"><label>Họ tên con</label><input name="child_name" class="form-control" value="<?= htmlspecialchars($info['child_name'] ?? '') ?>"></div>
  <div class="col-md-2"><label>Năm sinh</label>
    <select name="child_birth" class="form-select">
      <option value="">-- Chọn năm --</option>
      <?php foreach ($years as $year): ?>
        <option value="<?= $year ?>" <?= selected($info['child_birth'] ?? '', $year) ?>><?= $year ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-6"><label>Trường học</label><input name="child_school" class="form-control" value="<?= htmlspecialchars($info['child_school'] ?? '') ?>"></div>

  <!-- Anh/chị -->
  <div class="col-md-4"><label>Họ tên anh/chị</label><input name="sibling_name" class="form-control" value="<?= htmlspecialchars($info['sibling_name'] ?? '') ?>"></div>
  <div class="col-md-2"><label>Năm sinh</label>
    <select name="sibling_birth" class="form-select">
      <option value="">-- Chọn năm --</option>
      <?php foreach ($years as $year): ?>
        <option value="<?= $year ?>" <?= selected($info['sibling_birth'] ?? '', $year) ?>><?= $year ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4"><label>Nghề nghiệp</label><input name="sibling_job" class="form-control" value="<?= htmlspecialchars($info['sibling_job'] ?? '') ?>"></div>
  <div class="col-md-2"><label>SDT</label><input name="sibling_phone" class="form-control" value="<?= htmlspecialchars($info['sibling_phone'] ?? '') ?>"></div>
</div>

<div class="mt-4 text-end">
  <button class="btn btn-success">💾 Lưu thay đổi</button>
  <a href="index.php?page=module_info&tab=family" class="btn btn-secondary">🔙 Quay lại</a>
</div>
</form>
<?php ob_end_flush(); ?>
