<?php include '../../include/librarian/dashboardLibrarian.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Librarian Dashboard</title>
    <link rel="stylesheet" href="../../assets/dashboard_librarian.css">
</head>
<body>
    <a href="../../pages/librarian/addbookPage.php">Add Book</a>
    <a href="../../pages/librarian/addlibrarianPage.php">Add Librarian</a>
    <a href="../../include/logout.php">Logout</a>
    <h2>Borrowed Books</h2>
    <?php if (isset($_GET['message'])) { ?>
        <p style="color: green; text-align: center;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php } ?>
    <?php if (isset($_GET['error'])) { ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php } ?>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Borrower</th>
                <th>Borrow Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['borrow_date']); ?></td>
                    <td>
                        <form action="../../include/librarian/returnBook.php" method="POST" style="display: inline;">
                            <input type="hidden" name="borrow_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['book_id']); ?>">
                            <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 5px 10px; cursor: pointer;">Return</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>