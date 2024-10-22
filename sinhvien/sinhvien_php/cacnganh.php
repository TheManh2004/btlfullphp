<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang khóa học</title>
    <link rel="stylesheet" href="../sp_SinhVien/sinhvien-ind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap">
</head>
<body>

<?php 
include 'connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mảng để lưu dữ liệu khóa học theo ngành
$selectedCourses = [];

// Mảng chứa ID ngành tương ứng
$majors = [
    'technology' => 4,
    'language' => 5,
    'economics' => 6
];

// Lặp qua các ngành và lấy 1 khóa học
foreach ($majors as $major => $id) {
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
        course_enrollments ON chapters.id = course_enrollments.chapter_id  
    WHERE 
        chapters.major_id = :major_id  
    GROUP BY 
        chapters.id, chapters.subject_title, chapters.fee, chapters.image
    LIMIT 1";

    $chapterStmt = $conn->prepare($chapterSql);
    $chapterStmt->bindParam(':major_id', $id, PDO::PARAM_INT);
    $chapterStmt->execute();
    $selectedCourses[$major] = $chapterStmt->fetch(PDO::FETCH_ASSOC);
}

// Đóng kết nối
$conn = null;
?>

<section>
    <div class="section_top">
        <h1 style="text-align: center; margin: 0; padding: 0;">Khóa học nổi bật</h1>
    </div>
    
    <div class="section_footer_kh">
        <div class="box_mid">
            <?php if (!empty($selectedCourses['technology'])): ?>
                <div class="box4">
                    <div class="img-box">
                        <a href="../sinhvien_php/kick_kh.php?id=<?php echo htmlspecialchars($selectedCourses['technology']['chapter_id']); ?>">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($selectedCourses['technology']['chapter_image']); ?>" alt="<?php echo htmlspecialchars($selectedCourses['technology']['chapter_name']); ?>" style="width: 100%; height: auto;">
                        </a>
                    </div>
                    <div class="kh-comment">
                        <div class="tieude">
                            <p><?php echo htmlspecialchars($selectedCourses['technology']['chapter_name']); ?></p> 
                            <br>                                   
                            <p><?php echo number_format(floatval($selectedCourses['technology']['chapter_fee']), 0, ',', '.') . 'đ'; ?></p>
                        </div>
                        <hr>
                        <div class="comment-2">
                            <p>👥 <?php echo htmlspecialchars($selectedCourses['technology']['enrolled_students']); ?> học viên</p>
                            <p>🕒 <?php echo htmlspecialchars($selectedCourses['technology']['total_hours']); ?> giờ</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($selectedCourses['language'])): ?>
                <div class="box4">
                    <div class="img-box">
                        <a href="../sinhvien_php/kick_kh.php?id=<?php echo htmlspecialchars($selectedCourses['language']['chapter_id']); ?>">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($selectedCourses['language']['chapter_image']); ?>" alt="<?php echo htmlspecialchars($selectedCourses['language']['chapter_name']); ?>" style="width: 100%; height: auto;">
                        </a>
                    </div>
                    <div class="kh-comment">
                        <div class="tieude">
                            <p><?php echo htmlspecialchars($selectedCourses['language']['chapter_name']); ?></p> 
                            <br>                                   
                            <p><?php echo number_format(floatval($selectedCourses['language']['chapter_fee']), 0, ',', '.') . 'đ'; ?></p>
                        </div>
                        <hr>
                        <div class="comment-2">
                            <p>👥 <?php echo htmlspecialchars($selectedCourses['language']['enrolled_students']); ?> học viên</p>
                            <p>🕒 <?php echo htmlspecialchars($selectedCourses['language']['total_hours']); ?> giờ</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($selectedCourses['economics'])): ?>
                <div class="box4">
                    <div class="img-box">
                        <a href="../sinhvien_php/kick_kh.php?id=<?php echo htmlspecialchars($selectedCourses['economics']['chapter_id']); ?>">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($selectedCourses['economics']['chapter_image']); ?>" alt="<?php echo htmlspecialchars($selectedCourses['economics']['chapter_name']); ?>" style="width: 100%; height: auto;">
                        </a>
                    </div>
                    <div class="kh-comment">
                        <div class="tieude">
                            <p><?php echo htmlspecialchars($selectedCourses['economics']['chapter_name']); ?></p> 
                            <br>                                   
                            <p><?php echo number_format(floatval($selectedCourses['economics']['chapter_fee']), 0, ',', '.') . 'đ'; ?></p>
                        </div>
                        <hr>
                        <div class="comment-2">
                            <p>👥 <?php echo htmlspecialchars($selectedCourses['economics']['enrolled_students']); ?> học viên</p>
                            <p>🕒 <?php echo htmlspecialchars($selectedCourses['economics']['total_hours']); ?> giờ</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

</body>
</html>
