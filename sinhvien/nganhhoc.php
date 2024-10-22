<?php
include 'connect.php'; // Kết nối đến cơ sở dữ liệu

// Truy vấn để lấy thông tin khóa học
$sql = "SELECT name, img, fee, duration FROM courses"; // Thay đổi tên bảng và các cột theo cơ sở dữ liệu của bạn

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy tất cả dữ liệu
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
}

// Đóng kết nối
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khóa học ngành kinh tế</title>
    <link rel="stylesheet" href="../sp_SinhVien/sinhvien-ind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include("header.php") ?>
    <section>
        <div class="section_footer_kh">
            <div class="section_box" style="background-color: #E8FAFD; width: 100%;">
                <h1 style="text-align: center;margin: 0;padding: 2%;">Ngành kinh tế</h1>
                <div class="box_mid">

                    <?php 
                    // Lặp qua từng khóa học để hiển thị
                    foreach ($courses as $course): ?>
                        <div class="box4">
                            <div class="img-box">
                                <a href="../sinhvien_php/kick_kh.php"><img src="<?php echo htmlspecialchars($course['img']); ?>" alt="ảnh-box"></a>
                            </div>
                            <div class="kh-comment">
                                <div class="tieude">
                                    <p><?php echo htmlspecialchars($course['name']); ?></p>
                                    <br>
                                    <p><?php echo number_format($course['fee'], 0, ',', '.') . 'đ'; ?></p>
                                </div>
                                <hr>
                                <div class="comment-2">
                                    <p>👥 <?php echo htmlspecialchars($course['students_enrolled']); ?> học viên</p>
                                    <p>🕒 <?php echo htmlspecialchars($course['duration']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
        <script src="../js/khoahoc.js"></script>
    </section>
    <?php include("footer.php") ?>
</body>
</html>
