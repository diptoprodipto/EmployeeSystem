<?php
include "config.php";

if ($_POST['presentTableData'] || $_POST['absentTableData']) {
  $present_table_array = $_POST['presentTableData'];
  $absent_table_array = $_POST['absentTableData'];
} else if ($_POST['singleData']) {
  $single_data = $_POST['singleData'];
}

if ($single_data) {
  $employee_id = $single_data[0];
  $employee_name = $single_data[1];
  $date = $single_data[2];
  $working_status = $single_data[3];

  $exist = mysqli_query($conn, "SELECT * FROM `attendance` WHERE `employee_id`='$employee_id' AND `date`='$date';");

  if (mysqli_num_rows($exist) > 0) {
    mysqli_query($conn, "UPDATE `attendance` SET `date`='$date', `working_status`='$working_status' WHERE `employee_id`='$employee_id' AND date='$date';");
  } else {
    mysqli_query($conn, "INSERT INTO `attendance`(`employee_id`, `date`, `working_status`) VALUES ('$employee_id','$date','$working_status');");
  }
}

if ($present_table_array || $absent_table_array) {
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
    foreach ($absent_table_array as $data) {
      if ($data['working_status'] == "1") {
        $employee_id = $data['employee_id'];
        $date = $data['date'];
        $working_status = $data['working_status'];
        $sql_queries .= "INSERT INTO `attendance`(`employee_id`, `date`, `working_status`) VALUES ('$employee_id','$date','$working_status');";
      }
    }
  }

  mysqli_multi_query($conn, $sql_queries);
}

mysqli_close($conn);

header('Content-Type: application/json');
$post_return['response'] = true;
$post_return['data'] = "Successful";

$final_response = json_encode($post_return);

echo $final_response;