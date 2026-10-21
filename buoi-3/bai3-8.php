
<?php
$name = "Lê Văn Hào";
$email = "haovanle@edu.vn";
$subject = "Hỗ trợ kỹ thuật";
$content = "";
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if ($name === "") {
        $errors["name"] = "Vui lòng nhập họ tên.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email không hợp lệ.";
    }

    $validSubjects = ["Hỗ trợ kỹ thuật", "Góp ý", "Hợp tác", "Khác"];
    if (!in_array($subject, $validSubjects, true)) {
        $errors["subject"] = "Vui lòng chọn chủ đề.";
    }

    $length = mb_strlen($content, "UTF-8");
    if ($length < 10 || $length > 500) {
        $errors["content"] = "Nội dung phải từ 10 đến 500 ký tự.";
    }

    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            background: #f1f3f5;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            max-width: 640px;
            margin: 0 auto;
            padding: 34px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin: 0 0 14px;
            text-align: center;
            color: #245b88;
            font-size: 32px;
        }

        .description {
            margin-bottom: 30px;
            text-align: center;
            color: #666;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 16px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d5d5d5;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            font-size: 15px;
            background: white;
        }

        input, select {
            height: 44px;
        }

        textarea {
            height: 135px;
            resize: vertical;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #3788d8;
            box-shadow: 0 0 0 3px rgba(55, 136, 216, 0.15);
        }

        .invalid {
            border-color: #ff5555;
            background: #fff5f5;
        }

        .error {
            display: block;
            margin-top: 7px;
            color: #f04444;
            font-size: 13px;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #2674b9;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d619e;
        }

        .success {
            margin-top: 20px;
            padding: 12px;
            border-radius: 7px;
            background: #e8f7ed;
            color: #218344;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Liên hệ</h1>
    <p class="description">
        Vui lòng nhập đầy đủ thông tin bên dưới.
    </p>

    <form method="post">
        <div class="form-group">
            <label for="name">Họ tên</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
                class="<?= isset($errors['name']) ? 'invalid' : '' ?>"
            >
            <?php if (isset($errors["name"])): ?>
                <span class="error"><?= htmlspecialchars($errors["name"], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="text"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                class="<?= isset($errors['email']) ? 'invalid' : '' ?>"
            >
            <?php if (isset($errors["email"])): ?>
                <span class="error"><?= htmlspecialchars($errors["email"], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="subject">Chủ đề</label>
            <select id="subject" name="subject"
                class="<?= isset($errors['subject']) ? 'invalid' : '' ?>">
                <option value="Hỗ trợ kỹ thuật" <?= $subject === "Hỗ trợ kỹ thuật" ? "selected" : "" ?>>
                    Hỗ trợ kỹ thuật
                </option>
                <option value="Góp ý" <?= $subject === "Góp ý" ? "selected" : "" ?>>
                    Góp ý
                </option>
                <option value="Hợp tác" <?= $subject === "Hợp tác" ? "selected" : "" ?>>
                    Hợp tác
                </option>
                <option value="Khác" <?= $subject === "Khác" ? "selected" : "" ?>>
                    Khác
                </option>
            </select>
            <?php if (isset($errors["subject"])): ?>
                <span class="error"><?= htmlspecialchars($errors["subject"], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea
                id="content"
                name="content"
                placeholder="Nhập nội dung liên hệ..."
                class="<?= isset($errors['content']) ? 'invalid' : '' ?>"
            ><?= htmlspecialchars($content, ENT_QUOTES, 'UTF-8') ?></textarea>

            <?php if (isset($errors["content"])): ?>
                <span class="error"><?= htmlspecialchars($errors["content"], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Gửi liên hệ</button>
    </form>

    <?php if ($success): ?>
        <div class="success">
            Gửi liên hệ thành công!
        </div>
    <?php endif; ?>
</div>

</body>
</html>
