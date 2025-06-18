<?php
include __DIR__ . '/../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $type = 'librarian'; // Default account type is librarian

    // Check for unique email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Redirect back to add librarian page with error message
        header("Location: ../../pages/librarian/addlibrarianPage.php?error=Email already exists.");
        exit;
    }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert librarian into database
        $query = "INSERT INTO users (first_name, last_name, email, password, phone, address, type) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $firstName, $lastName, $email, $hashedPassword, $phone, $address, $type);
        if ($stmt->execute()) {
            // Redirect back to add librarian page with success message
            header("Location: ../../pages/librarian/addlibrarianPage.php?message=Librarian added successfully.");
            exit;
        } else {
            header("Location: ../../pages/librarian/addlibrarianPage.php?error=Error adding librarian.");
            exit;
        }
    }
?>