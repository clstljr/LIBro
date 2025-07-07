<?php
include __DIR__ . '/../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $stock = trim($_POST['stock']);
    $imageName = basename($_FILES["image"]["name"]);

    // Check for empty fields
    if (empty($title) || empty($author) || empty($description) || empty($category) || empty($stock) || empty($imageName)) {
        header("Location: ../../pages/librarian/addbookPage.php?error=All fields are required.");
        exit;
    }

    // Handle file upload
    $targetDir = "../../uploads/";
    $targetFilePath = $targetDir . $imageName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Validate file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        header("Location: ../../pages/librarian/addbookPage.php?error=Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        exit;
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        // Check if the book already exists
        $query = "SELECT * FROM books WHERE title = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Book exists, update its stock and other fields
            $existingBook = $result->fetch_assoc();
            $newStock = $existingBook['stock'] + $stock;

            $updateQuery = "UPDATE books SET author = ?, description = ?, image = ?, category = ?, stock = ? WHERE title = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ssssis", $author, $description, $imageName, $category, $newStock, $title);

            if ($updateStmt->execute()) {
                header("Location: ../../pages/librarian/addbookPage.php?message=Book updated successfully.");
                exit;
            } else {
                header("Location: ../../pages/librarian/addbookPage.php?error=Error updating book.");
                exit;
            }
        } else {
            // Book does not exist, insert as a new entry
            $insertQuery = "INSERT INTO books (title, author, description, image, category, stock) VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sssssi", $title, $author, $description, $imageName, $category, $stock);

            if ($insertStmt->execute()) {
                header("Location: ../../pages/librarian/addbookPage.php?message=Book added successfully.");
                exit;
            } else {
                header("Location: ../../pages/librarian/addbookPage.php?error=Error adding book.");
                exit;
            }
        }
    } else {
        header("Location: ../../pages/librarian/addbookPage.php?error=Error uploading image.");
        exit;
    }
}
?>