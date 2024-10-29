    <?php
    session_start();
    include('connect.php');
    try {
        if (isset($_GET['subject_id'])) {
            $_SESSION['subject_id'] = $_GET['subject_id'];
        }
        // Lấy subject_id từ session (hoặc từ GET nếu có)
        $subject_id = isset($_SESSION['subject_id']) ? $_SESSION['subject_id'] : null;
        if ($subject_id) {
            // Truy vấn để lấy thông tin subject_title, tên giảng viên và tổng số bài học
            $sql = "
            SELECT c.subject_title, u.name AS teacher_name, COUNT(l.id) AS total_lessons
            FROM chapters c
            JOIN users u ON c.teacher_id = u.id
            LEFT JOIN lessons l ON l.subject_id = c.id
            WHERE c.id = :subject_id
            GROUP BY c.subject_title, u.name";

            // Chuẩn bị truy vấn
            $stmt = $conn->prepare($sql);
            // Gán giá trị cho tham số
            $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            // Thực thi truy vấn
            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra nếu có kết quả
            if ($result) {
                $subject_title = $result['subject_title'];
                $teacher_name = $result['teacher_name'];
                $total_lessons = $result['total_lessons'];
            } else {
                echo "Không tìm thấy dữ liệu cho subject_id này.";
            }
        } else {
            echo "Không tìm thấy subject_id.";
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
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
            <div class="nav_top_kick">
                <div class="nav_top">
                    <div class="left">
                        <h1>Chào mừng bạn đến với <br> <span><?php echo $subject_title; ?></span></h1>
                    </div>
                    <div class="right">
                        <div class="img_right">
                            <img src="../img/snapedit_1728410569479.png" alt="ảnh ">
                        </div>
                    </div>
                </div>
                <div class="nav_mid" style="    text-align: center;">
                    <hr>
                    <p>Khóa học do <span><?php echo $teacher_name; ?></span> giảng dạy có tổng cộng <?php echo $total_lessons; ?> bài học.</p> <!-- Hiển thị tên giảng viên và tổng số bài học -->
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
                                <a href="#" id="buy-course-btn" style="color:white;">Mua khoá học</a>
                                <!-- Modal hiển thị mã QR -->
                                <div id="qr-modal" class="modal">
                                    <div class="modal-content">
                                        <h2>Mua khoá học</h2>
                                        <p>Vui lòng quét mã QR để thanh toán khoá học.</p>
                                        <!-- Mã QR -->
                                        <img src="../img/6.png" alt="Mã QR" style="width: 100%;">
                                        <!-- Nút xác nhận sau khi thanh toán -->
                                        <button class="confirm-btn" id="confirm-payment" style="
    border-radius: 15px;
    border: none;
    width: 100px;
    height: 30px;
    cursor: pointer;
    background-color: #b3e5fc;
">Xác nhận</button>
                                        <!-- Nút đóng modal -->
                                        <button class="close-btn" id="close-modal" style="
    border-radius: 15px;
    border: none;
    width: 100px;
    height: 30px;
    cursor: pointer;
    background-color: #b3e5fc;
">Đóng</button>
                                    </div>
                                    <script>
                                        // Lấy các phần tử từ HTML
                                        const buyCourseBtn = document.getElementById('buy-course-btn');
                                        const modal = document.getElementById('qr-modal');
                                        const closeModalBtn = document.getElementById('close-modal');
                                        const confirmPaymentBtn = document.getElementById('confirm-payment');

                                        // Khi người dùng nhấn vào "Mua khoá học", hiển thị modal
                                        buyCourseBtn.addEventListener('click', function(event) {
                                            event.preventDefault(); // Ngăn chuyển trang
                                            modal.style.display = 'block';
                                        });

                                        // Khi người dùng nhấn vào nút đóng modal
                                        closeModalBtn.addEventListener('click', function() {
                                            modal.style.display = 'none';
                                        });

                                        // Khi người dùng nhấn vào nút xác nhận sau khi thanh toán
                                        confirmPaymentBtn.addEventListener('click', function() {
                                            // Gửi yêu cầu AJAX để xác nhận thanh toán
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'thanhtoan.php', true);
                                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    // Nếu phản hồi từ PHP thành công, chuyển hướng tới trang xác nhận hoặc thông báo thành công
                                                    alert(xhr.responseText); // Hiển thị phản hồi từ PHP (có thể thay thế bằng giao diện tùy chỉnh)
                                                    window.location.href = 'frame5.php?subject_id=<?php echo $_SESSION["subject_id"]; ?>';
                                                } else {
                                                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                                                }
                                            };
                                            // Gửi subject_id tới PHP để xử lý
                                            xhr.send('subject_id=<?php echo $_SESSION["subject_id"]; ?>');
                                        });

                                        // Khi người dùng nhấn ra ngoài modal, đóng modal
                                        window.addEventListener('click', function(event) {
                                            if (event.target == modal) {
                                                modal.style.display = 'none';
                                            }
                                        });
                                    </script>
                                </div>
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
            <div class="section_top">
                <div class="section_top_kick">
                    <div class="left">
                        <div class="practice">
                            <h1 style="margin: 0;padding: 0;font-size: 40px;">Thực hành dự án cùng Fast Learn</h1>
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
                            <h1 style="margin: 0;padding: 0;font-size: 40px;">Khoá học được thiết kế bởi <br> Fast Learn</h1>
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