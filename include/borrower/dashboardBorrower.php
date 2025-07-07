<?php
session_start();
include __DIR__ . '/../db_connection.php';

// Fetch available books grouped by category
$query = "SELECT * FROM books WHERE stock > 0 ORDER BY category, title";
$result = $conn->query($query);

// Organize books by category
$booksByCategory = [];
while ($book = $result->fetch_assoc()) {
    $booksByCategory[$book['category']][] = $book;
}
?>
