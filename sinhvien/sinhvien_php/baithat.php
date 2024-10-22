<?php
session_start(); // Bắt đầu session

include 'connect.php'; // Kết nối CSDL

// Kiểm tra xem session có subject_id không
if (isset($_SESSION['subject_id'])) {
    $subject_id = $_SESSION['subject_id'];
    

    // Truy vấn lấy danh sách bài học thuộc khóa học (subject_id)
    $sql_lessons = "SELECT id, title, drive_link FROM lessons WHERE subject_id = :subject_id";
    $stmt = $conn->prepare($sql_lessons);
    $stmt->bindValue(':subject_id', $subject_id, PDO::PARAM_INT); // Gán tham số subject_id vào câu truy vấn
    $stmt->execute(); // Thực thi câu truy vấn
    $result_lessons = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy tất cả kết quả

    // Kiểm tra nếu kết quả không phải null và có dòng dữ liệu
    // if ($result_lessons && count($result_lessons) > 0) {
    //     // Duyệt qua các kết quả và xử lý dữ liệu ở đây
    //     foreach ($result_lessons as $row) {
    //         echo "<li><a href='" . htmlspecialchars($row['drive_link']) . "'>" . htmlspecialchars($row['title']) . "</a></li>";
    //     }
    // } else {
    //     echo "Không có bài học nào trong khóa học này.";
    // }

    // Đóng kết nối
    $stmt->closeCursor(); // Đóng con trỏ
    $conn = null; // Đóng kết nối
    echo "Current subject_id: " . htmlspecialchars($_SESSION['subject_id']);
    
} else {
    echo "Không tìm thấy subject_id.";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỏi Đáp</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Kết nối jQuery -->
    <style>
       .qa-frame {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1000;
    top: 0;
    right: 0;
    background-color: #ffffff; /* Màu nền trắng */
    overflow-x: hidden;
    transition: 0.5s;
    box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2); /* Bóng mờ đẹp hơn */
}

.qa-frame.open {
    width: 400px;
}

.qa-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: #007BFF; /* Màu xanh cho tiêu đề */
    color: white;
    font-size: 1.5em; /* Kích thước chữ lớn hơn */
    border-top-left-radius: 10px; /* Bo góc cho header */
    border-top-right-radius: 10px; /* Bo góc cho header */
}

.close-button {
    font-size: 30px;
    cursor: pointer;
    background: none;
    border: none;
    color: white;
}

.qa-content {
    padding: 20px;
    height: calc(100% - 60px); /* Cân chỉnh chiều cao sau header */
    overflow-y: auto;
}

.question-form {
    display: flex;
    flex-direction: column;
}

.question-form textarea {
    width: 100%;
    height: 100px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px; /* Kích thước chữ */
    transition: border-color 0.3s;
}

.question-form textarea:focus {
    border-color: #007BFF; /* Màu viền khi focus */
    outline: none;
}

.btn-submit {
    margin-top: 10px;
    padding: 10px;
    background-color: #007BFF; /* Màu nền cho nút gửi */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px; /* Kích thước chữ */
    transition: background-color 0.3s, transform 0.3s; /* Hiệu ứng chuyển màu */
}

.btn-submit:hover {
    background-color: #0056b3; /* Tối hơn khi hover */
    transform: translateY(-2px); /* Nhấc lên khi hover */
}

/* Responsive cho frame Hỏi Đáp */
@media screen and (max-width: 600px) {
    .qa-frame.open {
        width: 100%;
    }
}

    </style>
</head>
<body>
<div id="qaFrame" class="qa-frame"> <!-- Khung hỏi đáp -->
    <div class="qa-header">
        <h2>Câu Hỏi Hỗ Trợ</h2> <!-- Tiêu đề -->
        <button class="close-button" id="closeFrame">×</button> <!-- Nút đóng khung hỏi đáp -->
    </div>
    <div class="qa-content">
        <form id="questionForm" class="question-form"> <!-- Form gửi câu hỏi -->
            <textarea name="question" placeholder="Nhập câu hỏi của bạn..."></textarea>
            <input type="hidden" name="chapters_id" value="<?php echo htmlspecialchars($_SESSION['subject_id']); ?>"> <!-- Sử dụng subject_id làm chapters_id -->
            <input type="hidden" name="lesson_id" value="1"> <!-- Thay đổi giá trị này nếu cần -->
            <button type="submit" class="btn-submit">Gửi Câu Hỏi</button> <!-- Nút gửi câu hỏi -->
        </form>
    </div>
</div>

    <script>
        // Đảm bảo rằng mã JavaScript chỉ chạy sau khi tài liệu đã được tải hoàn toàn
document.addEventListener('DOMContentLoaded', () => {
    const openButton = document.getElementById('openFrame'); // Nút mở khung hỏi đáp
    const closeButton = document.getElementById('closeFrame'); // Nút đóng khung hỏi đáp
    const qaFrame = document.getElementById('qaFrame'); // Khung hỏi đáp

    // Mở khung hỏi đáp khi nhấn nút
    openButton.addEventListener('click', () => {
        qaFrame.classList.add('open'); // Thêm lớp 'open' để hiển thị khung
    });

    // Đóng khung hỏi đáp khi nhấn nút đóng
    closeButton.addEventListener('click', () => {
        qaFrame.classList.remove('open'); // Xóa lớp 'open' để ẩn khung
    });

    // Đóng khung hỏi đáp khi nhấn ngoài khung
    window.addEventListener('click', (event) => {
        if (event.target === qaFrame) {
            qaFrame.classList.remove('open'); // Xóa lớp 'open' để ẩn khung
        }
    });

    // Sử dụng jQuery để xử lý sự kiện gửi form
    $(document).ready(function() {
        // Khi gửi form
        $('#questionForm').on('submit', function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của form

            // Lấy câu hỏi và loại bỏ khoảng trắng ở đầu và cuối
            const question = $('textarea[name="question"]').val().trim(); 

            // Kiểm tra xem người dùng có nhập câu hỏi không
            if (!question) {
                alert("Vui lòng nhập câu hỏi của bạn."); // Thông báo nếu không có câu hỏi
                return; // Ngăn không cho gửi form
            }

            // Lấy dữ liệu từ form
            const formData = $(this).serialize(); 

            // Thực hiện AJAX gửi dữ liệu
            $.ajax({
                type: 'POST', // Phương thức gửi là POST
                url: 'submit_question.php', // URL xử lý
                data: formData, // Dữ liệu gửi
                success: function(response) {
                    alert("Câu hỏi của bạn đã được gửi thành công!"); // Thông báo khi gửi thành công
                    $('#questionForm')[0].reset(); // Đặt lại form
                    qaFrame.classList.remove('open'); // Đóng khung hỏi đáp sau khi gửi
                },
                error: function() {
                    alert("Có lỗi xảy ra. Vui lòng thử lại."); // Thông báo khi có lỗi
                }
            });
        });
    });
});
    </script>
</body>
</html>
