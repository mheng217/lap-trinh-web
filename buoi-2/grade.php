
<?php
$name = "";
$cc = "";
$mid = "";
$final = "";
$errors = [];
$result = null;

function isValidScore(string $score): bool {
    return $score !== ""
        && is_numeric($score)
        && (float)$score >= 0
        && (float)$score <= 10;
}

function finalScore(float $cc, float $mid, float $final): float {
    return $cc * 0.10 + $mid * 0.30 + $final * 0.60;
}

function classifyScore(float $score): string {
    if ($score >= 8) {
        return "Giỏi";
    } elseif ($score >= 6.5) {
        return "Khá";
    } elseif ($score >= 5) {
        return "Trung bình";
    }
    return "Chưa đạt";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $cc = trim($_POST["cc"] ?? "");
    $mid = trim($_POST["mid"] ?? "");
    $final = trim($_POST["final"] ?? "");

    if ($name === "") {
        $errors["name"] = "Vui lòng nhập họ tên";
    }

    if (!isValidScore($cc)) {
        $errors["cc"] = "Điểm chuyên cần phải từ 0 đến 10";
    }

    if (!isValidScore($mid)) {
        $errors["mid"] = "Điểm giữa kỳ phải từ 0 đến 10";
    }

    if (!isValidScore($final)) {
        $errors["final"] = "Điểm cuối kỳ phải từ 0 đến 10";
    }

    if (!$errors) {
        $result = finalScore(
            (float)$cc,
            (float)$mid,
            (float)$final
        );
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Máy tính điểm học phần</title>
</head>
<body>
    <h2>MÁY TÍNH ĐIỂM HỌC PHẦN</h2>

    <form method="post">
        <p>
            Họ tên:
            <input name="name" required
                value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors["name"])): ?>
                <span style="color:red"><?= $errors["name"] ?></span>
            <?php endif; ?>
        </p>

        <p>
            Điểm chuyên cần:
            <input type="number" name="cc" min="0" max="10"
                step="any" required
                value="<?= htmlspecialchars($cc, ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors["cc"])): ?>
                <span style="color:red"><?= $errors["cc"] ?></span>
            <?php endif; ?>
        </p>

        <p>
            Điểm giữa kỳ:
            <input type="number" name="mid" min="0" max="10"
                step="any" required
                value="<?= htmlspecialchars($mid, ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors["mid"])): ?>
                <span style="color:red"><?= $errors["mid"] ?></span>
            <?php endif; ?>
        </p>

        <p>
            Điểm cuối kỳ:
            <input type="number" name="final" min="0" max="10"
                step="any" required
                value="<?= htmlspecialchars($final, ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors["final"])): ?>
                <span style="color:red"><?= $errors["final"] ?></span>
            <?php endif; ?>
        </p>

        <button type="submit">Tính điểm</button>
    </form>

    <?php if ($result !== null && !$errors): ?>
        <h3>Kết quả</h3>
        <p>Họ tên: <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Điểm tổng kết: <?= number_format($result, 2) ?></p>
        <p>Xếp loại: <?= classifyScore($result) ?></p>
    <?php endif; ?>
</body>
</html>
