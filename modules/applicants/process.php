<?php
require_once __DIR__ . '/../../config/db.php';
session_start();

$action = $_GET['action'] ?? '';
$job_id = $_GET['job_id'] ?? null;
$user_id = $_SESSION['user']['id'] ?? null;

// Lấy applicant_id từ users (giả định 1-1 email giữa users và applicants)
$applicant = $pdo->prepare("SELECT id FROM applicants WHERE email = (SELECT email FROM users WHERE id = ?)");
$applicant->execute([$user_id]);
$applicant_id = $applicant->fetchColumn();

if (!$applicant_id) {
    $_SESSION['success'] = "❌ Không tìm thấy hồ sơ ứng viên!";
    header("Location: ../../public/index.php?page=jobs");
    exit;
}

switch ($action) {
    case 'apply':
        // Kiểm tra đã ứng tuyển chưa
        $check = $pdo->prepare("SELECT COUNT(*) FROM applications WHERE applicant_id = ? AND job_id = ?");
        $check->execute([$applicant_id, $job_id]);

        if ($check->fetchColumn() > 0) {
            $_SESSION['success'] = "⚠️ Bạn đã ứng tuyển vị trí này.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO applications (applicant_id, job_id, result) VALUES (?, ?, 'pending')");
            $stmt->execute([$applicant_id, $job_id]);
            $_SESSION['success'] = "✅ Ứng tuyển thành công!";
        }

        header("Location: ../../public/index.php?page=jobs");
        exit;

    case 'confirm_interview':
        $interview_id = $_GET['id'] ?? 0;

        $stmt = $pdo->prepare("UPDATE interviews SET status = 'confirmed' WHERE id = ?");
        $stmt->execute([$interview_id]);

        $_SESSION['success'] = "✅ Bạn đã xác nhận phỏng vấn.";
        header("Location: ../../public/index.php?page=interview_notice");
        exit;

    default:
        $_SESSION['success'] = "Không tìm thấy hành động hợp lệ.";
        header("Location: ../../public/index.php");
        exit;
}
