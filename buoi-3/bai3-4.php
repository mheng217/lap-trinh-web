
<?php
$name = '<b>Lan</b>';

echo "<p>In thô: $name</p>";

echo "<p>Mã hóa an toàn: "
    . htmlspecialchars($name, ENT_QUOTES, "UTF-8")
    . "</p>";
?>
