<?php
require_once __DIR__ . '/../../config/db.php'; // chỉ import
global $pdo; // nếu bạn khai báo $pdo bên ngoài


// Lấy tất cả hợp đồng
$sql = "SELECT c.*, e.full_name, ct.name AS contract_type_name
        FROM contracts c
        JOIN employees e ON c.employee_id = e.id
        JOIN contract_types ct ON c.contract_type_id = ct.id
        ORDER BY c.start_date DESC";
$stmt = $pdo->query($sql);
$contracts = $stmt->fetchAll();
?>

<div class="card shadow-sm rounded-4">
  <div class="card-header bg-warning text-dark">
    <h5 class="mb-0"><i class="bi bi-file-earmark-text-fill"></i> Danh sách Hợp đồng lao động</h5>
  </div>

  <div class="card-body bg-white">
    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle">
        <thead class="table-light text-center">
          <tr>
            <th>#</th>
            <th>Số HĐ</th>
            <th>Nhân viên</th>
            <th>Loại HĐ</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Tình trạng</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($contracts) > 0): ?>
            <?php foreach ($contracts as $index => $contract): ?>
              <tr class="text-center">
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($contract['contract_code']) ?></td>
                <td class="text-start"><?= htmlspecialchars($contract['full_name']) ?></td>
                <td><?= htmlspecialchars($contract['contract_type_name']) ?></td>
                <td><?= date('d/m/Y', strtotime($contract['start_date'])) ?></td>
                <td><?= $contract['end_date'] ? date('d/m/Y', strtotime($contract['end_date'])) : 'Không xác định' ?></td>
                <td>
                  <?php
                    if ($contract['status'] == 'active') echo '<span class="badge bg-success">Đang hiệu lực</span>';
                    elseif ($contract['status'] == 'expired') echo '<span class="badge bg-secondary">Hết hạn</span>';
                    else echo '<span class="badge bg-danger">Đã chấm dứt</span>';
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center py-4 text-danger">Không có hợp đồng lao động nào.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
