<?php
require_once __DIR__ . '/../../config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$tab = $_GET['tab'] ?? 'personal';
?>

<h2 class="mb-4"><i class="bi bi-person-circle"></i> Thông tin cá nhân</h2>

<!-- Tabs -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item"><a class="nav-link <?= $tab === 'personal' ? 'active' : '' ?>" href="index.php?page=module_info&tab=personal">Thông tin cơ bản</a></li>
  <li class="nav-item"><a class="nav-link <?= $tab === 'contact' ? 'active' : '' ?>" href="index.php?page=module_info&tab=contact">Thông tin liên hệ</a></li>
  <li class="nav-item"><a class="nav-link <?= $tab === 'family' ? 'active' : '' ?>" href="index.php?page=module_info&tab=family">Thông tin gia đình</a></li>
  <li class="nav-item"><a class="nav-link <?= $tab === 'pmm' ? 'active' : '' ?>" href="index.php?page=module_info&tab=pmm">Chính trị, quân sự, y tế</a></li>
  <li class="nav-item"><a class="nav-link <?= $tab === 'other' ? 'active' : '' ?>" href="index.php?page=module_info&tab=other">Thông tin khác</a></li>
  <li class="nav-item"><a class="nav-link <?= $tab === 'account' ? 'active' : '' ?>" href="index.php?page=module_info&tab=account">Tài khoản</a></li>
</ul>

<!-- Nội dung tab -->
<div class="tab-content p-3 border border-top-0 bg-white rounded-bottom shadow-sm">
  <?php
    $tabFiles = [
      'personal' => 'personal_info.php',
      'contact'  => 'contact_info.php',
      'family'   => 'family_info.php',
      'pmm'      => 'pmm_info.php',
      'other'  => 'other_info.php',
      'account'  => 'account_info.php'
    ];

    $targetFile = $tabFiles[$tab] ?? 'personal_info.php';
    $path = __DIR__ . '/' . $targetFile;

    if (file_exists($path)) {
        include $path;
    } else {  
        echo "<div class='alert alert-warning'>Không tìm thấy nội dung cho tab này.</div>";
    }
  ?>
</div>
