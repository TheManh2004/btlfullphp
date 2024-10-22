<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Đảm bảo rằng bạn đã cài đặt PHPMailer qua Composer

function sendVerificationEmail($email, $code) {
    $mail = new PHPMailer(true);
    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Sử dụng SMTP của Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'ntanh12062004@gmail.com'; // Địa chỉ email của bạn
        $mail->Password = 'gjrj hmop ygpu gbqx'; // Mật khẩu ứng dụng hoặc mật khẩu email của bạn
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Thông tin người gửi và người nhận
        $mail->setFrom('ntanh12062004@gmail.com', 'Fast Learn'); // Người gửi
        $mail->addAddress($email); // Người nhận (email người dùng)

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
        $mail->Body = "Your verification code is: <b>$code</b>";

        // Gửi email
        $mail->send();
        echo 'Verification email has been sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>