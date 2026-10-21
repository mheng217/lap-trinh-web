<?php
session_start();

function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

if (!isset($_SESSION['student'])) {
  header('Location: register.php');
  exit;
}

$student = $_SESSION['student'];
unset($_SESSION['student']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký thành công</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 400px; margin: 40px auto; }
    a { color: #00b050; }
  </style>
</head>
<body>
  <h1>Đăng ký thành công!</h1>
  <p>Họ tên: <?= e($student['name']) ?></p>
  <p>Email: <?= e($student['email']) ?></p>
  <p>Ngày sinh: <?= e($student['birthday']) ?></p>
  <a href="register.php">Đăng ký thêm</a>
</body>
</html>