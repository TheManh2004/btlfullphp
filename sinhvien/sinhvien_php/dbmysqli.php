<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost"; // Đổi thành thông tin server của bạn
$username = "root";        // Đổi thành username của bạn
$password = "";            // Đổi thành mật khẩu của bạn
$dbname = "btl"; // Đổi thành tên database của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>