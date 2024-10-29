<?php
include 'connect.php'; // Kết nối đến cơ sở dữ liệu
// Bật báo cáo lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);
$limit = 6; // Bạn có thể thay đổi giá trị này theo ý muốn
$freeLimit = 3; // Số lượng khóa học miễn phí
$sql = "SELECT 
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
        GROUP BY 
            chapters.id, chapters.subject_title, chapters.fee, chapters.image, chapters.major_id
        ORDER BY 
            enrolled_students DESC
        LIMIT :limit"; // Giới hạn lấy các khóa học theo giá trị biến $limit
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT); // Ràng buộc giá trị của $limit vào tham số :limit
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../sp_SinhVien/sinhvien-ind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php  include("header.php")?> 
    <nav>
        <div class="nav_top" style = " background-color: #fafafa;">
            <div class="container">
                <div class="slogan">
                    <div class="nav_left">
                        <h1>Nền Tảng <br><span style = "color: #0095FF;">Học & Cung Cấp</span><br>Tài Liệu</h1>
                        <div class="button_left">
                            <span><a href="../sinhvien_php/khoahoc_full.php">Truy cập tất cả các khoá học</a></span>
                        </div>
                    </div>
                    <div class="nav_right">
                        <a href="../sinhvien_php/index.php"> <img src="../img/snapedit_1728410569479.png" alt="ảnh "></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav_footer">
            <div class="banner">
                <div class = "slideshow-container">
                    <div class="banner1">
                        <img src="../img/hinh-nen-may-tinh-11.jpg" alt="">
                    </div> 
                </div>
            </div>
        </div>
    </nav>
<section>
    <div class="section_top" style = " background-color: #E6E6E6;
                                        padding-bottom: 10px;">
        <h1 style="padding-top: 15px;">Một số khoá học nổi bật mà <br> bạn có thể quan tâm</h1> 
        <div class="stye_box">
                <div class="box_left">
                    <div class="box1">
                        <i class="fa-solid fa-folder" style="font-size: 30px"></i>
                        <a href="../sinhvien_php/khoahoc.php" >Khoá học công nghệ</a>
                    </div>
                    <div class="box1">
                        <i class="fa-solid fa-folder" style="font-size: 30px"></i>
                        <a href="../sinhvien_php/khoahoc_t.php">Khoá học tiếng</a>
                    </div>
                    <div class="box1">
                        <i class="fa-solid fa-folder" style="font-size: 30px"></i>
                        <a href="../sinhvien_php/khoahoc_toan.php">Khoá học toán</a>
                    </div>
                </div>
                <div class="box_left">
                    <div class="box1">
                        <i class="fa-solid fa-folder" style="font-size: 30px "></i>
                        <a href="../sinhvien_php/khoahoc.php" >Khoá học du lịch</a>
                    </div>
                    <div class="box1">
                        <i class="fa-solid fa-folder" style="font-size: 30px "></i>
                        <a href="../sinhvien_php/khoahoc.php" >Khoá học kinh tế</a>
                    </div>
                    <div class="box1">
                        <i class="fa-solid fa-folder" style="font-size: 30px ;"></i>
                        <a href="../sinhvien_php/khoahoc.php" >Khoá học </a>
                    </div>
                </div>
                <div class="box_right">
                    <div class="next-back">
                        <button id="prev"><i class="fa-solid fa-caret-left"></i></button>
                        <button id="next"><i class="fa-solid fa-caret-right"></i></button>
                    </div>
                </div>
        </div>
        <div class="section_box_top">
            <div class="box_mid">
                <?php foreach ($courses as $index => $course): ?>
                    <div class="box2">
                        <div class="img-box">
                            <a href="../sinhvien_php/kick_kh-1.php?subject_id=<?php echo $course['chapter_id']; ?>">
                                <img src="image.php?id=<?php echo $course['chapter_id']; ?>" alt="Khóa học">
                            </a>
                            <div class="comment-2">
                                <p><?php echo htmlspecialchars($course['chapter_name']); ?></p>
                                <p><?php echo number_format($course['chapter_fee'], 0, ',', '.'); ?>đ</p>
                            </div>
                        </div>
                    </div>
                    <?php if (($index + 1) % 3 == 0): ?>
                        <!-- Kết thúc một hàng sau mỗi 3 khóa học -->
                        </div><div class="box_mid">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
            <script>
                                let currentIndex = 0; // Khởi tạo chỉ số slide hiện tại
                    const boxLefts = document.getElementsByClassName("box_left"); // Lấy tất cả các phần tử box_left

                    // Hàm hiển thị box_left hiện tại
                    function showSlide(index) {
                        // Ẩn tất cả các phần tử box_left
                        for (let i = 0; i < boxLefts.length; i++) {
                            boxLefts[i].style.display = "none";
                        }

                        // Xử lý việc lặp lại chỉ số
                        if (index >= boxLefts.length) {
                            currentIndex = 0; // Nếu chỉ số vượt quá, quay lại slide đầu tiên
                        }
                        if (index < 0) {
                            currentIndex = boxLefts.length - 1; // Nếu nhỏ hơn 0, quay lại slide cuối cùng
                        }

                        // Hiển thị box_left hiện tại
                        boxLefts[currentIndex].style.display = "flex";
                    }

                    // Hàm khi nhấn nút "Next"
                    function nextSlide() {
                        currentIndex++; // Chuyển tới slide tiếp theo
                        showSlide(currentIndex); // Hiển thị slide mới
                    }

                    // Hàm khi nhấn nút "Back"
                    function prevSlide() {
                        currentIndex--; // Quay lại slide trước
                        showSlide(currentIndex); // Hiển thị slide mới
                    }

                    // Gắn sự kiện cho các nút "Next" và "Back"
                    document.getElementById("next").addEventListener("click", nextSlide);
                    document.getElementById("prev").addEventListener("click", prevSlide);

                    // Hiển thị slide đầu tiên khi tải trang
                    showSlide(currentIndex);
    </script>
    <div class="section_mid">
        <h1>Khoá học miễn phí</h1>
        <div class="section_box">
            <div class="stye_box">
                <div class="box_right">
                    <div class="next-back">
                        <a href="../sinhvien_php/khoahoc_fr.php" style="text-decoration: none;color: white;">Xem tất cả </a>
                    </div>
                </div>
            </div>
            <div class="box_mid">
                <?php foreach ($freeCourses as $index => $course): ?>
                <div class="box3">
                    <div class="img-box">
                        <a href="kick_kh-1.php?subject_id=<?php echo $course['chapter_id']; ?>">
                            <img src="image.php?id=<?php echo $course['chapter_id']; ?>" alt="Khóa học">
                        </a>
                        <div class="comment-2">
                            <p><?php echo htmlspecialchars($course['chapter_name']); ?></p>
                            <p>Miễn phí</p>
                        </div>
                    </div>
                </div>

                <?php if (($index + 1) % 3 == 0): ?>
                    <!-- Kết thúc một hàng sau mỗi 3 khóa học -->
                    </div><div class="box_mid">
                    <?php endif; ?>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php include ("footer.php")?>
</body>
</html>
