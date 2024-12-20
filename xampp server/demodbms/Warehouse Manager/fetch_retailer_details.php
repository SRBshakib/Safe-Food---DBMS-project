<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "traceroots"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Fetch retailer details based on retailerID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['retailerID'])) {
    $retailerID = (int)$_POST['retailerID'];
    $query = "SELECT * FROM retailers_t WHERE retailerID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $retailerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $details = $result->fetch_assoc();
        echo json_encode(['success' => true, 'details' => $details]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Retailer not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
