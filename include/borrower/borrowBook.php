<?php
session_start();
include __DIR__ . '/../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];

    // Check if the book is already in "My Shelf"
    $query = "SELECT * FROM my_shelf WHERE user_id = ? AND book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the book is already borrowed and not yet returned
    $borrowedQuery = "SELECT * FROM borrowed_books WHERE user_id = ? AND book_id = ? AND status = 'borrowed'";
    $borrowedStmt = $conn->prepare($borrowedQuery);
    $borrowedStmt->bind_param("ii", $user_id, $book_id);
    $borrowedStmt->execute();
    $borrowedResult = $borrowedStmt->get_result();

    if ($result->num_rows > 0 || $borrowedResult->num_rows > 0) {
        // Redirect back with an error message
        header("Location: ../../pages/borrower/dashboardBorrowerPage.php");
        exit;
    } else {
        // Insert the book into "My Shelf"
        $insertQuery = "INSERT INTO my_shelf (user_id, book_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $user_id, $book_id);
        if ($insertStmt->execute()) {
            header("Location: ../../pages/borrower/dashboardBorrowerPage.php?message=Book added to your shelf.");
            exit;
        } else {
            header("Location: ../../pages/borrower/dashboardBorrowerPage.php?error=Error adding book to shelf.");
            exit;
        }
    }
}
?>