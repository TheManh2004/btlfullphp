<?php
session_start();
include("connect.php");

try {
    if (isset($_SESSION['user_id']) && isset($_POST['subject_id'])) {
        // Lấy student_id và subject_id từ session và POST
        $student_id = $_SESSION['user_id'];
        $chapter_id = $_POST['subject_id'];

        // Thêm bản ghi vào bảng course_enrollments
        $sql = "INSERT INTO course_enrollments (student_id, subject_id, enroll_date) VALUES (:student_id, :subject_id, NOW())";
        $stmt = $conn->prepare($sql);

        // Ràng buộc các giá trị tham số
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $chapter_id, PDO::PARAM_INT);

        // Thực thi truy vấn
        if ($stmt->execute()) {
            echo "Đăng ký khóa học thành công!";
        } else {
            echo "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    } else {
        echo "Không tìm thấy thông tin để xử lý.";
    }
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>