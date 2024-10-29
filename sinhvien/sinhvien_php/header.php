
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../sp_SinhVien/header.css">
    <link rel="stylesheet" href="../sp_SinhVien/taiKhoan.css">
    <link rel="stylesheet" href="../sp_SinhVien/chuong.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>

<header>
<?php
    // Đặt session_start() ở đầu tệp
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    include 'connect.php';
   $timeout_duration = 300; 

   if (isset($_SESSION['last_activity'])) {
       $time_inactive = time() - $_SESSION['last_activity'];
       if ($time_inactive > $timeout_duration) {
           session_unset();
           session_destroy();
           header('Location: /giangvien/account/login.php');
           exit;
       }
   }
   
   $_SESSION['last_activity'] = time();
   ?>
    <?php include('laydulieu.php')?>

            <div class="navbar">
                <div class="logo">
                    <a href="../sinhvien_php/index.php" style = "padding:0;">
                        <img src="../img/logo.png" alt="Fast Learn Logo">
                    </a>
                </div>
                <div class="search-container">
                    <input type="text" placeholder="What do you want to learn?">
                    <div class="separator"></div>
                    <button class="search-button">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    </button>
                </div>
                <!-- Phần menu chính -->
                <div class="header-content">
                    <ul class="menu">
                        <li class="menu-item">
                            <a href="../sinhvien_php/khoahoc_full.php">Khóa học</a>
                            <ul class="submenu">
                                <li><a href="../sinhvien_php/khoahoc_fr.php">Khóa học miễn phí</a></li>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a href="../sinhvien_php/khoahoccuatoi.php">Khóa học của tôi</a>
                        </li>
                    </ul>
                </div>
                <div class="user-profile" style="width: 200px; display: flex; align-items: center; justify-content: space-evenly;">
                <div class="clicknotification">
                        <div class="notification" id="notification" style="cursor: pointer;">
                            <i class="fa fa-envelope"></i>
                            <span class="badge">1</span>
                        </div>
                        <div class="question-list" id="questionList">
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                    </div>

                        <!-- /**js cảu form thông báo **/ -->
                             <script>
                                        // Khi nhấn vào notification, hiển thị/ẩn danh sách câu hỏi
                                        document.getElementById('notification').addEventListener('click', function () {
                                            var questionList = document.getElementById('questionList');
                                            if (questionList.style.display === 'block') {
                                                questionList.style.display = 'none';
                                            } else {
                                                questionList.style.display = 'block';
                                            }
                                        });
                                       // Hàm để lấy danh sách câu hỏi từ server (bạn cần kết nối với PHP ở đây)
                                       function loadQuestions() {
    fetch('getQuestions.php') // Gọi đến file PHP vừa tạo
        .then(response => response.json())
        .then(data => {
            var questionList = document.querySelector('.question-list ul');
            questionList.innerHTML = ''; // Xóa nội dung cũ

            data.forEach(question => {
                var li = document.createElement('li');
                li.innerHTML = `
                    <a style="text-decoration: none;">
                        <div class="question-title">${question.replier_name} trả lời:</div>
                        <div class="question-content">${question.answer_message}</div>
                        
                        <div class="question-time">Hỏi lúc: ${question.answer_created_at}</div>
                    </a>
                `;
                questionList.appendChild(li);
            });
        });
}

                                    // Gọi hàm loadQuestions khi trang được tải
                                    document.addEventListener('DOMContentLoaded', loadQuestions);
                            </script>
                        <!-- /****/ -->


                    <div id="profile-button" class="header-profile" style="cursor: pointer;">
                         <!-- Đây là nơi bạn click vào để mở profile -->
                        <i class="fa-solid fa-user"></i>
                        <div id="profile-container" class="profile-container" style="display: none;">
                            <div class="profile-header">
                                <div class="profile-image"></div>
                               
                                <div class="profile-info">
                                        <h2> <?php echo  htmlspecialchars($user_name) ?></h2>
                                        <p>  <?php echo  htmlspecialchars($user_email) ?></p>
                                </div>
                            </div>
                            <ul class="profile-menu">
                                <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Giỏ hàng</a></li>
                                <li><a href="#"><i class="fa-solid fa-bookmark"></i> Bài viết đã lưu</a></li>
                                <li><a href="#"><i class="fa-solid fa-wallet"></i> Lịch sử giao dịch</a></li>
                                <li><a href="tes.php"><i class="fa-solid fa-gear"></i> Cài đặt</a></li>
                                <li onclick="logout()"><a href="#"><i class="fa-solid fa-power-off"></i> Đăng xuất</a></li>
                            </ul>
                            <script src="../js/logout.js"></script>
                        </div>
                    </div>
                <script src="../js/tk.js"></script>
            </div>
    </header>
   
</body>
</html>