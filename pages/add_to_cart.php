<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["book_id"])) {
    $user_id = $_SESSION["user_id"];
    $book_id = intval($_POST["book_id"]);

    // Check if item already in cart
    $stmt = $conn->prepare("SELECT id FROM cart_items WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If it exists, increase quantity by 1
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $user_id, $book_id);
    } else {
        // Otherwise, insert new row
        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, book_id, quantity) VALUES (?, ?, 1)");
        $stmt->bind_param("ii", $user_id, $book_id);
    }

    $stmt->execute();
    $stmt->close();

    // Redirect back to dashboard with a success message (optional)
    header("Location: dashboard.php?added=1");
    exit();
}

// If accessed directly, redirect to dashboard
header("Location: dashboard.php");
exit();
