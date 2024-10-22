<?php
ob_start();
session_start();
include 'connect.php';

$errors = [];

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Kiểm tra token có hợp lệ không
    $stmt = $conn->prepare("SELECT id, email FROM users WHERE reset_token = :token AND token_expiry > NOW()");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);

    if ($user) {
        if (isset($_POST['submit'])) {
            $new_password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Kiểm tra mật khẩu nhập vào
            if (empty($new_password)) {
                $errors['password'] = 'Vui lòng nhập mật khẩu mới.';
            } elseif ($new_password !== $confirm_password) {
                $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp.';
            }

            if (empty($errors)) {
                // Hash mật khẩu và cập nhật trong cơ sở dữ liệu
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = :password, reset_token = NULL, token_expiry = NULL WHERE id = :id");
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':id', $user->id);
                $stmt->execute();

                $_SESSION['message'] = 'Mật khẩu của bạn đã được cập nhật.';
                header('Location: login.php');
                exit();
            }
        }
    } else {
        $_SESSION['message'] = 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.';
        header('Location: login.php');
        exit();
    }
} else {
    // header('Location: login.php');
    // exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/533aad8d01.js" crossorigin="anonymous"></script>
    <title>Đặt lại mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            box-sizing: border-box;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-container label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            width: 100%;
            text-align: left;
        }

        .login-container input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            font-size: 14px;
            box-sizing: border-box;
        }

        .login-container button {
            padding: 12px 20px;
            background-color: #0095FF;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #007ACC;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            text-align: left;
        }

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
        .icon{
            float: right;
        }
        .icon_exit{
            font-size: 20px;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="icon">
            <a href="login.php" class="icon_exit"><i class="exit fa-solid fa-xmark"></i></a>
        </div>
        <h2>Đặt lại mật khẩu</h2>
        <form action="" method="POST">
            <label for="password">Mật khẩu mới:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <?php if (!empty($errors['password'])): ?>
                <div class="alert alert-danger">
                    <?php echo $errors['password']; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors['confirm_password'])): ?>
                <div class="alert alert-danger">
                    <?php echo $errors['confirm_password']; ?>
                </div>
            <?php endif; ?>

            <button type="submit" name="submit">Cập nhật mật khẩu</button>
        </form>
    </div>
</body>
</html>
