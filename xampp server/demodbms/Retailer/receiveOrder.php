<?php
// Sample database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'traceroots';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch retailers for the selection dropdown
$retailerQuery = "SELECT retailerID, firstname, lastname FROM retailers_t";
$retailerResult = $conn->query($retailerQuery);

// Fetch ready orders for the selected retailer
$readyOrders = [];
if (isset($_POST['retailerID']) && !empty($_POST['retailerID'])) {
    $retailerID = (int)$_POST['retailerID'];
    $orderQuery = "
        SELECT 
            po.orderID, 
            po.weight, 
            po.quantity, 
            po.status, 
            r.firstname, 
            r.lastname, 
            w.warehouseID,
            p.product_name
        FROM 
            purchase_order_t po
        JOIN processed_batch_t pb ON po.pbatchID = pb.pbatchID
        JOIN lot_t l ON pb.lotID = l.lotID
        JOIN product_t p ON l.productID = p.productID
        JOIN retailers_t r ON po.retailerID = r.retailerID
        JOIN warehouse_t w ON po.warehouseID = w.warehouseID
        WHERE 
            po.status = 'Picked up' AND po.retailerID = ?";
    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param("i", $retailerID);
    $stmt->execute();
    $orderResult = $stmt->get_result();
    $readyOrders = $orderResult->fetch_all(MYSQLI_ASSOC);
}

// Handle Receive action
if (isset($_POST['receiveOrder']) && isset($_POST['orderID'])) {
    $orderID = (int)$_POST['orderID'];

    // Fetch the order details
    $orderDetailsQuery = "
        SELECT 
            po.retailerID, 
            po.weight, 
            po.quantity, 
            po.pbatchID, 
            po.warehouseID, 
            l.productID
        FROM 
            purchase_order_t po
        JOIN processed_batch_t pb ON po.pbatchID = pb.pbatchID
        JOIN lot_t l ON pb.lotID = l.lotID
        WHERE 
            po.orderID = ?";
    $stmt = $conn->prepare($orderDetailsQuery);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $orderDetailsResult = $stmt->get_result();

    if ($orderDetailsResult->num_rows > 0) {
        $orderDetails = $orderDetailsResult->fetch_assoc();
        $retailerID = $orderDetails['retailerID'];
        $productID = $orderDetails['productID'];
        $pbatchID = $orderDetails['pbatchID'];
        $weight = $orderDetails['weight'];
        $quantity = $orderDetails['quantity'];
        $warehouseID = $orderDetails['warehouseID'];

        // Update or insert into `retailer_inventory_t`
        $checkRetailerInventoryQuery = "
            SELECT * FROM retailer_inventory_t 
            WHERE retailerID = ? AND productID = ?";
        $checkStmt = $conn->prepare($checkRetailerInventoryQuery);
        $checkStmt->bind_param("ii", $retailerID, $productID);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Update retailer inventory
            $updateRetailerInventoryQuery = "
                UPDATE retailer_inventory_t 
                SET weight = weight + ?, 
                    quantity = quantity + ?, 
                    last_updated = NOW() 
                WHERE retailerID = ? AND productID = ?";
            $updateStmt = $conn->prepare($updateRetailerInventoryQuery);
            $updateStmt->bind_param("diii", $weight, $quantity, $retailerID, $productID);
            $updateStmt->execute();
        } else {
            // Insert into retailer inventory
            $insertRetailerInventoryQuery = "
                INSERT INTO retailer_inventory_t (retailerID, productID, weight, quantity, last_updated) 
                VALUES (?, ?, ?, ?, NOW())";
            $insertStmt = $conn->prepare($insertRetailerInventoryQuery);
            $insertStmt->bind_param("iidi", $retailerID, $productID, $weight, $quantity);
            $insertStmt->execute();
        }

        // Subtract from `warehouse_inventory_t`
        $updateWarehouseInventoryQuery = "
            UPDATE warehouse_inventory_t 
            SET weight = weight - ?, quantity = quantity - ? 
            WHERE warehouseID = ? AND productID = ?";
        $warehouseStmt = $conn->prepare($updateWarehouseInventoryQuery);
        $warehouseStmt->bind_param("diii", $weight, $quantity, $warehouseID, $productID);
        $warehouseStmt->execute();

        // Update the order status to 'Received'
        $updateOrderStatusQuery = "UPDATE purchase_order_t SET status = 'Received' WHERE orderID = ?";
        $orderStatusStmt = $conn->prepare($updateOrderStatusQuery);
        $orderStatusStmt->bind_param("i", $orderID);
        $orderStatusStmt->execute();

        echo "<script>alert('Order received and inventory updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to fetch order details.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Link to custom CSS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    
</head>
<body>
    <div class="sidebar close">
        <div class="logo-details">
          <i class='bx bxl-c-plus-plus'></i>
          <span class="logo_name">TraceRoots</span>
        </div>
        <ul class="nav-links">
        <li>
            <a href="retailerDashBoard.php">
              <i class='bx bx-grid-alt' ></i>
              <span class="link_name">Dashboard</span>
            </a>
          </li>
          <li>
        <a href="retailerInventroy.php">
          <i class='bx bx-history'></i>
          <span class="link_name">Inventory</span>
        </a>
          <li>
            <a href="reciveproduct.php">
            <i class='bx bx-transfer' ></i>
              <span class="link_name">Recive Product</span>
            </a>
            <
          </li>
          <li>
            <a href="retailerOrder.php">
            <i class='bx bxs-store'></i>
              <span class="link_name">Retailer Order</span>
            </a>
          </li>
          <li>
            <a href="history.php">
            <i class='bx bx-history' ></i>
              <span class="link_name">History</span>
            </a>
        
          </li>
          <li>
            <a href="settingsPage.php">
              <i class='bx bx-cog' ></i>
              <span class="link_name">Setting</span>
            </a>
           
          </li>
        <div class="profile-details">
          <div class="profile-content">
            <!--<img src="image/profile.jpg" alt="profileImg">-->
          </div>
          <div class="name-job">
            <div class="profile_name">Adnan Rahman</div>
            <div class="job">Driver</div>
          </div>
          <i class='bx bx-log-out' ></i>
        </div>
      </li>
    </ul>
      </div>
      <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Retailer Inventory Management</span>
        </div>
        <div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="mb-4">Retailer Inventory Management</h3>

            <!-- Retailer Selection Form -->
            <form method="POST" action="" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <label for="retailerID" class="form-label">Select Retailer:</label>
                        <select class="form-select" id="retailerID" name="retailerID" onchange="this.form.submit()" required>
                            <option value="">-- Select Retailer --</option>
                            <?php foreach ($retailerResult as $row): ?>
                                <option value="<?php echo $row['retailerID']; ?>" <?php echo (isset($_POST['retailerID']) && $_POST['retailerID'] == $row['retailerID']) ? 'selected' : ''; ?>>
                                    <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>

            <!-- Ready Orders Table -->
            <?php if (!empty($readyOrders)): ?>
                <div class="card shadow-sm rounded-table">
                    <div class="card-body">
                        <h5 class="card-title">Orders Ready for Retailers</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Retailer</th>
                                        <th>Warehouse</th>
                                        <th>Product Name</th>
                                        <th>Weight (KG)</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($readyOrders as $order): ?>
                                        <tr>
                                            <td><?php echo $order['orderID']; ?></td>
                                            <td><?php echo $order['firstname'] . " " . $order['lastname']; ?></td>
                                            <td><?php echo "WH-" . $order['warehouseID']; ?></td>
                                            <td><?php echo $order['product_name']; ?></td>
                                            <td><?php echo $order['weight']; ?></td>
                                            <td><?php echo $order['quantity']; ?></td>
                                            <td><?php echo $order['status']; ?></td>
                                            <td>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="orderID" value="<?php echo $order['orderID']; ?>">
                                                    <button type="submit" name="receiveOrder" class="btn btn-success btn-sm">Receive</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center mt-4">No orders ready for the selected retailer.</p>
            <?php endif; ?>
        </div>
    </div>
</div>



</section>



      <script>
 let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
let menuItems = document.querySelectorAll(".nav-links li");

// Open sidebar when mouse is over the menu button
sidebarBtn.addEventListener("mouseover", () => {
  sidebar.classList.remove("close");
});

// Open sidebar when hovering over any <li> item
menuItems.forEach((item) => {
  item.addEventListener("mouseover", () => {
    sidebar.classList.remove("close");
  });
});

// Close sidebar when mouse leaves the sidebar
sidebar.addEventListener("mouseout", () => {
  sidebar.classList.add("close");
});



      </script>
 <script>
  document.querySelector(".welcome-banner").addEventListener("mouseover", () => {
    document.querySelector(".img-1").style.animationPlayState = "paused";
});
document.querySelector(".welcome-banner").addEventListener("mouseout", () => {
    document.querySelector(".img-1").style.animationPlayState = "running";
});

 </script>
 <script>
  function updateTime() {
    const timerElement = document.getElementById("timer");
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';

    timerElement.textContent = `Time: ${hours}:${minutes}:${seconds} ${ampm}`;
}

// Update time every second
setInterval(updateTime, 1000);

// Initialize the time immediately on load
updateTime();
 </script>
</body>

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
