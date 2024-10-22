<?php
session_start();
include 'connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Vui lòng đăng nhập để gửi câu hỏi.";
    exit();
}

// Lấy thông tin người dùng
$student_id = $_SESSION['user_id'];
$subject_id = $_SESSION['subject_id'];
$lesson_id = $_POST['lesson_id'];

// Kiểm tra nếu dữ liệu đã được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem các trường cần thiết có tồn tại không
    if (!empty(trim($_POST['question']))) {
        $question = trim($_POST['question']);
        $state = 'Open'; // Trạng thái câu hỏi
        // $created_at = date('Y-m-d H:i:s'); // Định dạng 'YYYY-MM-DD HH:MM:SS'

        try {
           // Truy vấn lưu câu hỏi vào cơ sở dữ liệu
$sql = "INSERT INTO course_questions (student_id, chapters_id, question, state, created_at, lesson_id) 
VALUES (:student_id, :chapters_id, :question, :state, NOW(), :lesson_id)";
$stmt = $conn->prepare($sql);

// Ràng buộc các tham số
$stmt->bindParam(':student_id', $student_id);
$stmt->bindParam(':chapters_id', $subject_id);
$stmt->bindParam(':question', $question);
$stmt->bindParam(':state', $state);
$stmt->bindParam(':lesson_id', $lesson_id);

// Thực thi câu lệnh
$stmt->execute();

            // Kiểm tra nếu câu hỏi đã được thêm thành công
            if ($stmt->rowCount() > 0) {
                echo "Câu hỏi của bạn đã được gửi thành công!";
            } else {
                echo "Không có thay đổi nào trong cơ sở dữ liệu. Vui lòng kiểm tra lại.";
            }
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            exit();
        }
    } else {
        // Nếu trường câu hỏi trống hoặc không hợp lệ
        echo "Vui lòng nhập câu hỏi.";
        exit();
    }
} else {
    echo "Yêu cầu không hợp lệ.";
    exit();
}
?>
