use `attandance_system`;

CREATE TABLE academic_year (
	`acedemic_id` INT NOT NULL PRIMARY KEY,
    `academic_descr` VARCHAR(20) 
);

CREATE TABLE department (
	`dept_id` INT NOT NULL PRIMARY KEY,
    `dept_name` VARCHAR(50)
);

CREATE TABLE student_class (
	`s_class_id` INT NOT NULL PRIMARY KEY,
    `s_class_name` VARCHAR(50)
);

CREATE TABLE semester (
	`sem_id` INT NOT NULL PRIMARY KEY,
    `sem_name` VARCHAR(10),
    `s_class_id` INT,
    FOREIGN KEY (s_class_id) REFERENCES student_class(s_class_id)
);

CREATE TABLE division (
	`div_id` INT NOT NULL PRIMARY KEY,
    `div_name` VARCHAR(10)
);

CREATE TABLE batch (
	`batch_id` INT NOT NULL PRIMARY KEY,
    `batch_name` VARCHAR(10)
);

CREATE TABLE roles (
	`role_id` INT NOT NULL PRIMARY KEY,
    `role_description` VARCHAR(20)
);

CREATE TABLE courses (
	`course_id` INT NOT NULL PRIMARY KEY,
    `course_name` VARCHAR(50),
    `dept_id` INT,
    `sem_id` INT,
    FOREIGN KEY (dept_id) REFERENCES department(dept_id),
	FOREIGN KEY (sem_id) REFERENCES semester(sem_id)
);

CREATE TABLE faculty(
	`faculty_id` INT NOT NULL PRIMARY KEY,
    `first_name` VARCHAR(50),
    `last_name` VARCHAR(50),
    `dept_id` INT,
    `role_id` INT,
    `password` VARCHAR(255),
    FOREIGN KEY (dept_id) REFERENCES department(dept_id),
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

CREATE TABLE class (
	`class_id` INT NOT NULL PRIMARY KEY,
    `faculty_id` INT,
    `course_id` INT,
    `div_id` INT,
    `academic_id` INT,
	FOREIGN KEY (faculty_id) REFERENCES faculty(faculty_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
	FOREIGN KEY (div_id) REFERENCES division(div_id),
    FOREIGN KEY (academic_id) REFERENCES academic_year(acedemic_id)
);


CREATE TABLE student (
	`prn_no` INT NOT NULL PRIMARY KEY,
    `first_name` VARCHAR(50),
    `last_name` VARCHAR(50),
    `roll_no` VARCHAR(10),
    `dept_id` INTEGER,
    `year_id` INTEGER,
    `div_id` INTEGER,
    `batch_id` INTEGER,
    FOREIGN KEY (dept_id) REFERENCES department(dept_id)
);

CREATE TABLE attendance_list (
	`attendance_id` INT NOT NULL PRIMARY KEY,
    `class_id` INT,
    `date_time` DATETIME,
    FOREIGN KEY (class_id) REFERENCES class(class_id)
);

CREATE TABLE attendance (
	`attendance_id` INT NOT NULL PRIMARY KEY,
    `student_id` INT,
    `status` INT DEFAULT 0,
    FOREIGN KEY (attendance_id) REFERENCES attendance_list(attendance_id),
    FOREIGN KEY (student_id) REFERENCES student(prn_no)
);

CREATE TABLE practical_class (
	`p_class_id` INT NOT NULL PRIMARY KEY,
    `faculty_id` INT,
    `course_id` INT,
    `div_id` INT,
    `batch_id` INT,
    `academic_id` INT,
	FOREIGN KEY (faculty_id) REFERENCES faculty(faculty_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
	FOREIGN KEY (div_id) REFERENCES division(div_id),
    FOREIGN KEY (batch_id) REFERENCES batch(batch_id),
    FOREIGN KEY (academic_id) REFERENCES academic_year(acedemic_id)
);

CREATE TABLE pract_attend_list (
	`p_attend_id` INT NOT NULL PRIMARY KEY,
    `p_class_id` INT,
    `date_time` DATETIME,
     FOREIGN KEY (p_class_id) REFERENCES practical_class(p_class_id)
);

CREATE TABLE pract_attend (
	`p_attend_id` INT,
    `prn_no` INT,
    `status` INT DEFAULT 0,
    FOREIGN KEY (p_attend_id) REFERENCES pract_attend_list(p_attend_id),
    FOREIGN KEY (prn_no) REFERENCES student(prn_no)
);

INSERT INTO roles (role_id, role_description) VALUES 
(0, 'Admin'),
(1,'HOD'),
(2, 'Staff');

INSERT INTO student_class VALUES 
(1, 'F.Y.B.Tech'),
(2, 'S.Y.B.Tech'),
(3, 'T.Y.B.Tech'),
(4, 'B.Tech');

INSERT INTO 