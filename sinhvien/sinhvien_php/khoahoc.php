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
$limit = 3; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Lấy tất cả chương thuộc ngành công nghệ (giả sử major_id = 4)
$majorId = 4; 
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
    course_enrollments ON chapters.id = course_enrollments.chapter_image  
WHERE 
    chapters.major_id = :major_id  
GROUP BY 
    chapters.id, chapters.subject_title, chapters.fee, chapters.image
LIMIT :limit OFFSET :offset";

$chapterStmt = $conn->prepare($chapterSql);
$chapterStmt->bindParam(':major_id', $majorId);
$chapterStmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$chapterStmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$chapterStmt->execute();
$chapters = $chapterStmt->fetchAll(PDO::FETCH_ASSOC);

// Đếm tổng số khóa học để tạo phân trang
$totalSql = "SELECT COUNT(*) FROM chapters WHERE major_id = :major_id";
$totalStmt = $conn->prepare($totalSql);
$totalStmt->bindParam(':major_id', $majorId);
$totalStmt->execute();
$totalChapters = $totalStmt->fetchColumn();
$totalPages = ceil($totalChapters / $limit);

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
                    <?php if (!empty($chapters)): ?>
                        <?php foreach ($chapters as $chapter): ?>
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