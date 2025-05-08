<?php
$host = 'localhost';
$db   = 'nhanvien_potal'; 
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    echo "❌ Kết nối thất bại: " . $e->getMessage();
    exit();
}
?>
