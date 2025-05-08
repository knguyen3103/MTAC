<?php
require_once __DIR__ . '/../../config/db.php';

// KHÔNG gọi session_start() ở đây nếu đã có trong index.php

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name     = $_POST['full_name'];
    $email         = $_POST['email'];
    $phone         = $_POST['phone'];
    $dob           = $_POST['dob'];
    $university    = $_POST['university'];
    $major         = $_POST['major'];
    $department_id = $_POST['department_id'];
    $status        = $_POST['status'];

    // Xử lý upload file CV
    $cv_name = null;
    if (!empty($_FILES['cv']['name'])) {
        $allowed = ['pdf', 'doc', 'docx'];
        $ext = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $cv_name = time() . '_' . basename($_FILES['cv']['name']);
            $upload_dir = __DIR__ . '/../../public/uploads/cv/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $target_file = $upload_dir . $cv_name;

            if (!move_uploaded_file($_FILES['cv']['tmp_name'], $target_file)) {
                die("<div class='alert alert-danger'>❌ Upload thất bại!</div>");
            }
        } else {
            die("<div class='alert alert-danger'>❌ Chỉ chấp nhận file .pdf, .doc, .docx</div>");
        }
    }

    // Lưu dữ liệu vào database
    $stmt = $pdo->prepare("INSERT INTO applicants 
        (full_name, email, phone, dob, university, major, department_id, status, cv_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $full_name, $email, $phone, $dob,
        $university, $major, $department_id,
        $status, $cv_name
    ]);

    // Flash message và chuyển hướng
    $_SESSION['success'] = 'Upload CV thành công!';
    header("Location: index.php?page=applicants");
    exit;
}

// Lấy danh sách phòng ban sau khi xử lý POST để dùng cho form
$departments = $pdo->query("SELECT * FROM departments")->fetchAll();
?>

<!-- Giao diện form -->
<h2 class="mb-3">➕ Thêm ứng viên</h2>

<form method="POST" enctype="multipart/form-data">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Họ tên</label>
      <input name="full_name" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input name="email" type="email" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Số điện thoại</label>
      <input name="phone" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Ngày sinh</label>
      <input name="dob" type="date" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Trường</label>
      <input name="university" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Chuyên ngành</label>
      <input name="major" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Phòng ban</label>
      <select name="department_id" class="form-select" required>
        <option value="">-- Chọn phòng ban --</option>
        <?php foreach ($departments as $dep): ?>
          <option value="<?= $dep['id'] ?>"><?= htmlspecialchars($dep['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Trạng thái hồ sơ</label>
      <select name="status" class="form-select">
        <option value="draft">Nháp</option>
        <option value="approved">Đã duyệt</option>
        <option value="rejected">Từ chối</option>
      </select>
    </div>

    <div class="col-md-12">
      <label class="form-label">Tải lên CV</label>
      <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
    </div>
  </div>

  <button class="btn btn-success mt-3" type="submit">💾 Lưu</button>
</form>
