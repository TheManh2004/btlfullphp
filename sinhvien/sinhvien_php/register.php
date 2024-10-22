<?php
session_start();
include 'connect.php'; // Kết nối cơ sở dữ liệu
include './mailer.php'; // Gọi file chứa hàm sendVerificationEmail()

$error = '';
$verificationCode = ''; // Biến lưu mã xác nhận

if (isset($_POST['register'])) {

    $username = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'Student'; // Mặc định là Student

    // Kiểm tra thông tin cơ bản
    if (empty($username)) {
        $error = "Vui lòng nhập tên tài khoản.";
    } elseif (empty($email)) {
        $error = "Vui lòng nhập email.";
    } elseif (empty($password)) {
        $error = "Vui lòng nhập mật khẩu.";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error = "Mật khẩu phải có ít nhất 8 ký tự, chứa cả chữ hoa, chữ thường và số.";
    } else {

        try {
            // Kiểm tra tên tài khoản hoặc email đã tồn tại chưa
            $sql_check = "SELECT * FROM users WHERE name = :username OR email = :email";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->execute([
                'username' => $username, 
                'email' => $email
            ]);
            $result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($result_check) {
                $error = "Tên tài khoản hoặc email đã được sử dụng.";
            } else {
                // Tạo mã xác nhận
                $verificationCode = rand(100000, 999999);

                // Hash mật khẩu và thêm người dùng mới
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Chèn người dùng mới vào cơ sở dữ liệu với trạng thái Inactive
                $sql = "INSERT INTO users (name, password, email, role, state, verification_code) 
                        VALUES (:username, :password, :email, :role, 'Inactive', :verification_code)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':verification_code', $verificationCode);

                if ($stmt->execute()) {
                    // Gửi mã xác nhận qua email
                    sendVerificationEmail($email, $verificationCode);
                    // Thiết lập session sau khi người dùng đăng ký thành công
                    $_SESSION['user_id'] = $conn->lastInsertId(); // Lưu ID của người dùng mới
                    header("Location: login.php"); // Chuyển hướng đến trang chính sau khi đăng nhập thành công
                    exit();;
                } else {
                    $error = "Lỗi khi đăng ký: " . implode(", ", $stmt->errorInfo());
                }
            }
        } catch (PDOException $e) {
            $error = "Lỗi khi kết nối cơ sở dữ liệu: " . $e->getMessage();
        }
        
        $conn = null;
    }
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng Ký</title>
    <script src="https://kit.fontawesome.com/533aad8d01.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            width: 400px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        .tabs button.register {
            border-bottom: 2px solid #0095FF;
        }

        .btn-login {
            color: #000;
            text-decoration: none
        }

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
        }

        input,
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .phone-input {
            display: flex;
            gap: 10px;
        }

        input#email {
            flex-grow: 1;
        }

        .verify-btn {
            background-color: #0095FF;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
        }

        .verify-btn:hover {
            background-color: #4fb4fc;
        }

        .password-note {
            font-size: 12px;
            color: #555;
        }

        .register-button {
            padding: 10px 20px;
            background-color: #0095FF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .register-button:hover {
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

        .password-field {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .password-field input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .eye-icon {
            position: absolute;
            right: 10px;
            cursor: pointer;
            z-index: 1;
        }
        .eye-icon i {
            font-size: 20px;
            color: #666;
        }
        .password-field input:focus {
            border-color: #5cb85c;
            outline: none;
        }
        .password-field input:focus + .eye-icon i {
            color: #5cb85c;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-box">
            <div>
                <i class="exit fa-solid fa-xmark"></i>
            </div>
            <div class="tabs">
                <button><a class="btn-login" href="login.php">Đăng nhập</a></button>
                <button class="register">Đăng ký</button>
            </div>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form class="register-form" method="POST" action="register.php" role="form" id="register-form">
                <label for="username">Họ tên</label>
                <input type="text" id="username" name="name" placeholder="Họ tên" required>

                <label for="email">Nhập email</label>
                <input type="email" id="email" name="email" placeholder="Nhập email" required>

                <label for="password">Nhập mật khẩu</label>
                <div class="password-field">
                        <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                        <span class="eye-icon" id="toggle-password">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                </div>

                <p class="password-note">Mật khẩu phải gồm 6-20 ký tự và có ít nhất 1 ký tự đặc biệt</p>
                <button type="submit" class="register-button" name="register">Đăng ký</button>
            </form>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var registerForm = document.getElementById('register-form');

            registerForm.addEventListener('submit', function(event) {
                var username = document.getElementById('username').value;
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
                var errorMessage = '';

                // Kiểm tra xem các trường có trống không
                if (!username) {
                    errorMessage += 'Vui lòng nhập tên tài khoản.\n';
                }
                if (!email) {
                    errorMessage += 'Vui lòng nhập email.\n';
                }
                if (!password) {
                    errorMessage += 'Vui lòng nhập mật khẩu.\n';
                }

                // Nếu có lỗi, hiển thị thông báo và ngăn không cho gửi form
                if (errorMessage) {
                    alert(errorMessage);
                    event.preventDefault(); // Ngăn không cho gửi form
                }
            });
        });


        // Chức năng ẩn/hiện mật khẩu
        const togglePassword = document.getElementById('toggle-password');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            this.innerHTML = type === 'password' ? '<i class="fa-solid fa-eye"></i>' : '<i class="fa-regular fa-eye-slash"></i>';
        });

    </script>
</body>

</html>