<?php
session_start();

function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

$errors = [];
$data = ['name' => '', 'email' => '', 'birthday' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data['name']     = trim($_POST['name'] ?? '');
  $data['email']    = trim($_POST['email'] ?? '');
  $data['birthday'] = trim($_POST['birthday'] ?? '');

  if ($data['name'] === '') $errors['name'] = 'Vui lòng nhập họ tên';
  if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
    $errors['email'] = 'Email không hợp lệ';
  if ($data['birthday'] === '') $errors['birthday'] = 'Vui lòng nhập ngày sinh';

  if (!$errors) {
    $_SESSION['student'] = $data;
    header('Location: success.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký sinh viên</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 400px; margin: 40px auto; }
    label { display: block; margin-top: 12px; }
    input { width: 100%; padding: 8px; box-sizing: border-box; }
    .error { color: #d93025; font-size: 14px; }
    button { margin-top: 16px; padding: 8px 16px; }
  </style>
</head>
<body>
  <h1>Đăng ký sinh viên</h1>
  <form method="post" novalidate>
    <label>Họ tên
      <input type="text" name="name" value="<?= e($data['name']) ?>">
    </label>
    <?php if (isset($errors['name'])): ?>
      <span class="error"><?= e($errors['name']) ?></span>
    <?php endif; ?>

    <label>Email
      <input type="text" name="email" value="<?= e($data['email']) ?>">
    </label>
    <?php if (isset($errors['email'])): ?>
      <span class="error"><?= e($errors['email']) ?></span>
    <?php endif; ?>

    <label>Ngày sinh
      <input type="date" name="birthday" value="<?= e($data['birthday']) ?>">
    </label>
    <?php if (isset($errors['birthday'])): ?>
      <span class="error"><?= e($errors['birthday']) ?></span>
    <?php endif; ?>

    <button type="submit">Đăng ký</button>
  </form>
</body>
</html>