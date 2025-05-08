<?php
require_once __DIR__ . '/../../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Xác định chế độ xem
$view = $_GET['view'] ?? 'personal';
$userId = $_SESSION['user']['id'] ?? null;

// Lấy applicant_id
$appStmt = $pdo->prepare("SELECT id FROM applicants WHERE email = (SELECT email FROM users WHERE id = ?)");
$appStmt->execute([$userId]);
$applicantId = $appStmt->fetchColumn();

// Truy vấn dữ liệu
if ($view === 'all') {
    // HR xem tất cả
    $stmt = $pdo->query("
        SELECT i.*, a.full_name, a.major 
        FROM interviews i
        JOIN applicants a ON i.applicant_id = a.id
        ORDER BY interview_date, interview_time
    ");
} else {
    // Ứng viên xem lịch của mình
    $stmt = $pdo->prepare("
        SELECT i.*, a.major 
        FROM interviews i
        JOIN applicants a ON i.applicant_id = a.id
        WHERE i.applicant_id = ?
        ORDER BY interview_date, interview_time
    ");
    $stmt->execute([$applicantId]);
}

$interviews = $stmt->fetchAll();
?>

<h3 class="mb-3">
  📅 <?= $view === 'all' ? 'Lịch phỏng vấn toàn bộ ứng viên' : 'Lịch phỏng vấn cá nhân' ?>
</h3>

<!-- Nút chuyển chế độ -->
<div class="mb-3">
  <?php if ($view === 'all'): ?>
    <a href="index.php?page=interview_notice&view=personal" class="btn btn-outline-primary btn-sm">
      👤 Xem lịch phỏng vấn cá nhân
    </a>
  <?php else: ?>
    <a href="index.php?page=interview_notice&view=all" class="btn btn-outline-secondary btn-sm">
      👥 Xem lịch phỏng vấn toàn bộ ứng viên
    </a>
  <?php endif; ?>
</div>

<?php if (empty($interviews)): ?>
  <div class="alert alert-info">Không có lịch phỏng vấn nào.</div>
<?php else: ?>
  <table class="table table-hover table-bordered align-middle">
    <thead class="table-primary">
      <tr>
        <?php if ($view === 'all'): ?>
          <th>Ứng viên</th>
        <?php endif; ?>
        <th>Ngành học</th>
        <th>Ngày</th>
        <th>Giờ</th>
        <th>Địa điểm</th>
        <th>Ghi chú</th>
        <th>Trạng thái</th>
        <?php if ($view === 'personal'): ?>
          <th>Xác nhận</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($interviews as $iv): ?>
        <tr>
          <?php if ($view === 'all'): ?>
            <td><?= htmlspecialchars($iv['full_name'] ?? 'N/A') ?></td>
          <?php endif; ?>
          <td><?= htmlspecialchars($iv['major'] ?? 'Không rõ') ?></td>
          <td><?= date('d/m/Y', strtotime($iv['interview_date'])) ?></td>
          <td><?= date('H:i', strtotime($iv['interview_time'])) ?></td>
          <td><?= htmlspecialchars($iv['location'] ?? '-') ?></td>
          <td><?= htmlspecialchars($iv['notes'] ?? '-') ?></td>
          <td>
            <?php
              $status = $iv['status'];
              $badge = match ($status) {
                'confirmed' => 'success',
                'cancelled' => 'danger',
                default => 'secondary'
              };
            ?>
            <span class="badge bg-<?= $badge ?>">
              <?= ucfirst($status) ?>
            </span>
          </td>
          <?php if ($view === 'personal'): ?>
            <td>
              <?php if ($status === 'scheduled'): ?>
                <a href="modules/applicants/process.php?action=confirm_interview&id=<?= $iv['id'] ?>"
                   class="btn btn-sm btn-success"
                   onclick="return confirm('Xác nhận tham gia phỏng vấn này?')">
                  ✅ Xác nhận
                </a>
              <?php else: ?>
                <span class="text-muted">Đã xác nhận</span>
              <?php endif; ?>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
