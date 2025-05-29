<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Get user info (username, email, address, phone)
$stmt = $conn->prepare("SELECT username, email, address, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userResult = $stmt->get_result();
if ($userResult->num_rows > 0) {
    $userInfo = $userResult->fetch_assoc();
} else {
    die("User not found.");
}
$stmt->close();

// Get cart items with book info
$stmt = $conn->prepare("
    SELECT b.id, b.title, b.author, b.price, b.image, ci.quantity
    FROM cart_items ci
    JOIN books b ON ci.book_id = b.id
    WHERE ci.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cartResult = $stmt->get_result();

if ($cartResult->num_rows === 0) {
    die("Your cart is empty.");
}

// Handle checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_checkout'])) {
    // Update user information
    $new_address = trim($_POST['address']);
    $new_phone = trim($_POST['phone']);

    $stmtUpdate = $conn->prepare("UPDATE users SET address = ?, phone = ? WHERE id = ?");
    $stmtUpdate->bind_param("ssi", $new_address, $new_phone, $user_id);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    // Insert purchases with address and phone
    $stmtInsert = $conn->prepare("INSERT INTO purchases (user_id, book_id, quantity, address, phone) VALUES (?, ?, ?, ?, ?)");

    while ($item = $cartResult->fetch_assoc()) {
        $stmtInsert->bind_param("iiiss", $user_id, $item['id'], $item['quantity'], $new_address, $new_phone);
        $stmtInsert->execute();
    }
    $stmtInsert->close();

    // Clear cart
    $stmtClear = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $stmtClear->bind_param("i", $user_id);
    $stmtClear->execute();
    $stmtClear->close();

    // Redirect to dashboard with success message
    header("Location: dashboard.php?checkout=success");
    exit;
}

// Reset cartResult pointer to reuse for display
$cartResult->data_seek(0);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 700px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        img { max-width: 80px; }
        .container { max-width: 800px; margin: auto; }
        .btn { padding: 10px 20px; font-size: 16px; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2>Checkout</h2>
    <p><a href="cart.php">← Back to Cart</a></p>

    <h3>Delivery Information</h3>
    <form method="post">
        <p><strong>Name:</strong> <?= htmlspecialchars($userInfo['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($userInfo['email']) ?></p>
        <p>
            <strong>Address:</strong>
            <input type="text" name="address" value="<?= htmlspecialchars($userInfo['address']) ?>" required>
        </p>
        <p>
            <strong>Phone:</strong>
            <input type="text" name="phone" value="<?= htmlspecialchars($userInfo['phone']) ?>" required>
        </p>

        <h3>Order Summary</h3>
        <table>
            <tr>
                <th>Book</th>
                <th>Name</th>
                <th>Author</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $total = 0;
            while ($row = $cartResult->fetch_assoc()):
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td>
                    <img src="/LIBro/uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" width="50">
                </td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td>₱<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>₱<?= number_format($subtotal, 2) ?></td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <th colspan="5" style="text-align:right">Total:</th>
                <th>₱<?= number_format($total, 2) ?></th>
            </tr>
        </table>

        <button type="submit" name="confirm_checkout" class="btn">Confirm and Checkout</button>
    </form>
</div>
</body>
</html>
