<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traceroots";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$batchID = isset($_GET['batchID']) ? (int)$_GET['batchID'] : 0;

$query = "SELECT f.farmName, f.district, pb.rating 
          FROM processed_batch_t pb
          JOIN lot_t l ON pb.lotID = l.lotID
          JOIN farm_t f ON l.farmID = f.farmID
          WHERE pb.pbatchID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $batchID);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
$conn->close();
?>
