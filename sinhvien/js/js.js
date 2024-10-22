
let slidebox = 0;
showbox();

function showbox() {
let i;
const slides = document.getElementsByClassName("section_box");

for (i = 0; i < slides.length; i++) {
slides[i].style.display = "none";
}

slidebox++;
if (slidebox > slides.length) {
slidebox = 1;
}

slides[slidebox - 1].style.display = "block";
setTimeout(showbox, 3000); // Thay đổi ảnh mỗi 2 giây (có thể điều chỉnh thời gian tại đây)
};