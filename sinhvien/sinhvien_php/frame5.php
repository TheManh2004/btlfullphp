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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../sp_SinhVien/sinhvien-ind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../sp_SinhVien/thongbao.css">
    <link rel="stylesheet" href="../sp_SinhVien/hoidap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include("header.php") ?>
<main>
        <section class="video-section">
            <div class="video-player">
                <video controls>
                    <source src="VIDEO.mp4" type="video/mp4">
                </video>
            </div>
            <div class="video-info">
                <div class="info-container">
                    <div class="text-container">
                        <h2>Buổi 1: Cách cài đặt và tạo môi trường học</h2>
                        <div class="info-text">
                            <p>Nguyễn Duy Khánh</p>
                            <p>Thời lượng: 3p22s</p>
                        </div>
                        <a href="#" id="notificationButton" style="width: 50px; height: 50px;">
                            <img src="../img/image 75.png" alt="Thông báo" style="width: 10%; border-radius: 50%;">
                        </a>
                    </div>
                    <button class="qa-button" id="openFrame">Hỏi Đáp</button> <!-- Nút mở khung hỏi đáp -->
                    
                    <div id="qaFrame" class="qa-frame"> <!-- Khung hỏi đáp -->
                    <div class="qa-content">
                        <button class="Dong" id="closeFrame">Đóng</button> <!-- Nút đóng khung hỏi đáp -->
                        <form id="questionForm"> <!-- Form gửi câu hỏi -->
                            <textarea name="question" placeholder="Nhập câu hỏi của bạn..."></textarea>
                            <!-- <input type="hidden" name="chapters_id" value="1"> Thay đổi giá trị này nếu cần -->
                            <input type="hidden" name="chapters_id" value="<?php echo htmlspecialchars($_SESSION['subject_id']); ?>"> <!-- Sử dụng subject_id làm chapters_id -->
                            <input type="hidden" name="lesson_id" value="1"> <!-- Thay đổi giá trị này nếu cần -->
                            <button type="submit">Gửi Câu Hỏi</button> <!-- Nút gửi câu hỏi -->
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
            </div>
        </section>
                </div>
        <div class="main-right">
                <aside class="sidebar">
                                <ul>
                                <?php if ($result_lessons && count($result_lessons) > 0): ?>
                        <ul>
                            <?php foreach ($result_lessons as $row): ?>
                                <li>
                                    <a href="<?php echo htmlspecialchars($row['drive_link']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Không có bài học nào trong khóa học này.</p>
                    <?php endif; ?>
                                </ul>
                            </aside>
                        </ul>
                </aside>

            <button class="next-lesson">Bài tiếp theo</button>
        </div>
                <!-- Frame Thông Báo Bên Trái -->
            <div id="notificationFrame" class="notification-frame">
                <div class="register-container">
                    <div>
                        <a href="#" class="icon-exit" id="closeNotification"><i class="exit fa-solid fa-xmark"></i></a>
                    </div>
                    <div class="register-box">
                        <div class="banner">
                            <h5># "Try Hard" Cùng Lớp Học Offline Tại Hà Nội - Ai Sợ Thì Đi Về!</h5>
                        </div>
                        <img src="/img/hoc_off.jpg" class="img_learn" alt="Học Offline">
                        <p class="note">
                            <strong>Lưu ý: </strong>Lớp học offline dành cho những bạn xác định "all in" với nghề. Không dành cho các bạn nghĩ "học offline cho dễ học" nhé. Vì để đáp ứng cho đầu vào doanh nghiệp hiện nay, kiến thức học sẽ thử thách và nâng cao - đòi hỏi bạn phải là người có tính nỗ lực, dám đầu tư thời gian và công sức!
                        </p>
                        <p class="Posted">Đăng bởi 
                            <a href="#" class="name_post">Sơn Đặng</a>
                            <span class="dot">·</span>
                            <time class="time">một tháng trước</time>
                        </p>
                    </div>
                    <div class="register-box">
                        <div class="banner">
                            <h5># "Try Hard" Cùng Lớp Học Offline Tại Hà Nội - Ai Sợ Thì Đi Về!</h5>
                        </div>
                        <img src="/img/hoc_off.jpg" class="img_learn" alt="Học Offline">
                        <p class="note">
                            <strong>Lưu ý: </strong>Lớp học offline dành cho những bạn xác định "all in" với nghề. Không dành cho các bạn nghĩ "học offline cho dễ học" nhé. Vì để đáp ứng cho đầu vào doanh nghiệp hiện nay, kiến thức học sẽ thử thách và nâng cao - đòi hỏi bạn phải là người có tính nỗ lực, dám đầu tư thời gian và công sức!
                        </p>
                        <p class="Posted">Đăng bởi 
                            <a href="#" class="name_post">Sơn Đặng</a>
                            <span class="dot">·</span>
                            <time class="time">một tháng trước</time>
                        </p>
                    </div>
                </div>
            </div>
                <script src="../js/thongbao.js"></script>
        
</main>
<?php include("footer.php") ?>
</body>
</html>
<?php
