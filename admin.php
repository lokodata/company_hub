<?php
    session_start();

    // if session not logged in OR accountype not admin go to login
    if (!isset($_SESSION["user"]) OR $_SESSION["account_type"] !== "Admin") {
        header("Location: login.php");
        die();
    }

    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];

    require_once "connect.php";

    // check if search form submitted
    if (isset($_POST['submit'])) {
        $search_term = $_POST['search'];

        // get checked positions and departments, if any
        $positions = isset($_POST['position']) ? $_POST['position'] : array();
        $departments = isset($_POST['department']) ? $_POST['department'] : array();
        $account_types = isset($_POST['account_type']) ? $_POST['account_type'] : array();
        $min_salary = $_POST['min_salary'];
        $max_salary = $_POST['max_salary'];
        $min_datehired = $_POST['min_datehired'];
        $max_datehired = $_POST['max_datehired'];

        // build query string for filter
        $query_str = "SELECT * FROM employeetbl";

        // check if positions, departments, account types, min salary, max salary, min datehired, and max datehired is empty
        if (!empty($positions) || !empty($departments) || !empty($account_types) || !empty($min_salary) || !empty($max_salary)
         || !empty($min_datehired) || !empty($max_datehired)) {
            $query_str .= " WHERE (";
            if (!empty($positions)) {
                foreach ($positions as $position) {
                    // add positions to query string
                    $query_str .= "position LIKE '%$position%' OR ";
                }
            }
            if (!empty($departments)) {
                foreach ($departments as $department) {
                    // add department to query string
                    $query_str .= "department LIKE '%$department%' OR ";
                }
            }
            if (!empty($account_types)) {
                foreach ($account_types as $account_type) {
                    // add account type to query string
                    $query_str .= "account_type LIKE '%$account_type%' OR ";
                }
            }
            if (!empty($min_salary) || !empty($max_salary)) {
                if (empty($min_salary)) {
                    // if min salary is empty make it 0
                    $min_salary = 0;
                }
                if (empty($max_salary)) {
                    // if max salary is empty make it the highest number
                    $max_salary = PHP_INT_MAX;
                }
                // add salary to query string
                $query_str .= "salary BETWEEN '".$min_salary."' AND '".$max_salary."' OR ";
            }
            if (!empty($min_datehired) || !empty($max_datehired)) {
                if (empty($min_datehired)) {
                    // if min datehired is empty make it the least date
                    $min_datehired = '1900-01-01';
                }
                if (empty($max_datehired)) {
                    // if max datehired is empty make it the current date
                    $max_datehired = date('Y-m-d');
                }
                // add datehired to query string
                $query_str .= "datehired BETWEEN '".$min_datehired."' AND '".$max_datehired."' OR ";
            }
            $query_str = rtrim($query_str, " OR "); // remove last 'OR'
            $query_str .= ")";
        }

        if (!empty($search_term) AND empty($positions) AND empty($departments) AND empty($account_types) AND empty($min_salary) 
        AND empty($max_salary) AND empty($min_datehired) AND empty($max_datehired)) {
            $query_str .= " WHERE (firstname LIKE '%$search_term%' OR lastname LIKE '%$search_term%' OR employee_id = '$search_term' OR salary = '$search_term' OR account_type LIKE '%$search_term%' OR username LIKE '%$search_term%')";
        } 
        
        if (!empty($search_term) || !empty($positions) || !empty($departments) || !empty($account_types) || !empty($min_salary) || !empty($max_salary)
        || !empty($min_datehired) || !empty($max_datehired)) {
            $query_str .= " AND (firstname LIKE '%$search_term%' OR lastname LIKE '%$search_term%' OR employee_id = '$search_term' OR salary = '$search_term' OR account_type LIKE '%$search_term%' OR username LIKE '%$search_term%')";
        }

        // query data from employeetbl based on search term and checked positions and departments
        $query = mysqli_query($conn, $query_str);
    } else {
        // query all the data from employeetbl
        $query = mysqli_query($conn, "SELECT * FROM employeetbl");
    }
    
    $result = mysqli_query($conn, "SELECT DISTINCT position, department, account_type FROM employeetbl");
    while ($row = mysqli_fetch_assoc($result)) {
        $positions[] = $row['position'];
        $departments[] = $row['department'];
        $account_types[] = $row['account_type'];
    }

    $positions = array_unique($positions);
    $departments = array_unique($departments);
    $account_types = array_unique($account_types);
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/admin.css">

</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
     
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand" href="#">
                <img src="img/logo1.png" alt="Logo" width="30" height="30">
                Logo Name
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon toggler"></span>
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

    <div class="container-fluid header">
        <h1>Welcome Admin, <?php echo $firstname . ' ' . $lastname ?></h1>

        <h3>Manage Accounts</h3>

        <div class="functions d-flex justify-content-between">
            <a href="add_account.php">
                <button type="button" class="btn btn-outline-dark ms-auto">Create New Account</button>
            </a>

            <a href="#" id="toggle-search-link"> <img src="img/search.png" height="35" width="35"> </a>
        </div>
    </div>

    
    <div class="container-fluid table_container overflow-auto">
        <div class="row">
            <div class="col-10 left flex-grow-1">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="trhead">
                                <td id="tr1"><strong>Employee ID</strong></td>
                                <td id="tr1"><strong>First Name</strong></td>
                                <td id="tr1"><strong>Last Name</strong></td>
                                <td id="tr1"><strong>Position</strong></td>
                                <td id="tr1"><strong>Department</strong></td>
                                <td id="tr1"><strong>Salary</strong></td>
                                <td id="tr1"><strong>Date Hired</strong></td>
                                <td id="tr1"><strong>Username</strong></td>
                                <td id="tr1"><strong>Password</strong></td>
                                <td id="tr1"><strong>Account Type</strong></td>
                                <td id="tr1"><strong>Update</strong></td>
                                <td id="tr1"><strong>Delete</strong></td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                if(mysqli_num_rows($query) > 0) {
                                    // there is at least one row
                                    while($row = mysqli_fetch_array($query)) {
                                        // do something with the row
                                        ?>
                                        <tr>
                                            <td><?php echo $row['employee_id'];?></td>
                                            <td><?php echo $row['firstname'];?></td>
                                            <td><?php echo $row['lastname'];?></td>                             
                                            <td><?php echo $row['position'];?></td>
                                            <td><?php echo $row['department'];?></td>
                                            <td><?php echo $row['salary'];?></td>
                                            <td><?php echo $row['datehired'];?></td>
                                            <td><?php echo $row['username'];?></td>
                                            <td><?php echo $row['password'];?></td>
                                            <td><?php echo $row['account_type'];?></td>
                                            <td>
                                                <a href="update_account.php?employee_id=<?php echo $row['employee_id'];?>" class="update">
                                                    <img src="img/edit.png" width="15px" height="15px">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="delete.php?employee_id=<?php echo $row['employee_id'];?>" class="delete" onclick="return confirm('Are you sure you want to delete this Account?')">
                                                    <img src="img/delete.png" width="15px" height="15px">
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    // there are no rows
                                    echo "<tr><td colspan='11'>No rows found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-2 right flex-grow-1">
                <form class="form" method="post">
                    <div class="input-group col-10">
                        <input class="form-control form-control-md input_search" type="search" placeholder="Search" aria-label="Search" name="search">
                        <button class="btn btn-outline-dark" type="submit" name="submit">Search</button>
                    </div>

                    <h5 class='filter_title'>Search Filter</h5>

                    <div class="col-12">
                        <label for="" class="form-label">Position</label>
                        <?php foreach ( $positions as $position ) {
                            echo  "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='$position' id='$position' name='position[]'>
                                    <label class='form-check-label' for='$position'>
                                            $position
                                        </label>
                                    </div>";
                            }
                        ?>
                    </div>

                    <div class="col-12">
                        <label for="" class="form-label">Department</label>
                        <?php foreach ( $departments as $department ) {
                            echo  "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='$department' id='$department' name='department[]'>
                                    <label class='form-check-label' for='$department'>
                                            $department
                                        </label>
                                    </div>";
                            }
                        ?>
                    </div>

                    <div class="col-12">
                        <label for="" class="form-label">Salary</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" name="min_salary" placeholder="Min Salary">
                            <span class="input-group-text text-dark">-</span>
                            <input type="number" class="form-control" name="max_salary" placeholder="Max Salary">
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="" class="form-label">Date Hired</label>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" name="min_datehired" placeholder="Min Date Hired">
                            <span class="input-group-text text-dark">-</span>
                            <input type="date" class="form-control" name="max_datehired" placeholder="Max Date Hired">
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="" class="form-label">Account Type</label>
                        <?php foreach ( $account_types as $account_type ) {
                            echo  "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='$account_type' id='$account_type' name='account_type[]'>
                                    <label class='form-check-label' for='$account_type'>
                                            $account_type
                                        </label>
                                    </div>";
                            }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        const toggleLink = document.getElementById("toggle-search-link");
        const img = toggleLink.querySelector("img");

        toggleLink.addEventListener("click", function (event) {
            event.preventDefault();
            img.src = img.src.includes("search.png") ? "img/search1.png" : "img/search.png";
        });

        function toggleSearch() {
            var rightDiv = document.querySelector('.right');
            var leftDiv = document.querySelector('.left');

            var rightDivDisplayStyle = window.getComputedStyle(rightDiv).getPropertyValue('display');

            if (rightDivDisplayStyle === 'none') {
                rightDiv.style.display = 'block';
            } else {
                rightDiv.style.display = 'none';
            }
        }

        var toggleSearchLink = document.getElementById('toggle-search-link');
        toggleSearchLink.addEventListener('click', function(event) {
            event.preventDefault();
            toggleSearch();
        });
    </script>

</body>
</html>