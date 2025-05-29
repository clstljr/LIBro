To use my sql database

Step 1: Open phpMyAdmin In your browser, go to: http://localhost/phpmyadmin

Step 2: Open the SQL Tab At the top menu, click the "SQL" tab.

Step 3: Paste the following SQL code into the textbox:

    CREATE DATABASE IF NOT EXISTS library_db;

    USE library_db;

    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        address VARCHAR(255),
        phone VARCHAR(20)
    );

    CREATE TABLE books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        image VARCHAR(255),
        uploaded_by INT,
        FOREIGN KEY (uploaded_by) REFERENCES users(id)
    );

    CREATE TABLE purchases (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        book_id INT,
        quantity INT, 
        address VARCHAR(255),
        phone VARCHAR(20),
        purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
    );

    CREATE TABLE cart_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        book_id INT,
        quantity INT,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (book_id) REFERENCES books(id)
    );




