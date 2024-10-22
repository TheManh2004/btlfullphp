let currentIndex = 0; // Khởi tạo chỉ số slide hiện tại
const boxLefts = document.getElementsByClassName("box_left"); // Lấy tất cả các phần tử box_left
const sectionTops = document.getElementsByClassName("section_box_top"); // Lấy tất cả các phần tử section_box_top

// Hàm hiển thị box_left và section_box_top hiện tại
function showSlide(index) {
    // Ẩn tất cả các phần tử box_left
    for (let i = 0; i < boxLefts.length; i++) {
        boxLefts[i].style.display = "none";
    }

    // Ẩn tất cả các phần tử section_box_top
    for (let i = 0; i < sectionTops.length; i++) {
        sectionTops[i].style.display = "none";
    }

    // Xử lý việc lặp lại chỉ số
    if (index >= boxLefts.length || index >= sectionTops.length) {
        currentIndex = 0; // Nếu chỉ số vượt quá, quay lại slide đầu tiên
    }
    if (index < 0) {
        currentIndex = boxLefts.length - 1; // Nếu nhỏ hơn 0, quay lại slide cuối cùng
    }

    // Hiển thị box_left và section_box_top hiện tại
    boxLefts[currentIndex].style.display = "flex";
    sectionTops[currentIndex].style.display = "block";
}

// Hàm khi nhấn nút "Next"
function nextSlide() {
    currentIndex++; // Chuyển tới slide tiếp theo
    showSlide(currentIndex); // Hiển thị slide mới
}

// Hàm khi nhấn nút "Back"
function prevSlide() {
    currentIndex--; // Quay lại slide trước
    showSlide(currentIndex); // Hiển thị slide mới
}

// Gắn sự kiện cho các nút "Next" và "Back"
document.getElementById("next").addEventListener("click", nextSlide);
document.getElementById("prev").addEventListener("click", prevSlide);

// Hiển thị slide đầu tiên khi tải trang
showSlide(currentIndex);