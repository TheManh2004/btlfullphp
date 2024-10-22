<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('location: ../../giangvien/account/login.php'); 
    exit();
}

// Lấy ID người dùng từ session
$user_id = $_SESSION['user_id'];

try {
    // Truy vấn lấy thông tin người dùng từ cơ sở dữ liệu
    $sql = "SELECT name, phone_number, gender, email, password FROM users WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Không tìm thấy người dùng.";
        exit();
    }

    // Lưu thông tin người dùng vào các biến để hiển thị trong form
    $user_name = $user['name'];
    $user_phone = $user['phone_number'];
    $user_gender = $user['gender'];
    $user_email = $user['email'];
    $user_password = $user['password']; // Lưu mật khẩu để kiểm tra mật khẩu cũ

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
    exit();
}
?>