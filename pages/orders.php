<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Fetch purchases with quantity
$sql = "SELECT p.purchase_date, b.title, b.author, b.price, b.image, p.quantity 
        FROM purchases p 
        JOIN books b ON p.book_id = b.id 
        WHERE p.user_id = ? 
        ORDER BY p.purchase_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$purchases = [];
while ($row = $result->fetch_assoc()) {
    $purchases[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Purchases</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>My Purchases</h2>
    <p><a href="dashboard.php">Back to Dashboard</a></p>

    <?php if (empty($purchases)) : ?>
        <p>You haven't purchased any books yet.</p>
    <?php else : ?>
        <div class="purchase-list">
            <table border="1" cellpadding="10">
                <tr>
                    <th>Book</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Purchase Date</th>
                </tr>
                <?php foreach ($purchases as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['title']) ?></td>
                    <td><?= htmlspecialchars($p['author']) ?></td>
                    <td>₱<?= number_format($p['price'], 2) ?></td>
                    <td><?= $p['quantity'] ?></td>
                    <td>₱<?= number_format($p['price'] * $p['quantity'], 2) ?></td>
                    <td><?= $p['purchase_date'] ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
