<?php
include 'connect.php'; // Kết nối đến cơ sở dữ liệu

if (isset($_GET['id'])) {
    $chapter_id = $_GET['id'];

    // Truy vấn để lấy hình ảnh từ cơ sở dữ liệu
    $sql = "SELECT image FROM chapters WHERE id = :chapter_id"; // Thay đổi tên bảng và cột cho phù hợp
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':chapter_id', $chapter_id, PDO::PARAM_INT);
    $stmt->execute();

    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image) {
        header("Content-Type: image/jpeg"); // Thay đổi kiểu MIME nếu hình ảnh không phải JPEG
        echo $image['image']; // In ra hình ảnh
    } else {
        echo "Hình ảnh không tồn tại."; // Thông báo nếu không tìm thấy hình ảnh
    }
} else {
    echo "ID không hợp lệ."; // Thông báo nếu không có ID
}

$conn = null; // Đóng kết nối
?>