<?php
ob_start(); // Bắt đầu đệm đầu ra
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Xử lý trước nếu form add_applicant được submit (tránh lỗi header)
$page = $_GET['page'] ?? 'dashboard';
if ($page === 'add_applicant' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../modules/applicants/add.php';
    exit; // dừng lại để không in HTML
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Cổng thông tin nhân viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/sidebar.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background-color: #f0f2f5;
      min-height: 100vh;
      display: flex;
      margin: 0;
    }
    .sidebar {
      width: 240px;
      background: #212529;
      color: #fff;
      min-height: 100vh;
      padding-top: 20px;
    }
    .sidebar a {
      color: #adb5bd;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
    }
    .sidebar a:hover {
      background-color: #495057;
      color: #fff;
    }
    .content {
      flex: 1;
      padding: 30px;
    }
    .navbar {
      background: #ffffff;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
      padding: 10px 20px;
      margin-bottom: 20px;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<?php include '../includes/sidebar.php'; ?>

<!-- Nội dung -->
<div class="content">
  <?php include '../includes/header.php'; ?>

  <?php
  switch ($page) {
      case 'employees':
          include '../modules/employees.php';
          break;
      case 'internal_employees':
          include '../modules/employees/internal_employees.php';
          break;
      case 'external_employees':
          include '../modules/employees/external_employees.php';
          break;
      case 'labor_contracts':
          include '../modules/hr/labor_contracts.php';
          break;
      case 'applicants':
          include '../modules/applicants/list.php';
          break;
      case 'add_applicant':
          include '../modules/applicants/add.php'; // lúc này là chỉ hiển thị form
          break;
      case 'jobs':
          include '../modules/jobs.php';
          break;
      case 'interview_notice':
          include '../modules/applicants/interview_notice.php';
          break;        
          
      case 'interviews':
          include '../modules/interviews.php';
          break;
      case 'module_info':
          include '../modules/info/module_info.php';
          break;
      
      case 'update_personal':
          include '../modules/info/update/update_personal.php';
          break;       
       
      case 'update_contact':
           include '../modules/info/update/update_contact.php';
           break;
      case 'update_family':
          include '../modules/info/update/update_family.php';
          break;
      case 'update_pmm':
            include '../modules/info/update/update_pmm.php';
            break;
        case 'update_other':
            include '../modules/info/update/update_other.php';
            break;
        case 'update_account':
                include '../modules/info/update/update_account.php';
                break;
        case 'update_avatar':
                include '../modules/info/update/update_avatar.php';
                break;
        case 'change_password':
                include '../modules/info/change_password.php';
                break;
                         
      case 'recruitment_plans':
          include '../modules/recruitment_plans.php';
          break;
      case 'evaluations':
          include '../modules/evaluations.php';
          break;
      case 'recruitment_reports':
          include '../modules/recruitment_reports.php';
          break;
      case 'reports':
          include '../modules/reports.php';
          break;
      default:
          echo "<h3>🏠 Chào mừng đến với Cổng thông tin nhân viên!</h3>";
  }
  ?>

  <?php include '../includes/footer.php'; ?>
</div>

</body>
</html>
