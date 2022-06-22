<?php
include "config.php";

$array = $_POST['tableData'];

$sql_queries = '';
foreach ($array as $data){
  $employee_id = $data['employee_id'];
  $date = $data['date'];
  $working_status = $data['working_status'];
  $sql_queries .= "INSERT INTO `attendance`(`employee_id`, `date`, `working_status`) VALUES ('$employee_id','$date','$working_status');";
}

mysqli_multi_query($conn, $sql_queries);
mysqli_close($conn);


header('Content-Type: application/json');
$post_return['response'] = true;
$post_return['data'] = $array;

$final_response = json_encode($post_return);

echo $final_response;