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
    <?php include("header.php")?>
    <section>
        <div class = "section_top">
            <div class="section_top_ht">
                <h1 style="text-align: center;">Chào mừng bạn đến với khoá học thử</h1>
                <div class="video_comment">
                    <div class="left">
                        <div class="video_ht">
                            <div class="video-player">
                                <video controls>
                                    <source src="VIDEO.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                        <div class="button" style="    display: flex;
    justify-content: space-between;">
                            <div class="kick">
                                <a href="../sinhvien_php/kick_kh.php" style="color:white;">Trở về</a>
                            </div>
                            <div class="kick">
                                <a href="../sinhvien_php/kick_kh.php" style="color:white;">Bắt đầu</a>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="comment">
                            <h2>Buổi 1: Cách cài đặt và cài môi trường học</h2>
                            <p>Tóm tắt :<br></br>- Làm quen với HTML CSS để nắm rõ các thẻ, các thuộc tính CSS. Biết cách hiển thị và sử dụng thẻ HTML nào và thuộc tính CSS nào.
                                <br>- Học cách làm trang web từ các thiết kế thiết kế sẵn. Bạn sẽ học các kỹ năng phân tích bố cục trang web, phân tách các thành phần nhỏ trên trang, cách đặt tên class CSS và tối ưu sử dụng chúng.</p>
                            <div class="button">
                                <div class="kick">
                                    <a href="#" style="color:white;">Mua khoá học</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </section>
    <?php include("footer.php")?>
</body>
</html>