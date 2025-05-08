<?php
$pdo = require '../config/db.php';
$stmt = $pdo->query("SELECT full_name, email, phone, university FROM applicants");
$rows = $stmt->fetchAll();
?>

<h4>📄 Danh sách ứng viên</h4>
<table class="table table-bordered table-striped">
  <thead><tr><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Trường</th></tr></thead>
  <tbody>
    <?php foreach ($rows as $a): ?>
    <tr>
      <td><?= $a['full_name'] ?></td>
      <td><?= $a['email'] ?></td>
      <td><?= $a['phone'] ?></td>
      <td><?= $a['university'] ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
