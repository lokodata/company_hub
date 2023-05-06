<?php 
    session_start();

    // if session not logged in OR accountype not admin go to login
    if (!isset($_SESSION["user"]) OR $_SESSION["account_type"] !== "Admin") {
        header("Location: login.php");
        die();
    }

    require_once "connect.php";
    require_once "errors.php";

    // Gets all output of each forms
    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $repeatpassword = $_POST["repeatpassword"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $datehired = $_POST["datehired"];
        $position = $_POST["position"];
        $department = $_POST["department"];
        $salary = $_POST["salary"];
        $account_type = $_POST["account_type"];

        // Check if a form is empty 
        if (empty($username) OR empty($password) OR empty($firstname) OR empty($lastname) 
            OR empty($datehired) OR empty($position) OR empty($department) OR empty($salary) OR empty($repeatpassword)){
                push_error("All fields are required.");
        }
        // Check if password < 8
        if (strlen($password)<8){
            push_error("Password must be at least 8 characters long.");
        }
        // Check if password equal to repeat password
        if ($password!==$repeatpassword) {
            push_error("Password does not match.");
        }
        // Check if username < 4
        if (strlen($username)<4){
            push_error("Username must be at least 4 characters long.");
        }

        // encrypting password
        $passwordhash = password_hash($password, PASSWORD_BCRYPT);

        // Check if username already exist
        $query = "SELECT * FROM employeetbl WHERE username = '$username'";
        $userresult = mysqli_query($conn, $query);
        $userrowcount = mysqli_num_rows($userresult);
        if ($userrowcount>0) {
            push_error("Username already exists!");
        }

        // Check if there is any errors, if there is then echo the error
        if (empty($errors)){
            $query = "INSERT INTO employeetbl (username, password, firstname, lastname, datehired, position, department, salary, account_type) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt, $query);


            if ($preparestmt) {
                mysqli_stmt_bind_param($stmt,"sssssssss", $username, $passwordhash, $firstname, $lastname, $datehired, $position, $department, $salary, $account_type);
                mysqli_stmt_execute($stmt);

                header("Location: admin.php");

            } else {
                die("Something went wrong.");
            }
        }
    }            
?>

<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/add_account.css">
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
            <h3>Add Account</h3>
        </div>

        <form action="add_account.php" method="post" class="row form">
            <div class="col-md-12">
                <label class="form-label" for="username">USERNAME</label>  
                <input type="text" class="form-control form-control-md" name="username" placeholder="Username ">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="password">PASSWORD</label>  
                <input type="password" class="form-control form-control-md" name="password" placeholder="Password ">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="password">REPEAT PASSWORD</label>  
                <input type="password" class="form-control form-control-md" name="repeatpassword" placeholder="Repeat Password ">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="fistname">FIRST NAME</label>  
                <input type="text" class="form-control form-control-md" name="firstname" placeholder="First Name ">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="lastname">LAST NAME</label>  
                <input type="text" class="form-control form-control-md" name="lastname" placeholder="Last Name ">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="datehired">DATE HIRED</label>  
                <input type="date" class="form-control form-control-md" name="datehired">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="position">POSITION</label>  
                <input type="text" class="form-control form-control-md" name="position" placeholder="Position ">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="department">DEPARTMENT</label>  
                <input type="text" class="form-control form-control-md" name="department" placeholder="Department ">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="salary">SALARY</label>  
                <input type="number" class="form-control form-control-md" name="salary" placeholder="Salary ">
            </div>
            <div class="col-md-12"> 
                <label class="form-label" for="account_type">ACCOUNT TYPE</label>
                <select class="form-control form-control-md" name="account_type">
                    <option>User</option>
                    <option>Admin</option>
                </select>   
            </div>
            <div class="col button">
                <input type="submit" class="btn btn-dark btn-lg" name="submit" value="Create Account">
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