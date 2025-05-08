<?php
ob_start();
require_once __DIR__ . '/../../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$userId = $_SESSION['user']['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM employees WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$userId]);
$info = $stmt->fetch();

// Cập nhật dữ liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE employees SET 
        phone = ?, company_phone = ?, relative_phone = ?, personal_email = ?, company_email = ?,
        other_email = ?, facebook = ?, zalo = ?, tiktok = ?, other_contact = ?,
        country = ?, province = ?, district = ?, ward = ?, household_number = ?, 
        family_id = ?, is_householder = ?, address = ?
        WHERE email = (SELECT email FROM users WHERE id = ?)");

    $stmt->execute([
        $_POST['phone'], $_POST['company_phone'], $_POST['relative_phone'],
        $_POST['personal_email'], $_POST['company_email'], $_POST['other_email'],
        $_POST['facebook'], $_POST['zalo'], $_POST['tiktok'], $_POST['other_contact'],
        $_POST['country'], $_POST['province'], $_POST['district'], $_POST['ward'],
        $_POST['household_number'], $_POST['family_id'], $_POST['is_householder'], $_POST['address'],
        $userId
    ]);

    $_SESSION['success'] = "Cập nhật thông tin liên hệ thành công!";
    header("Location: index.php?page=module_info&tab=contact");
    exit;
}
?>

<!-- Form cập nhật -->
<h2 class="mb-4">📬 Cập nhật thông tin liên hệ</h2>
<form method="POST" class="row g-3">
  <div class="col-md-4">
    <label>Số điện thoại</label>
    <input name="phone" class="form-control" value="<?= htmlspecialchars($info['phone'] ?? '') ?>">
  </div>
  <div class="col-md-4">
    <label>Điện thoại công ty</label>
    <input name="company_phone" class="form-control" value="<?= htmlspecialchars($info['company_phone'] ?? '') ?>">
  </div>
  <div class="col-md-4">
    <label>Điện thoại người thân</label>
    <input name="relative_phone" class="form-control" value="<?= htmlspecialchars($info['relative_phone'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Email cá nhân</label>
    <input name="personal_email" class="form-control" value="<?= htmlspecialchars($info['personal_email'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Email công ty</label>
    <input name="company_email" class="form-control" value="<?= htmlspecialchars($info['company_email'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Email khác</label>
    <input name="other_email" class="form-control" value="<?= htmlspecialchars($info['other_email'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Facebook</label>
    <input name="facebook" class="form-control" value="<?= htmlspecialchars($info['facebook'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Zalo</label>
    <input name="zalo" class="form-control" value="<?= htmlspecialchars($info['zalo'] ?? '') ?>">
  </div>
  <div class="col-md-6">
    <label>Tiktok</label>
    <input name="tiktok" class="form-control" value="<?= htmlspecialchars($info['tiktok'] ?? '') ?>">
  </div>
  <div class="col-md-12">
    <label>Liên hệ khác</label>
    <input name="other_contact" class="form-control" value="<?= htmlspecialchars($info['other_contact'] ?? '') ?>">
  </div>

  <h5 class="mt-4">🏠 Hộ khẩu thường trú</h5>
  <div class="col-md-4">
    <label>Quốc gia</label>
    <input name="country" class="form-control" value="<?= htmlspecialchars($info['country'] ?? '') ?>">
  </div>
  <div class="col-md-4">
    <label>Tỉnh/Thành phố</label>
    <input name="province" class="form-control" value="<?= htmlspecialchars($info['province'] ?? '') ?>">
  </div>
  <div class="col-md-4">
    <label>Quận/Huyện</label>
    <input name="district" class="form-control" value="<?= htmlspecialchars($info['district'] ?? '') ?>">
  </div>
  <div class="col-md-4">
    <label>Phường/Xã</label>
    <input name="ward" class="form-control" value="<?= htmlspecialchars($info['ward'] ?? '') ?>">
  </div>
  <div class="col-md-4">
    <label>Số hộ khẩu</label>
    <input name="household_number" class="form-control" value="<?= htmlspecialchars($info['household_number'] ?? '') ?>">
  </div>
  <div class="col-md-4">
    <label>Mã số gia đình</label>
    <input name="family_id" class="form-control" value="<?= htmlspecialchars($info['family_id'] ?? '') ?>">
  </div>
  <div class="col-md-4">
    <label>Là chủ hộ</label>
    <select name="is_householder" class="form-select">
      <option value="0" <?= ($info['is_householder'] ?? 0) == 0 ? 'selected' : '' ?>>Không</option>
      <option value="1" <?= ($info['is_householder'] ?? 0) == 1 ? 'selected' : '' ?>>Có</option>
    </select>
  </div>
  <div class="col-md-8">
    <label>Địa chỉ</label>
    <input name="address" class="form-control" value="<?= htmlspecialchars($info['address'] ?? '') ?>">
  </div>

  <div class="col-12 mt-3">
    <button class="btn btn-success" type="submit">💾 Lưu thay đổi</button>
    <a href="index.php?page=module_info&tab=contact" class="btn btn-secondary">🔙 Quay lại</a>
  </div>
</form>

<?php ob_end_flush(); ?>
