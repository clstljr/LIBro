<?php
require '../../include/db_connection.php';

if (!isset($_POST['id'])) {
    header("Location: ../../pages/librarian/dashboardLibrarianPage.php?error=Missing book ID");
    exit;
}

$id = intval($_POST['id']);

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../../pages/librarian/dashboardLibrarianPage.php?message=Book removed successfully.");
} else {
    header("Location: ../../pages/librarian/dashboardLibrarianPage.php?error=Failed to remove book.");
}

$stmt->close();
$conn->close();
?>