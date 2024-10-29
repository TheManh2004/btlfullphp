<?php
session_start(); // Bắt đầu session

include 'connect.php'; // Kết nối CSDL
// Kiểm tra xem có subject_id mới từ URL (khi người dùng chọn khóa học khác)
if (isset($_GET['subject_id'])) {
    // Cập nhật subject_id mới vào session
    $_SESSION['subject_id'] = $_GET['subject_id'];
}

// Kiểm tra lại subject_id trong session
if (isset($_SESSION['subject_id'])) {
    $subject_id = $_SESSION['subject_id'];

    // Truy vấn lấy danh sách bài học thuộc subject_id
    $sql_lessons = "SELECT id, title, drive_link FROM lessons WHERE subject_id = :subject_id";
    $stmt = $conn->prepare($sql_lessons);
    $stmt->bindValue(':subject_id', $subject_id, PDO::PARAM_INT); // Gán subject_id vào câu truy vấn
    $stmt->execute(); // Thực thi câu truy vấn
    $result_lessons = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy kết quả
    $stmt->closeCursor(); // Đóng con trỏ sau khi lấy dữ liệu
} else {
    // Nếu không có subject_id trong session, thông báo lỗi
    echo "Không tìm thấy subject_id.";
    exit();
}

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Vui lòng đăng nhập để gửi câu hỏi và trả lời.";
    exit();
}

$lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 1; // Lấy lesson_id từ URL, mặc định là 1

// Lấy teacher_id của bài giảng
$sql_get_teacher = "SELECT teacher_id FROM chapters WHERE id = :lesson_id"; // Sửa lại từ chapters thành lessons
$stmt = $conn->prepare($sql_get_teacher);
$stmt->bindValue(':lesson_id', $lesson_id);
$stmt->execute();
$lesson = $stmt->fetch(PDO::FETCH_ASSOC);
$lesson_teacher_id = $lesson['teacher_id'];  // Lấy teacher_id của bài giảng

// // Xử lý khi người dùng gửi câu hỏi
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question'])) {
//     $question = trim($_POST['question']);
//     $student_id = $_SESSION['user_id'];
//     $chapters_id = $_POST['chapters_id']; // ID chương học
//     $state = 'Open';

//     if (!empty($question)) {
//         $sql_insert = "INSERT INTO course_questions (student_id, chapters_id, question, state, lesson_id) 
//                        VALUES (:student_id, :chapters_id, :question, :state, :lesson_id)";
//         $stmt = $conn->prepare($sql_insert);
//         $stmt->execute([
//             ':student_id' => $student_id,
//             ':chapters_id' => $chapters_id,
//             ':question' => $question,
//             ':state' => $state,
//             ':lesson_id' => $lesson_id
//         ]);
//         echo "Câu hỏi của bạn đã được gửi!";
//     } else {
//         echo "Vui lòng nhập câu hỏi.";
//     }
// }

// Lấy danh sách câu hỏi theo lesson_id
$sql_questions = "SELECT cq.id AS question_id, cq.question, cq.created_at, u.name AS student_name 
                  FROM course_questions cq 
                  JOIN users u ON cq.student_id = u.id 
                  WHERE cq.lesson_id = :lesson_id
                  LIMIT 3";
$stmt = $conn->prepare($sql_questions);
$stmt->bindValue(':lesson_id', $lesson_id);
$stmt->execute();
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Thêm câu trả lời (chỉ cho phép giảng viên phụ trách trả lời)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer']) && isset($_POST['question_id'])) {
    $answer = trim($_POST['answer']);
    $replier_id = $_SESSION['user_id'];
    $question_id = $_POST['question_id'];

    // Kiểm tra xem người dùng có phải là giảng viên phụ trách không
    if ($replier_id == $lesson_teacher_id) {  // Kiểm tra xem user_id có khớp với teacher_id của bài học không
        if (!empty($answer)) {
            $sql_insert_answer = "INSERT INTO answers (replier_id, answer, question_id) 
                                  VALUES (:replier_id, :answer, :question_id)";
            $stmt = $conn->prepare($sql_insert_answer);
            $stmt->execute([
                ':replier_id' => $replier_id,
                ':answer' => $answer,
                ':question_id' => $question_id
            ]);
            echo "Câu trả lời của bạn đã được gửi!";
        } else {
            echo "Vui lòng nhập câu trả lời.";
        }
    } else {
        echo "Bạn không có quyền trả lời câu hỏi này."; // Thông báo nếu không phải là giảng viên phụ trách
    }
}

// Đóng kết nối
$stmt->closeCursor();
$conn = null; // Đóng kết nối
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
            <div class="video-player" style="display: flex;
                                            gap: 50px;">
                <video controls>
                    <source src="VIDEO.mp4" type="video/mp4">
                </video>
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
            </div>
            <div class="video-info">
                <div class="info-container">
                    <div class="text-container">
                        <h2>Buổi 1: Cách cài đặt và tạo môi trường học</h2>
                        <div class="info-text">
                            <p>Nguyễn Duy Khánh</p>
                            <p>Thời lượng: 3p22s</p>
                        </div>
                        <a id="notificationButton" style="width: 50px; height: 50px;
                                                        cursor: pointer;">
                            <img src="../img/image 75.png" alt="Thông báo" style="width: 10%; border-radius: 50%;">
                        </a>
                    </div>


                    <button class="qa-button" id="openFrame">Hỏi Đáp</button> <!-- Nút mở khung hỏi đáp -->

                    <div id="qaFrame" class="qa-frame" style="width: 30%;
                                                        display: none;"> <!-- Khung hỏi đáp -->
                        <div class="qa-content">
                            <button class="Dong" id="closeFrame">Đóng</button> <!-- Nút đóng khung hỏi đáp -->
                            <form id="questionForm"> <!-- Form gửi câu hỏi -->
                                <textarea name="question" placeholder="Nhập câu hỏi của bạn..."></textarea>
                                <!-- <input type="hidden" name="chapters_id" value="1"> Thay đổi giá trị này nếu cần -->
                                <input type="hidden" name="chapters_id" value="<?php echo htmlspecialchars($_SESSION['subject_id']); ?>"> <!-- Sử dụng subject_id làm chapters_id -->
                                <input type="hidden" name="lesson_id" value="1"> <!-- Thay đổi giá trị này nếu cần -->
                                <button type="submit">Gửi Câu Hỏi</button> <!-- Nút gửi câu hỏi -->
                            </form>
                            <script>
                                // Mở khung hỏi đáp
                                document.getElementById('openFrame').onclick = function() {
                                    document.getElementById('qaFrame').style.display = 'block';
                                }
                                // Đóng khung hỏi đáp
                                document.getElementById('closeFrame').onclick = function() {
                                    document.getElementById('qaFrame').style.display = 'none';
                                }
                            </script>
                            <hr>

                            <!-- Hiển thị các câu hỏi -->
                            <h2>Danh Sách Câu Hỏi</h2>
                            <?php foreach ($questions as $question): ?>
                                <div style="margin: 5%">
                                    <p><strong><?php echo htmlspecialchars($question['student_name']); ?> hỏi:</strong> <?php echo htmlspecialchars($question['question']); ?></p>
                                    <p><small>Ngày tạo: <?php echo htmlspecialchars($question['created_at']); ?></small></p>

                                    <!-- Hiển thị câu trả lời liên quan đến câu hỏi -->
                                    <h3>Các câu trả lời của giảng viên:</h3>
                                    <?php
                                    include('connect.php');
                                    $sql_answers = "SELECT a.answer, u.name AS replier_name, a.created_at 
                        FROM answers a 
                        JOIN users u ON a.replier_id = u.id 
                        WHERE a.question_id = :question_id AND u.role = 'teacher'";

                                    $stmt = $conn->prepare($sql_answers);
                                    $stmt->bindValue(':question_id', $question['question_id']);
                                    $stmt->execute();
                                    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php if (count($answers) > 0): ?>
                                        <?php foreach ($answers as $answer): ?>
                                            <p><strong><?php echo htmlspecialchars($answer['replier_name']); ?> trả lời:</strong> <?php echo htmlspecialchars($answer['answer']); ?></p>
                                            <p><small>Ngày trả lời: <?php echo htmlspecialchars($answer['created_at']); ?></small></p>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Chưa có câu trả lời.</p>
                                    <?php endif; ?>
                                </div>
                                <hr>
                            <?php endforeach; ?>

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


        <!-- Frame Thông Báo Bên Trái -->
        <!-- Frame Thông Báo Bên Trái -->
        <div id="notificationFrame" class="notification-frame" style="display: none;">
            <div class="register-container">


                <!-- Dữ liệu từ cơ sở dữ liệu sẽ được tải vào đây -->
            </div>
            <div>
                <a class="icon-exit" id="closeNotification">
                    <i class="exit fa-solid fa-xmark"></i>
                </a>
            </div>
        </div>
        <script>
            function loadNotification() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_notifications.php', true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.querySelector('#notificationFrame .register-container').innerHTML = this.responseText;
                    } else {
                        console.error('Lỗi khi tải nội dung!');
                    }
                };

                xhr.onerror = function() {
                    console.error('Yêu cầu AJAX thất bại!');
                };

                xhr.send();
            }


            function closeNotification() {
                document.getElementById('notificationFrame').style.display = 'none';
            }

            // Thêm sự kiện nhấn cho nút thông báo
            document.getElementById('notificationButton').addEventListener('click', toggleNotification);

            function toggleNotification() {
                const notificationFrame = document.getElementById('notificationFrame');
                if (notificationFrame.style.display === 'none' || notificationFrame.style.display === '') {
                    notificationFrame.style.display = 'block';
                    loadNotification(); // Gọi hàm để tải thông báo nếu cần
                } else {
                    closeNotification();
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                loadNotification();

                // Thêm sự kiện đóng thông báo
                document.getElementById('closeNotification').addEventListener('click', closeNotification);
            });
        </script>
        <!-- <script src="../js/thongbao.js"></script> -->

    </main>
    <?php include("footer.php") ?>
</body>

</html>
<?php
