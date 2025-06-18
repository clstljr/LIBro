<?php
session_start();
include __DIR__ . '/../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];

    // Remove the book from "My Shelf"
    $query = "DELETE FROM my_shelf WHERE user_id = ? AND book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $book_id);
    if ($stmt->execute()) {
        header("Location: ../../pages/borrower/myshelfPage.php?message=Book removed from shelf.");
        exit;
    } else {
        header("Location: ../../pages/borrower/myshelfPage.php?error=Error removing book from shelf.");
        exit;
    }
}
?>