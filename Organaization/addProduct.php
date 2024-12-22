<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traceroots";

$conn = new mysqli($servername, $username, $password, $dbname);

// Handle Add Product Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addProduct'])) {
    $productName = $_POST['product_name'];
    $mrp = $_POST['mrp'];
    $productType = $_POST['product_type'];

    $insertQuery = "INSERT INTO product_t (product_name, mrp, product_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sds", $productName, $mrp, $productType);
    if ($stmt->execute()) {
        $successMessage = "Product added successfully!";
    } else {
        $errorMessage = "Failed to add product. Please try again.";
    }
}

// Handle Update MRP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateMRP'])) {
    $productID = $_POST['product_id'];
    $updatedMRP = $_POST['updated_mrp'];

    $updateQuery = "UPDATE product_t SET mrp = ? WHERE productID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("di", $updatedMRP, $productID);
    if ($stmt->execute()) {
        $successMessage = "MRP updated successfully!";
    } else {
        $errorMessage = "Failed to update MRP. Please try again.";
    }
}

// Fetch Products
$search = isset($_GET['search']) ? $_GET['search'] : '';
$productQuery = "SELECT * FROM product_t WHERE product_name LIKE ? ORDER BY productID DESC";
$stmt = $conn->prepare($productQuery);
$searchParam = "%" . $search . "%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$productResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
            <a href="organaization_dashboard.php">
              <i class='bx bx-grid-alt' ></i>
              <span class="link_name">Dashboard</span>
            </a>
          </li>

          <li>
            <a href="manageTranceport.php">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="link_name">Transport</span>
            </a>
          </li>
          <li>
            <a href="warehouseManagement.php">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">Warehouse Management</span>
            </a>
            
          </li>
          <li>
            <a href="pending_users.php">
              <i class='bx bx-support' ></i>
              <span class="link_name">Users</span>
            </a>
          </li>
          
          <li>
            <a href="addProduct.php">
              <i class='bx bx-support' ></i>
              <span class="link_name">Add Product</span>
            </a>
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
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Admin Dashboard</span>
        </div>


        <div class="container my-5">
        <h1 class="text-center">Product Management</h1>

        <!-- Messages -->
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <!-- Add Product Form -->
        <div class="card my-4">
            <div class="card-header">Add Product</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name:</label>
                        <input type="text" id="product_name" name="product_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mrp" class="form-label">MRP:</label>
                        <input type="number" id="mrp" name="mrp" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_type" class="form-label">Product Type:</label>
                        <input type="text" id="product_type" name="product_type" class="form-control" required>
                    </div>
                    <button type="submit" name="addProduct" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>

        <!-- Search -->
        <form method="GET" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Product Name..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </form>

        <!-- Product Table -->
        <div class="card">
            <div class="card-header">Product List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>MRP</th>
                                <th>Product Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($productResult->num_rows > 0): ?>
                                <?php while ($row = $productResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['productID']; ?></td>
                                        <td><?php echo $row['product_name']; ?></td>
                                        <td><?php echo $row['mrp']; ?></td>
                                        <td><?php echo $row['product_type']; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="updateMRP(<?php echo $row['productID']; ?>, '<?php echo $row['product_name']; ?>', <?php echo $row['mrp']; ?>)">Update MRP</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No products found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update MRP Modal -->
    <div class="modal fade" id="updateMRPModal" tabindex="-1" aria-labelledby="updateMRPModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateMRPModalLabel">Update MRP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="product_id" name="product_id">
                        <div class="mb-3">
                            <label for="product_name_display" class="form-label">Product Name:</label>
                            <input type="text" id="product_name_display" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="updated_mrp" class="form-label">Updated MRP:</label>
                            <input type="number" id="updated_mrp" name="updated_mrp" class="form-control" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="updateMRP" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateMRP(productID, productName, currentMRP) {
            document.getElementById('product_id').value = productID;
            document.getElementById('product_name_display').value = productName;
            document.getElementById('updated_mrp').value = currentMRP;
            const modal = new bootstrap.Modal(document.getElementById('updateMRPModal'));
            modal.show();
        }
    </script>

  

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


    
</html>
