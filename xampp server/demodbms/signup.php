<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this with your database username
$password = ""; // Change this with your database password
$dbname = "traceroots2.0"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define messages
$success_message = $error_message = "";

// Process the form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $category = $_POST['category'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password
    $gender = $_POST['gender'];

    // Check if username already exists
    $checkUsernameQuery = "SELECT * FROM pending_users_t WHERE username = '$username'";
    $usernameResult = $conn->query($checkUsernameQuery);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM pending_users_t WHERE email = '$email'";
    $emailResult = $conn->query($checkEmailQuery);

    // If username or email already exists, show an error message
    if ($usernameResult->num_rows > 0) {
        $error_message = "Username already exists.";
    } elseif ($emailResult->num_rows > 0) {
        $error_message = "Email already exists.";
    } else {
        // Insert data into the pending_users_t table if no duplicates found
        $sql = "INSERT INTO pending_users_t (category, first_name, last_name, email, username, password, gender) 
                VALUES ('$category', '$first_name', '$last_name', '$email', '$username', '$password', '$gender')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Signup successful. Your account is pending approval.";

            // Redirect to the same page to avoid form resubmission on refresh
            header("Location: /demodbms/signup.php?success=1");
            exit();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}

// If success is set in the URL, show success message
if (isset($_GET['success'])) {
    $success_message = "Signup successful. Your account is pending approval.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 50px;
        }
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Signup Form</h2>
    
    <!-- Show success or error message -->
    <?php if (!empty($success_message)) { ?>
        <div class="alert alert-success text-center" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php } ?>

    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php } ?>

    <!-- Signup Form -->
    <form action="signup.php" method="POST">
        <div class="mb-3">
            <label for="category" class="form-label">Select Category:</label>
            <select id="category" name="category" class="form-select" required>
                <option value="farmer">Farmer</option>
                <option value="retailer">Retailer</option>
                <option value="quality_control_officer">Quality Control Officer</option>
                <option value="driver">Driver</option>
                <option value="warehouse_manager">Warehouse Manager</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" id="first_name" name="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" id="last_name" name="last_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <!-- Gender Selection -->
        <div class="mb-3">
            <label class="form-label">Gender:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="gender_male" name="gender" value="male" required>
                <label class="form-check-label" for="gender_male">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="gender_female" name="gender" value="female" required>
                <label class="form-check-label" for="gender_female">Female</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="gender_other" name="gender" value="other" required>
                <label class="form-check-label" for="gender_other">Other</label>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
    </form>
</div>

<!-- Add Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
