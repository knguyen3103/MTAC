<?php
require_once __DIR__ . '/../config/db.php';
?>

<h3 class="mb-3">💼 Danh sách vị trí tuyển dụng</h3>

<!-- Thông báo flash -->
<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Bảng danh sách -->
<table class="table table-bordered table-hover align-middle">
  <thead class="table-primary">
    <tr>
      <th>Vị trí</th>
      <th>Phòng ban</th>
      <th>Yêu cầu</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $jobs = $pdo->query("
      SELECT r.id, r.position, r.requirements, d.name AS department 
      FROM recruitment_requests r
      LEFT JOIN departments d ON r.department_id = d.id
    ")->fetchAll();

    if (count($jobs) === 0): ?>
      <tr>
        <td colspan="4" class="text-center text-muted">Chưa có vị trí tuyển dụng nào</td>
      </tr>
    <?php else: ?>
      <?php foreach ($jobs as $job): ?>
        <tr>
          <td><?= htmlspecialchars($job['position']) ?></td>
          <td><?= htmlspecialchars($job['department']) ?></td>
          <td><?= nl2br(htmlspecialchars($job['requirements'])) ?></td>
          <td>
            <a href="modules/applicants/process.php?action=apply&job_id=<?= $job['id'] ?>"
               class="btn btn-sm btn-primary"
               onclick="return confirm('Xác nhận ứng tuyển vị trí này?');">
              Ứng tuyển
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
