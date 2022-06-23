<?php
include "config.php";

$date = date('Y-m-d');
$result = mysqli_query($conn, "SELECT * FROM attendance WHERE date='$date';");
$attendance_data = array();

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $attendance_data[] = $row;
    }
}

header('Content-Type: application/json');
$response_data['response'] = true;
$response_data['data'] = $attendance_data;

echo json_encode($response_data);