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

// Fetch retailers for the dropdown
$retailerQuery = "SELECT retailerID, firstname, lastname FROM retailers_t";
$retailerResult = $conn->query($retailerQuery);

// Handle retailer selection
$selectedRetailerID = isset($_GET['retailerID']) ? (int)$_GET['retailerID'] : null;
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare base query for fetching inventory
$inventoryQuery = "
    SELECT 
        ri.productID, 
        p.product_name, 
        p.product_type, 
        ri.quantity, 
        ri.weight 
    FROM 
        retailer_inventory_t ri
    JOIN 
        product_t p ON ri.productID = p.productID
    WHERE 
        1 = 1";

// Filter by retailer if selected
if ($selectedRetailerID) {
    $inventoryQuery .= " AND ri.retailerID = $selectedRetailerID";
}

// Apply search filter if applicable
if (!empty($searchQuery)) {
    $searchQueryEscaped = $conn->real_escape_string($searchQuery);
    $inventoryQuery .= " AND (p.product_name LIKE '%$searchQueryEscaped%' OR p.product_type LIKE '%$searchQueryEscaped%')";
}

// Execute the query
$inventoryResult = $conn->query($inventoryQuery);

// Check for query execution errors
if (!$inventoryResult) {
    die("Query failed: " . $conn->error);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Retailer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Retailar.css"> <!-- Link to custom CSS -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <style>
        .low-stock { background-color: #f8d7da; } /* Red for less than 5kg */
        .medium-stock { background-color: #fff3cd; } /* Yellow for less than 15kg */
        .badge-low-stock { background-color: #dc3545; } /* Badge for low stock */
        .badge-medium-stock { background-color: #ffc107; } /* Badge for medium stock */
        .badge-in-stock { background-color: #28a745; } /* Badge for in-stock items */
    </style>

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

      <li>
        <div class="profile-details">
          <div class="profile-content">
            <!--<img src="image/profile.jpg" alt="profileImg">-->
          </div>
          <div class="name-job">
            <div class="profile_name">Abdullah Yousuf</div>
            <div class="job">Retailer</div>
          </div>
          <i class='bx bx-log-out'></i>
        </div>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu'></i>
      <span class="text">Retailer Dashboard</span>
    </div>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Retailer Inventory</h3>

        <!-- Retailer Selection -->
        <form method="GET" action="" class="mb-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="retailerID" class="form-label">Select Retailer:</label>
                    <select name="retailerID" id="retailerID" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Select Retailer --</option>
                        <?php while ($row = $retailerResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['retailerID']; ?>" 
                                <?php echo ($row['retailerID'] == $selectedRetailerID) ? 'selected' : ''; ?>>
                                <?php echo $row['firstname'] . " " . $row['lastname']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <!-- Search Bar -->
                    <label for="search" class="form-label">Search:</label>
                    <div class="input-group">
                        <input 
                            type="text" 
                            name="search" 
                            id="search"
                            class="form-control" 
                            placeholder="Search by Product Name or Category" 
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Inventory Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Weight (KG)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($inventoryResult->num_rows > 0): ?>
                        <?php while ($row = $inventoryResult->fetch_assoc()): ?>
                            <tr class="<?php 
                                if ($row['weight'] < 5) {
                                    echo 'low-stock';
                                } elseif ($row['weight'] < 15) {
                                    echo 'medium-stock';
                                } 
                            ?>">
                                <td><?php echo $row['productID']; ?></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['product_type']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['weight']; ?></td>
                                <td>
                                    <?php if ($row['weight'] < 5): ?>
                                        <span class="badge badge-low-stock">Low Stock</span>
                                    <?php elseif ($row['weight'] < 15): ?>
                                        <span class="badge badge-medium-stock">Medium Stock</span>
                                    <?php else: ?>
                                        <span class="badge badge-in-stock">In Stock</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No inventory data available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>



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


    // Sample data with quantities for each product category
const soldProductsData = {
  Vegetables: "50 kg",
  Fruits: "30 kg",
  Fish: "20 kg",
  Meats: "25 kg",
  Frozen_Food: "40 kg"
};

// Function to populate the list
function loadSoldProductsSummary() {
  const soldProductsList = document.getElementById("soldProductsList");
  soldProductsList.innerHTML = ''; // Clear existing content

  // Loop through each category in the data and create a list item
  for (const [category, quantity] of Object.entries(soldProductsData)) {
    const listItem = document.createElement("li");
    listItem.textContent = `${category}: ${quantity}`;
    soldProductsList.appendChild(listItem);
  }
}

// Call the function to load the summary on page load
document.addEventListener("DOMContentLoaded", loadSoldProductsSummary);

    // Initialize the time immediately on load
    updateTime();
  </script>
</body>

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>