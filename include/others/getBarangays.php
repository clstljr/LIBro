<?php
include '../db_connection.php';
$cityCode = $_GET['city'] ?? '';
$options = '<option value="">Select Barangay</option>';
if ($cityCode) {
    $result = $conn->query("SELECT * FROM refbrgy WHERE citymunCode = '$cityCode'");
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['brgyCode']}'>{$row['brgyDesc']}</option>";
    }
}
echo $options;
?>