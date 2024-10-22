<?php
    session_start();
    include 'connect.php'; // Kết nối cơ sở dữ liệu
    include './mailer.php'; // Gọi file chứa hàm sendVerificationEmail()

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (empty($email)) {
            echo "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Định dạng email không hợp lệ.";
        } else {
            // Tạo mã xác nhận
            $verificationCode = rand(100000, 999999);

            // Gửi mã xác nhận qua email
            if (sendVerificationEmail($email, $verificationCode)) {
                // Lưu mã xác nhận vào cơ sở dữ liệu
                $stmt = $conn->prepare("INSERT INTO user_verification (email, verification_code, created_at) VALUES (:email, :code, NOW())
                                ON DUPLICATE KEY UPDATE verification_code = :code, created_at = NOW()");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':code', $verificationCode);

                if ($stmt->execute()) {
                    echo "Mã xác nhận đã được gửi đến email của bạn.";
                } else {
                    echo "Có lỗi khi lưu mã xác nhận vào cơ sở dữ liệu.";
                }
            } else {
                echo "Có lỗi khi gửi email. Vui lòng thử lại.";
            }
        }
    } else {
        echo "Yêu cầu không hợp lệ.";
    }
?>