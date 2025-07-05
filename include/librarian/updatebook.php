<?php
session_start();
require '../../include/db_connection.php';

if (!isset($_POST['id'])) {
    header("Location: ../../pages/librarian/dashboardLibrarianPage.php?error=Missing book ID");
    exit;
}

$id = intval($_POST['id']);
$title = trim($_POST['title']);
$author = trim($_POST['author']);
$description = trim($_POST['description']);
$category = trim($_POST['category']);
$stock = intval($_POST['stock']);

$image_name = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $allowed = ['jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed)) {
        header("Location: ../../pages/librarian/updatebookPage.php?id=$id&error=Invalid image format.");
        exit;
    }
    $image_name = uniqid() . '.' . $file_ext;
    $upload_path = __DIR__ . '/../../uploads/' . $image_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
}

if ($image_name) {
    $stmt = $conn->prepare("UPDATE books SET title=?, author=?, description=?, category=?, stock=?, image=? WHERE id=?");
    $stmt->bind_param("ssssisi", $title, $author, $description, $category, $stock, $image_name, $id);
} else {
    $stmt = $conn->prepare("UPDATE books SET title=?, author=?, description=?, category=?, stock=? WHERE id=?");
    $stmt->bind_param("ssssii", $title, $author, $description, $category, $stock, $id);
}

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../../pages/librarian/dashboardLibrarianPage.php?message=Book updated successfully.");
    } else {
        header("Location: ../../pages/librarian/dashboardLibrarianPage.php?error=No changes made to the book.");
    }
} else {
    header("Location: ../../pages/librarian/dashboardLibrarianPage.php?error=Failed to update book: " . $stmt->error);
}


$stmt->close();
$conn->close();
?>