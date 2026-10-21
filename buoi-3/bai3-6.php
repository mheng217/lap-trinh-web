
<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_FILES["avatar"]) ||
        $_FILES["avatar"]["error"] !== UPLOAD_ERR_OK) {
        $message = "Vui lòng chọn ảnh hợp lệ";
    } else {
        $file = $_FILES["avatar"];
        $maxSize = 2 * 1024 * 1024;

        $allowed = [
            "image/jpeg" => "jpg",
            "image/png" => "png",
            "image/gif" => "gif"
        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file["tmp_name"]);

        if ($file["size"] > $maxSize) {
            $message = "Ảnh không được lớn hơn 2 MB";
        } elseif (!isset($allowed[$mime])) {
            $message = "Chỉ chấp nhận ảnh JPG, PNG, GIF";
        } else {
            $filename = bin2hex(random_bytes(16))
                . "." . $allowed[$mime];

            $destination = __DIR__ . "/uploads/" . $filename;

            if (move_uploaded_file(
                $file["tmp_name"],
                $destination
            )) {
                $message = "Tải ảnh thành công";
            } else {
                $message = "Không thể lưu ảnh";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload ảnh đại diện</title>
</head>
<body>
    <h2>UPLOAD ẢNH ĐẠI DIỆN</h2>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="avatar"
            accept="image/jpeg,image/png,image/gif" required>

        <button type="submit">Tải ảnh lên</button>
    </form>

    <p>
        <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
    </p>
</body>
</html>
