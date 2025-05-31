<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Shelf</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <a href="../../pages/borrower/dashboardBorrowerPage.php">Back to Dashboard</a>
    <h2>My Shelf</h2>
    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color: red; text-align: center;'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>
    <ul>
        <?php include '../../include/borrower/myshelf.php'; ?>
        <?php while ($book = $result->fetch_assoc()) { ?>
            <li>
                <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" width="50">
                <p><strong>Title:</strong> <?php echo htmlspecialchars($book['title']); ?></p>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($book['quantity']); ?></p>
                <form action="../../include/borrower/removeFromShelf.php" method="POST">
                    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>">
                    <button type="submit">Remove</button>
                </form>
            </li>
        <?php } ?>
    </ul>
    <form action="checkoutPage.php" method="GET">
        <button type="submit" name="confirm_checkout">Check Out</button>
    </form>
</body>
</html>