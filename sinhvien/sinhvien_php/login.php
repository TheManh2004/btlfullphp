<?php
ob_start();
session_start();
include 'connect.php';  // Giả định file này tạo kết nối PDO $conn

$errors = [];  // Tạo biến $errors để lưu thông báo lỗi

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];  // Lấy giá trị của role từ form

    // Kiểm tra thông tin đăng nhập
    if (empty($email)) {
        $errors['email'] = 'Email không được để trống.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ.';
    }

    if (empty($password)) {
        $errors['password'] = 'Mật khẩu không được để trống.';
    }

    if (empty($role)) {
        $errors['role'] = 'Vui lòng chọn vai trò.';
    }

    if (empty($errors)) {  // Nếu không có lỗi thì mới tiến hành truy vấn
        $stmt = $conn->prepare("SELECT id, name, email, role, password, verification_code, state FROM users WHERE email = :email AND role = :role");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);

        $stmt->execute();
        $query = $stmt->fetch(PDO::FETCH_OBJ);

        if ($query) {  // Kiểm tra nếu truy vấn trả về kết quả
            // Kiểm tra mật khẩu
            if (password_verify($password, $query->password)) {
                // Kiểm tra trạng thái tài khoản
                if ($query->state === 'Inactive') {
                    // Tài khoản chưa kích hoạt, yêu cầu nhập mã xác nhận
                    $name = $query->name;  // Lấy tên người dùng để hiển thị
                    $message = "Tài khoản {$name} cần nhập mã xác nhận để kích hoạt.";  // Tạo thông báo
                    if (isset($_POST['verification_code'])) {
                        $verification_code = $_POST['verification_code'];
                    
                        if (empty($verification_code)) {
                            $errors['verification_code'] = 'Mã xác nhận không được để trống.';
                        } elseif ($query->verification_code === $verification_code) {
                            // Cập nhật trạng thái tài khoản
                            $update_stmt = $conn->prepare("UPDATE users SET state = 'active' WHERE id = :id");
                            $update_stmt->bindParam(':id', $query->id);
                            $update_stmt->execute();
            
                            // Lưu id người dùng vào session
                            $_SESSION['user_id'] = $query->id;  // Thay đổi ở đây
            
                            // Chuyển hướng dựa trên vai trò
                            switch ($query->role) {
                                case 'Admin':
                                    header('Location: qtv/qtv.php');
                                    exit();
                                case 'Teacher':
                                    header('Location: ../index.php');
                                    exit();
                                case 'Student':
                                    header('Location: index.php');
                                    exit();
                                default:
                                    $errors['failed'] = 'Vai trò không hợp lệ.';
                                    header('Location: login.php');
                                    exit();
                            }
                        } else {
                            $errors['failed'] = 'Mã xác nhận không chính xác.';
                        }
                    }
                } else {
                    // Tài khoản đã kích hoạt, không cần mã xác nhận
                    $_SESSION['user_id'] = $query->id;  // Thay đổi ở đây
            
                    // Chuyển hướng dựa trên vai trò
                    switch ($query->role) {
                        case 'Admin':
                            header('Location: qtv/qtv.php');
                            exit();
                        case 'Teacher':
                            header('Location: ../index.php');
                            exit();
                        case 'Student':
                            header('Location: ./index.php');
                            exit();
                        default:
                            $errors['failed'] = 'Vai trò không hợp lệ.';
                            header('Location: login.php');
                            exit();
                    }
                }
            } else {
                $errors['failed'] = 'Mật khẩu không chính xác.';
            }
        } else {
            $errors['failed'] = 'Tài khoản không tồn tại hoặc vai trò không hợp lệ.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/533aad8d01.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }


        .exit {
            float: right;
            font-size: 20px;
        }

        .tabs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .tabs button {
            flex: 1;
            background: none;
            border: none;
            font-size: 16px;
            padding: 10px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }

        .tabs button.btn-login {
            border-bottom: 2px solid #0095FF;
        }

        .btn-register {
            color: #000;
            text-decoration: none
        }

        .login-form form {
            display: flex;
            flex-direction: column;
        }

        .login-form label {
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        .login-form select,
        .login-form input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #0095FF;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .login-button {
            padding: 10px;
            background-color: #0095FF;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #4fb4fc;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }

        .social-login {
            display: flex;
            justify-content: space-between;
        }

        .social-login button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
            color: white;
        }

        .social-login button:last-child {
            margin-right: 0;
        }

        .facebook {
            background-color: #3b5998;
        }

        .facebook:hover {
            background-color: #4d6598;
        }

        .google {
            background-color: #db4437;
        }

        .google:hover {
            background-color: #cb5d53;
        }

        .github {
            background-color: #333;
        }

        .github:hover {
            background-color: #474747;
        }

        .terms {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }

        .terms a {
            color: #0095FF;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .alert-danger {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            font-size: 16px;
            font-family: Arial, sans-serif;
        }

        .alert-danger strong {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div>
                <i class="exit fa-solid fa-xmark"></i>
            </div>
            <div class="tabs">
                <button class="btn-login">Đăng nhập</button>
                <button><a href="register.php" class="btn-register">Đăng ký</a></button>
            </div>
            <div class="login-form">
                <form action="" method="POST" role="form">
                    <label for="role">Vai trò</label>
                    <select id="role" name="role" required>
                        <option value="">-- Chọn vai trò --</option>
                        <option value="Admin">Admin</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Student">Student</option>
                    </select>
                    <?php if (!empty($errors['role'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $errors['role']; ?>
                        </div>
                    <?php endif; ?>

                    <label for="username">Email</label>
                    <input type="email" name="email" placeholder="Nhập email" required>
                    <?php if (!empty($errors['email'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $errors['email']; ?>
                        </div>
                    <?php endif; ?>

                    <label for="password">Nhập mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                    <?php if (!empty($errors['password'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $errors['password']; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($message)): ?>  <!-- Thêm thông báo nếu tài khoản cần mã xác nhận -->
            <div class="alert alert-warning">
                <?php echo $message; ?>  <!-- Hiển thị thông báo -->
            </div>
        <?php endif; ?>

        <?php if (isset($query) && $query->state === 'Inactive'): ?>
            <label for="verification_code">Mã xác nhận</label>
            <input type="text" name="verification_code" placeholder="Nhập mã xác nhận" required>
            <?php if (!empty($errors['verification_code'])): ?>
                <div class="alert alert-danger">
                    <?php echo $errors['verification_code']; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

                    <div class="forgot-password">
                        <a href="forgot_pass.php">Quên mật khẩu?</a>
                    </div>

                    <?php if (!empty($errors['failed'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $errors['failed']; ?>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="login-button">Đăng nhập</button>
                </form>
            </div>

            <div class="divider">
                <span>Hoặc đăng nhập bằng ứng dụng của bên thứ 3</span>
            </div>

            <div class="social-login">
                <button class="facebook">Facebook</button>
                <button class="google">Google</button>
                <button class="github">GitHub</button>
            </div>

            <div class="terms">
                <span>Đăng ký có nghĩa bạn đồng ý với <a href="#">Điều khoản người dùng</a> và <a href="#">Chính sách Quyền riêng tư</a></span>
            </div>
        </div>
    </div>
</body>

</html>