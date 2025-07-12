<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $type = 'librarian'; 

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
        header("Location: ../../pages/librarian/addlibrarianPage.php?error=Email already exists.");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
   
    // Generate custom ID: YYYY2NNN (8 chars)
    $year = date('Y');
    $idPrefix = $year . '2';
    // Get the latest ID with this prefix
    $latestIdQuery = "SELECT id FROM users WHERE id LIKE '{$idPrefix}%'
                      ORDER BY id DESC LIMIT 1";
    $latestIdResult = mysqli_query($conn, $latestIdQuery);
    if ($latestIdRow = mysqli_fetch_assoc($latestIdResult)) {
        $lastNumber = (int)substr($latestIdRow['id'], 5, 3);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }
    $nextID = $idPrefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    // Insert new user into the database
    $insertQuery = "INSERT INTO users (id, first_name, last_name, email, password, phone, type, region, province, city, barangay)
    VALUES ('$nextID', '$firstName', '$lastName', '$email', '$hashedPassword', '$phone', '$type', '$region', '$province', '$city', '$barangay')";

    if (mysqli_query($conn, $insertQuery)) {
        // Registration successful, redirect to login page with success message
        header("Location: ../../pages/librarian/addlibrarianPage.php?message=Librarian added successfully.");
        exit;
    } else {
        // Registration failed
        header("Location: ../../pages/librarian/addlibrarianPage.php?error=Error adding librarian.");
        exit;
    }
}
?>