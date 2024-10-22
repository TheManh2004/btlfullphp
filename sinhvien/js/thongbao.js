
    document.addEventListener('DOMContentLoaded', () => {
        const openFrameButton = document.getElementById('openFrame'); // Nút "Hỏi đáp"
        const closeFrameButton = document.getElementById('closeFrame'); // Nút đóng Frame Hỏi Đáp
        const qaFrame = document.getElementById('qaFrame'); // Frame Hỏi Đáp

        const notificationButton = document.getElementById('notificationButton'); // Biểu tượng thông báo
        const closeNotificationButton = document.getElementById('closeNotification'); // Nút đóng Frame Thông Báo
        const notificationFrame = document.getElementById('notificationFrame'); // Frame Thông Báo

        // Mở Frame Hỏi Đáp khi nhấn nút "Hỏi đáp"
        openFrameButton.addEventListener('click', (e) => {
            e.preventDefault(); // Ngăn hành vi mặc định nếu có
            qaFrame.classList.add('open');
        });

        // Đóng Frame Hỏi Đáp khi nhấn nút đóng
        closeFrameButton.addEventListener('click', () => {
            qaFrame.classList.remove('open');
        });

        // Đóng Frame Hỏi Đáp khi nhấn ngoài frame
        window.addEventListener('click', (event) => {
            if (event.target == qaFrame) {
                qaFrame.classList.remove('open');
            }
        });

        // Mở Frame Thông Báo khi nhấn vào biểu tượng thông báo
        notificationButton.addEventListener('click', (e) => {
            e.preventDefault(); // Ngăn hành vi mặc định của thẻ <a>
            notificationFrame.classList.add('open');
        });

        // Đóng Frame Thông Báo khi nhấn nút đóng
        closeNotificationButton.addEventListener('click', () => {
            notificationFrame.classList.remove('open');
        });

        // Đóng Frame Thông Báo khi nhấn ngoài frame
        window.addEventListener('click', (event) => {
            if (event.target == notificationFrame) {
                notificationFrame.classList.remove('open');
            }
        });

        // Xử lý gửi bình luận trong Frame Hỏi Đáp
        const sendBtn = document.getElementById('sendBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const textarea = document.querySelector('.comment-input textarea');
        const commentCountElement = document.querySelector('.comment-section p strong');

        sendBtn.addEventListener('click', () => {
            const commentText = textarea.value.trim();
            if (commentText) {
                // Tạo phần tử bình luận mới
                const comment = document.createElement('div');
                comment.classList.add('comment');
                comment.innerHTML = `
                    <img src="../img/person.png" alt="User Icon">
                    <div class="comment-content">
                        <div class="comment-header">Bạn <span class="comment-time">Vừa xong</span></div>
                        <div class="comment-text">${commentText}</div>
                        <div class="comment-actions">
                            <a href="#">Thích</a>
                            <a href="#">Phản hồi</a>
                        </div>
                    </div>
                `;
                // Thêm bình luận vào phần bình luận
                const comments = document.querySelectorAll('.comment-section .comment');
                const lastComment = comments[comments.length - 1];
                lastComment.parentNode.insertBefore(comment, lastComment.nextSibling);
                
                // Cập nhật số bình luận
                let count = parseInt(commentCountElement.textContent);
                count += 1;
                commentCountElement.textContent = `${count} bình luận`;

                // Reset textarea
                textarea.value = '';
            }
        });

        // Xử lý hủy bình luận
        cancelBtn.addEventListener('click', () => {
            textarea.value = '';
        });
    });
