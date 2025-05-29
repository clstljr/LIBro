<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT p.purchase_date, b.title, b.author, b.price, b.image 
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
    <p><a href="dashboard.php">Back to Dashboard</a> | <a href="logout.php">Logout</a></p>

    <?php if (empty($purchases)) : ?>
        <p>You haven't purchased any books yet.</p>
    <?php else : ?>
        <div class="purchase-list">
            <?php foreach ($purchases as $p): ?>
                <div class="purchase-item">
                    <?php if ($p['image']): ?>
                        <img src="uploads/<?= htmlspecialchars($p['image']) ?>" width="100"><br>
                    <?php endif; ?>
                    <strong><?= htmlspecialchars($p['title']) ?></strong><br>
                    by <?= htmlspecialchars($p['author']) ?><br>
                    Purchased on: <?= $p['purchase_date'] ?><br>
                    Price: ₱<?= number_format($p['price'], 2) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
