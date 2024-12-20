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

// Handle Search and Pagination
$searchTerm = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$limit = 10; // Rows per page
$offset = ($page - 1) * $limit;

// Build WHERE clause based on search
$whereClause = "";

if (!empty($searchTerm)) {
    $whereClause = "
        WHERE 
            d.shipmentID LIKE '%$searchTerm%' OR 
            p.product_name LIKE '%$searchTerm%' OR 
            w.Sub_district LIKE '%$searchTerm%' OR
            d.status LIKE '%$searchTerm%'
    ";
}

// Fetch total rows for pagination
$totalQuery = "
    SELECT COUNT(*) as totalRows
    FROM delivery_t d
    JOIN processed_batch_t pb ON d.pbatchID = pb.pbatchID
    JOIN lot_t l ON pb.lotID = l.lotID
    JOIN product_t p ON l.productID = p.productID
    JOIN warehouse_t w ON d.warehouseID = w.warehouseID
    $whereClause
";
$totalResult = $conn->query($totalQuery);
$totalRows = $totalResult->fetch_assoc()['totalRows'];
$totalPages = ceil($totalRows / $limit);

// Fetch paginated stock history data
$query = "
    SELECT 
        d.shipmentID,
        p.product_name,
        w.Sub_district AS warehouse_location,
        d.status,
        d.shipment_date,
        pb.weight,
        pb.quantity
    FROM 
        delivery_t d
    JOIN 
        processed_batch_t pb ON d.pbatchID = pb.pbatchID
    JOIN 
        lot_t l ON pb.lotID = l.lotID
    JOIN 
        product_t p ON l.productID = p.productID
    JOIN 
        warehouse_t w ON d.warehouseID = w.warehouseID
    $whereClause
    ORDER BY d.shipment_date DESC
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($query);
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
            <a href="warehousehistory.php">
              <i class='bx bx-history'></i>
              <span class="link_name">History</span>
            </a>
        
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
          
        </div>
        <div class="container mt-5">
        <h2 class="text-center">History of Stock</h2>

        <!-- Search Form -->
        <form method="GET" action="warehousehistory.php" class="mb-4">
            <div class="input-group">
                <input 
                    type="text" 
                    class="form-control" 
                    name="search" 
                    placeholder="Search by Shipment ID, Product Name, Warehouse, or Status"
                    value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <!-- Stock History Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Shipment ID</th>
                        <th>Product Name</th>
                        <th>Warehouse Location</th>
                        <th>Status</th>
                        <th>Shipment Date</th>
                        <th>Weight (KG)</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['shipmentID']; ?></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['warehouse_location']; ?></td>
                                <td>
                                    <span class="badge 
                                        <?php echo $row['status'] === 'In Stock' ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo $row['shipment_date']; ?></td>
                                <td><?php echo $row['weight']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <a 
                href="?page=<?php echo max($page - 1, 1); ?>&search=<?php echo urlencode($searchTerm); ?>" 
                class="btn btn-secondary <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                Previous
            </a>
            <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
            <a 
                href="?page=<?php echo min($page + 1, $totalPages); ?>&search=<?php echo urlencode($searchTerm); ?>" 
                class="btn btn-secondary <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                Next
            </a>
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

</body>

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
