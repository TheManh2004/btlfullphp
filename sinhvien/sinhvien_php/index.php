
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
    <div class="section_top" style = " background-color: #fafafa;">
        <h1>Một số khoá học nổi bật mà <br> bạn có thể quan tâm</h1>
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
                <div class="box2">
                    <div class="img-box">
                            <a href="../sinhvien_php/kick_kh.php">
                                <img src="../img/2.png" alt="anh1" style="">
                            </a>
                            <div class="comment-2">
                                <p>Khoá Học HTML</p>
                                <p>129.000đ</p>
                            </div>
                    </div>
                </div>
                <div class="box2">
                    <div class="img-box">
                            <a href="../sinhvien_php/kick_kh.php">
                                <img src="../img/java-pro.png" alt="anh1" style="">
                            </a>
                            <div class="comment-2">
                                <p>Khoá Học Java-pro </p>
                                <p>129.000đ</p>
                            </div>
                    </div>
                </div>
                <div class="box2">
                    <div class="img-box">
                        <a href="../sinhvien_php/kick_kh.php"><img src="../img/Sass.png" alt="anh1" style=""></a>
                        <div class="comment-2">
                            <p>Khoá Học Sacc</p>
                            <p>129.000đ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section_box_top">
            <div class="box_mid">
                <div class="box2">
                    <div class="img-box">
                        <a href="../sinhvien_php/kick_kh.php"><img src="../img/1.png" alt="anh1" style=""></a>
                        <div class="comment-2">
                            <p>Khoá Học IT</p>
                            <p>129.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="box2">
                    <div class="img-box">
                        <a href="../sinhvien_php/kick_kh.php"><img src="../img/6.png" alt="anh1" style=""></a>
                        <div class="comment-2">
                            <p>Khoá Học Tiếng</p>
                            <p>129.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="box2">
                    <div class="img-box">
                        <a href="../sinhvien_php/kick_kh.php"><img src="../img/c++.png" alt="anh1" style=""></a>
                        <div class="comment-2">
                            <p>Khoá Học C++</p>
                            <p>129.000đ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <script>
            let currentIndex = 0; // Khởi tạo chỉ số slide hiện tại
        const boxLefts = document.getElementsByClassName("box_left"); // Lấy tất cả các phần tử box_left
        const sectionTops = document.getElementsByClassName("section_box_top"); // Lấy tất cả các phần tử section_box_top

        // Hàm hiển thị box_left và section_box_top hiện tại
        function showSlide(index) {
            // Ẩn tất cả các phần tử box_left
            for (let i = 0; i < boxLefts.length; i++) {
                boxLefts[i].style.display = "none";
            }

            // Ẩn tất cả các phần tử section_box_top
            for (let i = 0; i < sectionTops.length; i++) {
                sectionTops[i].style.display = "none";
            }

            // Xử lý việc lặp lại chỉ số
            if (index >= boxLefts.length || index >= sectionTops.length) {
                currentIndex = 0; // Nếu chỉ số vượt quá, quay lại slide đầu tiên
            }
            if (index < 0) {
                currentIndex = boxLefts.length - 1; // Nếu nhỏ hơn 0, quay lại slide cuối cùng
            }

            // Hiển thị box_left và section_box_top hiện tại
            boxLefts[currentIndex].style.display = "flex";
            sectionTops[currentIndex].style.display = "block";
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
    <!-- <script src="../js/box.js"></script> -->

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
                <div class="box3">
                    <div class="img-box">
                        <a href="../sinhvien_php/hocbai_fr.php">
                            <img src="../img/c++.png" alt="anh1" style="">
                            <div class="comment-2">
                                <p>Khoá Học IT</p>
                                <p>miễn phí</p>
                            
                            </div>
                        </a>
                    
                    </div>
                </div>
                <div class="box3">
                    <div class="img-box">
                        <a href="../sinhvien_php/hocbai_fr.php">
                            <img src="../img/Sass.png" alt="anh1" style="">
                            <div class="comment-2">
                                <p>Khoá Học IT</p>
                                <p>miễn phí</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="box3">
                    <div class="img-box">
                        <a href="../sinhvien_php/hocbai_fr.php">
                            <img src="../img/2.png" alt="anh1" style="">
                            <div class="comment-2">
                                <p>Khoá Học IT</p>
                                <p>miễn phí</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include ("footer.php")?>
</body>
</html>
