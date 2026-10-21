<?php
session_start();

function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

$subjects = ['Hỗ trợ kỹ thuật', 'Góp ý', 'Hợp tác', 'Khác'];
$errors = [];
$data = ['name' => '', 'email' => '', 'subject' => $subjects[0], 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data['name']    = trim($_POST['name'] ?? '');
  $data['email']   = trim($_POST['email'] ?? '');
  $data['subject'] = $_POST['subject'] ?? '';
  $data['message'] = trim($_POST['message'] ?? '');

  // Họ tên + nội dung không rỗng
  if ($data['name'] === '') $errors['name'] = 'Vui lòng nhập họ tên';

  // Email đúng định dạng
  if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
    $errors['email'] = 'Email không hợp lệ';

  // Chủ đề phải nằm trong danh sách
  if (!in_array($data['subject'], $subjects, true))
    $errors['subject'] = 'Chủ đề không hợp lệ';

  // Nội dung 10-500 ký tự
  $len = mb_strlen($data['message'], 'UTF-8');
  if ($data['message'] === '' || $len < 10 || $len > 500)
    $errors['message'] = 'Nội dung phải từ 10 đến 500 ký tự.';

  // Upload ảnh đại diện: 3 kiểm tra
  $file = $_FILES['avatar'] ?? null;
  $ext = null;
  if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
    $errors['avatar'] = 'Vui lòng chọn ảnh đại diện';          // (1) có chọn file
  } elseif ($file['error'] !== UPLOAD_ERR_OK) {
    $errors['avatar'] = 'Tải ảnh lên thất bại, hãy thử lại';    // (1) không lỗi upload
  } elseif ($file['size'] > 2 * 1024 * 1024) {
    $errors['avatar'] = 'Ảnh không được lớn hơn 2MB';           // (2) dung lượng
  } else {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
    if (!isset($allowed[$mime])) {
      $errors['avatar'] = 'Chỉ chấp nhận ảnh JPG, PNG hoặc GIF'; // (3) loại file
    } else {
      $ext = $allowed[$mime];
    }
  }

  if (!$errors) {
    if (!is_dir(__DIR__ . '/uploads')) mkdir(__DIR__ . '/uploads', 0755, true);
    $newName = bin2hex(random_bytes(8)) . '.' . $ext;   // tên ngẫu nhiên, tránh trùng/độc hại
    move_uploaded_file($file['tmp_name'], __DIR__ . '/uploads/' . $newName);

    $_SESSION['flash'] = 'Gửi liên hệ thành công. Cảm ơn bạn!';
    header('Location: contact.php');
    exit;
  }
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Liên hệ</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f3f5f7; margin: 0; padding: 40px 16px; }
    .card { max-width: 480px; margin: 0 auto; background: #fff; padding: 28px;
            border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
    h1 { text-align: center; color: #1f4e79; margin: 0; }
    .sub { text-align: center; color: #777; font-size: 14px; margin: 8px 0 20px; }
    label { display: block; font-weight: bold; font-size: 14px; margin-top: 16px; }
    input[type=text], select, textarea {
      width: 100%; padding: 10px; margin-top: 6px; box-sizing: border-box;
      border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
    textarea { height: 130px; resize: vertical; }
    .invalid { border-color: #e53935 !important; background: #fff5f5; }
    .error { color: #d93025; font-size: 13px; margin-top: 4px; display: block; }
    .success { background: #e6f4ea; color: #1e7e34; padding: 12px; border-radius: 6px; margin-bottom: 8px; }
    button { width: 100%; margin-top: 20px; padding: 12px; border: 0; border-radius: 6px;
             background: #1f6fb2; color: #fff; font-weight: bold; font-size: 15px; cursor: pointer; }
    button:hover { background: #185a92; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Liên hệ</h1>
    <p class="sub">Vui lòng nhập đầy đủ thông tin bên dưới.</p>

    <?php if ($flash): ?>
      <div class="success"><?= e($flash) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" novalidate>
      <label>Họ tên
        <input type="text" name="name" value="<?= e($data['name']) ?>"
               class="<?= isset($errors['name']) ? 'invalid' : '' ?>">
      </label>
      <?php if (isset($errors['name'])): ?><span class="error"><?= e($errors['name']) ?></span><?php endif; ?>

      <label>Email
        <input type="text" name="email" value="<?= e($data['email']) ?>"
               class="<?= isset($errors['email']) ? 'invalid' : '' ?>">
      </label>
      <?php if (isset($errors['email'])): ?><span class="error"><?= e($errors['email']) ?></span><?php endif; ?>

      <label>Chủ đề
        <select name="subject">
          <?php foreach ($subjects as $s): ?>
            <option value="<?= e($s) ?>" <?= $data['subject'] === $s ? 'selected' : '' ?>><?= e($s) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <?php if (isset($errors['subject'])): ?><span class="error"><?= e($errors['subject']) ?></span><?php endif; ?>

      <label>Nội dung
        <textarea name="message" placeholder="Nhập nội dung liên hệ..."
                  class="<?= isset($errors['message']) ? 'invalid' : '' ?>"><?= e($data['message']) ?></textarea>
      </label>
      <?php if (isset($errors['message'])): ?><span class="error"><?= e($errors['message']) ?></span><?php endif; ?>

      <label>Ảnh đại diện
        <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif">
      </label>
      <?php if (isset($errors['avatar'])): ?><span class="error"><?= e($errors['avatar']) ?></span><?php endif; ?>

      <button type="submit">Gửi liên hệ</button>
    </form>
  </div>
</body>
</html>