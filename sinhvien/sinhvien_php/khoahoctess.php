<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khoá học công nghệ</title>
    <link rel="stylesheet" href="../sp_SinhVien/sinhvien-ind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap">
</head>
<?php 
include 'connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Số khóa học trên mỗi trang
$limit = 9; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Mảng để lưu dữ liệu khóa học theo ngành
$coursesByMajor = [
    'technology' => [],
    'language' => [],
    'economics' => [],
    'tourism' => []
];

// Mảng chứa ID ngành tương ứng
$majors = [
    'technology' => 4,
    'language' => 5,
    'economics' => 6,
    'tourism' => 7
];

// Lặp qua các ngành và lấy khóa học
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
    LIMIT :limit OFFSET :offset";

    $chapterStmt = $conn->prepare($chapterSql);
    $chapterStmt->bindParam(':major_id', $id);
    $chapterStmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $chapterStmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $chapterStmt->execute();
    $coursesByMajor[$major] = $chapterStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Đóng kết nối
$conn = null;
?>

<body>
    <?php include('header.php') ?>
    <section>
        <div class="section_top">
            <h1 style="text-align: center; margin: 0; padding: 0;">Khoá học</h1>
            <div class="tabs-container">
                <ul class="tabs">
                    <li><a href="#" data-box="1" class="active">Ngành công nghệ</a></li>
                    <li><a href="#" data-box="2">Ngành ngôn ngữ</a></li>
                    <li><a href="#" data-box="3">Ngành kinh tế</a></li>
                    <li><a href="#" data-box="4">Ngành du lịch</a></li>
                </ul>
            </div>
        </div>
        
        <div class="section_footer_kh">
            <!-- Khóa học ngành công nghệ -->
            <div class="section_box" data-box="1" style="background-color: #E8FAFD; width: 100%;">
                <h1 style="text-align: center;margin: 0;padding: 2%;">Khoá học công nghệ</h1>
                <div class="box_mid">
                    <?php if (!empty($coursesByMajor['technology'])): ?>
                        <?php foreach ($coursesByMajor['technology'] as $chapter): ?>
                            <div class="box4">
                                <div class="img-box">
                                    <a href="../sinhvien_php/kick_kh.php?id=<?php echo htmlspecialchars($chapter['chapter_id']); ?>">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($chapter['chapter_image']); ?>" alt="<?php echo htmlspecialchars($chapter['chapter_name']); ?>" style="width: 100%; height: auto;">
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

            <!-- Khóa học ngành ngôn ngữ -->
            <div class="section_box hidder" data-box="2" style="background-color: #E8FAFD; width: 100%;">
                <h1 style="text-align: center;margin: 0;padding: 2%;">Khoá học ngôn ngữ</h1>
                <div class="box_mid">
                    <?php if (!empty($coursesByMajor['language'])): ?>
                        <?php foreach ($coursesByMajor['language'] as $chapter): ?>
                            <div class="box4">
                                <div class="img-box">
                                    <a href="../sinhvien_php/kick_kh.php?id=<?php echo htmlspecialchars($chapter['chapter_id']); ?>">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($chapter['chapter_image']); ?>" alt="<?php echo htmlspecialchars($chapter['chapter_name']); ?>" style="width: 100%; height: auto;">
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

            <!-- Khóa học ngành kinh tế -->
            <div class="section_box hidder" data-box="3" style="background-color: #E8FAFD; width: 100%;">
                <h1 style="text-align: center;margin: 0;padding: 2%;">Khoá học kinh tế</h1>
                <div class="box_mid">
                    <?php if (!empty($coursesByMajor['economics'])): ?>
                        <?php foreach ($coursesByMajor['economics'] as $chapter): ?>
                            <div class="box4">
                                <div class="img-box">
                                    <a href="../sinhvien_php/kick_kh.php?id=<?php echo htmlspecialchars($chapter['chapter_id']); ?>">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($chapter['chapter_image']); ?>" alt="<?php echo htmlspecialchars($chapter['chapter_name']); ?>" style="width: 100%; height: auto;">
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

            <!-- Khóa học ngành du lịch -->
            <div class="section_box hidder" data-box="4" style="background-color: #E8FAFD; width: 100%;">
                <h1 style="text-align: center;margin: 0;padding: 2%;">Khoá học du lịch</h1>
                <div class="box_mid">
                    <?php if (!empty($coursesByMajor['tourism'])): ?>
                        <?php foreach ($coursesByMajor['tourism'] as $chapter): ?>
                            <div class="box4">
                                <div class="img-box">
                                    <a href="../sinhvien_php/kick_kh.php?id=<?php echo htmlspecialchars($chapter['chapter_id']); ?>">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($chapter['chapter_image']); ?>" alt="<?php echo htmlspecialchars($chapter['chapter_name']); ?>" style="width: 100%; height: auto;">
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
    <script>
        const tabs = document.querySelectorAll('.tabs a');
        const boxes = document.querySelectorAll('.section_box');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                tabs.forEach(t => t.classList.remove('active'));
                boxes.forEach(box => box.classList.add('hidder'));
                this.classList.add('active');
                const boxToShow = document.querySelector(`.section_box[data-box="${this.dataset.box}"]`);
                boxToShow.classList.remove('hidder');
            });
        });
    </script>
</body>
</html>
