
<?php
$diem = 7.5;

if ($diem < 0 || $diem > 10) {
    echo "Điểm không hợp lệ";
} elseif ($diem >= 8) {
    echo "Xếp loại: Giỏi";
} elseif ($diem >= 6.5) {
    echo "Xếp loại: Khá";
} elseif ($diem >= 5) {
    echo "Xếp loại: Trung bình";
} else {
    echo "Xếp loại: Chưa đạt";
}
?>
