<?php 
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        die();
    }
    require_once "connect.php";

    $employee_id = $_GET['employee_id'];

    // Check if the user is an admin
    if ($_SESSION["account_type"] === "Admin") {
        // Get the employee id to delete
        $employee_id = $_GET["employee_id"];

        // Perform the deletion from the employeetbl table
        mysqli_query($conn, "DELETE FROM `employeetbl` WHERE employee_id=$employee_id");

        // Get the maximum employee ID value from the employeetbl table
        $result = mysqli_query($conn, "SELECT MAX(employee_id) AS max_id FROM employeetbl");
        $row = mysqli_fetch_assoc($result);
        $max_id = $row['max_id'];

        // reset auto-increment value
        mysqli_query($conn, "ALTER TABLE `employeetbl` AUTO_INCREMENT=". ($max_id + 1));

        header("Location: admin.php");
        exit;
    } elseif ($_SESSION["account_type"] === "User") {
        // Get the project id to delete
        $project_id = $_GET["project_id"];

        // Perform the deletion from the projectstbl table
        mysqli_query($conn, "DELETE FROM `projectstbl` WHERE project_id=$project_id");

        // Get the maximum project id value from the projectstbl table
        $result = mysqli_query($conn, "SELECT MAX(project_id) AS max_id FROM projectstbl");
        $row = mysqli_fetch_assoc($result);
        $max_id = $row['max_id'];

        // reset auto-increment value
        mysqli_query($conn, "ALTER TABLE `projectstbl` AUTO_INCREMENT=". ($max_id + 1));

        header("Location: employee.php");
        exit;
    }
?>
