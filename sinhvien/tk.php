<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- File CSS của bạn -->
    <title>Thông Báo</title>
    <style>
        .notification-container {
    width: 300px;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    position: absolute;
    display: none;
    top: 100%;
    right: 0;
    z-index: 1;
}

.notification-container h1 {
    text-align: left;
    font-size: 25px;
    margin-bottom: 20px;
}

.notification {
    display: flex;
    margin-bottom: 15px;
}

.icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.icon.green {
    background-color: #28a745;
}

.icon.red {
    background-color: #dc3545;
}

.content {
    margin-left: 10px;
    flex-grow: 1;
}

.message {
    font-size: 15px;
    margin: 0;
}

.date {
    font-size: 14px;
    color: #777;
    margin: 10px 0px;
}

.view-all {
    display: block;
    text-align: center;
    font-size: 18px;
    color: #0095FF;
    text-decoration: none;
    margin-top: 20px;
}

.view-all:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div id="notification-icon" style="cursor: pointer;">
        <i class="fa-regular fa-bell" style="font-size: 25px;"></i>
    </div>
    <div class="notification-container" id="notification-container" style="display: none;">
        <h1>Thông báo</h1>
        <hr>
        <ul id="notification-list"></ul> <!-- Danh sách thông báo -->
        <a href="#" class="view-all">Tất cả thông báo</a>
    </div>

    <script src="script.js"></script> <!-- File JS của bạn -->
</body>
<script>
    document.getElementById('notification-icon').addEventListener('click', function() {
    var notificationContainer = document.getElementById('notification-container');
    
    // Toggle hiển thị notification
    if (notificationContainer.style.display === 'none' || notificationContainer.style.display === '') {
        notificationContainer.style.display = 'block';  // Hiển thị thông báo
        loadNotifications();  // Gọi hàm để tải thông báo
    } else {
        notificationContainer.style.display = 'none';   // Ẩn thông báo
    }
});

// Hàm để lấy danh sách thông báo từ server
function loadNotifications() {
    fetch('getQuestions.php') // Đường dẫn đến file PHP để lấy thông báo
        .then(response => response.json())
        .then(data => {
            var notificationList = document.getElementById('notification-list');
            notificationList.innerHTML = ''; // Xóa nội dung cũ

            data.forEach(notification => {
                var li = document.createElement('li');
                li.innerHTML = `
                    <div class="notification-title">${notification.title}</div>
                    <div class="notification-content">${notification.message}</div>
                    <div class="notification-time">Ngày: ${notification.date}</div>
                `;
                notificationList.appendChild(li);
            });
        })
        .catch(error => {
            console.error('Error fetching notifications:', error); // In lỗi nếu có vấn đề
        });
}
</script>
</html>
