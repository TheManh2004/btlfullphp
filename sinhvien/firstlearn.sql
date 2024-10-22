CREATE DATABASE btl;
USE btl;

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) UNIQUE NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) UNIQUE NOT NULL,
  role ENUM ('Student', 'Teacher', 'Admin') DEFAULT 'Student',
  user_info INT,
  state ENUM ('Active', 'Inactive', 'Removed') DEFAULT 'Inactive'
);

CREATE TABLE user_infos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  fullname VARCHAR(511),
  email VARCHAR(255),
  gender ENUM ('Male', 'Female', 'Others'),
  phone_number VARCHAR(20),
  address VARCHAR(255),
);


CREATE TABLE user_verification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    verification_code INT(6) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    fee DECIMAL(10, 2) DEFAULT 0,
    subject_id INT NOT NULL,
    teacher_id INT NOT NULL,
    start_date DATE,
    end_date DATE
);

CREATE TABLE part_of_course (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    create_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE lesson (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    course_id INT NOT NULL,
    part_id INT NOT NULL,
    length VARCHAR(50),
    description TEXT,
    create_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE course_feedbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    student_id INT NOT NULL,
    feedback TEXT,
    rating INT,
    feedback_date DATE
);

CREATE TABLE course_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    question TEXT NOT NULL,
    state ENUM ('Open', 'Closed', 'Hidden') DEFAULT 'Open'
);

CREATE TABLE answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    replier_id INT NOT NULL,
    answer TEXT NOT NULL,
    question_id INT NOT NULL
);

CREATE TABLE course_enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enroll_date DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE course_materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    name VARCHAR(255),
    content TEXT,
    link VARCHAR(511),
	state ENUM ('Creating', 'Hidden', 'Visible') DEFAULT 'Creating'
);


CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  admin_id INT NOT NULL,         
  title VARCHAR(255) NOT NULL,   
  content TEXT NOT NULL,        
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP, 
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

ALTER TABLE users ADD CONSTRAINT fk_user_info FOREIGN KEY (user_info) REFERENCES user_infos (id);


ALTER TABLE courses ADD CONSTRAINT fk_teacher_id FOREIGN KEY (teacher_id) REFERENCES users (id);

ALTER TABLE course_feedbacks ADD CONSTRAINT fk_course_id FOREIGN KEY (course_id) REFERENCES courses (id);

ALTER TABLE course_feedbacks ADD CONSTRAINT fk_student_id FOREIGN KEY (student_id) REFERENCES users (id);

ALTER TABLE course_questions ADD CONSTRAINT fk_question_student_id FOREIGN KEY (student_id) REFERENCES users (id);

ALTER TABLE answers ADD CONSTRAINT fk_replier_id FOREIGN KEY (replier_id) REFERENCES users (id);

ALTER TABLE answers ADD CONSTRAINT fk_question_id FOREIGN KEY (question_id) REFERENCES course_questions (id);

ALTER TABLE course_materials ADD CONSTRAINT fk_course_material_course_id FOREIGN KEY (course_id) REFERENCES courses (id);

ALTER TABLE course_questions ADD FOREIGN KEY (course_id) REFERENCES courses (id);

ALTER TABLE posts ADD CONSTRAINT fk_post_admin_id FOREIGN KEY (admin_id) REFERENCES users (id);

ALTER TABLE notifications ADD CONSTRAINT fk_notification_user_id FOREIGN KEY (user_id) REFERENCES users (id);

ALTER TABLE course_enrollments ADD CONSTRAINT fk_course_enrollments_student_id FOREIGN KEY (student_id) REFERENCES users (id);

ALTER TABLE course_enrollments ADD CONSTRAINT fk_course_enrollments_course_id FOREIGN KEY (course_id) REFERENCES courses (id);

ALTER TABLE carts ADD CONSTRAINT fk_carts_user_id FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE carts ADD CONSTRAINT fk_carts_course_id FOREIGN KEY (course_id) REFERENCES courses(id);