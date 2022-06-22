<?php
include "config.php";
include "navbar.php";

// Insertion and Update
if (isset($_POST['submit'])) {
    $employee_name = $_POST['employee_name'];
    $designation = $_POST['designation'];
    $role = (int) $_POST['role'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];
    $resignation_date = (empty($_POST['resignation_date'])) ? '0000-00-00 00:00:00' : $_POST['resignation_date'];
    $password = $_POST['password'];

    $record_exist = mysqli_query($conn, "SELECT * FROM employees WHERE email='$email' LIMIT 1;");
    if (mysqli_num_rows($record_exist) > 0) {
        $sql = "UPDATE `employees` SET `employee_name`='$employee_name',`designation`='$designation',`role`='$role',`email`='$email',`phone`='$phone',`salary`='$salary',`status`='$status',`resignation_date`='$resignation_date',`password`='$password' WHERE `email`='$email'";
    } else {
        $sql = "INSERT INTO `employees`(`employee_name`, `designation`, `role`, `email`, `phone`, `salary`, `status`, `resignation_date`, `password`) VALUES ('$employee_name','$designation','$role','$email','$phone','$salary','$status','$resignation_date','$password')";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: index.php');
    } else {
        echo "Error:" . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

$sql = "SELECT * FROM employees";
$emp_result = $conn->query($sql);

// Edit
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $email = $_GET['email'];
    $record = mysqli_query($conn, "SELECT * FROM employees WHERE email='$email' LIMIT 1;");

    if (mysqli_num_rows($record) > 0) {
        $n = mysqli_fetch_array($record);
        $edit_name = $n['employee_name'];
        $edit_designation = $n['designation'];
        $edit_role = $n['role'];
        $edit_email = $n['email'];
        $edit_phone = $n['phone'];
        $edit_salary = $n['salary'];
        $edit_status = $n['status'];
        $edit_resignation_date = $n['resignation_date'];
        $edit_password = $n['password'];
    }

    if ($edit_status == "1") {
        echo "
                <script type=\"text/javascript\">
                    document.addEventListener(\"DOMContentLoaded\", function() {
                        document.querySelector('#resigned').checked = true
                    });
                </script>
            ";
    }
}

// Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $email = $_GET['email'];
    echo "
            <script type=\"text/javascript\">
                document.addEventListener(\"DOMContentLoaded\", () => {
                    
                });
            </script>
        ";

    // mysqli_query($conn, "DELETE FROM employees WHERE email='$email';");
    // header('Location: index.php');
    // mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <div>
        <div class="container mt-5">
            <h2 style="margin-top: 100px;">Employee Information</h2>

            <form action="" method="POST">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-3">
                            Employee Name:<br>
                            <input type="text" name="employee_name" value="<?php echo $edit_name; ?>" />
                        </div>
                        <div class="col-lg-3">
                            Designation:<br>
                            <input type="text" name="designation" value="<?php echo $edit_designation; ?>" />
                        </div>
                        <div class="col-lg-2">
                            Role:<br>
                            <select name="role" id="role" value="<?php echo $edit_dev; ?>">
                                <option value="1">Admin</option>
                                <option value="2">Dev</option>
                                <option value="3">User</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Email:<br>
                            <input type="email" name="email" value="<?php echo $edit_email; ?>" />
                        </div>
                        <div class="col-lg-2">
                            Phone:<br>
                            <input type="text" name="phone" value="<?php echo $edit_phone; ?>" />
                        </div>

                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-3">
                            Salary:<br>
                            <input type="text" name="salary" value="<?php echo $edit_salary; ?>" />
                        </div>
                        <div class="col-lg-3">
                            Status:<br>
                            <input type="radio" id="not-resigned" name="status" onclick="checkStatus(this);" value="0" checked="checked" />Not Resigned
                            <input type="radio" id="resigned" name="status" onclick="checkStatus(this);" value="1" />Resigned
                        </div>
                        <div class="col-lg-3">
                            Resignation Date:<br>
                            <input type="datetime-local" id="resignation_date" name="resignation_date" disabled />
                        </div>
                        <div class="col-lg-3">
                            Password:<br>
                            <input type="password" id="password" name="password" value="<?php echo $edit_password; ?>" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <input type="submit" name="submit" value="submit">
                    </div>

                </fieldset>
            </form>

        </div>

        <div class="container mt-5">
            <h2>Employees</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th>Resignation Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if ($emp_result->num_rows > 0) {
                        while ($row = $emp_result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['employee_id']; ?></td>
                                <td><?php echo $row['employee_name']; ?></td>
                                <td><?php echo $row['designation']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['salary']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['resignation_date']; ?></td>
                                <td><a class="btn btn-info" href="index.php?action=edit&email=<?php echo $row['email']; ?>">Edit</a>&nbsp;<a class="btn btn-danger" href="index.php?action=delete&email=<?php echo $row['email']; ?>">Delete</a></td>
                            </tr>
                    <?php   }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="./index.js"></script>
</body>

</html>