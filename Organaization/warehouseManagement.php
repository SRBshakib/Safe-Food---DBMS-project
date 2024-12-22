<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your password
$dbname = "traceroots";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch manager data
$managersQuery = "SELECT managerID, firstname, lastname, gender, username, email, status, affiliation_date FROM warehouse_managers_t";
$managersResult = $conn->query($managersQuery);

// Fetch existing warehouses
$warehouseQuery = "
    SELECT 
        w.warehouseID, w.sub_district, w.district, w.division, w.storage_capacity, 
        w.humidity_level, w.temperature, w.phone, w.email, 
        CONCAT(m.firstname, ' ', m.lastname) AS manager_name
    FROM warehouse_t w
    LEFT JOIN warehouse_managers_t m ON w.managerID = m.managerID
";
$warehouseResult = $conn->query($warehouseQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>warehhouse Management</title>
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
            <span class="text">Admin Dashboard</span>
        </div>
        <div class="container-fluid default-dashboard">
            <div class="row">
              <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for additional styling */
        body {
            background-color: #f4f4f4;
            padding-top: 5px;
        }
        .container {
            max-width: 1800px;
        }
        .form-container, .table-container {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header class="text-center mb-4">
            <h3>Warehouse Management System</h3>
        </header>

        <div class="row">
        <!-- Warehouse Creation Form -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Create Warehouse and Assign Manager</h5>
                </div>
                <div class="card-body">
                    <form id="warehouse-form" method="POST" action="create_warehouse.php">
                        <div class="row">
                            <!-- District, Sub-District, Division -->
                            <div class="col-md-4 mb-3">
                                <label for="district" class="form-label">District:</label>
                                <input type="text" class="form-control" id="district" name="district" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sub_district" class="form-label">Sub-District:</label>
                                <input type="text" class="form-control" id="sub_district" name="sub_district" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="division" class="form-label">Division:</label>
                                <input type="text" class="form-control" id="division" name="division" required>
                            </div>
                        </div>

                        <!-- Storage and Manager Details -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="storage_capacity" class="form-label">Storage Capacity (m²):</label>
                                <input type="number" class="form-control" id="storage_capacity" name="storage_capacity" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="humidity_level" class="form-label">Humidity Level (%):</label>
                                <input type="number" class="form-control" id="humidity_level" name="humidity_level" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="temperature" class="form-label">Temperature (°C):</label>
                                <input type="number" class="form-control" id="temperature" name="temperature" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="manager-select" class="form-label">Assign Manager:</label>
                            <select class="form-select" id="manager-select" name="managerID" required>
                                <option value="">-- Select a Manager --</option>
                                <?php while ($row = $managersResult->fetch_assoc()): ?>
                                    <option value="<?php echo $row['managerID']; ?>">
                                        <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Create Warehouse</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Warehouse List -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Warehouse List</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Warehouse ID</th>
                            <th>Sub-District</th>
                            <th>District</th>
                            <th>Division</th>
                            <th>Storage Capacity</th>
                            <th>Humidity Level</th>
                            <th>Temperature</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Manager</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $warehouseResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['warehouseID']; ?></td>
                                <td><?php echo $row['sub_district']; ?></td>
                                <td><?php echo $row['district']; ?></td>
                                <td><?php echo $row['division']; ?></td>
                                <td><?php echo $row['storage_capacity']; ?> m²</td>
                                <td><?php echo $row['humidity_level']; ?>%</td>
                                <td><?php echo $row['temperature']; ?> °C</td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['manager_name'] ?: 'Unassigned'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
  

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
