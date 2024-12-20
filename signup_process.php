<?php
session_start(); // Start the session

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "traceroots");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['signup'])) {

    // Sanitize user inputs
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $sub_district = mysqli_real_escape_string($conn, $_POST['sub-district']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $division = mysqli_real_escape_string($conn, $_POST['division']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact-no']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fields based on category
    $driving_license_no = isset($_POST['driving-license-no']) ? mysqli_real_escape_string($conn, $_POST['driving-license-no']) : '';
    $trade_license_no = isset($_POST['trade-license-no']) ? mysqli_real_escape_string($conn, $_POST['trade-license-no']) : '';
    $qc_license_no = isset($_POST['qc-license-no']) ? mysqli_real_escape_string($conn, $_POST['qc-license-no']) : '';
    $warehouse_name = isset($_POST['warehouse-name']) ? mysqli_real_escape_string($conn, $_POST['warehouse-name']) : '';
    $warehouse_district = isset($_POST['warehouse-district']) ? mysqli_real_escape_string($conn, $_POST['warehouse-district']) : '';
    $warehouse_division = isset($_POST['warehouse-division']) ? mysqli_real_escape_string($conn, $_POST['warehouse-division']) : '';
    $warehouse_capacity = isset($_POST['warehouse-capacity']) ? mysqli_real_escape_string($conn, $_POST['warehouse-capacity']) : '';

    // Check if the username or email already exists
    $check_sql = "SELECT * FROM pending_users_t WHERE Username = '$username' OR Email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Username or Email already exists. Please try a different one.";
    } else {
        // Construct the SQL query
        $sql = "INSERT INTO pending_users_t (category, first_name, last_name, gender, sub_district, district, division, contact_no, email, username, password, driving_license_no, trade_license_no, qc_license_no, warehouse_name, warehouse_district, warehouse_division, warehouse_capacity)
                VALUES ('$category', '$first_name', '$last_name', '$gender', '$sub_district', '$district', '$division', '$contact_no', '$email', '$username', '$password', '$driving_license_no', '$trade_license_no', '$qc_license_no', '$warehouse_name', '$warehouse_district', '$warehouse_division', '$warehouse_capacity')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo "Sign up successful! Please wait for admin approval.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
