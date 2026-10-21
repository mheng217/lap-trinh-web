
<?php
// ==================== 1. KHOI TAO DU LIEU ====================

$name = "";
$email = "";
$subject = "";
$content = "";

$errors = [];
$success = false;

// Danh sách chủ đề được phép chọn
$validSubjects = [
    "Hỗ trợ kỹ thuật",
    "Góp ý",
    "Hợp tác",
    "Khác"
];

// ==================== 2. XU LY FORM ====================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Lấy dữ liệu và loại bỏ khoảng trắng đầu, cuối
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $content = trim($_POST["content"] ?? "");

    // ---------- Kiểm tra họ tên ----------
    if ($name === "") {
        $errors["name"] = "Vui lòng nhập họ tên.";
    } elseif (mb_strlen($name, "UTF-8") > 100) {
        $errors["name"] = "Họ tên không được quá 100 ký tự.";
    }

    // ---------- Kiểm tra email ----------
    if ($email === "") {
        $errors["email"] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email không đúng định dạng.";
    } elseif (strlen($email) > 254) {
        $errors["email"] = "Email không được quá 254 ký tự.";
    }

    // ---------- Kiểm tra chủ đề ----------
    if (!in_array($subject, $validSubjects, true)) {
        $errors["subject"] = "Vui lòng chọn một chủ đề hợp lệ.";
    }

    // ---------- Kiểm tra nội dung ----------
    $contentLength = mb_strlen($content, "UTF-8");

    if ($content === "") {
        $errors["content"] = "Vui lòng nhập nội dung liên hệ.";
    } elseif ($contentLength < 10 || $contentLength > 500) {
        $errors["content"] = "Nội dung phải từ 10 đến 500 ký tự.";
    }

    // ---------- Kết quả ----------
    if (empty($errors)) {
        $success = true;
    }
}

// Hàm hiển thị dữ liệu an toàn, chống XSS
function e($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        "UTF-8"
    );
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
            background-color: #f1f3f5;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
            padding: 34px;
            background-color: #fff;
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
            margin: 0 0 30px;
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

        input,
        select,
        textarea {
            display: block;
            width: 100%;
            padding: 12px;
            border: 1px solid #d5d5d5;
            border-radius: 8px;
            background-color: #fff;
            font-family: Arial, sans-serif;
            font-size: 15px;
            color: #222;
        }

        input,
        select {
            height: 44px;
        }

        textarea {
            height: 135px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3788d8;
            box-shadow: 0 0 0 3px rgba(55, 136, 216, 0.15);
        }

        .invalid {
            border-color: #ff5555;
            background-color: #fff5f5;
        }

        .error {
            display: block;
            margin-top: 7px;
            color: #f04444;
            font-size: 13px;
        }

        button {
            display: block;
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background-color: #2674b9;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #1d619e;
        }

        .success {
            margin-top: 20px;
            padding: 12px;
            border: 1px solid #b7e4c7;
            border-radius: 7px;
            background-color: #e8f7ed;
            color: #218344;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 22px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Liên hệ</h1>

    <p class="description">
        Vui lòng nhập đầy đủ thông tin bên dưới.
    </p>

    <form method="post" action="">

        <!-- Họ tên -->
        <div class="form-group">
            <label for="name">Họ tên</label>

            <input
                type="text"
                id="name"
                name="name"
                maxlength="100"
                value="<?= e($name) ?>"
                class="<?= isset($errors['name']) ? 'invalid' : '' ?>"
                required
            >

            <?php if (isset($errors["name"])): ?>
                <span class="error"><?= e($errors["name"]) ?></span>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                maxlength="254"
                value="<?= e($email) ?>"
                class="<?= isset($errors['email']) ? 'invalid' : '' ?>"
                required
            >

            <?php if (isset($errors["email"])): ?>
                <span class="error"><?= e($errors["email"]) ?></span>
            <?php endif; ?>
        </div>

        <!-- Chủ đề -->
        <div class="form-group">
            <label for="subject">Chủ đề</label>

            <select
                id="subject"
                name="subject"
                class="<?= isset($errors['subject']) ? 'invalid' : '' ?>"
                required
            >
                <option value="">-- Chọn chủ đề --</option>

                <?php foreach ($validSubjects as $item): ?>
                    <option
                        value="<?= e($item) ?>"
                        <?= $subject === $item ? "selected" : "" ?>
                    >
                        <?= e($item) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?php if (isset($errors["subject"])): ?>
                <span class="error"><?= e($errors["subject"]) ?></span>
            <?php endif; ?>
        </div>

        <!-- Nội dung -->
        <div class="form-group">
            <label for="content">Nội dung</label>

            <textarea
                id="content"
                name="content"
                minlength="10"
                maxlength="500"
                placeholder="Nhập nội dung liên hệ..."
                class="<?= isset($errors['content']) ? 'invalid' : '' ?>"
                required
            ><?= e($content) ?></textarea>

            <?php if (isset($errors["content"])): ?>
                <span class="error"><?= e($errors["content"]) ?></span>
            <?php endif; ?>
        </div>

        <!-- Nút gửi -->
        <button type="submit">Gửi liên hệ</button>

    </form>

    <!-- Thông báo thành công -->
    <?php if ($success): ?>
        <div class="success" role="status">
            <strong>Gửi liên hệ thành công!</strong>
            <p>Thông tin đã vượt qua bước kiểm tra dữ liệu.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
