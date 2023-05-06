<?php
    session_start();

    // if session not logged in OR accountype not admin go to login
    if (!isset($_SESSION["user"]) OR $_SESSION["account_type"] !== "Admin") {
        header("Location: login.php");
        die();
    }

    require_once "connect.php";
    require_once "errors.php";

    if (isset($_POST['update'])) {
        $employee_id = $_POST['employee_id'];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $datehired = $_POST["datehired"];
        $position = $_POST["position"];
        $department = $_POST["department"];
        $salary = $_POST["salary"];
        $account_type = $_POST["account_type"];

        // Check if a form is empty 
        if (empty($username) OR empty($password) OR empty($firstname) OR empty($lastname) 
            OR empty($datehired) OR empty($position) OR empty($department) OR empty($salary)){
                push_error("All fields are required.");
        }
        // Check if password < 8
        if (strlen($password)<8){
            push_error("Password must be at least 8 characters long.");
        }
        // Check if username < 4
        if (strlen($username)<4){
            push_error("Username must be at least 4 characters long.");
        }

        // check if password has changed
        $query = mysqli_query($conn, "SELECT * FROM employeetbl WHERE employee_id=$employee_id");
        $result = mysqli_fetch_array($query);
        $stored_password = $result["password"];
        if ($password === $result["password"]) {
            $passwordhash = $password;
        } else {
            $passwordhash = password_hash($password, PASSWORD_BCRYPT);
        }

        if (empty($errors)){
            $result = mysqli_query($conn, "UPDATE employeetbl SET username='$username', password='$passwordhash', firstname='$firstname', lastname='$lastname', datehired='$datehired', 
            position='$position', department='$department', salary='$salary', account_type='$account_type' WHERE employee_id='$employee_id'");

            header('location: admin.php');
        }
    }

    if (isset($_GET['employee_id'])) {
		$employee_id = $_GET['employee_id'];
		$query = mysqli_query($conn, "SELECT * FROM employeetbl WHERE employee_id=$employee_id");
        $result = mysqli_fetch_array($query);
            $username = $result["username"];
            $password = $result["password"];
            $firstname = $result["firstname"];
            $lastname = $result["lastname"];
            $datehired = $result["datehired"];
            $position = $result["position"];
            $department = $result["department"];
            $salary = $result["salary"];
            $account_type = $result["account_type"];
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/update_account.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark w-100">
        <div class="container-fluid">
            <span class="navbar-brand" href="#">
            <img src="img/logo1.png" alt="Logo" width="30" height="30">
            Logo Name
            </span>


            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="admin.php" class="nav-link">Admin</a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container-fluid container">
        <div class="header">
            <h4>Update Account</h4>
        </div>

        <form action="update_account.php?employee_id=<?php echo $_GET['employee_id'];?>" method="post" class="row form">
            <div class="col-sm-12">
                <label class="form-label" for="username">USERNAME</label>  
                <input type="text" class="form-control form-control-md" name="username" placeholder="Username" value="<?php echo $username;?>">
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="password">PASSWORD</label>  
                <input type="password" class="form-control form-control-md" name="password" placeholder="Password" value="<?php echo $password;?>">
            </div>
            <div class="col-sm-6 ">
                <label class="form-label" for="fistname">FIRST NAME</label>  
                <input type="text" class="form-control form-control-md" name="firstname" placeholder="First Name" value="<?php echo $firstname;?>">
            </div>
            <div class="col-sm-6 ">
                <label class="form-label" for="lastname">LAST NAME</label>  
                <input type="text" class="form-control form-control-md" name="lastname" placeholder="Last Name" value="<?php echo $lastname;?>">
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="datehired">DATE HIRED</label>  
                <input type="date" class="form-control form-control-md" name="datehired" value="<?php echo $datehired;?>">
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="position">POSITION</label>  
                <input type="text" class="form-control form-control-md" name="position" placeholder="Position" value="<?php echo $position;?>">
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="department">DEPARTMENT</label>  
                <input type="text" class="form-control form-control-md" name="department" placeholder="Department" value="<?php echo $department;?>">
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="salary">SALARY</label>  
                <input type="number" class="form-control form-control-md" name="salary" placeholder="Salary" value="<?php echo $salary;?>">
            </div>
            <div class="col-sm-12"> 
                <label class="form-label" for="account_type">ACCOUNT TYPE</label>
                <select class="form-control form-control-md" name="account_type" selected="<?php echo $account_type;?>">
                    <option value="User" <?php echo ($account_type == "User") ? 'selected' : ''; ?>>User</option>
                    <option value="Admin" <?php echo ($account_type == "Admin") ? 'selected' : ''; ?>>Admin</option>
                </select>   
            </div>
            <div class="col-sm-12 button">
                <input type="hidden" name="employee_id" value="<?php echo $_GET['employee_id'];?>">
                <input type="submit" class="btn btn-dark btn-lg" name="update" value="Update">
            </div>
        </form>

        <div class="errors">
            <?php 
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo "<div class='error'> <b>" . $error . "</b> <br> </div>";    
                    }
                    
                    // Reset errors after displaying them
                    reset_errors();
                }
            ?>
        </div>
    </div>
</body>
</html>
