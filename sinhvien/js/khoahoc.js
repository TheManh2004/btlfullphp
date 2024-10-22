   // Lấy tất cả các dot và section box
   const dots = document.querySelectorAll('.dot');
   const sections = document.querySelectorAll('.section_box');
   
   // Hàm để cập nhật trạng thái hiển thị cho các phần và dots
   function updateDisplay(boxNumber) {
       // Ẩn tất cả các sections
       sections.forEach((section, index) => {
           if (index + 1 == boxNumber) {
               section.classList.remove('hidder'); // Hiện phần được chọn
           } else {
               section.classList.add('hidder'); // Ẩn các phần khác
           }
       });
   
       // Cập nhật trạng thái của các dots
       dots.forEach(dot => {
           dot.classList.remove('active');
       });
       document.querySelector(`.dot[data-box="${boxNumber}"]`).classList.add('active');
   
       // Cập nhật trạng thái của các tabs
       tabs.forEach(tab => {
           tab.classList.remove('active'); // Bỏ lớp active ở các tab khác
       });
       document.querySelector(`.tabs a[data-box="${boxNumber}"]`).classList.add('active'); // Thêm lớp active cho tab được chọn
   }
   
   // Thêm sự kiện click cho tất cả các dot
   dots.forEach(dot => {
       dot.addEventListener('click', function() {
           // Lấy số hiệu của box từ thuộc tính data-box
           const boxNumber = dot.getAttribute('data-box');
           // Cập nhật hiển thị cho các phần tương ứng
           updateDisplay(boxNumber);
       });
   });
   
   // Lấy tất cả các tab
   const tabs = document.querySelectorAll('.tabs a');
   
   // Thiết lập sự kiện cho mỗi tab
   tabs.forEach(tab => {
       tab.addEventListener('click', function(e) {
           e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ a
   
           // Lấy giá trị data-box của tab đang nhấp
           const boxToShow = this.getAttribute('data-box');
   
           // Cập nhật hiển thị cho các phần tương ứng
           updateDisplay(boxToShow);
       });
   });