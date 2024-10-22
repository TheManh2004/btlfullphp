<?php
// Xử lý chỉnh sửa thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editProfile'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    // Cập nhật thông tin trong CSDL
    $update_stmt = $conn->prepare("UPDATE users SET name = :name, phone_number = :phone, gender = :gender WHERE id = :id");
    $update_stmt->bindParam(':name', $name);
    $update_stmt->bindParam(':phone', $phone);
    $update_stmt->bindParam(':gender', $gender);
    $update_stmt->bindParam(':id', $user_id);

    if ($update_stmt->execute()) {
        echo "Cập nhật thông tin thành công!";
        // Cập nhật lại session để giữ thông tin mới
        $_SESSION['user_name'] = $name;
        $_SESSION['user_phone'] = $phone;
        $_SESSION['user_gender'] = $gender;
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin.";
    }
}

// Xử lý đổi mật khẩu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changePassword'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu cũ
    if (password_verify($old_password, $user_password)) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Cập nhật mật khẩu trong CSDL
            $change_stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
            $change_stmt->bindParam(':password', $hashed_password);
            $change_stmt->bindParam(':id', $user_id);

            if ($change_stmt->execute()) {
                echo "Đổi mật khẩu thành công!";
            } else {
                echo "Có lỗi xảy ra khi đổi mật khẩu.";
            }
        } else {
            echo "Mật khẩu mới không khớp!";
        }
    } else {
        echo "Mật khẩu cũ không đúng!";
    }
}
?>