create database libro_db

-- USERS TABLE
CREATE TABLE users (
    id VARCHAR(8) PRIMARY KEY, -- e.g., 20250001
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    type ENUM('librarian', 'borrower') NOT NULL,
    region VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    barangay VARCHAR(100) NOT NULL
);

-- BOOKS TABLE
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(50),
    stock INT NOT NULL DEFAULT 0
);

-- BORROWED_BOOKS TABLE
CREATE TABLE borrowed_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(8) NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('borrowed', 'pending', 'returned') NOT NULL DEFAULT 'borrowed',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- MY_SHELF TABLE
CREATE TABLE my_shelf (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(8) NOT NULL,
    book_id INT NOT NULL,
    added_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);