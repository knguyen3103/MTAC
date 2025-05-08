<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../../config/db.php';

$userId = $_SESSION['user']['id'] ?? null;

// Kiểm tra có file tải lên không
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['avatar']['tmp_name'];
    $fileName = 'avatar_' . time() . '_' . $userId . '.' . pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $uploadDir = __DIR__ . '/../../../public/uploads/avatars/';
    $uploadPath = $uploadDir . $fileName;

    // Đảm bảo thư mục tồn tại
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Di chuyển file
    if (move_uploaded_file($fileTmp, $uploadPath)) {
        // Cập nhật đường dẫn avatar vào DB
        $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->execute([$fileName, $userId]);

        $_SESSION['success'] = "Cập nhật ảnh đại diện thành công!";
    } else {
        $_SESSION['success'] = "❌ Tải ảnh lên thất bại!";
    }
}

// Quay về trang account_info
header('Location: index.php?page=module_info&tab=account');
exit;
