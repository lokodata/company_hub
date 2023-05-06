<?php 
    session_start();

    // if session not logged in OR accountype not user go to login
    if (!isset($_SESSION["user"]) OR $_SESSION["account_type"] !== "User") {
        header("Location: login.php");
        die();
    }

    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];

    require_once "connect.php";

    // check if search form submitted
    if (isset($_POST['submit'])) {
        $search_term = $_POST['search'];
        // query data from projectstbl based on search term
        $query = mysqli_query($conn, "SELECT * FROM projectstbl WHERE project_name LIKE '%$search_term%' OR employee_name LIKE '%$search_term%' OR
         project_cost = '$search_term' OR department LIKE '%$search_term%' OR project_id = '$search_term' OR project_description LIKE '%$search_term%'");
    } else {
        // query all the data from projectstbl
        $query = mysqli_query($conn, "SELECT * FROM projectstbl");
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/employee.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand" href="#">
            <img src="img/logo1.png" alt="Logo" width="30" height="30">
            Logo Name
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" 
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ms-auto">
                    <a href="logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid container">
        <div class="header">    
            <h1>Welcome Employee, <?php echo $firstname . ' ' . $lastname ?></h1>

            <h3>Manage Projects</h3>

            <div class="functions d-flex justify-content-between">
                <a href="add_project.php">
                    <button type="button" class="btn btn-outline-dark">Add New Project</button>
                </a>

                <form class="d-flex ms-auto" method="post">
                    <input class="form-control form-control-md" type="search" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-outline-dark" type="submit" name="submit">Search</button>
                </form>
            </div>
        </div>

   
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="trhead">
                        <td id="tr1"><strong>Project ID</strong></td>
                        <td id="tr1"><strong>Project Name</strong></td>
                        <td id="tr1"><strong>Employee Name</strong></td>
                        <td id="tr1"><strong>Employee ID</strong></td>
                        <td id="tr1"><strong>Department</strong></td>
                        <td id="tr1"><strong>Project Description</strong></td>
                        <td id="tr1"><strong>Project Cost</strong></td>
                        <td id="tr1"><strong>Project Start</strong></td>
                        <td id="tr1"><strong>Project Deadline</strong></td>
                        <td id="tr1"><strong>Project Duration</strong></td>
                        <td id="tr1"><strong>Project Time Remaining</strong></td>
                        <td id="tr1"><strong>Update</strong></td>
                        <td id="tr1"><strong>Delete</strong></td>
                    </tr>
                </thead>

                <tbody>
                    <?php while($row = mysqli_fetch_array($query)):?>
                    <tr>
                        <td><?php echo $row['project_id'];?></td>
                        <td><?php echo $row['project_name'];?></td>
                        <td><?php echo $row['employee_name'];?></td>
                        <td><?php echo $row['employee_id'];?></td>
                        <td><?php echo $row['department'];?></td>
                        <td><?php echo $row['project_description'];?></td>								
                        <td><?php echo $row['project_cost'];?></td>
                        <td><?php echo $row['project_start'];?></td>
                        <td><?php echo $row['project_deadline'];?></td>
                        <td><?php echo $row['project_duration'];?></td>
                        <td><?php echo $row['project_timeremaining'];?></td>
                        <td>
                            <a href="update_project.php?project_id=<?php echo $row['project_id'];?>" class="update">
                            <img src="img/edit.png" width="15px" height="15px">
                            </a>
                        </td>
                        <td>
                            <a href="delete.php?project_id=<?php echo $row['project_id'];?>" class="delete" onclick="return confirm('Are you sure you want to delete this Project?')">
                            <img src="img/delete.png" width="15px" height="15px">
                            </a>
                        </td>
                    </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
        </div>

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