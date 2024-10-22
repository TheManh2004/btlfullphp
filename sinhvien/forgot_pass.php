<?php
ob_start();
session_start();
include 'connect.php';  // Kết nối cơ sở dữ liệu

$errors = [];  // Biến chứa lỗi

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Kiểm tra nếu email không được nhập
    if (empty($email)) {
        $errors['email'] = 'Vui lòng nhập email.';
    } else {
        // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
        $stmt = $conn->prepare("SELECT id, email FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) {
            // Tạo token cho liên kết đặt lại mật khẩu
            $token = bin2hex(random_bytes(50));
            $stmt = $conn->prepare("UPDATE users SET reset_token = :token, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Gửi email chứa liên kết đặt lại mật khẩu
            $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";
            $subject = "Khôi phục mật khẩu";
            $message = "Nhấp vào liên kết sau để đặt lại mật khẩu của bạn: $resetLink";
            $headers = "From: ntanh12062004@gmail.com";

            if (mail($email, $subject, $message, $headers)) {
                $_SESSION['message'] = 'Liên kết đặt lại mật khẩu đã được gửi đến email của bạn.';
                header('Location: login.php');
                exit();
            } else {
                $errors['email'] = 'Đã xảy ra lỗi khi gửi email. Vui lòng thử lại.';
            }
        } else {
            $errors['email'] = 'Email không tồn tại.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
</head>
<body>
    <div class="login-container">
        <h2>Khôi phục mật khẩu</h2>
        <form action="" method="POST">
            <label for="email">Nhập email của bạn:</label>
            <input type="email" id="email" name="email" required>

            <?php if (!empty($errors['email'])): ?>
                <div class="alert alert-danger">
                    <?php echo $errors['email']; ?>
                </div>
            <?php endif; ?>

            <button type="submit" name="submit">Gửi yêu cầu</button>
        </form>
    </div>
</body>
</html>
