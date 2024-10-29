<?php
include 'connect.php'; // Đảm bảo kết nối đúng

try {
    // Thực hiện truy vấn
    $stmt = $conn->query("
        SELECT p.content, p.image, p.updated_at, u.name as admin_name
        FROM posts p
        JOIN users u ON p.admin_id = u.id
        ORDER BY p.updated_at DESC
    ");

    $posts = $stmt->fetchAll();

    foreach ($posts as $post) {
        echo '<div class="register-box">';
        echo '    <div class="banner">';
        echo '        <h5># ' . htmlspecialchars($post['content']) . '</h5>';
        echo '    </div>';

        if (!empty($post['image'])) {
            echo '    <img src="data:image/jpeg;base64,' . base64_encode($post['image']) . '" style = "width: 90%;" class="img_learn" alt="Học Offline">';
        } else {
            echo '    <img src="/path/to/default-image.jpg" class="img_learn" alt="Default Image">';
        }

        echo '    <p class="note">';
        echo '        <strong>Lưu ý: </strong>Lớp học offline dành cho những bạn xác định "all in" với nghề. Không dành cho các bạn nghĩ "học offline cho dễ học" nhé. Vì để đáp ứng cho đầu vào doanh nghiệp hiện nay, kiến thức học sẽ thử thách và nâng cao - đòi hỏi bạn phải là người có tính nỗ lực, dám đầu tư thời gian và công sức!';
        echo '    </p>';
        echo '    <p class="Posted">Đăng bởi ';
        echo '        <a href="#" class="name_post">' . htmlspecialchars($post['admin_name']) . '</a>';
        echo '        <span class="dot">·</span>';
        echo '        <time class="time">' . htmlspecialchars($post['updated_at']) . '</time>';
        echo '    </p>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
