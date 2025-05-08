<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';

// Lấy thông tin người dùng
$userId = $_SESSION['user']['id'] ?? null;
$userFullName = 'Người dùng';
$userAvatar = 'assets/default_avatar.png'; // Ảnh mặc định

if ($userId) {
    $stmt = $pdo->prepare("SELECT full_name, avatar FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    if ($user) {
        $userFullName = $user['full_name'] ?? $userFullName;
        $userAvatar = !empty($user['avatar']) ? 'uploads/avatars/' . $user['avatar'] : $userAvatar;

    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid px-4">

    <!-- Logo công ty -->
    <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php?page=dashboard">
      <img src="uploads/pictures/logo.png" alt="Logo công ty" style="height: 40px;" class="me-2">
      <span class="text-white">Cổng thông tin</span>
    </a>

    <!-- Toggle mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu chính -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav mx-auto fw-semibold text-uppercase">
        <li class="nav-item"><a class="nav-link text-white" href="index.php?page=dashboard">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="index.php?page=employees">Thông tin nhân viên</a></li>

        <!-- Tuyển dụng -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">Tuyển dụng</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item small" href="index.php?page=applicants">📄 Hồ sơ ứng viên</a></li>
            <li><a class="dropdown-item small" href="index.php?page=interview_notice">📅 Lịch phỏng vấn</a></li>
            <li><a class="dropdown-item small" href="index.php?page=jobs">🧾 Vị trí tuyển dụng</a></li>
            <li><a class="dropdown-item small" href="index.php?page=recruitment_plans">📝 Kế hoạch</a></li>
            <li><a class="dropdown-item small" href="index.php?page=evaluations">📋 Đánh giá</a></li>
            <li><a class="dropdown-item small" href="index.php?page=recruitment_reports">📈 Báo cáo</a></li>
          </ul>
        </li>

        <!-- Hồ sơ nhân sự -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">Hồ sơ nhân sự</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item small" href="index.php?page=internal_employees">👥 Nhân sự nội bộ</a></li>
            <li><a class="dropdown-item small" href="index.php?page=external_employees">👤 Nhân sự bên ngoài</a></li>
            <li><a class="dropdown-item small" href="index.php?page=labor_contracts">📄 Hợp đồng</a></li>
            <li><a class="dropdown-item small" href="index.php?page=decisions">📝 Quyết định</a></li>
            <li><a class="dropdown-item small" href="index.php?page=hr_reports">📈 Báo cáo</a></li>
          </ul>
        </li>
      </ul>

      <!-- Thông tin người dùng -->
      <div class="d-flex align-items-center ms-auto">
      <img src="<?= htmlspecialchars($userAvatar) . '?t=' . time() ?>" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">

        <div class="dropdown">
          <button class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
            <?= htmlspecialchars($userFullName) ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="index.php?page=module_info">👤 Thông tin cá nhân</a></li>
            <li><a class="dropdown-item" href="index.php?page=change_password">🔒 Đổi mật khẩu</a></li>
          </ul>
        </div>
        <a href="logout.php" class="btn btn-outline-light btn-sm ms-2">Đăng xuất</a>
      </div>

    </div>
  </div>
</nav>
