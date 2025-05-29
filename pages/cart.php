<?php
session_start();
require 'config.php';

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Handle quantity update
if (isset($_POST['update'])) {
    $book_id = $_POST['book_id'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("iii", $quantity, $user_id, $book_id);
    $stmt->execute();
}

// Handle item removal
if (isset($_POST['remove'])) {
    $book_id = $_POST['book_id'];

    $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
}

// Fetch cart items
$stmt = $conn->prepare("
    SELECT books.id, books.title, books.price, books.image, cart_items.quantity
    FROM cart_items
    JOIN books ON cart_items.book_id = books.id
    WHERE cart_items.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Your Cart</h2>
    <p><a href="dashboard.php">← Back to Dashboard</a></p>

    <table border="1" cellpadding="10">
        <tr>
            <th>Book</th>
            <th>Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Actions</th>
        </tr>

        <?php
        $total = 0;
        while ($row = $result->fetch_assoc()):
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td>
                <img src="/LIBro/uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" width="50">
            </td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td>₱<?= number_format($row['price'], 2) ?></td>
            <td>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="book_id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="quantity" value="<?= max(1, $row['quantity'] - 1) ?>">
                    <button type="submit" name="update" <?= $row['quantity'] <= 1 ? 'disabled' : '' ?>>−</button>
                </form>

                <?= $row['quantity'] ?>

                <form method="post" style="display: inline;">
                    <input type="hidden" name="book_id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="quantity" value="<?= $row['quantity'] + 1 ?>">
                    <button type="submit" name="update">+</button>
                </form>
            </td>
            <td>₱<?= number_format($subtotal, 2) ?></td>
            <td>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="book_id" value="<?= $row['id'] ?>">
                    <button type="submit" name="remove" onclick="return confirm('Remove this item from your cart?')">🗑 Remove</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h3>Total: ₱<?= number_format($total, 2) ?></h3>
    <a href="checkout.php">Proceed to Checkout</a>
</div>
</body>
</html>
