<?php
include 'db_connection.php';
$provinceCode = $_GET['province'] ?? '';
$options = '<option value="">Select City</option>';
if ($provinceCode) {
    $result = $conn->query("SELECT * FROM refcitymun WHERE provCode = '$provinceCode'");
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['citymunCode']}'>{$row['citymunDesc']}</option>";
    }
}
echo $options;
?>