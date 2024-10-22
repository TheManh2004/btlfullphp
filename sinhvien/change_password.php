<?php
session_start();
include '../dbmysqli.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Initialize error messages
$errorMessage = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Verify if new passwords match
    if ($newPassword !== $confirmPassword) {
        $errorMessage = "Mật khẩu mới không khớp.";
    } elseif ($oldPassword === $newPassword) {
        $errorMessage = "Mật khẩu mới không được trùng với mật khẩu cũ.";
    } else {
        // Verify old password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!password_verify($oldPassword, $user['password'])) {
            $errorMessage = "Mật khẩu cũ không đúng.";
        } else {
            // Update password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashedNewPassword, $user_id);
            $stmt->execute();
            $stmt->close();

            // Redirect to login page after successful password change
            header('Location: login.php?message=Đổi mật khẩu thành công! Hãy đăng nhập lại.');
            exit;
        }
    }
}

// Store the error message in session to display it in account.php
$_SESSION['error_message'] = $errorMessage;

// Redirect back to account.php
header('Location: account.php');
exit;
?>