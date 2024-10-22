<?php
session_start();
include 'connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php'); // Redirect to login if not logged in
    exit;
}

// Fetch user data from database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Retrieve error message from session, if any
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Clear the error message after displaying it
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://kit.fontawesome.com/ef5ee47b32.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="account-content">
        <div class="header">
            <img style="width: 100px; height: 100px;" src="../image/logo.png" alt="logo">
            <h2>Tài Khoản</h2>
        </div>

        <!-- Display error message if available -->
        <?php if ($errorMessage): ?>
            <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <form method="POST" action="profile_edit.php">
            <div id="personalInfo" class="info-box">
                <div class="info-item">
                    <span id="phoneDisplay">Số điện thoại: <?= htmlspecialchars($user['phone_number'] ?? 'Chưa có') ?></span>
                    <i class="fa fa-arrow-right edit-icon" onclick="toggleEdit('phone')"></i>
                    <i class="fa fa-times cancel-icon" onclick="cancelEdit('phone')" style="display:none;"></i> <!-- Biểu tượng hủy -->
                </div>
                <input type="text" id="phoneInput" name="phone_number" placeholder="Nhập số điện thoại mới" style="display:none;" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>">
                <button class="save-btn" id="savePhoneBtn" type="submit" name="savePhoneBtn" style="display:none;">Lưu</button>

                <div class="info-item">
                    <span id="gmailDisplay">Gmail: <?= htmlspecialchars($user['email']) ?></span>
                    <i class="fa fa-arrow-right edit-icon" onclick="toggleEdit('gmail')"></i>
                    <i class="fa fa-times cancel-icon" onclick="cancelEdit('gmail')" style="display:none;"></i> <!-- Biểu tượng hủy -->
                </div>
                <input type="email" id="gmailInput" name="gmail" placeholder="Nhập Gmail mới" style="display:none;">
                <button class="save-btn" id="saveGmailBtn" type="submit" name="saveGmailBtn" style="display:none;">Lưu</button>

                <div class="info-item">
                    <span id="genderDisplay">Giới tính: <?= htmlspecialchars($user['gender']) ?></span>
                    <i class="fa fa-arrow-right edit-icon" onclick="toggleEdit('gender')"></i>
                    <i class="fa fa-times cancel-icon" onclick="cancelEdit('gender')" style="display:none;"></i> <!-- Biểu tượng hủy -->
                </div>
                <input type="text" id="genderInput" name="gender" placeholder="Nhập giới tính mới" style="display:none;">
                <button class="save-btn" id="saveGenderBtn" type="submit" name="saveGenderBtn" style="display:none;">Lưu</button>
            </div>
        </form>

        <form method="POST" action="change_password.php">
            <div id="passwordChange" class="info-box">
                <h3>Đổi mật khẩu</h3>
                <label for="oldPassword">Mật khẩu cũ</label>
                <input type="password" id="oldPassword" name="oldPassword" placeholder="Nhập mật khẩu cũ" required>

                <label for="newPassword">Mật khẩu mới</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="Nhập mật khẩu mới" required>

                <label for="confirmPassword">Xác nhận mật khẩu mới</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Nhập lại mật khẩu mới" required>

                <button id="confirmPasswordChange" type="submit" name="changePasswordBtn">Đổi mật khẩu</button>
            </div>
        </form>
            <div class="buttonlog">
        <form method="POST" action="logout.php">
            <button class="logout" id="logoutBtn" type="submit" name="logoutBtn">Đăng xuất</button>
            
        </form>
        <form method="POST" action="logouttrangchu.php">
        <button class="logouttrangchu" id="logoutBtntrangchu" type="submit" name="logoutBtntrangchu">Trang chủ</button>
            
        </form>
        </div>
        
    </div>

    <script src="./js/script.js"></script>
</body>

</html>