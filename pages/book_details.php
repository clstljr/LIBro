<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["book_id"])) {
    $book_id = $_POST["book_id"];
    $user_id = $_SESSION["user_id"];

    // Check if item already in cart
    $stmt = $conn->prepare("SELECT id FROM cart_items WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update quantity
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $user_id, $book_id);
    } else {
        // Insert new
        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, book_id, quantity) VALUES (?, ?, 1)");
        $stmt->bind_param("ii", $user_id, $book_id);
    }

    $stmt->execute();
    header("Location: cart.php");
    exit();
}
?>

<form method="post">
    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
    <button type="submit">Add to Cart</button>
</form>
