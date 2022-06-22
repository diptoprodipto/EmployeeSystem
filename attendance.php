<?php
    include "config.php";

    $sql_emp = "SELECT * FROM employees";
    $emp_res = mysqli_query($conn, $sql_emp);
    date_default_timezone_set("Asia/Dhaka");
    $date = date('Y-m-d H:i');
    $dateArr = explode(" ",$date);
    $finalDate = $dateArr[0]."T".$dateArr[1];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
</head>
<body>
    <?php
        include "navbar.php";
    ?>
    <div>
        <div class="container" style="margin-top: 100px;">
            <h2>Employees</h2>
            <table id="attendanceTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Working Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                    if (mysqli_num_rows($emp_res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($emp_res)) {
                ?>
                            <tr>
                                <td><?php echo $row['employee_id']; ?></td>
                                <td><?php echo $row['employee_name']; ?></td>
                                <td><input type="datetime-local" id="current-date" name="current-date" value="<?php echo $finalDate ?>"/></td>
                                <td>
                                    <input type="radio" id="present" name="<?php echo "group".$i; ?>" onclick="" value="1" checked="checked" />Present
                                    <input type="radio" id="absent" name="<?php echo "group".$i; ?>" onclick="" value="0" />Absent
                                </td>
                                <td><a class="btn btn-info" href="index.php?action=edit&email=<?php echo $row['email']; ?>">Save</a></td>
                            </tr>
                <?php   $i++; }
                    }
                ?>

                    
                </tbody>
            </table>

            <button onclick="saveAllData()" class="btn btn-danger" type="submit" name="saveall" value="submit">Save</button>

        </div>

    </div>
    <script type="text/javascript" src="index.js"></script>
</body>
</html>