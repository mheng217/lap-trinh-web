
<form method="get">
    <label>Nhập tên sinh viên:</label>
    <input type="text" name="name">
    <button type="submit">Tìm kiếm</button>
</form>

<?php
$name = trim($_GET["name"] ?? "");

if ($name !== "") {
    echo "Bạn đang tìm sinh viên: "
        . htmlspecialchars($name, ENT_QUOTES, "UTF-8");
}
?>
