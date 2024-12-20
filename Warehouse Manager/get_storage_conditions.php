<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traceroots";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$warehouseID = isset($_GET['warehouseID']) ? (int)$_GET['warehouseID'] : 0;

$query = "SELECT Temperature AS temperature, Humidity_level AS humidity, Sub_district AS warehouseName 
          FROM warehouse_t 
          WHERE warehouseID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $warehouseID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'temperature' => (float)$row['temperature'],
        'humidity' => (float)$row['humidity'],
        'warehouseName' => $row['warehouseName'],
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found for the selected warehouse']);
}

$stmt->close();
$conn->close();
?>
