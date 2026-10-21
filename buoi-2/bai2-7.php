
<?php
function money(float $value): string {
    return number_format($value, 0, ",", ".") . " đ";
}

$name = "";
$qty = "";
$price = "";
$total = 0;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $qty = $_POST["qty"] ?? "";
    $price = $_POST["price"] ?? "";

    if ($name === "") {
        $errors[] = "Vui lòng nhập tên tài liệu";
    }

    if ($qty === "" || filter_var($qty, FILTER_VALIDATE_INT) === false
        || (int)$qty < 1) {
        $errors[] = "Số lượng phải là số nguyên từ 1 trở lên";
    }

    if ($price === "" || !is_numeric($price) || (float)$price < 0) {
        $errors[] = "Đơn giá phải là số không âm";
    }

    if (!$errors) {
        $total = (int)$qty * (float)$price;
    }
}
?>

<h2>HÓA ĐƠN HỌC LIỆU</h2>

<form method="post">
    <p>
        Tên tài liệu:
        <input name="name"
            value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <p>
        Số lượng:
        <input type="number" name="qty" min="1"
            value="<?= htmlspecialchars((string)$qty, ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <p>
        Đơn giá:
        <input type="number" name="price" min="0" step="any"
            value="<?= htmlspecialchars((string)$price, ENT_QUOTES, 'UTF-8') ?>">
    </p>

    <button type="submit">Tính tiền</button>
</form>

<?php
foreach ($errors as $error) {
    echo "<p style='color:red'>"
        . htmlspecialchars($error, ENT_QUOTES, 'UTF-8')
        . "</p>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && !$errors) {
    echo "<p>Tên tài liệu: "
        . htmlspecialchars($name, ENT_QUOTES, 'UTF-8')
        . "</p>";

    echo "<p>Thành tiền: " . money($total) . "</p>";
}
?>
