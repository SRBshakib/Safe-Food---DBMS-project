<?php
// Database connection
$servername = "localhost";
$username = "root"; // replace with your username
$password = ""; // replace with your password
$dbname = "traceroots"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Handle the "Receive" button click
if (isset($_GET['receive'])) {
  $shipmentID = $_GET['receive']; // Get the shipmentID from the query parameter

  // Fetch the necessary data for insertion or update in w_inventory_t
  $fetchDataQuery = "
      SELECT 
          d.warehouseID, 
          d.pbatchID, 
          l.productID, 
          pb.weight, 
          pb.quantity 
      FROM 
          delivery_t d
      JOIN 
          processed_batch_t pb ON d.pbatchID = pb.pbatchID
      JOIN 
          lot_t l ON pb.lotID = l.lotID
      WHERE 
          d.shipmentID = ?";
  $stmt = $conn->prepare($fetchDataQuery);
  $stmt->bind_param("i", $shipmentID);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $data = $result->fetch_assoc();
      $warehouseID = $data['warehouseID'];
      $pbatchID = $data['pbatchID'];
      $productID = $data['productID'];
      $weight = $data['weight'];
      $quantity = $data['quantity'];

      // Check if the batch already exists in w_inventory_t
      $checkInventoryQuery = "SELECT * FROM w_inventory_t WHERE warehouseID = ? AND pbatchID = ?";
      $stmt = $conn->prepare($checkInventoryQuery);
      $stmt->bind_param("ii", $warehouseID, $pbatchID);
      $stmt->execute();
      $inventoryResult = $stmt->get_result();

      if ($inventoryResult->num_rows > 0) {
          // If batch exists, no additional action is taken
          echo "<script>alert('This batch is already recorded in the inventory. Updating status in delivery_t.');</script>";
      } else {
          // Insert the data into w_inventory_t
          $insertInventoryQuery = "
              INSERT INTO w_inventory_t (warehouseID, pbatchID, productID, weight, quantity) 
              VALUES (?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($insertInventoryQuery);
          $stmt->bind_param("iiidd", $warehouseID, $pbatchID, $productID, $weight, $quantity);

          if ($stmt->execute()) {
              echo "<script>alert('Batch successfully added to inventory!');</script>";
          } else {
              echo "<script>alert('Error inserting data into inventory: " . $conn->error . "');</script>";
          }
      }

      // Update the status of the delivery_t entry
      $updateDeliveryQuery = "UPDATE delivery_t SET status = 'Received' WHERE shipmentID = ?";
      $stmt = $conn->prepare($updateDeliveryQuery);
      $stmt->bind_param("i", $shipmentID);
      if ($stmt->execute()) {
          echo "<script>alert('Delivery status updated to Received.');</script>";
      } else {
          echo "<script>alert('Error updating delivery status: " . $conn->error . "');</script>";
      }
  } else {
      echo "<script>alert('No valid data found for the specified shipment ID.');</script>";
  }
}

// Fetch data for the dropdown
$warehouseID = isset($_POST['warehouseID']) ? $_POST['warehouseID'] : null;
$warehouseQuery = "SELECT warehouseID FROM warehouse_t";
$warehouses = $conn->query($warehouseQuery);

// Fetch pending shipments for the selected warehouse
$result = null;
if ($warehouseID) {
  $fetchPendingShipmentsQuery = "
      SELECT 
          d.shipmentID, 
          d.shipment_date, 
          f.farmName, 
          p.product_name, 
          pb.weight, 
          pb.quantity, 
          d.status,
          p.shelf_life,
          p.temp,
          p.humidity,
          p.mrp
      FROM 
          delivery_t d
      JOIN 
          processed_batch_t pb ON d.pbatchID = pb.pbatchID
      JOIN 
          lot_t l ON pb.lotID = l.lotID
      JOIN 
          product_t p ON l.productID = p.productID
      JOIN 
          farm_t f ON l.farmID = f.farmID
      WHERE 
          d.status = 'Pending' AND d.warehouseID = ?";
  $stmt = $conn->prepare($fetchPendingShipmentsQuery);
  $stmt->bind_param("i", $warehouseID);
  $stmt->execute();
  $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Manager</title>
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
          <span class="logo_name">Safe Food</span>
        </div>
        <ul class="nav-links">
          <li>
            <a href="warehouse_manager.php">
              <i class='bx bx-grid-alt' ></i>
              <span class="link_name">Dashboard</span>
            </a>
            
          </li>

          <li>
          <a href="reciveproduct.php">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="link_name">Recive Product</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#"></a></li>
            </ul>
          </li>
          <li>
            <a href="retailerOrder.php">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">Retailer Order</span>
            </a>
          </li>
          <li>
            <a href="order_index.html">
              <i class='bx bx-history'></i>
              <span class="link_name">Orders</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#"></a></li>
            </ul>
          </li>
          <li>
            <a href="pending_users.php">
              <i class='bx bx-support' ></i>
              <span class="link_name">Users</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class='bx bx-cog' ></i>
              <span class="link_name">Settings</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#"></a></li>
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
            <div class="profile_name">Mr. Admin</div>
            <div class="job">Administrator</div>
          </div>
          <i class='bx bx-log-out' ></i>
        </div>
      </li>
    </ul>
      </div>
      <section class="home-section">
      <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <h3>Receive Pending Shipments</h3>
            </div>
            <div class="card-body">
                <!-- Warehouse Selection Form -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="warehouseID">Select Warehouse:</label>
                        <select class="form-control" id="warehouseID" name="warehouseID" onchange="this.form.submit()">
                            <option value="">-- Select Warehouse --</option>
                            <?php while ($warehouse = $warehouses->fetch_assoc()): ?>
                                <option value="<?php echo $warehouse['warehouseID']; ?>" <?php echo ($warehouse['warehouseID'] == $warehouseID) ? 'selected' : ''; ?>>
                                    Warehouse ID: <?php echo $warehouse['warehouseID']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </form>

                <?php if ($result && $result->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Shipment ID</th>
                                <th>Shipment Date</th>
                                <th>Farm Name</th>
                                <th>Product Name</th>
                                <th>Shelf Life</th>
                                <th>Temperature</th>
                                <th>Humidity</th>
                                <th>MRP</th>
                                <th>Weight</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['shipmentID']; ?></td>
                                    <td><?php echo $row['shipment_date']; ?></td>
                                    <td><?php echo $row['farmName']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['shelf_life']; ?></td>
                                    <td><?php echo $row['temp']; ?>°C</td>
                                    <td><?php echo $row['humidity']; ?>%</td>
                                    <td>৳<?php echo $row['mrp']; ?></td>
                                    <td><?php echo $row['weight']; ?> kg</td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <!-- Receive Button -->
                                        <a href="?receive=<?php echo $row['shipmentID']; ?>" class="btn btn-success btn-sm">
                                            Receive
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php elseif ($result && $result->num_rows == 0): ?>
                    <p>No pending shipments found for this warehouse.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal for confirming receive -->
    <div class="modal" id="statusModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Status Change Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>The status of the shipment has been successfully updated to <strong>"Received"</strong>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
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
<!-- jQuery, Popper.js, and Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
<?php
// Close connection
$conn->close();
?>