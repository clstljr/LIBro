<?php
session_start();
include __DIR__ . '/../db_connection.php'; 

// Fetch borrowed books
$query = "SELECT borrowed_books.id, borrowed_books.book_id, books.title, books.image, users.first_name, users.last_name, borrowed_books.borrow_date 
          FROM borrowed_books 
          JOIN books ON borrowed_books.book_id = books.id 
          JOIN users ON borrowed_books.user_id = users.id";
$result = $conn->query($query);
?>
