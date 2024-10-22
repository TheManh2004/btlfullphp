<?php
session_start();
header('Content-Type: application/json');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Lấy user_id từ session
$user_id = $_SESSION['user_id'];

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "btl");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truy vấn với JOIN giữa bảng answers và users
$sql = "SELECT 
            a.answer AS answer_message, 
            a.created_at AS answer_created_at,
            u.name AS replier_name
        FROM 
            answers a
        JOIN 
            users u ON a.replier_id = u.id -- Kết nối bảng answers với users qua replier_id
        ORDER BY 
            a.created_at DESC";

// Thực hiện truy vấn
$result = $conn->query($sql);

// Kiểm tra nếu có kết quả
if ($result->num_rows > 0) {
    // Tạo mảng để lưu dữ liệu
    $questions = [];

    // Duyệt qua từng dòng kết quả
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row; // Thêm từng kết quả vào mảng
    }

    // Trả về dữ liệu dạng JSON
    echo json_encode($questions);
} else {
    echo "Không có dữ liệu.";
}

// Đóng kết nối
$conn->close();