
<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "traceroots"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch distinct retailers
$retailerQuery = "SELECT retailerID, firstname, lastname FROM retailers_t";
$retailerResult = $conn->query($retailerQuery);

// Fetch pending orders for a selected retailer
$pendingOrders = [];
if (isset($_POST['retailerID']) && !empty($_POST['retailerID'])) {
    $retailerID = (int)$_POST['retailerID'];
    $orderQuery = "
        SELECT 
            po.orderID,
            po.retailerID,
            po.warehouseID,
            w.district AS warehouse_district,
            p.product_name,
            po.weight,
            po.quantity,
            po.order_date,
            po.order_time,
            po.status
        FROM 
            purchase_order_t po
        JOIN 
            processed_batch_t pb ON po.pbatchID = pb.pbatchID
        JOIN 
            lot_t l ON pb.lotID = l.lotID
        JOIN 
            product_t p ON l.productID = p.productID
        JOIN 
            warehouse_t w ON po.warehouseID = w.warehouseID
        WHERE 
            po.retailerID = ? AND po.status = 'Pending'";
    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param("i", $retailerID);
    $stmt->execute();
    $result = $stmt->get_result();
    $pendingOrders = $result->fetch_all(MYSQLI_ASSOC);
}

// Handle Ready action
if (isset($_POST['readyOrder']) && isset($_POST['orderID'])) {
    $orderID = (int)$_POST['orderID'];

    $updateQuery = "UPDATE purchase_order_t SET status = 'Ready' WHERE orderID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $orderID);

    if ($stmt->execute()) {
        echo "<script>alert('Order status updated to Ready!');</script>";
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
    <title>Warehouse Manager Dashboard</title>
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
              <li><a class="link_name" href="#">Analytics</a></li>
            </ul>
          </li>
          <li>
            <a href="retailerOrder.php">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">Retailer Order</span>
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
            <div class="profile_name">Kamal Hasan</div>
            <div class="job">Warehouse Manager</div>
          </div>
          <i class='bx bx-log-out' ></i>
        </div>
      </li>
    </ul>
      </div>
      <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Warehouse Manager Dashboard</span>
        </div>
       
        <div class="container mt-5">
        <h3 class="mb-4">Retailer Order Management</h3>
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

        <!-- Pending Orders Table -->
        <?php if (!empty($pendingOrders)): ?>
            <div class="card shadow-sm rounded-table">
                <div class="card-body">
                    <h5 class="card-title">Pending Orders</h5>
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
                                    <th>Order Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingOrders as $order): ?>
                                    <tr>
                                        <td><?php echo $order['orderID']; ?></td>
                                        <td><?php echo $order['retailerID']; ?></td>
                                        <td><?php echo "WH-" . $order['warehouseID'] . " (" . $order['warehouse_district'] . ")"; ?></td>
                                        <td><?php echo $order['product_name']; ?></td>
                                        <td><?php echo $order['weight']; ?></td>
                                        <td><?php echo $order['quantity']; ?></td>
                                        <td><?php echo $order['order_date']; ?></td>
                                        <td><?php echo $order['order_time']; ?></td>
                                        <td><?php echo $order['status']; ?></td>
                                        <td>
                                            <form method="POST" action="">
                                                <input type="hidden" name="orderID" value="<?php echo $order['orderID']; ?>">
                                                <button type="submit" name="readyOrder" class="btn btn-success btn-sm">Ready</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php elseif (isset($_POST['retailerID'])): ?>
            <p class="text-center mt-4">No pending orders for the selected retailer.</p>
        <?php endif; ?>
    </div>
</body>
<script>
    $(document).ready(function () {
        $("#retailerID").change(function () {
            this.form.submit();
        });
    });
</script>
<script>
document.querySelectorAll('.retailer-details').forEach(button => {
    button.addEventListener('click', function () {
        const retailerID = this.getAttribute('data-retailer-id');

        // Make an AJAX request to fetch retailer details
        fetch('fetch_retailer_details.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `retailerID=${retailerID}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Populate modal with retailer details
                    const modalBody = document.querySelector('#retailerDetailsModal .modal-body');
                    modalBody.innerHTML = `
                        <p><strong>First Name:</strong> ${data.details.firstname}</p>
                        <p><strong>Last Name:</strong> ${data.details.lastname}</p>
                        <p><strong>Gender:</strong> ${data.details.gender}</p>
                        <p><strong>Username:</strong> ${data.details.username}</p>
                        <p><strong>Email:</strong> ${data.details.email}</p>
                        <p><strong>Status:</strong> ${data.details.status}</p>
                        <p><strong>Affiliation Date:</strong> ${data.details.affiliation_date}</p>
                        <p><strong>Trade License:</strong> ${data.details.trade_license_no}</p>
                        <p><strong>Contact No:</strong> ${data.details.contactNO}</p>
                    `;

                    // Show the modal
                    const retailerModal = new bootstrap.Modal(document.getElementById('retailerDetailsModal'));
                    retailerModal.show();
                } else {
                    alert('Failed to fetch retailer details.');
                }
            })
            .catch(error => {
                console.error('Error fetching retailer details:', error);
                alert('An error occurred while fetching retailer details.');
            });
    });
});
</script>

      
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

</body>

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
