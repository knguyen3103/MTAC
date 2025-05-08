<?php
$pdo = require '../config/db.php';
$stmt = $pdo->query("SELECT applicant_id, user_id, criteria FROM evaluations");
$rows = $stmt->fetchAll();
?>

<h4>⭐ Danh sách đánh giá ứng viên</h4>
<table class="table table-bordered table-striped">
  <thead><tr><th>Ứng viên ID</th><th>Người đánh giá</th><th>Tiêu chí</th></tr></thead>
  <tbody>
    <?php foreach ($rows as $e): ?>
    <tr>
      <td><?= $e['applicant_id'] ?></td>
      <td><?= $e['user_id'] ?></td>
      <td><?= $e['criteria'] ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
