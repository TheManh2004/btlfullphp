 // Đảm bảo rằng mã JavaScript chỉ chạy sau khi tài liệu đã được tải hoàn toàn
 document.addEventListener('DOMContentLoaded', () => {
    const openButton = document.getElementById('openFrame'); // Nút mở khung hỏi đáp
    const closeButton = document.getElementById('closeFrame'); // Nút đóng khung hỏi đáp
    const qaFrame = document.getElementById('qaFrame'); // Khung hỏi đáp

    // Mở khung hỏi đáp khi nhấn nút
    openButton.addEventListener('click', () => {
        qaFrame.classList.add('open'); // Thêm lớp 'open' để hiển thị khung
    });

    // Đóng khung hỏi đáp khi nhấn nút đóng
    closeButton.addEventListener('click', () => {
        qaFrame.classList.remove('open'); // Xóa lớp 'open' để ẩn khung
    });

    // Đóng khung hỏi đáp khi nhấn ngoài khung
    window.addEventListener('click', (event) => {
        if (event.target === qaFrame) {
            qaFrame.classList.remove('open'); // Xóa lớp 'open' để ẩn khung
        }
    });

    // Sử dụng jQuery để xử lý sự kiện gửi form
    $(document).ready(function() {
        // Khi gửi form
        $('#questionForm').on('submit', function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của form

            // Lấy câu hỏi và loại bỏ khoảng trắng ở đầu và cuối
            const question = $('textarea[name="question"]').val().trim(); 

            // Kiểm tra xem người dùng có nhập câu hỏi không
            if (!question) {
                alert("Vui lòng nhập câu hỏi của bạn."); // Thông báo nếu không có câu hỏi
                return; // Ngăn không cho gửi form
            }

            // Lấy dữ liệu từ form
            const formData = $(this).serialize(); 

            // Thực hiện AJAX gửi dữ liệu
            $.ajax({
                type: 'POST', // Phương thức gửi là POST
                url: 'submit_question.php', // URL xử lý
                data: formData, // Dữ liệu gửi
                success: function(response) {
                    alert("Câu hỏi của bạn đã được gửi thành công!"); // Thông báo khi gửi thành công
                    $('#questionForm')[0].reset(); // Đặt lại form
                    qaFrame.classList.remove('open'); // Đóng khung hỏi đáp sau khi gửi
                },
                error: function() {
                    alert("Có lỗi xảy ra. Vui lòng thử lại."); // Thông báo khi có lỗi
                }
            });
        });
    });
});