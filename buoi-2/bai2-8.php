
<?php
$students = [
    ["name" => "An", "midterm" => 7, "final" => 8],
    ["name" => "Binh", "midterm" => 4, "final" => 5],
    ["name" => "Chi", "midterm" => 3, "final" => 4]
];

function calculateAverage(float $midterm, float $final): float {
    return ($midterm + $final) / 2;
}
?>

<h2>BẢNG ĐIỂM SINH VIÊN</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Hoh tên</th>
        <th>Giữa kỳ</th>
        <th>Cuối kỳ</th>
        <th>Trung bình</th>
        <th>Kết quả</th>
    </tr>

    <?php foreach ($students as $student): ?>
        <?php
        $avg = calculateAverage(
            $student["midterm"],
            $student["final"]
        );
        ?>
        <tr>
            <td><?= htmlspecialchars($student["name"], ENT_QUOTES, "UTF-8") ?></td>
            <td><?= $student["midterm"] ?></td>
            <td><?= $student["final"] ?></td>
            <td><?= number_format($avg, 2) ?></td>
            <td><?= $avg >= 5 ? "Đạt" : "Chưa đạt" ?></td>
        </tr>
    <?php endforeach; ?>
</table>
