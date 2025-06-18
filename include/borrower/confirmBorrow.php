<?php
session_start();
include __DIR__ . '/../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_checkout'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch books from "My Shelf"
    $query = "SELECT book_id, quantity FROM my_shelf WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Move books to "Borrowed Books" and update stock
    while ($row = $result->fetch_assoc()) {
        $book_id = $row['book_id'];
        $quantity = $row['quantity'];

        // Insert into borrowed_books
        $insertQuery = "INSERT INTO borrowed_books (user_id, book_id, quantity, borrow_date) VALUES (?, ?, ?, NOW())";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("iii", $user_id, $book_id, $quantity);
        $insertStmt->execute();

        // Deduct stock from books table
        $updateStockQuery = "UPDATE books SET stock = stock - ? WHERE id = ?";
        $updateStockStmt = $conn->prepare($updateStockQuery);
        $updateStockStmt->bind_param("ii", $quantity, $book_id);
        $updateStockStmt->execute();
    }

    // Clear "My Shelf"
    $deleteQuery = "DELETE FROM my_shelf WHERE user_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $user_id);
    $deleteStmt->execute();

    // Redirect to dashboard with success message
    header("Location: ../../pages/borrower/dashboardBorrowerPage.php?message=Please pick it up at the LIBro library.");}
?>
