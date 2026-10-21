
<?php
$name = "";
$email = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($name === "") {
        $errors["name"] = "Vui lòng nhập họ tên";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email không hợp lệ";
    }
      if (!$errors) {
    $_SESSION['student'] = $data;
    header('Location: bai3-5.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form đăng ký</title>
</head>
<body>
    <h2>FORM ĐĂNG KÝ</h2>

    <form method="post">
        <p>
            Họ tên:
            <input name="name"
                value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors["name"])): ?>
                <span style="color:red"><?= $errors["name"] ?></span>
            <?php endif; ?>
        </p>

        <p>
            Email:
            <input name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors["email"])): ?>
                <span style="color:red"><?= $errors["email"] ?></span>
            <?php endif; ?>
        </p>

        <button type="submit">Đăng ký</button>
    </form>

</body>
</html>
