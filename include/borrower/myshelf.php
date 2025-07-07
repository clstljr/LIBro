<?php
session_start();
include __DIR__ . '/../db_connection.php'; 

// Fetch books in "My Shelf"
$user_id = $_SESSION['user_id'];
$query = "SELECT books.id AS book_id, books.title, books.image, books.author, books.description, my_shelf.added_date 
          FROM my_shelf 
          JOIN books ON my_shelf.book_id = books.id 
          WHERE my_shelf.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

