<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $type = 'borrower'; // Default account type is borrower

    // Check if email is already registered
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already registered, redirect to login page
        header("Location: ../pages/loginPage.php?error=Email is already registered. Please log in.");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $insertQuery = "INSERT INTO users (first_name, last_name, email, password, phone, address, type) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("sssssss", $firstName, $lastName, $email, $hashedPassword, $phone, $address, $type);

    if ($insertStmt->execute()) {
        // Registration successful, redirect to login page with success message
        header("Location: ../pages/loginPage.php?message=Registration successful. Please log in.");
        exit;
    } else {
        // Registration failed
        header("Location: ../pages/registerPage.php?error=Registration failed. Please try again.");
        exit;
    }
}
?>