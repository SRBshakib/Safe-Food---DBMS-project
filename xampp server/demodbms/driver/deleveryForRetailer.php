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
// Fetch driver list
$driverQuery = "SELECT t.driverID, d.firstname, d.lastname, t.Vehicle_reg_no, t.Transport_capacity 
                FROM transport_t t
                JOIN drivers_t d ON t.driverID = d.driverID";
$driverResult = $conn->query($driverQuery);

// Fetch orders based on selected driver and transport capacity
$orders = [];
$transportCapacity = 0;

if (isset($_POST['driverID']) && !empty($_POST['driverID'])) {
    $driverID = (int)$_POST['driverID'];

    // Fetch transport capacity for the driver
    $capacityQuery = "SELECT Transport_capacity FROM transport_t WHERE driverID = ?";
    $capacityStmt = $conn->prepare($capacityQuery);
    $capacityStmt->bind_param("i", $driverID);
    $capacityStmt->execute();
    $capacityResult = $capacityStmt->get_result();

    if ($capacityResult->num_rows > 0) {
        $transportCapacity = $capacityResult->fetch_assoc()['Transport_capacity'];
    }

    // Fetch orders with weight <= transport capacity and status = 'Ready'
    $orderQuery = "
        SELECT 
            po.orderID, 
            po.retailerID, 
            po.warehouseID, 
            po.weight, 
            po.quantity, 
            po.status, 
            po.order_date, 
            w.district AS warehouse_district, 
            r.district AS retailer_district,
            p.product_name, 
            DATE_ADD(l.production_date, INTERVAL p.shelf_life DAY) AS expire_date
        FROM 
            purchase_order_t po
        JOIN processed_batch_t pb ON po.pbatchID = pb.pbatchID
        JOIN lot_t l ON pb.lotID = l.lotID
        JOIN product_t p ON l.productID = p.productID
        JOIN warehouse_t w ON po.warehouseID = w.warehouseID
        JOIN retailers_t r ON po.retailerID = r.retailerID
        WHERE 
            po.status = 'Ready' AND po.weight <= ?";
    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param("i", $transportCapacity);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
}

// Handle Pickup action
if (isset($_POST['pickupOrder']) && isset($_POST['orderID'])) {
    $orderID = (int)$_POST['orderID'];

    $updateQuery = "UPDATE purchase_order_t SET status = 'Picked up' WHERE orderID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $orderID);

    if ($stmt->execute()) {
        echo "<script>alert('Order status updated to Picked up!');</script>";
    } else {
        echo "<script>alert('Failed to update order status: " . $conn->error . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
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
            <a href="driverdashboard.php">
              <i class='bx bx-grid-alt' ></i>
              <span class="link_name">Dashboard</span>
            </a>
          </li>

          <li>
            <a href="deleveryForRetailer.php">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="link_name">Delevery For Retailers</span>
            </a>
          </li>
          <li>
          <a href="certification_rating.php">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">Certification and Rating</span>
            </a>
          </li>
        
          <li>
            <a href="#">
              <i class='bx bx-history'></i>
              <span class="link_name">History</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#">History</a></li>
            </ul>
          </li>
          <li>
            <a href="#">
              <i class='bx bx-cog' ></i>
              <span class="link_name">Setting</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#">Setting</a></li>
            </ul>
          </li>
          <li>
            <a href="#">
              <i class='bx bx-support' ></i>
              <span class="link_name">Help and Support</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#">Help and Support</a></li>
            </ul>
          </li>

          <li>
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
            <span class="text">Delevery For Retailers</span>
        </div>

        <div class="container mt-5">
        <h3 class="mb-4">Delivery for Retailers</h3>

        <!-- Driver Selection Form -->
        <form method="POST" action="" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <label for="driverID" class="form-label">Select Driver:</label>
                    <select class="form-select" id="driverID" name="driverID" onchange="this.form.submit()" required>
                        <option value="">-- Select Driver --</option>
                        <?php foreach ($driverResult as $row): ?>
                            <option value="<?php echo $row['driverID']; ?>" <?php echo (isset($_POST['driverID']) && $_POST['driverID'] == $row['driverID']) ? 'selected' : ''; ?>>
                                <?php echo "Driver: " . $row['firstname'] . " " . $row['lastname'] . " (Vehicle: " . $row['Vehicle_reg_no'] . ")"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>

        <!-- Orders Table -->
        <?php if (!empty($orders)): ?>
            <div class="card shadow-sm rounded-table">
                <div class="card-body">
                    <h5 class="card-title">Orders Ready for Pickup</h5>
                    <p><strong>Transport Capacity:</strong> <?php echo $transportCapacity; ?> KG</p>
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
                                    <th>Order Date</th>
                                    <th>Expire Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo $order['orderID']; ?></td>
                                        <td><?php echo $order['retailerID'] . " (" . $order['retailer_district'] . ")"; ?></td>
                                        <td><?php echo $order['warehouseID'] . " (" . $order['warehouse_district'] . ")"; ?></td>
                                        <td><?php echo $order['product_name']; ?></td>
                                        <td><?php echo $order['weight']; ?></td>
                                        <td><?php echo $order['quantity']; ?></td>
                                        <td><?php echo $order['order_date']; ?></td>
                                        <td><?php echo $order['expire_date']; ?></td>
                                        <td><?php echo $order['status']; ?></td>
                                        <td>
                                            <form method="POST" action="">
                                                <input type="hidden" name="orderID" value="<?php echo $order['orderID']; ?>">
                                                <button type="submit" name="pickupOrder" class="btn btn-success btn-sm">Pickup</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php elseif (isset($_POST['driverID'])): ?>
            <p class="text-center mt-4">No orders ready for pickup for the selected driver.</p>
        <?php endif; ?>
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
