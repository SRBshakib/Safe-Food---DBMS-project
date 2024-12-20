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

// Fetch driver list
$driversQuery = "SELECT driverID, firstname, lastname, driving_license_no, contactNo, status FROM drivers_t";
$driversResult = $conn->query($driversQuery);

// Fetch assigned transport data
$transportQuery = "
    SELECT 
        t.transportID, 
        t.vehicle_reg_no, 
        t.Transport_capacity, 
        t.transport_storage_temp, 
        t.humidity, 
        t.driverID,
        CONCAT(d.firstname, ' ', d.lastname) AS driver_name,
        d.email, 
        d.driving_license_no, 
        d.contactNo, 
        d.status 
    FROM transport_t t
    LEFT JOIN drivers_t d ON t.driverID = d.driverID
    ORDER BY t.transportID ASC";
$transportResult = $conn->query($transportQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Management</title>
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
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#">Category</a></li>
            </ul>
          </li>

          <li>
            <a href="manageTranceport.php">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="link_name">Transport</span>
            </a>
          </li>
          <li>
              <li>
                <a href="personInOrg.html">
                  <i class='bx bx-line-chart' ></i>
                  <span class="link_name">My Organization</span>
                </a>
                <ul class="sub-menu blank">
                  <li><a class="link_name" href="#">Chart</a></li>
                </ul>
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
                <a href="warehouseManagement.html">
                  <i class='bx bx-cog' ></i>
                  <span class="link_name">Manage Warehouse</span>
                </a>
                <ul class="sub-menu blank">
                  <li><a class="link_name" href="#"></a></li>
                </ul>
              </li>
              <li>
                <a href="transportManagement.html">
                  <i class='bx bx-cog' ></i>
                  <span class="link_name">Manage Transport</span>
                </a>
                <ul class="sub-menu blank">
                  <li><a class="link_name" href="#"></a></li>
                </ul>
              </li>
              <li>
                <a href="pending.html">
                  <i class='bx bx-support' ></i>
                  <span class="link_name">Pending User</span>
                </a>
                <ul class="sub-menu blank">
                  <li><a class="link_name" href="#">Help and Support</a></li>
                </ul>
              </li>
              <li>
                <a href="settingsPage.html">
                  <i class='bx bx-support' ></i>
                  <span class="link_name">User Settings</span>
                </a>
                <ul class="sub-menu blank">
                  <li><a class="link_name" href="#">User Settings</a></li>
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
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Transport Management System</span>
        </div>
        <div class="container-fluid default-dashboard">
            <div class="row">

                <!-- Welcome -->
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <title>Transport Management System</title>
                  <!-- Bootstrap CSS -->
                  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
              </head>
              <body>
                   <!-- Driver Selection and Assignment -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Select Driver and View Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="driver-select" class="form-label">Select Driver:</label>
                        <select id="driver-select" class="form-select">
                            <option value="">-- Select a Driver --</option>
                            <?php while ($row = $driversResult->fetch_assoc()): ?>
                                <option value="<?php echo $row['driverID']; ?>">
                                    <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Driver Information Display -->
                    <div id="driver-info" class="mt-4">
                        <h5>Driver Information</h5>
                        <p id="driver-name">Name: </p>
                        <p id="driver-license">License No: </p>
                        <p id="driver-contact">Contact: </p>
                        <p id="driver-status">Status: </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transport Assignment -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Create Transport and Assign Driver</h5>
                </div>
                <div class="card-body">
                    <form action="assign_transport.php" method="POST">
                        <div class="mb-3">
                            <label for="vehicle-reg-no" class="form-label">Vehicle Registration No:</label>
                            <input type="text" id="vehicle-reg-no" name="vehicle_reg_no" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="transport-capacity" class="form-label">Transport Capacity:</label>
                            <input type="number" id="transport-capacity" name="capacity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="transport-storage-temp" class="form-label">Storage Temperature:</label>
                            <input type="number" id="transport-storage-temp" name="storage_temp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="humidity" class="form-label">Humidity:</label>
                            <input type="number" id="humidity" name="humidity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="driver" class="form-label">Assign Driver:</label>
                            <select id="driver" name="driverID" class="form-select" required>
                                <option value="">-- Select a Driver --</option>
                                <?php
                                $driversResult->data_seek(0); // Reset pointer
                                while ($row = $driversResult->fetch_assoc()): ?>
                                    <option value="<?php echo $row['driverID']; ?>">
                                        <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Assign Transport</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Driver and Transport Details -->
    <div class="mt-5">
        <h2 class="mb-4">Transport Details</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Transport ID</th>
                    <th>Vehicle Reg. No.</th>
                    <th>Capacity</th>
                    <th>Storage Temp</th>
                    <th>Humidity</th>
                    <th>Driver Name</th>
                    <th>License No</th>
                    <th>Contact</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $transportResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['transportID']; ?></td>
                        <td><?php echo $row['vehicle_reg_no']; ?></td>
                        <td><?php echo $row['Transport_capacity']; ?> KG</td>
                        <td><?php echo $row['transport_storage_temp']; ?> °C</td>
                        <td><?php echo $row['humidity']; ?>%</td>
                        <td><?php echo $row['driver_name']; ?></td>
                        <td><?php echo $row['driving_license_no']; ?></td>
                        <td><?php echo $row['contactNo']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('driver-select').addEventListener('change', function () {
    const drivers = {
        <?php
        $driversResult->data_seek(0); // Reset pointer
        while ($row = $driversResult->fetch_assoc()): ?>
        "<?php echo $row['driverID']; ?>": {
            name: "<?php echo $row['firstname'] . ' ' . $row['lastname']; ?>",
            license: "<?php echo $row['license_no']; ?>",
            contact: "<?php echo $row['contact']; ?>",
            status: "<?php echo $row['status']; ?>"
        },
        <?php endwhile; ?>
    };

    const selectedDriver = this.value;
    if (drivers[selectedDriver]) {
        document.getElementById('driver-name').innerText = "Name: " + drivers[selectedDriver].name;
        document.getElementById('driver-license').innerText = "License No: " + drivers[selectedDriver].license;
        document.getElementById('driver-contact').innerText = "Contact: " + drivers[selectedDriver].contact;
        document.getElementById('driver-status').innerText = "Status: " + drivers[selectedDriver].status;
    } else {
        document.getElementById('driver-name').innerText = "Name: ";
        document.getElementById('driver-license').innerText = "License No: ";
        document.getElementById('driver-contact').innerText = "Contact: ";
        document.getElementById('driver-status').innerText = "Status: ";
    }
});
</script>












<script>
// Load More Functions

// Load initial rows on page load
document.addEventListener("DOMContentLoaded", function() {
    loadUpcomingList();
    loadBatchLocation();
});

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
