<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Email not registered, redirect to registration page
        header("Location: ../pages/registerPage.php?error=Email not registered. Register now!");
        exit;
    }

    $user = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $user['password'])) {
        // Incorrect password
        header("Location: ../pages/loginPage.php?error=Incorrect email or password.");
        exit;
    }

    // Successful login
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_type'] = $user['type'];

    if ($user['type'] === 'librarian') {
        header("Location: ../pages/librarian/dashboardLibrarianPage.php");
    } else {
        header("Location: ../pages/borrower/dashboardBorrowerPage.php");
    }
    exit;
}
?>