<?php
// Database connection
$servername = "localhost";
$username = "root"; // replace with your username
$password = ""; // replace with your password
$dbname = "traceroots"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch QCO IDs for the dropdown
$qcoQuery = "SELECT qcoID FROM quality_control_officers_t"; // Replace with your QCO table name
$qcos = $conn->query($qcoQuery);

// Handle rating submission
if (isset($_POST['submit_rating'])) {
    $shipmentID = (int)$_POST['shipmentID'];
    $rating = (int)$_POST['rating'];
    $productID = (int)$_POST['productID'];
    $qcoID = (int)$_POST['qcoID'];

    // Fetch warehouseID and batch details from delivery_t
    $fetchDetailsQuery = "
        SELECT d.warehouseID, d.pbatchID, pb.weight, pb.quantity
        FROM delivery_t d
        JOIN processed_batch_t pb ON d.pbatchID = pb.pbatchID
        WHERE d.shipmentID = ?";
    $stmt = $conn->prepare($fetchDetailsQuery);
    $stmt->bind_param("i", $shipmentID);
    $stmt->execute();
    $detailsResult = $stmt->get_result();

    if ($detailsResult->num_rows > 0) {
        $detailsRow = $detailsResult->fetch_assoc();
        $warehouseID = (int)$detailsRow['warehouseID'];
        $pbatchID = (int)$detailsRow['pbatchID'];
        $batchWeight = (float)$detailsRow['weight'];
        $batchQuantity = (int)$detailsRow['quantity'];

        // Insert into inspection_report_t
        $insertReportQuery = "
            INSERT INTO inspection_report_t (time, date, productID, qcoID, warehouseID, shipmentID, wRating)
            VALUES (NOW(), CURDATE(), ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertReportQuery);
        $stmt->bind_param("iiiid", $productID, $qcoID, $warehouseID, $shipmentID, $rating);
        $stmt->execute();

        // Check if the batch already exists in w_inventory_t
        $checkInventoryQuery = "SELECT * FROM w_inventory_t WHERE warehouseID = ? AND pbatchID = ?";
        $stmt = $conn->prepare($checkInventoryQuery);
        $stmt->bind_param("ii", $warehouseID, $pbatchID);
        $stmt->execute();
        $inventoryResult = $stmt->get_result();

        if ($inventoryResult->num_rows > 0) {
            echo "<script>alert('This batch already exists in the inventory.');</script>";
        } else {
            // Insert a new record into w_inventory_t
            $insertInventoryQuery = "
                INSERT INTO w_inventory_t (warehouseID, pbatchID, productID, weight, quantity)
                VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertInventoryQuery);
            $stmt->bind_param("iiidd", $warehouseID, $pbatchID, $productID, $batchWeight, $batchQuantity);

            if ($stmt->execute()) {
                // Update delivery_t status to 'In-Stock'
                $updateDeliveryQuery = "UPDATE delivery_t SET status = 'In-Stock' WHERE shipmentID = ?";
                $stmt = $conn->prepare($updateDeliveryQuery);
                $stmt->bind_param("i", $shipmentID);
                $stmt->execute();

                echo "<script>alert('Batch successfully added to inventory and rated!');</script>";
            } else {
                echo "<script>alert('Error inserting into inventory: " . $conn->error . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid Shipment ID or no associated data found.');</script>";
    }
}

// Fetch received batches for the selected warehouse
$warehouseQuery = "SELECT DISTINCT warehouseID FROM delivery_t";
$warehouses = $conn->query($warehouseQuery);

// Fetch data for display based on shipmentID
if (isset($_POST['warehouseID'])) {
    $warehouseID = (int)$_POST['warehouseID'];
    $sql = "
        SELECT d.shipmentID, d.shipment_date, p.product_name, pb.weight, pb.quantity, pb.rating, d.status, p.productID
        FROM delivery_t d
        JOIN processed_batch_t pb ON d.pbatchID = pb.pbatchID
        JOIN lot_t l ON pb.lotID = l.lotID
        JOIN product_t p ON l.productID = p.productID
        WHERE d.warehouseID = ? AND d.status = 'Received'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $warehouseID);
    $stmt->execute();
    $receivedBatchesResult = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quality Control Officer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Link to custom CSS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</head>
<body>
<i class="bx bx-menu"></i>
    <div class="sidebar close">
        <div class="logo-details">
          <i class='bx bxl-c-plus-plus'></i>
          <span class="logo_name">TraceRoots</span>
        </div>
        <ul class="nav-links">
          <li>
            <a href="quality_officer_dashboard.php">
              <i class='bx bx-grid-alt' ></i>
              <span class="link_name">Dashboard</span>
            </a>
          </li>

          <li>
            <a href="qco_shelf_life.php">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="link_name">Set Shelf-Life</span>
            </a>
          </li>
          <li>
          <a href="certification_rating.php">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">Certification and Rating</span>
            </a>
          </li>
          <li>
            <a href="rateRecivedProduct.php">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">Check Recived Product</span>
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
            <div class="job">Quality Control Inspector</div>
          </div>
          <i class='bx bx-log-out' ></i>
        </div>
      </li>
    </ul>
      </div>
      <section class="home-section">
      <div class="container my-4">
    <h3>Received Batches</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label for="warehouseID">Select Warehouse:</label>
            <select class="form-control" id="warehouseID" name="warehouseID" onchange="this.form.submit()">
                <option value="">-- Select Warehouse --</option>
                <?php while ($warehouse = $warehouses->fetch_assoc()): ?>
                    <option value="<?php echo $warehouse['warehouseID']; ?>" <?php echo isset($warehouseID) && $warehouse['warehouseID'] == $warehouseID ? 'selected' : ''; ?>>
                        Warehouse ID: <?php echo $warehouse['warehouseID']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </form>

    <?php if (isset($receivedBatchesResult) && $receivedBatchesResult->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Shipment ID</th>
                <th>Shipment Date</th>
                <th>Product Name</th>
                <th>Weight</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Processed Batch Rating</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $receivedBatchesResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['shipmentID']; ?></td>
                    <td><?php echo $row['shipment_date']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['weight']; ?> kg</td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['rating']; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="setProductDetails(<?php echo $row['productID']; ?>, <?php echo $row['shipmentID']; ?>)">
                            Rate
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No received products found for this warehouse.</p>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Enter Rating</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="shipmentID" name="shipmentID">
                    <input type="hidden" id="productID" name="productID">
                    <div class="form-group">
                        <label for="rating">Rating:</label>
                        <input type="number" class="form-control" id="rating" name="rating" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="qcoID">Select QCO:</label>
                        <select class="form-control" id="qcoID" name="qcoID" required>
                            <?php while ($qco = $qcos->fetch_assoc()): ?>
                                <option value="<?php echo $qco['qcoID']; ?>"><?php echo $qco['qcoID']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" name="submit_rating" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setProductDetails(productID, shipmentID) {
        document.getElementById('productID').value = productID;
        document.getElementById('shipmentID').value = shipmentID;
    }
</script>

       
    </section>
    
    
     
  
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        let menuItems = document.querySelectorAll(".nav-links li");

        // Open sidebar when hovering over the sidebar button
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

 
</body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
