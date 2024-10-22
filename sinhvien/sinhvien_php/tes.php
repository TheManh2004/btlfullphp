<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../sp_SinhVien/style-tk.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/533aad8d01.js" crossorigin="anonymous"></script> 
    <title>Thông tin người dùng</title>
</head>
<body>
<?php
include('laydulieu.php');
include('updeat_doipass.php');
?>
<?php include('header.php')?>
    <div class="container">
        <div class="left">
            <img src="../img/logo.png" alt="Ảnh đại diện">
            <h3>Thông tin tài khoản</h3>
        </div>
        <div class="right">
            <div class="tren">
                <div class="text1">Thông tin đăng nhập</div>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Họ Tên:</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user_name); ?>" placeholder="Họ Tên" required>
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại:</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user_phone); ?>" placeholder="Số điện thoại" required>
                    </div>

                    <div class="form-group">
                        <label>Giới Tính:</label>
                        <input type="text" name="gender" value="<?php echo htmlspecialchars($user_gender); ?>" placeholder="Giới tính" required>
                    </div>

                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" name="email" value="<?php echo htmlspecialchars($user_email); ?>" placeholder="Email" readonly>
                    </div>

                    <button class="btn" name="editProfile" type="submit">Chỉnh sửa</button>
                </form>
            </div>

            <div class="duoi" style="margin-top: 10%;">
                <div class="text2">Đổi mật khẩu</div>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Nhập mật khẩu cũ</label>
                        <input type="password" name="old_password" placeholder="Mật khẩu cũ" required>
                    </div>

                    <div class="form-group">
                        <label>Nhập mật khẩu mới</label>
                        <input type="password" name="new_password" placeholder="Mật khẩu mới" required>
                    </div>

                    <div class="form-group">
                        <label>Nhập lại mật khẩu mới</label>
                        <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
                    </div>

                    <button class="btn2" name="changePassword" type="submit">Lưu</button>
                </form>
            </div>
        </div>
        <div class="btn-exit">
            <a href="../sinhvien_php/index.php"><i class="fa-solid fa-xmark"></i></a>
        </div>
    </div>
    <?php include('footer.php')?>
</body>
</html>
