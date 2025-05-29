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
    <p><a href="add_book.php">Publish a Book</a> | <a href="orders.php">My Purchases</a> | <a href="logout.php">Logout</a> | <a href="cart.php">My Cart</a></p>

    <h3>Available Books</h3>
    <?php if (empty($books)) : ?>
        <p>No books available yet.</p>
    <?php else : ?>
        <div class="book-list">
            <?php foreach ($books as $book): ?>
                <div class="book-item">
                    <?php if ($book['image']): ?>
                        <img src="/LIBro/uploads/<?= htmlspecialchars($book['image']) ?>" width="100"><br>
                    <?php endif; ?>
                    <strong><?= htmlspecialchars($book['title']) ?></strong><br>
                    by <?= htmlspecialchars($book['author']) ?><br>
                    ₱<?= number_format($book['price'], 2) ?><br>
                    <form method="post" action="add_to_cart.php" style="display:inline;">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
    <?php if (isset($_GET['added'])): ?>
        <p style="color: green;">Book added to cart successfully!</p>
    <?php endif; ?>
    <?php if (isset($_GET['checkout']) && $_GET['checkout'] === 'success'): ?>
    <div class="notification">
        <p>Your order has been placed successfully and will arrive soon!</p>
    </div>
<?php endif; ?>
</body>
</html>
