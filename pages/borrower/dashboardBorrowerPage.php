<!DOCTYPE html>
<html lang="en">
<head>
    <title>Borrower Dashboard</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <?php include '../../include/borrower/dashboardBorrower.php'; ?>
    
    <!-- Display success message -->
    <?php if (isset($_GET['message'])) { ?>
        <p style="color: green; text-align: center;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php } ?>

    <!-- Navigation Links -->
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="../../pages/borrower/myshelfPage.php">My Shelf</a> |
        <a href="../../include/logout.php">Logout</a>
    </div>

    <h2>Available Books</h2>
    <?php foreach ($booksByCategory as $category => $books) { ?>
        <h3><?php echo htmlspecialchars($category); ?></h3>
        <div>
            <?php foreach ($books as $book) { ?>
                <div>
                    <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" width="100">
                    <h4><?php echo htmlspecialchars($book['title']); ?></h4>
                    <p><?php echo htmlspecialchars($book['author']); ?></p>
                    <p>Stock: <?php echo htmlspecialchars($book['stock']); ?></p>
                    <form action="../../include/borrower/borrowBook.php" method="POST">
                        <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['id']); ?>">
                        <button type="submit" <?php echo $book['stock'] == 0 ? 'disabled' : ''; ?>>Borrow Now</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>