<?php include ("tes2.php")?>
<div class="all-courses__list">
                    <!-- Hiển thị các khóa học -->
                    <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $row): ?>
                    <div class="all-courses__item">
                        <!-- Hình ảnh của khóa học -->
                        <?php if ($row && !empty($row['course_image'])): ?>
                        <?php 
                        $imagePath = './admin/' . htmlspecialchars($row['course_image']); 
                        if (file_exists($imagePath)): // Kiểm tra tồn tại của tệp hình ảnh
                        ?>
                        <img src="<?php echo $imagePath; ?>" alt="Course Image">
                        <?php else: ?>
                        <p>Hình ảnh không tồn tại.</p>
                        <?php endif; ?>
                        <?php else: ?>
                        <p>Không có hình ảnh nào.</p>
                        <?php endif; ?>


                        <!-- Tên khóa học -->
                        <h2><?php echo htmlspecialchars($row['course_name']); ?></h2>

                        <!-- Tên giảng viên -->
                        <p><?php echo htmlspecialchars($row['instructor_name']); ?></p>

                        <!-- Giá khóa học -->
                        <span
                            class="all-courses__price"><?php echo number_format(floatval($row['course_fee']), 0, ',', '.') . 'đ'; ?></span>


                        <div class="all-courses__bottom">
                            <div class="all-courses__numbers">
                                <ul>
                                    <!-- Số học viên đã đăng ký khóa học -->
                                    <li class="all-courses__number">
                                        <i class="fa-solid fa-users"></i>
                                        <span><?php echo $row['enrolled_students']; ?></span>
                                    </li>

                                    <!-- Số chương học của khóa học -->
                                    <li class="all-courses__number">
                                        <i class="fa-regular fa-newspaper"></i>
                                        <span><?php echo $row['total_chapters']; ?></span>
                                    </li>

                                    <!-- Tổng thời gian khóa học -->
                                    <li class="all-courses__number">
                                        <i class="fa-regular fa-clock"></i>
                                        <span><?php echo $row['total_hours'] . ' giờ ' . $row['total_minutes'] . ' phút'; ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>No courses available.</p>
                    <?php endif; ?>
                </div>