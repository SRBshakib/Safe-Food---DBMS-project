
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

// Pagination settings
$recordsPerPage = 10;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Fetch retailers for the dropdown
$retailerQuery = "SELECT retailerID, firstname, lastname FROM retailers_t";
$retailersResult = $conn->query($retailerQuery);

// Initialize filters
$selectedRetailerID = isset($_GET['retailerID']) ? (int)$_GET['retailerID'] : null;
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : "";

// Fetch total number of records for pagination
$countQuery = "
    SELECT COUNT(*) as total
    FROM purchase_order_t po
    JOIN retailers_t r ON po.retailerID = r.retailerID
    WHERE 1=1
";

if ($selectedRetailerID) {
    $countQuery .= " AND po.retailerID = $selectedRetailerID";
}
if (!empty($searchQuery)) {
    $countQuery .= " AND (po.status LIKE '%$searchQuery%' OR po.pbatchID LIKE '%$searchQuery%')";
}

$countResult = $conn->query($countQuery);
$totalRecords = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Fetch history records based on filters and pagination
$historyQuery = "
    SELECT po.orderID, po.weight, po.quantity, po.order_date, po.order_time, po.status, 
           r.firstname, r.lastname, po.pbatchID, po.warehouseID
    FROM purchase_order_t po
    JOIN retailers_t r ON po.retailerID = r.retailerID
    WHERE 1=1
";

if ($selectedRetailerID) {
    $historyQuery .= " AND po.retailerID = $selectedRetailerID";
}
if (!empty($searchQuery)) {
    $historyQuery .= " AND (po.status LIKE '%$searchQuery%' OR po.pbatchID LIKE '%$searchQuery%')";
}

$historyQuery .= " LIMIT $offset, $recordsPerPage";
$historyResult = $conn->query($historyQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer</title>
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
            <div class="profile_name">Rafik Ali</div>
            <div class="job">Farmer</div>
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
    <h2 class="text-center">Retailer Order History</h2>

    <!-- Filters -->
    <form method="GET" action="" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="retailerID" class="form-label">Select Retailer:</label>
            <select id="retailerID" name="retailerID" class="form-select" onchange="this.form.submit()">
                <option value="">-- All Retailers --</option>
                <?php while ($row = $retailersResult->fetch_assoc()): ?>
                    <option value="<?php echo $row['retailerID']; ?>" <?php echo ($selectedRetailerID == $row['retailerID']) ? 'selected' : ''; ?>>
                        <?php echo $row['firstname'] . " " . $row['lastname']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="searchQuery" class="form-label">Search:</label>
            <input type="text" id="searchQuery" name="searchQuery" class="form-control" placeholder="Search status or batch ID..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <!-- History Table -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th>Order ID</th>
                <th>Warehouse</th>
                <th>Batch ID</th>
                <th>Weight (KG)</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Order Time</th>
                <th>Status</th>
                <th>Retailer</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($historyResult->num_rows > 0): ?>
                <?php while ($row = $historyResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['orderID']; ?></td>
                        <td><?php echo "WH-" . $row['warehouseID']; ?></td>
                        <td><?php echo $row['pbatchID']; ?></td>
                        <td><?php echo $row['weight']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td><?php echo $row['order_time']; ?></td>
                        <td>
                            <?php if ($row['status'] === 'Delivered'): ?>
                                <span class="badge bg-success"><?php echo $row['status']; ?></span>
                            <?php elseif ($row['status'] === 'Pending'): ?>
                                <span class="badge bg-warning"><?php echo $row['status']; ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo $row['status']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No order history found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&retailerID=<?php echo $selectedRetailerID; ?>&searchQuery=<?php echo $searchQuery; ?>" tabindex="-1">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&retailerID=<?php echo $selectedRetailerID; ?>&searchQuery=<?php echo $searchQuery; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&retailerID=<?php echo $selectedRetailerID; ?>&searchQuery=<?php echo $searchQuery; ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>
</body>
    

      

     
  
                <!-- end of the page -->

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
