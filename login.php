<?php
session_start(); // Start the session

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "traceroots");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    // Sanitize user input
    $userid = mysqli_real_escape_string($conn, $_POST['userid']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM user_t WHERE UserID = '$userid' AND Password = '$pass'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Store user data in session
        $_SESSION['user_id'] = $row['UserID'];
        $_SESSION['Category'] = $row['Category'];

        // Redirect based on user category
        if ($row['Category'] == "farmer") {
            header("Location: /demodbms/Farmer/farmer_dashboard.php");
            exit;
        } elseif ($row['Category'] == "retailer") {
            header("Location: /demodbms/Retailer/Dashboard.php");
            exit;
        } elseif ($row['Category'] == "warehouse_manager") {
            header("Location: /demodbms/Warehouse_Manager/warehouse_manager_dashboard.php");
            exit;
        } elseif ($row['Category'] == "quality_control_officer") {
            header("Location: /demodbms/Quality Control Officer/quality_officer_dashboard.php");
            exit;
        } elseif ($row['Category'] == "driver") {
            header("Location: /demodbms/Driver/driver_dashboard.php");
            exit;
        } else {
            echo "Invalid category.";
        }
    } else {
        echo "Invalid UserID or Password.";
    }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <title>TraceRoots</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <meta name="robots" content="noindex, follow">
</head>

<body>

<div class="limiter">
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-t-30 p-b-50">
                <span class="login100-form-title p-b-41">
                    Please Login
                </span>
                <form class="login100-form validate-form p-b-33 p-t-5" action="" method="POST">

                    <!-- UserID or Email input -->
                    <div class="wrap-input100 validate-input" data-validate="Enter username or email">
                        <input class="input100" type="text" name="userid" placeholder="Username or Email" required>
                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                    </div>

                    <!-- Password input -->
                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>

                    <!-- Category selection -->
                    <div class="wrap-input100 validate-input">
                        <select class="input100" name="category" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="farmer">Farmer</option>
                            <option value="retailer">Retailer</option>
                            <option value="warehouse_manager">Warehouse Manager</option>
                            <option value="quality_control_officer">Quality Control Officer</option>
                            <option value="driver">Driver</option>
                        </select>
                        <span class="focus-input100"></span>
                    </div>

                    <!-- Login button -->
                    <div class="container-login100-form-btn m-t-32">
                        <button class="login100-form-btn" name="login">
                            Login
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>
