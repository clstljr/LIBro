<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Fetch books
$books = [];
$result = $conn->query("SELECT * FROM books ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</h2>
    <p><a href="add_book.php">Publish a Book</a> | <a href="orders.php">My Purchases</a> | <a href="logout.php">Logout</a></p>

    <h3>Available Books</h3>
    <?php if (empty($books)) : ?>
        <p>No books available yet.</p>
    <?php else : ?>
        <div class="book-list">
            <?php foreach ($books as $book): ?>
                <div class="book-item">
                    <?php if ($book['image']): ?>
                        <img src="uploads/<?= htmlspecialchars($book['image']) ?>" width="100"><br>
                    <?php endif; ?>
                    <strong><?= htmlspecialchars($book['title']) ?></strong><br>
                    by <?= htmlspecialchars($book['author']) ?><br>
                    ₱<?= number_format($book['price'], 2) ?><br>
                    <a href="buy_book.php?id=<?= $book['id'] ?>">Buy</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
