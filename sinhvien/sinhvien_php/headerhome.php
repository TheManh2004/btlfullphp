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

        <div class="navbar" style="background-color: #E6E6E6;">
            <div class="logo">
                <a href="../sinhvien_php/home.php" style="padding:0;">
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
                        <a href="../sinhvien_php/home.php">Trang chủ</a>
                    </li>
                    <li class="menu-item">
                    <a href=/giangvien/account/login.php>Ngành học</a>
                        
                        <ul class="submenu">
                            <li><a href=/giangvien/account/login.php>Khóa học ngoại ngữ</a></li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
            <div class="user-profile" style="width: 200px; display: flex; align-items: center; justify-content: space-evenly;">
                <a href="/giangvien/account/login.php"><button style="background-color: #0095FF;
                                                                        border-radius: 15px;
                                                                        height: 40px;
                                                                        color: white;
                                                                        width: 100px;
                                                                        border: none;
                                                                        cursor: pointer;">Bắt đầu</button></a>




                <script src="../js/tk.js"></script>
            </div>
    </header>

</body>

</html>