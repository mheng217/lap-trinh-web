
<?php
$email = " A@Example.COM ";

$email = trim($email);
$email = strtolower($email);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email hợp lệ: "
        . htmlspecialchars($email, ENT_QUOTES, "UTF-8");
} else {
    echo "Email không hợp lệ";
}
?>
