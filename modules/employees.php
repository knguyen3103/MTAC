<?php
$pdo = require '../config/db.php';

// Sửa lại: sắp xếp theo ID tăng dần
$stmt = $pdo->query("SELECT employee_code, full_name, gender, phone, email, position, join_date FROM employees ORDER BY id ASC");
$employees = $stmt->fetchAll();
?>

<div class="container-fluid px-4">
  <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h2 class="fw-semibold text-primary">👥 Danh sách nhân viên</h2>
  </div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-4 py-3">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-center text-secondary fw-semibold border-bottom">
            <tr>
              <th>STT</th>
              <th>Mã NV</th>
              <th>Họ tên</th>
              <th>Giới tính</th>
              <th>Điện thoại</th>
              <th>Email</th>
              <th>Chức vụ</th>
              <th>Ngày vào làm</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php if (count($employees) > 0): ?>
              <?php foreach ($employees as $index => $emp): ?>
                <tr>
                  <td class="text-muted"><?= $index + 1 ?></td>
                  <td><span class="badge bg-secondary"><?= htmlspecialchars($emp['employee_code']) ?></span></td>
                  <td class="text-start"><?= htmlspecialchars($emp['full_name']) ?></td>
                  <td><?= $emp['gender'] === 'male' ? 'Nam' : ($emp['gender'] === 'female' ? 'Nữ' : 'Khác') ?></td>
                  <td><?= htmlspecialchars($emp['phone']) ?></td>
                  <td class="text-start"><?= htmlspecialchars($emp['email']) ?></td>
                  <td><span class="badge bg-info text-dark"><?= htmlspecialchars($emp['position']) ?></span></td>
                  <td><?= date('d/m/Y', strtotime($emp['join_date'])) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="py-4 text-danger">Không có nhân viên nào.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
