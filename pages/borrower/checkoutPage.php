<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <?php include '../../include/borrower/checkout.php'; ?>
    <h2>Checkout</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <h3>Books in Your Cart:</h3>
    <ul>
        <?php while ($book = $cart->fetch_assoc()) { ?>
            <li>
                <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" width="50">
                <p><strong>Title:</strong> <?php echo htmlspecialchars($book['title']); ?></p>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($book['quantity']); ?></p>
            </li>
        <?php } ?>
    </ul>
    <form action="../../include/borrower/confirmBorrow.php" method="POST">
        <button type="submit" name="confirm_checkout">Yes, I Agree</button>
    </form>
    <a href="../../pages/borrower/dashboardBorrowerPage.php">Go Back to Dashboard</a>
</body>
</html>