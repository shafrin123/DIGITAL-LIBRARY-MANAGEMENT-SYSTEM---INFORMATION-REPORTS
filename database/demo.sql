CREATE TABLE login (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    username varchar(50) NOT NULL,
    password varchar(255) NOT NULL,
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    email varchar(255) NOT NULL,
    reset_token varchar(255) DEFAULT NULL,
    reset_token_expiry datetime DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
) ENGINE = InnoDB AUTO_INCREMENT = 10 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci


CREATE TABLE book_issues (
    id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
    access_no varchar(50) NOT NULL COMMENT 'Book Accession Number',
    book_name varchar(255) NOT NULL COMMENT 'Book Name',
    author_name varchar(255) NOT NULL COMMENT 'Book Author',
    receiver enum('student', 'staff') NOT NULL COMMENT 'Receiver Type',
    student_name varchar(255) DEFAULT NULL COMMENT 'Student Name (if applicable)',
    class enum('ug', 'pg') DEFAULT NULL COMMENT 'Class (if applicable)',
    year enum('1st', '2nd', '3rd') DEFAULT NULL COMMENT 'Year (if applicable)',
    student_id varchar(50) DEFAULT NULL COMMENT 'Student ID (if applicable)',
    contact varchar(20) DEFAULT NULL COMMENT 'Student Contact (if applicable)',
    staff_name varchar(255) DEFAULT NULL COMMENT 'Staff Name (if applicable)',
    department varchar(255) DEFAULT NULL COMMENT 'Staff Department (if applicable)',
    issued_date date NOT NULL COMMENT 'Issued Date',
    due_date date NOT NULL COMMENT 'Due Date',
    return_date date DEFAULT NULL COMMENT 'Return Date',
    status enum('issued', 'returned') NOT NULL DEFAULT 'issued' COMMENT 'Book Status',
    fine_amount decimal(10, 5) NOT NULL COMMENT 'Fine amount',
    PRIMARY KEY (id),
    KEY book_issues_ibfk_2 (access_no)
) ENGINE = InnoDB AUTO_INCREMENT = 68 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'Table for tracking book issues'



CREATE TABLE report (
    category varchar(50) NOT NULL,
    count int(11) DEFAULT NULL,
    PRIMARY KEY (category)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci


CREATE TABLE pre_bookings (
    id int(11) NOT NULL AUTO_INCREMENT,
    user_type varchar(50) NOT NULL,
    name varchar(100) NOT NULL,
    class varchar(50) DEFAULT NULL,
    department varchar(50) DEFAULT NULL,
    book_name varchar(100) NOT NULL,
    author_name varchar(100) NOT NULL,
    status enum('pending', 'seen', 'expired') DEFAULT 'pending',
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    expired_at timestamp NOT NULL DEFAULT(
        current_timestamp() + interval 48 hour
    ),
    PRIMARY KEY (id)
) ENGINE = InnoDB AUTO_INCREMENT = 19 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'Table for storing pre-bookings'


CREATE TABLE booksss (
    id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
    create_time datetime DEFAULT current_timestamp() COMMENT 'Create Time',
    access_no varchar(50) NOT NULL COMMENT 'Book Access Number',
    name varchar(255) NOT NULL COMMENT 'Book Name',
    author varchar(255) NOT NULL COMMENT 'Book Author',
    price decimal(10, 2) NOT NULL COMMENT 'Book Price',
    total_quantity int(11) NOT NULL DEFAULT 1 COMMENT 'Total Quantity of Books',
    avail_quantity int(11) NOT NULL DEFAULT 1 COMMENT 'Available Quantity of Books',
    categories varchar(255) DEFAULT NULL COMMENT 'Book Categories',
    PRIMARY KEY (id),
    UNIQUE KEY access_no (access_no)
) ENGINE = InnoDB AUTO_INCREMENT = 135 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'Table for storing book records'


CREATE TABLE user_feedback (
    feedback_id int(11) NOT NULL,
    name varchar(255) DEFAULT NULL,
    email varchar(255) DEFAULT NULL,
    message text DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci

CREATE TABLE stureg (
name varchar(255) NOT NULL,
department varchar(255) NOT NULL,
id int(11) NOT NULL,
phone varchar(10) NOT NULL,
mail varchar(60) NOT NULL,
class enum('ug', 'pg') DEFAULT NULL,
year enum('1st', '2nd', '3rd') DEFAULT NULL,
PRIMARY KEY (id)
)

CREATE TABLE staff (
id int(10) NOT NULL AUTO_INCREMENT,
name varchar(30) NOT NULL,
department varchar(50) NOT NULL,
phone varchar(15) DEFAULT NULL,
email varchar(30) NOT NULL,
PRIMARY KEY (id),
UNIQUE KEY email (email),
UNIQUE KEY phone (phone)
); 

CREATE TABLE Bookss (
    id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Create Time',
    access_no VARCHAR(50) NOT NULL COMMENT 'Book Access Number',
    name VARCHAR(255) NOT NULL COMMENT 'Book Name',
    author VARCHAR(255) NOT NULL COMMENT 'Book Author',
    price DECIMAL(10, 2) NOT NULL COMMENT 'Book Price',
    total_quantity INT(11) NOT NULL DEFAULT 1 COMMENT 'Total Quantity of Books',
    avail_quantity INT(11) NOT NULL DEFAULT 1 COMMENT 'Available Quantity of Books',
    categories VARCHAR(255) DEFAULT NULL COMMENT 'Book Categories',
    book_condition ENUM('New', 'Good', 'Fair', 'Damaged', 'Lost') DEFAULT 'New' COMMENT 'Condition of the Book',
    admin_approval TINYINT(1) DEFAULT 0 COMMENT 'Admin Approval for Damaged/Lost Book',
    PRIMARY KEY (id),
    UNIQUE KEY access_no (access_no)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table for storing book records';

INSERT INTO book_issues (access_no, book_name, author_name, receiver, student_name, class, year, student_id, contact, staff_name, department, issued_date, due_date, return_date, status, fine_amount) VALUES
('A001', 'Data Structures', 'Mark Allen', 'student', 'Alice Brown', 'ug', '2nd', 'UG2021001', '9876543210', NULL, NULL, '2025-05-01', '2025-05-15', NULL, 'issued', 0.00000),
('A002', 'Operating Systems', 'Andrew Tanenbaum', 'staff', NULL, NULL, NULL, NULL, NULL, 'Dr. Sarah Lee', 'Computer Science', '2025-04-25', '2025-05-09', '2025-05-06', 'returned', 0.00000);

INSERT INTO report (category, count) VALUES
('issued', 35),
('returned', 22),
('overdue', 5);

INSERT INTO pre_bookings (user_type, name, class, department, book_name, author_name) VALUES
('student', 'Emily Clark', 'ug', 'Physics', 'Quantum Mechanics', 'Stephen Gasiorowicz'),
('staff', 'Prof. Alan Watts', NULL, 'Philosophy', 'Eastern Thought', 'Alan Watts');

INSERT INTO booksss (access_no, name, author, price, total_quantity, avail_quantity, categories) VALUES
('B001', 'Database Systems', 'Elmasri & Navathe', 45.00, 5, 3, 'Computer Science'),
('B002', 'Introduction to Algorithms', 'Cormen et al.', 60.00, 3, 1, 'Algorithms');

INSERT INTO user_feedback (feedback_id, name, email, message) VALUES
(1, 'Anna Walker', 'anna@example.com', 'Great library system! Easy to use.'),
(2, 'Bob Martin', 'bob@example.com', 'Please add more computer science books.');

INSERT INTO stureg (name, department, id, phone, mail, class, year) VALUES
('Tom Hardy', 'Electrical Engineering', 101, '9123456780', 'tom@example.com', 'ug', '1st'),
('Sara Connor', 'Mechanical Engineering', 102, '9876504321', 'sara@example.com', 'pg', '2nd');

INSERT INTO staff (name, department, phone, email) VALUES
('Dr. Richard Miles', 'Mathematics', '9012345678', 'richard.miles@example.com'),
('Ms. Jenny Blake', 'Library Science', '9023456789', 'jenny.blake@example.com');

INSERT INTO Bookss (access_no, name, author, price, total_quantity, avail_quantity, categories, book_condition, admin_approval)
VALUES
('A001', 'Introduction to Algorithms', 'Thomas H. Cormen', 120.50, 5, 3, 'Computer Science', 'New', 0),
('A002', 'Database System Concepts', 'Abraham Silberschatz', 95.00, 4, 2, 'Database', 'Good', 0),
('A003', 'Artificial Intelligence: A Modern Approach', 'Stuart Russell', 110.00, 2, 1, 'AI', 'Fair', 0),
('A004', 'Clean Code', 'Robert C. Martin', 85.00, 3, 3, 'Software Engineering', 'Damaged', 1),
('A005', 'Operating System Concepts', 'Silberschatz', 105.75, 6, 5, 'Operating Systems', 'Lost', 1),
('A006', 'Computer Networks', 'Andrew S. Tanenbaum', 88.40, 4, 4, 'Networking', 'Good', 0),
('A007', 'Discrete Mathematics and Its Applications', 'Kenneth H. Rosen', 70.00, 3, 3, 'Mathematics', 'New', 0),
('A008', 'Modern Compiler Implementation', 'Andrew Appel', 99.99, 2, 2, 'Compilers', 'Fair', 0),
('A009', 'Software Engineering', 'Ian Sommerville', 90.00, 4, 4, 'Software Engineering', 'Good', 0),
('A010', 'Python Crash Course', 'Eric Matthes', 60.00, 5, 5, 'Programming', 'New', 0);