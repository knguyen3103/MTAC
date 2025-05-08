<?php
require_once __DIR__ . '/../../config/db.php';

// Lấy danh sách phòng ban
$departments = $pdo->query("SELECT * FROM departments")->fetchAll();

// Nhận tham số lọc từ URL
$department_id = $_GET['department_id'] ?? '';
$status = $_GET['status'] ?? '';

// Truy vấn danh sách ứng viên
$sql = "SELECT a.*, d.name AS department_name 
        FROM applicants a
        LEFT JOIN departments d ON a.department_id = d.id
        WHERE 1=1";
$params = [];

if ($department_id) {
    $sql .= " AND a.department_id = ?";
    $params[] = $department_id;
}

if ($status) {
    $sql .= " AND a.status = ?";
    $params[] = $status;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$applicants = $stmt->fetchAll();
?>

<h2 class="mb-3">📂 Hồ sơ ứng viên</h2>

<!-- 🔔 Thông báo flash -->
<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Nút thêm -->
<a href="index.php?page=add_applicant" class="btn btn-primary mb-4">➕ Thêm ứng viên</a>

<!-- Bộ lọc -->
<form method="GET" class="row g-2 mb-4">
  <input type="hidden" name="page" value="applicants">

  <div class="col-md-4">
    <label>Phòng ban</label>
    <select name="department_id" class="form-select" onchange="this.form.submit()">
      <option value="">-- Tất cả --</option>
      <?php foreach ($departments as $dep): ?>
        <option value="<?= $dep['id'] ?>" <?= $dep['id'] == $department_id ? 'selected' : '' ?>>
          <?= htmlspecialchars($dep['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-4">
    <label>Trạng thái</label>
    <select name="status" class="form-select" onchange="this.form.submit()">
      <option value="">-- Tất cả --</option>
      <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Nháp</option>
      <option value="approved" <?= $status === 'approved' ? 'selected' : '' ?>>Đã duyệt</option>
      <option value="rejected" <?= $status === 'rejected' ? 'selected' : '' ?>>Từ chối</option>
    </select>
  </div>
</form>

<!-- Danh sách ứng viên -->
<table class="table table-hover table-bordered align-middle">
  <thead class="table-primary">
    <tr>
      <th>Họ tên</th>
      <th>Email</th>
      <th>SĐT</th>
      <th>Phòng ban</th>
      <th>Trạng thái</th>
      <th>CV</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($applicants) === 0): ?>
      <tr>
        <td colspan="6" class="text-center text-muted">Không có dữ liệu phù hợp</td>
      </tr>
    <?php else: ?>
      <?php foreach ($applicants as $a): ?>
        <tr>
          <td><?= htmlspecialchars($a['full_name']) ?></td>
          <td><?= htmlspecialchars($a['email']) ?></td>
          <td><?= htmlspecialchars($a['phone']) ?></td>
          <td><?= htmlspecialchars($a['department_name']) ?></td>
          <td>
            <span class="badge bg-<?= 
              $a['status'] === 'approved' ? 'success' :
              ($a['status'] === 'rejected' ? 'danger' : 'secondary') ?>">
              <?= ucfirst($a['status']) ?>
            </span>
          </td>
          <td>
            <?php if (!empty($a['cv_path'])): ?>
              <a href="uploads/cv/<?= htmlspecialchars($a['cv_path']) ?>" target="_blank">📄 Xem</a>
            <?php else: ?>
              <span class="text-danger">⚠ Chưa có CV</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
