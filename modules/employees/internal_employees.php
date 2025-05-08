<?php
$pdo = require '../config/db.php'; // ✅ nhận đúng đối tượng PDO

$stmt = $pdo->query("SELECT employee_code, full_name, gender, phone, email, position FROM employees WHERE employee_type = 'internal'");
$employees = $stmt->fetchAll();
?>

<div class="card shadow-sm rounded-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0"><i class="bi bi-people-fill"></i> Danh sách nhân sự nội bộ</h5>
  </div>

  <div class="card-body bg-white">
    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle">
        <thead class="table-light text-center">
          <tr>
            <th>#</th>
            <th>Mã NV</th>
            <th>Họ và tên</th>
            <th>Giới tính</th>
            <th>Điện thoại</th>
            <th>Email</th>
            <th>Chức vụ</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($employees) > 0): ?>
            <?php foreach ($employees as $index => $emp): ?>
              <tr class="text-center">
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($emp['employee_code']) ?></td>
                <td class="text-start"><?= htmlspecialchars($emp['full_name']) ?></td>
                <td><?= $emp['gender'] === 'male' ? 'Nam' : ($emp['gender'] === 'female' ? 'Nữ' : 'Khác') ?></td>
                <td><?= htmlspecialchars($emp['phone']) ?></td>
                <td><?= htmlspecialchars($emp['email']) ?></td>
                <td><?= htmlspecialchars($emp['position']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center py-4 text-danger">Không có nhân sự nội bộ nào.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
