<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khóa học công nghệ</title>
    <link rel="stylesheet" href="../sp_SinhVien/sinhvien-ind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<?php 
include 'connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Số khóa học trên mỗi trang
$limit = 9; 
// Truy vấn để lấy các khóa học miễn phí (có fee = 0)
$sqlFreeCourses = "SELECT 
            chapters.id AS chapter_id,
            chapters.subject_title AS chapter_name,
            chapters.fee AS chapter_fee,
            COUNT(course_enrollments.student_id) AS enrolled_students,
            chapters.image AS chapter_image,
            chapters.major_id
        FROM 
            chapters
        LEFT JOIN 
            course_enrollments ON chapters.id = course_enrollments.subject_id  
        WHERE 
            chapters.fee = 0
        GROUP BY 
            chapters.id, chapters.subject_title, chapters.fee, chapters.image, chapters.major_id
        ORDER BY 
            enrolled_students DESC
        LIMIT :limit";

$stmtFree = $conn->prepare($sqlFreeCourses);
$stmtFree->bindValue(':limit', $freeLimit, PDO::PARAM_INT); // Ràng buộc giá trị của $freeLimit vào tham số :limit
$stmtFree->execute();
$freeCourses = $stmtFree->fetchAll(PDO::FETCH_ASSOC);

// Đóng kết nối
$conn = null;
?>
<body>
    <?php include('header.php') ?>
    
    <section>
        <div class="section_footer_kh">
            <h1 style="text-align: center;margin: 0;padding: 2%;">Khóa học công nghệ</h1>
            <div class="section_box" style="background-color: #E8FAFD; width: 100%;">
                <div class="box_mid">
                        <?php foreach ($freeCourses as $index => $course): ?>
                            <div class="box4">
                                <div class="img-box">
                                        <a href="kick_kh.php?subject_id=<?php echo $course['chapter_id']; ?>">
                                            <img src="image.php?id=<?php echo $course['chapter_id']; ?>" alt="Khóa học">
                                        </a>
                                </div>
                                <div class="kh-comment">
                                    <div class="tieude">
                                        <p><?php echo htmlspecialchars($course['chapter_name']); ?></p>
                                        <br>                                   
                                        <p>Miễn phí</p>
                                    </div>
                                    <hr>
                                    <div class="comment-2">
                                        <p>👥 <?php echo htmlspecialchars($chapter['enrolled_students']); ?> học viên</p>
                                        <p>🕒 <?php echo htmlspecialchars($chapter['total_hours']); ?> giờ</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                </div>
            </div>

            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <span class="dot <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </span>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <?php include("footer.php") ?>
    <script src="../js/khoahoc.js"></script>
</body>