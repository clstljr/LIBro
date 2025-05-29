<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid book ID.");
}

$book_id = (int)$_GET['id'];

// Get book details
$stmt = $conn->prepare("SELECT title, author, description, price, image FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Book not found.");
}

$book = $result->fetch_assoc();

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert purchase record
    $stmt2 = $conn->prepare("INSERT INTO purchases (user_id, book_id) VALUES (?, ?)");
    $stmt2->bind_param("ii", $user_id, $book_id);
    if ($stmt2->execute()) {
        $success = "Purchase successful! Thank you for buying <strong>" . htmlspecialchars($book['title']) . "</strong>.";
    } else {
        $error = "Error: " . $stmt2->error;
    }
    $stmt2->close();
}

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buy Book</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Buy Book</h2>
    <p><a href="dashboard.php">Back to Dashboard</a></p>

    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <div class="book-details">
        <?php if ($book['image']): ?>
            <img src="uploads/<?= htmlspecialchars($book['image']) ?>" width="150"><br>
        <?php endif; ?>
        <strong><?= htmlspecialchars($book['title']) ?></strong><br>
        Author: <?= htmlspecialchars($book['author']) ?><br>
        Price: ₱<?= number_format($book['price'], 2) ?><br><br>
        <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
    </div>

    <?php if (!$success): ?>
    <form method="post">
        <button type="submit">Confirm Purchase</button>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
