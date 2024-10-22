<?php
session_start(); // Bắt đầu session

// Kiểm tra nếu subject_id được truyền qua URL
if (isset($_GET['subject_id'])) {
    // Lưu subject_id vào session
    $_SESSION['subject_id'] = $_GET['subject_id'];

    // Chuyển hướng người dùng đến trang chi tiết khoá học
} else {
    echo "Không tìm thấy subject_id.";
}
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
    <?php include("header.php") ?>
    <nav>
        <div class = "nav_top_kick">
            <div class="nav_top">
                <div class = "left">
                    <h1>Học HTML , CSS cho người mới bắt đầu </h1>
                </div>
                <div class = "right">
                    <div class = "img_right">
                        <img src="../img/snapedit_1728410569479.png" alt="ảnh ">
                    </div>
                </div>
            </div>
            <div class="nav_mid">
                <hr>
                <p>Thực hàng với 10 dự án ,hơn 280 bài tập , đang đợi bạn thử thách .</p>
            </div>
            <div class="nav_footer">
                <div class="button">
                    <div class="button_left">
                        <div class="kick">
                            <a href="../sinhvien_php/hocthu.php" style="color: white;">Học thử miễn phí</a>
                        </div>
                    </div>
                    <div class="button_right">
                        <div class="kick">
                        
                        <a href="frame5.php?subject_id=<?php echo $_SESSION['subject_id']; ?>" style="color:white;">Mua khoá học</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav_footer">
            <i class="fa-solid fa-angles-down"></i>
        </div>
    </nav>
    <section>
        <div class = "section_top">
            <div class="section_top_kick">
                <div class="left">
                    <div class="practice">
                        <h1 style="margin: 0;padding: 0;font-size: 40px;">Thực hành với 10 dự án cùng Khánh Buf</h1>
                        <p>"Trang web đầu tiên mình làm vào năm 2013, tuy nó chưa được xuất sắc nhưng đã giúp công ty cũ của mình bán được hàng trăm triệu mỗi tháng nhờ chức năng đặt hàng online."<br>
                            "Mình có thêm 2 giải quán quân cuộc thi sáng tạo của FPT vào 2016 với sản phẩm là game Siêu Đạo Chích, game gắp thú bằng máy vật lý qua Internet đầu tiên tại VN."</p>
                    </div>
                </div>
                <div class="right">
                        <img class="img_left" src="../img/kick_img_1.jfif" style="width:100% ;" alt="">
                        <img class="img_right" src="../img/kick_img_2.png" style="width: 70%;" alt="">
                    </div>   
                </div>
            </div>
        </div>
        <div class="section_mid">
            <div class="section_mid_kick">
                <div class="left">
                    <div class="practice">
                        <h1 style="margin: 0;padding: 0;font-size: 40px;">Khoá học được thiết kế bởi Khánh Buf</h1>
                        <p>"Trang web đầu tiên mình làm vào năm 2013, tuy nó chưa được xuất sắc nhưng đã giúp công ty cũ của mình bán được hàng trăm triệu mỗi tháng nhờ chức năng đặt hàng online."<br>
                            "Mình có thêm 2 giải quán quân cuộc thi sáng tạo của FPT vào 2016 với sản phẩm là game Siêu Đạo Chích, game gắp thú bằng máy vật lý qua Internet đầu tiên tại VN."</p>
                            <div class="button">
                                <div class="kick">
                                    <a href="#" style="color: white;">Tìm hiển thêm</a>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="right">
                        <div class="bloc">
                            <img src="../img/snapedit_1728410569479.png" alt="">
                        </div>
                </div> 
            </div>
        </div>
    </section>
    <?php include("footer.php") ?>
</body>
</html>