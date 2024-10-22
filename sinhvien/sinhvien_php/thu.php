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
<?php
session_start();  // Khởi động phiên làm việc

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_login'])) {
    $user = $_SESSION['user_login'];
    $email = $_SESSION['email'];
    echo "Xin chào, người dùng " . htmlspecialchars($user->name) . "!";  // Hiển thị tên người dùng
} else {
    echo "Xin chào bạn!";
}
?>
<nav>
    <div class="nav_top" style="background-color: #fafafa;">
        <div class="container">
            <div class="slogan">
                <div class="nav_left">
                    <h1>Nền Tảng <br><span style="color: #0095FF;">Học & Cung Cấp</span><br>Tài Liệu</h1>
                    <div class="button_left">
                        <span><a href="../sinhvien_php/khoahoc_full.php">Truy cập tất cả các khoá học</a></span>
                    </div>
                </div>
                <div class="nav_right">
                    <a href="../sinhvien_php/index.php"><img src="../img/snapedit_1728410569479.png" alt="ảnh"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="nav_footer">
        <div class="banner">
            <div class="slideshow-container">
                <div class="banner1">
                    <img src="../img/hinh-nen-may-tinh-11.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</nav>

<section>
    <div class="section_top" style="background-color: #fafafa;">
        <h1>Một số khoá học nổi bật mà <br> bạn có thể quan tâm</h1>
        <!-- Hiển thị thông tin người dùng -->
        <div class="user-info">
            <?php if (isset($user)): ?>
                <p>Xin chào, <strong><?php echo htmlspecialchars($user->name); ?></strong>!</p>
            <?php else: ?>
                <p>Xin chào, khách!</p>
            <?php endif; ?>
        </div>
        <!-- Phần còn lại của mã HTML -->
    </div>
    <!-- Phần còn lại của trang -->
</section>

<?php include("footer.php"); ?>
</body>
</html>
