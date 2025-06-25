<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $type = 'borrower'; // Default account type is borrower

    $regionCode = $_POST['region'];
    $provinceCode = $_POST['province'];
    $cityCode = $_POST['city'];
    $barangayCode = $_POST['barangay'];

    // Get names from codes
    $region = mysqli_fetch_assoc(mysqli_query($conn, "SELECT regDesc FROM refregion WHERE regCode = '$regionCode'"))['regDesc'] ?? '';
    $province = mysqli_fetch_assoc(mysqli_query($conn, "SELECT provDesc FROM refprovince WHERE provCode = '$provinceCode'"))['provDesc'] ?? '';
    $city = mysqli_fetch_assoc(mysqli_query($conn, "SELECT citymunDesc FROM refcitymun WHERE citymunCode = '$cityCode'"))['citymunDesc'] ?? '';
    $barangay = mysqli_fetch_assoc(mysqli_query($conn, "SELECT brgyDesc FROM refbrgy WHERE brgyCode = '$barangayCode'"))['brgyDesc'] ?? '';

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
   
    $currentYear = date("Y");
    $query = "SELECT id FROM users WHERE id LIKE '{$currentYear}%' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $lastID = (int)substr($row['id'], 4);
        $nextID = $currentYear . str_pad($lastID + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $nextID = $currentYear . "0001";
    }

    // Insert new user into the database
    $insertQuery = "INSERT INTO users (id, first_name, last_name, email, password, phone, type, region, province, city, barangay)
    VALUES ('$nextID', '$firstName', '$lastName', '$email', '$hashedPassword', '$phone', '$type', '$region', '$province', '$city', '$barangay')";

    if (mysqli_query($conn, $insertQuery)) {
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