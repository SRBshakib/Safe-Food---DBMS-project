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

$query = "
    SELECT 
        wi.productID, 
        p.product_name, 
        p.product_type, 
        SUM(wi.quantity) AS quantity, 
        SUM(wi.weight) AS weight 
    FROM 
        w_inventory_t wi
    JOIN 
        product_t p ON wi.productID = p.productID
    WHERE 
        wi.warehouseID = ?
    GROUP BY 
        wi.productID
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $warehouseID);
$stmt->execute();
$result = $stmt->get_result();

$inventory = [];
while ($row = $result->fetch_assoc()) {
    $inventory[] = $row;
}

if (!empty($inventory)) {
    echo json_encode(['success' => true, 'inventory' => $inventory]);
} else {
    echo json_encode(['success' => false, 'message' => 'No inventory data found for this warehouse']);
}

$stmt->close();
$conn->close();
?>
