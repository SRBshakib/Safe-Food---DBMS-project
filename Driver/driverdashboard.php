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

// Get the current year and month using PHP's date function
$year = date('Y');  // Get the current year (e.g., 2024)
$month = date('m'); // Get the current month (e.g., 12 for December)

// Query to get the total shipment count for the current month and year
$sql = "SELECT COUNT(*) AS total_deliveries FROM delivery_t WHERE YEAR(shipment_date) = ? AND MONTH(shipment_date) = ?";
$stmt = $conn->prepare($sql); // Prepare the SQL query
$stmt->bind_param("ii", $year, $month); // Bind the parameters (current year, current month)
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result
$row = $result->fetch_assoc(); // Fetch the row
$totalDeliveries = $row['total_deliveries']; // Get the total deliveries count

// Query to get the vehicle registration number based on driverID from the transport_t table
$sql_vehicle = "SELECT Vehicle_reg_no FROM transport_t WHERE driverID = ?";
$stmt_vehicle = $conn->prepare($sql_vehicle); // Prepare the SQL query for vehicle registration number
$stmt_vehicle->bind_param("i", $driverID); // Bind the driverID parameter
$stmt_vehicle->execute(); // Execute the query
$result_vehicle = $stmt_vehicle->get_result(); // Get the result
$row_vehicle = $result_vehicle->fetch_assoc(); // Fetch the row for vehicle registration number

// If a vehicle is found for the driver, store the vehicle registration number
if ($row_vehicle) {
    $vehicleRegNo = $row_vehicle['Vehicle_reg_no']; // Get the vehicle registration number
} else {
    $vehicleRegNo = "No vehicle assigned";  // Handle case where no vehicle is assigned
}

// Check if pickup button is clicked
if (isset($_POST['pickup'])) {
  $pbatchID = $_POST['pbatchID'];
  $driverID = $_POST['driverID'];  // Get the driver ID from the form

  // Get the transportID based on the driverID
  $transport_query = "SELECT transportID FROM transport_t WHERE driverID = '$driverID'";
  $transport_result = $conn->query($transport_query);
  $transport_row = $transport_result->fetch_assoc();
  $transportID = $transport_row['transportID'];

  // Get the current date and time for shipment date
  $shipment_date = date('Y-m-d H:i:s');

  // Get the warehouseID based on the district of the farm
  $warehouse_query = "SELECT w.warehouseID FROM warehouse_t w
                      JOIN farm_t f ON w.district = f.district
                      JOIN lot_t l ON l.farmID = f.farmID
                      WHERE l.lotID = (SELECT lotID FROM processed_batch_t WHERE pbatchID = '$pbatchID')";
  $warehouse_result = $conn->query($warehouse_query);
  $warehouse_row = $warehouse_result->fetch_assoc();
  $warehouseID = $warehouse_row['warehouseID'];

  // Insert into delivery_t table
  $insert_query = "INSERT INTO delivery_t (shipment_date, pbatchID, warehouseID, transportID, status) 
                   VALUES ('$shipment_date', '$pbatchID', '$warehouseID', '$transportID', 'Pending')";
  if ($conn->query($insert_query) === TRUE) {
      // Update status in processed_batch_t table to 'In-Transit'
      $update_query = "UPDATE processed_batch_t SET status='In-Transit' WHERE pbatchID='$pbatchID'";
      $conn->query($update_query);
  }
}

// Fetch processed data for display
$sql = "SELECT pb.pbatchID, pb.processing_Date, pb.weight, pb.quantity, pb.product_type, pb.lotID, pb.status,
             f.district
      FROM processed_batch_t pb
      JOIN lot_t l ON pb.lotID = l.lotID
      JOIN farm_t f ON l.farmID = f.farmID
      WHERE pb.status = 'Processed'";
$result = $conn->query($sql);



// Close the database connection
$stmt->close();
$stmt_vehicle->close();

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
            <span class="text">Driver Dashboard</span>
        </div>
        <div class="container-fluid default-dashboard">
    <div class="row">
      

        <!-- Welcome Banner Card -->
        <div class="col-xl-4 col-sm-6 box-col-6">
            <div class="card welcome-banner">
                <div class="card-header p-0 card-no-border">
                    <div class="welcome-card">
                        <img class="w-100 img-fluid" src="images/trucks1.png" alt="">
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-center">
                        <h1>
                            "Hello, Mr. Kamal"
                            <img src="images/delivary_emoji.jpeg" alt="">
                        </h1>
                    </div>
                    <p>Welcome back! Let's start from where you left.</p>
                    <div class="d-flex align-center justify-content-between">
                        <a class="btn btn-pill btn-primary" href="driverdashboard.html">What's New</a>
                        <div id="timer" class="real-time-timer"></div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Total Deliveries Count Card -->
        <div class="col-xl-4 col-sm-6 box-col-6">
            <div class="card total-deliveries-card">
                <div class="card-header text-center">
                    <h2>Total Deliveries</h2>
                </div>
                <div class="card-body" style="padding: 95px;" >
                    <h4 class="text-center">
                        <?php echo 'Current Month-Year: '. $month . '-' . $year; ?>
                    </h4>
                    <h2 class="text-center"><?php echo $totalDeliveries; ?></h2>
                    <p class="text-center">Total Deliveries for the month</p>
                </div>
            </div>

    
</div>
<div class="col-xl-4 col-sm-6 box-col-6">
    <div class="card vehicle-info-card">
        <div class="card-header">
            <h5>Allocated Vehicle</h5>
        </div>
        <div class="card-body" style="padding: 125px;">
            <h4 class="text-center">
                <?php echo $vehicleRegNo; ?>  <!-- Display the vehicle registration number fetched from PHP -->
            </h4>
            <p class="text-center">Driver ID: <?php echo $driverID; ?>  <!-- Optionally show the driver ID --></p>
        </div>
    </div>
</div>
<div class="container mt-5">
    <h2>Upcoming Deliveries</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Batch ID</th>
                <th>Processing Date</th>
                <th>Weight</th>
                <th>Quantity</th>
                <th>Product Type</th>
                <th>Lot ID</th>
                <th>Farm District</th>
                <th>Status</th>
                <th>Driver ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form action="driverdashboard.php" method="POST">
                    <td><?php echo $row['pbatchID']; ?></td>
                    <td><?php echo $row['processing_Date']; ?></td>
                    <td><?php echo $row['weight']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['product_type']; ?></td>
                    <td><?php echo $row['lotID']; ?></td>
                    <td><?php echo $row['district']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <select name="driverID" class="form-select" required>
                            <option value="">Select Driver</option>
                            <?php
                            // Fetching available drivers
                            $driver_query = "SELECT driverID FROM drivers_t";
                            $driver_result = $conn->query($driver_query);
                            while ($driver = $driver_result->fetch_assoc()):
                            ?>
                                <option value="<?php echo $driver['driverID']; ?>"><?php echo $driver['driverID']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="pbatchID" value="<?php echo $row['pbatchID']; ?>">
                        <button type="submit" name="pickup" class="btn btn-primary">Pickup</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
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
