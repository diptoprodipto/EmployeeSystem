<?php
include "config.php";

$present_table_array = $_POST['presentTableData'];
$absent_table_array = $_POST['absentTableData'];
$sql_queries = '';

if ($present_table_array) {
  foreach ($present_table_array as $data) {
    $employee_id = $data['employee_id'];
    $date = $data['date'];
    $working_status = $data['working_status'];
    $sql_queries .= "UPDATE `attendance` SET `date`='$date', `working_status`='$working_status' WHERE `employee_id`='$employee_id' AND date='$date';";
  }
}

if ($absent_table_array) {
  foreach ($absent_table_array as $data){
    $employee_id = $data['employee_id'];
    $date = $data['date'];
    $working_status = $data['working_status'];
    $sql_queries .= "INSERT INTO `attendance`(`employee_id`, `date`, `working_status`) VALUES ('$employee_id','$date','$working_status');";
  }
}

mysqli_multi_query($conn, $sql_queries);
mysqli_close($conn);


header('Content-Type: application/json');
$post_return['response'] = true;
// $post_return['data'] = $array;

$final_response = json_encode($post_return);

echo $final_response;