
<?php
$students = [
    ["name" => "An", "score" => 8.5],
    ["name" => "Bình", "score" => 7.0],
    ["name" => "Chi", "score" => 4.5]
];

echo "<table border='1' cellpadding='8'>";
echo "<tr><th>Họ tên</th><th>Điểm</th></tr>";

foreach ($students as $student) {
    echo "<tr>";
    echo "<td>" .
        htmlspecialchars($student["name"]) . "</td>";
    echo "<td>" . $student["score"] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
