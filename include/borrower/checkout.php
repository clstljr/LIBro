<?php
    session_start();

include __DIR__ . '/../db_connection.php'; // Use __DIR__ to ensure the correct path

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../pages/loginPage.php?error=Please log in to continue.");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user information
$userQuery = "SELECT first_name, last_name, email FROM users WHERE id = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("i", $user_id);
$userStmt->execute();
$userResult = $userStmt->get_result();
$user = $userResult->fetch_assoc();

if (!$user) {
    header("Location: ../../pages/loginPage.php?error=User not found.");
    exit;
}

// Fetch books from "My Shelf" (cart)
$cartQuery = "SELECT books.title, books.image, books.author, books.description 
              FROM my_shelf 
              JOIN books ON my_shelf.book_id = books.id 
              WHERE my_shelf.user_id = ?";
$cartStmt = $conn->prepare($cartQuery);
$cartStmt->bind_param("i", $user_id);
$cartStmt->execute();
$cart = $cartStmt->get_result();
?>