<?php
session_start();
session_destroy(); // Destroy all session data
header("Location: ../pages/loginPage.php?message=You have been logged out.");
exit;
?>