<?php
    session_start();

    require_once "connect.php";
    require_once "errors.php";

    // if user logged in, go to appropriate index page
    if (isset($_SESSION["user"])) {
        if ($_SESSION["account_type"] == "Admin") {
            header("Location: admin.php");
        } else if ($_SESSION["account_type"] == "User") {
            header("Location: employee.php");
        }
        die();
    }

    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // look for the user in database
        $query = "SELECT * FROM employeetbl WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $account_type = $user["account_type"];

            // check username and password
            if ($user && password_verify($password, $user["password"])) {
                // create a session
                $_SESSION["user"] = $username;
                $_SESSION["account_type"] = $account_type;
                $_SESSION["firstname"] = $user["firstname"];
                $_SESSION["lastname"] = $user["lastname"];
                $_SESSION["employee_id"] = $user["employee_id"];
                $_SESSION["department"] = $user["department"];

                // redirect to appropriate index page
                if ($account_type == "Admin") {
                    header("Location: admin.php");
                } else if ($account_type == "User") {
                    header("Location: employee.php");
                }
            } else {
                push_error("<p> <b> Incorrect password. </b> </p>");
            }
        } else {
            push_error(" <p> <b> Username does not exist.</b> </p>");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/login.css">
</head>
<body>
    <div class="container-fluid container">
        <div class="col">
            <div class="row-sm-6 top row">
                <div class="logo">  
                    <img src="img/logo.png" height="80" width="80" alt="Logo">
                    <h1><b>Logo Name</b></h1>
                </div>
            </div>

            <div class="row-sm-6 bottom row">
                <div class="form">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <span> <img src="img/person.png" height="40" width="40" alt="Person"> </span> 
                            <input type="username" placeholder="Username" name="username" class="form-control-lg border-0">
                        </div>
                        <div class="form-group">
                            <span> <img src="img/lock.png" height="40" width="40" alt="Lock"> </span> 
                            <input type="password" placeholder="Password" name="password" class="form-control-lg border-0">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="LOG IN" name="login" class="btn btn-dark btn-lg">
                        </div>
                    </form>
                    <div class="register">
                        <p><a href="register.php"><b>Register now</b></a></p>
                    </div>
                </div>
                
                <div class="error">
                    <?php 
                        if (!empty($errors)) {
                            foreach ($errors as $error) {
                                echo $error;
                            }
                            
                            // Reset errors after displaying them
                            reset_errors();
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>