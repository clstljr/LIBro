<?php
session_start();
session_destroy();
header("Location: ../pages/loginPage.php?message=You have been logged out.");
exit;
?>