<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $uploaded_by = $_SESSION["user_id"];

    // Handle image upload
    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, $allowed)) {
            $image_name = uniqid() . "." . $file_ext;
            
            if (!is_dir(__DIR__ . "/../uploads")) {
                mkdir(__DIR__ . "/../uploads", 0777, true); // Create the directory if it doesn't exist
            }

            if (is_writable(__DIR__ . "/../uploads")) {
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../uploads/" . $image_name);
            } else {
                $error = "Uploads directory is not writable.";
            }
        } else {
            $error = "Invalid image format. Allowed: jpg, jpeg, png, gif.";
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, description, price, image, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisi", $title, $author, $description, $price, $image_name, $uploaded_by);
        if ($stmt->execute()) {
            $success = "Book published successfully.";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Publish Book</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Publish a New Book</h2>
    <p><a href="dashboard.php">Back to Dashboard</a></p>

    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Book Title" required><br>
        <input type="text" name="author" placeholder="Author" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="number" step="0.01" name="price" placeholder="Price" required><br>
        <label>Book Cover Image (optional):</label><br>
        <input type="file" name="image" accept="image/*"><br><br>
        <button type="submit">Publish Book</button>
    </form>
</div>
</body>
</html>
