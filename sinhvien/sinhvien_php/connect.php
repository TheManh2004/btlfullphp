<?php
// connect.php
$servername = "localhost";  // Tên máy chủ
$username = "root";         // Tên người dùng MySQL
$password = "";             // Mật khẩu của MySQL (thường trống cho XAMPP)
$dbname = "btl";  // Tên cơ sở dữ liệu

try {
    // Tạo kết nối bằng PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Thiết lập chế độ lỗi của PDO là Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Kết nối thành công"; 
} catch(PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}
?>
