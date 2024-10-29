<?php
// Kết nối cơ sở dữ liệu
include("connect.php");
include('laydulieu.php');
// Giả sử rằng user_id được lấy từ session của học sinh đã đăng nhập
$user_id = $_SESSION['user_id']; // Lấy user_id từ session của người dùng đã đăng nhập

// Truy vấn SQL để lấy ra tất cả các khóa học mà học sinh đã đăng ký
$chapterSql = "SELECT 
                chapters.id AS chapter_id,
                chapters.subject_title AS chapter_name,
                chapters.fee AS chapter_fee,
                COUNT(course_enrollments.student_id) AS enrolled_students,
                chapters.image AS chapter_image,
                FLOOR(TIMESTAMPDIFF(MINUTE, chapters.created_at, chapters.updated_at) / 60) AS total_hours
            FROM 
                chapters
            LEFT JOIN 
                course_enrollments ON chapters.id = course_enrollments.subject_id
            WHERE 
                course_enrollments.student_id = :user_id
            GROUP BY 
                chapters.id, chapters.subject_title, chapters.fee, chapters.image";

$chapterStmt = $conn->prepare($chapterSql);
$chapterStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Ràng buộc biến user_id với tham số trong truy vấn
$chapterStmt->execute();
$courses = $chapterStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khóa học của tôi</title>
    <link rel="stylesheet" href="../sp_SinhVien/sinhvien-ind.css">
</head>
<body>
    <?php include("header.php"); ?>
    <section>
        <div class="section_top">
            <h1 style="text-align: center;padding: 0;">Khóa học của tôi</h1>
            <div class="tabs-container">
                <ul class="tabs">
                    <li><a href="#">Tất cả khóa học</a></li>
                    <li><a href="#">Chưa hoàn thành</a></li>
                    <li><a href="#">Đã hoàn thành</a></li>
                </ul>
            </div>
        </div>
        <div class="section_footer_kh">
        <div class = "section_box" style="background-color: #E8FAFD; width: 100%;">
            <div class="box_mid" style="    margin-top: 18px;">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $chapter): ?>
                        <div class="box4">
                            <div class="img-box">
                                <a href="../sinhvien_php/frame5.php?subject_id=<?php echo htmlspecialchars($chapter['chapter_id']); ?>">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($chapter['chapter_image']); ?>"
                                        alt="<?php echo htmlspecialchars($chapter['chapter_name']); ?>"
                                        style="width: 100%; height: auto;">
                                </a>
                            </div>
                            <div class="kh-comment">
                                <div class="tieude">
                                    <p><?php echo htmlspecialchars($chapter['chapter_name']); ?></p>
                                    <br>
                                    <p><?php echo number_format(floatval($chapter['chapter_fee']), 0, ',', '.') . 'đ'; ?></p>
                                </div>
                                <hr>
                                <div class="comment-2">
                                    <p>👥 <?php echo htmlspecialchars($chapter['enrolled_students']); ?> học viên</p>
                                    <p>🕒 <?php echo htmlspecialchars($chapter['total_hours']); ?> giờ</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có chương học nào thuộc ngành này.</p>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </section>
    <?php include("footer.php"); ?>
</body>
</html>
