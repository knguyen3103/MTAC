<?php
ob_start();
require_once __DIR__ . '/../../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$userId = $_SESSION['user']['id'] ?? null;

// Lấy thông tin hiện tại
$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();
$gender = $info['gender'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE employees SET 
        full_name = ?, gender = ?, dob = ?, place_of_birth = ?, hometown = ?,
        marital_status = ?, tax_code = ?, family_city = ?, personal_city = ?, religion = ?, nationality = ?,
        id_type = ?, id_number = ?, passport_number = ?, passport_issue_date = ?
        WHERE email = (SELECT email FROM users WHERE id = ?)");

    $stmt->execute([
        $_POST['full_name'], $_POST['gender'], $_POST['dob'], $_POST['place_of_birth'], $_POST['hometown'],
        $_POST['marital_status'], $_POST['tax_code'], $_POST['family_city'], $_POST['personal_city'],
        $_POST['religion'], $_POST['nationality'], $_POST['id_type'], $_POST['id_number'],
        $_POST['passport_number'], $_POST['passport_issue_date'], $userId
    ]);

    $_SESSION['success'] = "Cập nhật thông tin thành công!";
    header("Location: index.php?page=module_info");
    exit;
}
?>

<h2 class="mb-4">📝 Cập nhật thông tin cơ bản</h2>
<form method="POST" class="needs-validation" novalidate>
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
      <input name="full_name" class="form-control" required value="<?= htmlspecialchars($info['full_name'] ?? '') ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label">Giới tính <span class="text-danger">*</span></label>
      <select name="gender" class="form-select" required>
        <option value="">-- Chọn giới tính --</option>
        <option value="male" <?= $gender === 'male' ? 'selected' : '' ?>>Nam</option>
        <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Nữ</option>
        <option value="other" <?= $gender === 'other' ? 'selected' : '' ?>>Khác</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Ngày sinh</label>
      <input name="dob" type="date" class="form-control" value="<?= htmlspecialchars($info['dob'] ?? '') ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Nơi sinh</label>
      <input name="place_of_birth" class="form-control" value="<?= htmlspecialchars($info['place_of_birth'] ?? '') ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Nguyên quán</label>
      <input name="hometown" class="form-control" value="<?= htmlspecialchars($info['hometown'] ?? '') ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Tình trạng hôn nhân</label>
      <input name="marital_status" class="form-control" value="<?= htmlspecialchars($info['marital_status'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">MST cá nhân</label>
      <input name="tax_code" class="form-control" value="<?= htmlspecialchars($info['tax_code'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">TP gia đình</label>
      <input name="family_city" class="form-control" value="<?= htmlspecialchars($info['family_city'] ?? '') ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">TP bản thân</label>
      <input name="personal_city" class="form-control" value="<?= htmlspecialchars($info['personal_city'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Tôn giáo</label>
      <input name="religion" class="form-control" value="<?= htmlspecialchars($info['religion'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Quốc tịch <span class="text-danger">*</span></label>
      <input name="nationality" class="form-control" required value="<?= htmlspecialchars($info['nationality'] ?? '') ?>">
    </div>

    <h5 class="mt-4">II. CMND / CCCD / HỘ chiếu</h5>

    <div class="col-md-4">
      <label class="form-label">Loại giấy tờ</label>
      <select name="id_type" class="form-select">
        <option value="">-- Chọn loại --</option>
        <option value="Căn cước công dân" <?= $info['id_type'] === 'Căn cước công dân' ? 'selected' : '' ?>>Căn cước công dân</option>
        <option value="Chứng minh nhân dân" <?= $info['id_type'] === 'Chứng minh nhân dân' ? 'selected' : '' ?>>Chứng minh nhân dân</option>
        <option value="Hộ chiếu" <?= $info['id_type'] === 'Hộ chiếu' ? 'selected' : '' ?>>Hộ chiếu</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Số CMND/CCCD <span class="text-danger">*</span></label>
      <input name="id_number" class="form-control" required value="<?= htmlspecialchars($info['id_number'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Số hộ chiếu</label>
      <input name="passport_number" class="form-control" value="<?= htmlspecialchars($info['passport_number'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Ngày cấp hộ chiếu <span class="text-danger">*</span></label>
      <input name="passport_issue_date" type="date" class="form-control" required value="<?= htmlspecialchars($info['passport_issue_date'] ?? '') ?>">
    </div>

    <div class="col-12 mt-4">
      <button type="submit" class="btn btn-success">💾 Lưu thay đổi</button>
      <a href="index.php?page=module_info" class="btn btn-secondary">🔙 Quay lại</a>
    </div>
  </div>
</form>

<?php ob_end_flush(); ?>
