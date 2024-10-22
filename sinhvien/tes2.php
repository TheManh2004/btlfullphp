<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../sp_SinhVien/sinhvien-ind.css">
</head>
<body>
<?php 
include 'sinhvien_php/connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Lấy tất cả khóa học thuộc ngành công nghệ (giả sử major_id = 1 là ngành công nghệ)
$majorId = 5; // Giả sử ID ngành công nghệ là 1
$courseSql = "SELECT 
    courses.id AS course_id,
    courses.name AS course_name,
    courses.fee AS course_fee,
    COUNT(course_enrollments.student_id) AS enrolled_students,
    courses.img AS course_image,
    FLOOR(TIMESTAMPDIFF(MINUTE, courses.start_date, courses.end_date) / 60) AS total_hours
FROM 
    courses
LEFT JOIN 
    course_enrollments ON courses.id = course_enrollments.course_id  
WHERE 
    courses.major_id = :major_id  
GROUP BY 
    courses.id, courses.name, courses.fee, courses.img";

$courseStmt = $conn->prepare($courseSql);
$courseStmt->bindParam(':major_id', $majorId);
$courseStmt->execute();
$courses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);

// Đóng kết nối (PDO tự động đóng kết nối khi hết phạm vi)
$conn = null;
?>
    <section>
        <div class="section_footer_kh">
            <div class="section_box" style="background-color: #E8FAFD; width: 100%;">
                <h1 style="text-align: center;margin: 0;padding: 2%;">Khoá học công nghệ</h1>
                <div class="box_mid">
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="box4">
                                <div class="img-box">
                                    <a href="../sinhvien_php/kick_kh.php?id=<?php echo htmlspecialchars($course['course_id']); ?>">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($course['course_image']); ?>" alt="<?php echo htmlspecialchars($course['course_name']); ?>" style="width: 100%; height: auto;">
                                    </a>
                                </div>
                                <div class="kh-comment">
                                    <div class="tieude">
                                        <p><?php echo htmlspecialchars($course['course_name']); ?></p> 
                                        <br>                                   
                                        <p><?php echo number_format(floatval($course['course_fee']), 0, ',', '.') . 'đ'; ?></p>
                                    </div>
                                    <hr>
                                    <div class="comment-2">
                                        <p>👥 <?php echo htmlspecialchars($course['enrolled_students']); ?> học viên</p>
                                        <p>🕒 <?php echo htmlspecialchars($course['total_hours']); ?> giờ</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không có khóa học nào thuộc ngành học này.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="pagination">
                <span class="dot active" data-box="1"></span>
                <span class="dot" data-box="2"></span>
            </div>
        </div>
        <script src="../js/khoahoc.js"></script>
    </section>
    <?php include("footer.php") ?>
</body>
</html>