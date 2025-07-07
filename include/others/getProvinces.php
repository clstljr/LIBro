<?php
include '../db_connection.php'; // Adjust path if needed
$regionCode = $_GET['region'] ?? '';
$options = '<option value="">Select Province</option>';
if ($regionCode) {
    $result = $conn->query("SELECT * FROM refprovince WHERE regCode = '$regionCode'");
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['provCode']}'>{$row['provDesc']}</option>";
    }
}
echo $options;
?>