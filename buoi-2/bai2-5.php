
<?php
function finalScore(
    float $cc,
    float $mid,
    float $final
): float {
    return $cc * 0.10
         + $mid * 0.30
         + $final * 0.60;
}

$diem = finalScore(8, 7, 9);

echo "Điểm tổng kết: " . $diem;
?>
