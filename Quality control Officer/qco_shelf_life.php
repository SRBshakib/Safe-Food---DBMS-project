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

// Fetch product types for the dropdown
$product_types_query = "SELECT DISTINCT product_type FROM product_t";
$product_types_result = $conn->query($product_types_query);

// Handle form submission to update shelf_life, temp, and humidity
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $product_id = $_POST['productID'];
    $shelf_life = $_POST['shelf_life'];
    $temp = $_POST['temp'];
    $humidity = $_POST['humidity'];

    // Update query for the selected product
    $update_query = "UPDATE product_t SET shelf_life = ?, temp = ?, humidity = ? WHERE productID = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssss", $shelf_life, $temp, $humidity, $product_id);
    $stmt->execute();
}

// Fetch products with NULL values for shelf_life, temp, and humidity based on the selected type
$selected_type = isset($_POST['product_type']) ? $_POST['product_type'] : '';
$products_query = "SELECT * FROM product_t WHERE product_type = ? AND (shelf_life IS NULL OR temp IS NULL OR humidity IS NULL)";
$stmt = $conn->prepare($products_query);
$stmt->bind_param("s", $selected_type);
$stmt->execute();
$products_result = $stmt->get_result();

// Fetch products where shelf_life, temp, and humidity are NOT NULL
$completed_products_query = "SELECT * FROM product_t WHERE product_type = ? AND shelf_life IS NOT NULL AND temp IS NOT NULL AND humidity IS NOT NULL";
$completed_stmt = $conn->prepare($completed_products_query);
$completed_stmt->bind_param("s", $selected_type);
$completed_stmt->execute();
$completed_products_result = $completed_stmt->get_result();
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
    
</head>
<body>
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
          <<li>
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
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Set Shelf-life, Temp and Humidity</span>
        </div>
      
    </section>
    
    <div class="container mt-5">
        <h2 class="text-center mb-4">Product Quality Control</h2>

        <!-- Product Type Dropdown -->
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label for="product_type">Select Product Type:</label>
                <select name="product_type" id="product_type" class="form-select" required>
                    <option value="">Select Type</option>
                    <?php while ($row = $product_types_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['product_type']; ?>" <?php echo $row['product_type'] == $selected_type ? 'selected' : ''; ?>>
                            <?php echo $row['product_type']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Show Products</button>
        </form>

        <!-- Table 1: Products with Missing Data (NULL) -->
        <h3>Update Products Details</h3>
        <form method="POST" action="" class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Shelf Life</th>
                        <th>Temperature</th>
                        <th>Humidity</th>
                        <th>Submit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $products_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $product['productID']; ?></td>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><input type="text" name="shelf_life" value="<?php echo $product['shelf_life']; ?>" class="form-control"></td>
                            <td><input type="text" name="temp" value="<?php echo $product['temp']; ?>" class="form-control"></td>
                            <td><input type="text" name="humidity" value="<?php echo $product['humidity']; ?>" class="form-control"></td>
                            <td><button type="submit" name="submit" value="update" class="btn btn-success">Update</button></td>
                            <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>

        <!-- Table 2: Products with Complete Data -->
        <h3>Products Details</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Shelf Life</th>
                    <th>Temperature</th>
                    <th>Humidity</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $completed_products_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $product['productID']; ?></td>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['shelf_life']; ?></td>
                        <td><?php echo $product['temp']; ?></td>
                        <td><?php echo $product['humidity']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    

  <script>
    // Function to handle adding a product (you can implement the logic later as needed)
    function addProduct() {
      var productType = document.getElementById("product_type").value;
      var productID = document.getElementById("productID").value;
      var productName = document.getElementById("product_name").value;
      var shelfLife = document.getElementById("shelf_Life").value;
      var temperature = document.getElementById("temp").value;
      var humidity = document.getElementById("humidity").value;

      if (productType && productID && productName && shelfLife && temperature && humidity) {
        // Here you would send this data to your server for insertion into the database
        // This part can be handled using AJAX or a form submission
        alert("Product submitted successfully!");
      } else {
        alert("Please fill out all fields!");
      }
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
