<?php
session_start();
include __DIR__ . '/../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];

    // Get borrow record details
    $borrowQuery = "SELECT * FROM borrowed_books WHERE id = ?";
    $borrowStmt = $conn->prepare($borrowQuery);
    $borrowStmt->bind_param("i", $borrow_id);
    $borrowStmt->execute();
    $borrowResult = $borrowStmt->get_result();
    $borrowRow = $borrowResult->fetch_assoc();

    // Get book details
    $bookQuery = "SELECT * FROM books WHERE id = ?";
    $bookStmt = $conn->prepare($bookQuery);
    $bookStmt->bind_param("i", $book_id);
    $bookStmt->execute();
    $bookResult = $bookStmt->get_result();
    $bookRow = $bookResult->fetch_assoc();

    // Remove the borrowed book from the borrowed_books table
    $deleteQuery = "DELETE FROM borrowed_books WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $borrow_id);

    if ($deleteStmt->execute()) {
        // Increase the stock of the book in the books table
        $updateStockQuery = "UPDATE books SET stock = stock + 1 WHERE id = ?";
        $updateStockStmt = $conn->prepare($updateStockQuery);
        $updateStockStmt->bind_param("i", $book_id);
        if ($updateStockStmt->execute()) {
            // Redirect back to the dashboard with a success message
            header("Location: ../../pages/librarian/dashboardLibrarianPage.php?message=Book returned successfully.");
            exit;
        } else {
            // Redirect back with an error message if stock update fails
            header("Location: ../../pages/librarian/dashboardLibrarianPage.php?error=Error updating book stock.");
            exit;
        }
    } else {
        // Redirect back with an error message if deletion fails
        header("Location: ../../pages/librarian/dashboardLibrarianPage.php?error=Error returning book.");
        exit;
    }
}
?>