
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
// Fetch warehouses for the dropdown
$warehouseQuery = "SELECT warehouseID, Sub_district FROM warehouse_t";
$warehouseResult = $conn->query($warehouseQuery);

// Default to previously selected warehouse
session_start();
$selectedWarehouseID = isset($_POST['warehouseID']) 
    ? (int)$_POST['warehouseID'] 
    : (isset($_SESSION['selectedWarehouseID']) ? $_SESSION['selectedWarehouseID'] : null);
$_SESSION['selectedWarehouseID'] = $selectedWarehouseID;

// Fetch capacity data for the selected warehouse
$capacityData = [
    'totalCapacity' => 0,
    'currentUtilization' => 0,
    'utilizationPercentage' => 0
];

if ($selectedWarehouseID) {
    $capacityQuery = "
        SELECT 
            w.storage_capacity AS totalCapacity,
            IFNULL(SUM(wi.weight), 0) AS currentUtilization
        FROM 
            warehouse_t w
        LEFT JOIN 
            w_inventory_t wi ON w.warehouseID = wi.warehouseID
        WHERE 
            w.warehouseID = ?
        GROUP BY 
            w.warehouseID
    ";
    $stmt = $conn->prepare($capacityQuery);
    $stmt->bind_param("i", $selectedWarehouseID);
    $stmt->execute();
    $result = $stmt->get_result();
    $capacityData = $result->fetch_assoc();
    if ($capacityData) {
        $capacityData['utilizationPercentage'] = ($capacityData['totalCapacity'] > 0) 
            ? ($capacityData['currentUtilization'] / $capacityData['totalCapacity']) * 100 
            : 0;
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
        <div class="container-fluid default-dashboard">
            <div class="row">
                <!-- Welcome Banner Card -->
                <div class="col-xl-4 proorder-xxl-1 col-sm-6 box-col-6">
                  <div class="card welcome-banner">
                        <div class="card-header p-0 card-no-border">
                            <div class="welcome-card">
                                <img class="w-100 img-fluid" src="images/welcome-bg.png" alt="">
                                <img class="position-absolute img-1 img-fluid" src="images/img-1.png" alt="">
                                <img class="position-absolute img-2 img-fluid" src="images/img-2.png" alt="">
                                <img class="position-absolute img-3 img-fluid" src="images/img-3.png" alt="">
                                <img class="position-absolute img-4 img-fluid" src="images/img-4.png" alt="">
                                <img class="position-absolute img-5 img-fluid" src="images/img-5.png" alt="">
                            </div>
                        </div>
                        <div class="card-body" >
                            <div class="d-flex align-center">
                                <h1>
                                    "Hello, Mr. Kamal"
                                    <img src="images/hand.png" alt="">
                                </h1>
                            </div>
                            <p>Welcome back! Let's start from where you left.</p>
                            <div class="d-flex align-center justify-content-between">
                                <a class="btn btn-pill btn-primary" href="index.html">What's New</a>
                                <div id="timer" class="real-time-timer"></div>
                            </div>
                        </div>
                    </div>
                </div>
               
       

        <!-- Capacity Overview -->
        <div class="col-xl-4 box-col-6">
    <div class="card inspection-card styled-card shadow-sm styled-card_height">
        <div class="card-body text-center" id="chart_capacity">
            <h5 class="card-title">Capacity Overview</h5>
            <form method="POST" action="" id="warehouseForm">
                <div class="form-group mb-3">
                    <label for="warehouseID">Select Warehouse:</label>
                    <select class="form-select" id="warehouseID" name="warehouseID" onchange="this.form.submit()">
                        <?php while ($row = $warehouseResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['warehouseID']; ?>" 
                                <?php echo ($selectedWarehouseID == $row['warehouseID']) ? 'selected' : ''; ?>>
                                <?php echo "WH-" . $row['warehouseID'] . " (" . $row['Sub_district'] . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </form>
            <p>Total Capacity: <span id="totalCapacity"><?php echo $capacityData['totalCapacity']; ?></span> KG</p>
            <p>Current Utilization: <span id="currentUtilization"><?php echo $capacityData['currentUtilization']; ?></span> KG</p>
            <div id="capacityChart" class="d-flex justify-content-center align-items-center" style="height: 150px;"></div>
        </div>
    </div>
</div>

<div class="col-xl-4 box-col-6">
    <div class="card inspection-card styled-card shadow-sm styled-card_height">
        <div class="card-body text-center">
            <h5 class="card-title">Storage Conditions</h5>
            <p>Warehouse: <span id="warehouseNameDisplay">--</span></p>
            <p>Temperature: <span id="temperatureDisplay">--</span> °C</p>
            <p>Humidity: <span id="humidityDisplay">--</span>%</p>
        </div>
    </div>
</div>

<script>
// Function to update storage conditions when warehouse changes in Capacity Overview
function updateStorageConditionsBasedOnCapacityOverview() {
    const warehouseID = document.getElementById("warehouseID").value; // WarehouseID from Capacity Overview

    if (warehouseID) {
        // Fetch temperature and humidity data for the selected warehouse
        fetch(`get_storage_conditions.php?warehouseID=${warehouseID}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Update temperature and humidity display
                    document.getElementById("temperatureDisplay").innerText = data.temperature;
                    document.getElementById("humidityDisplay").innerText = data.humidity;
                    document.getElementById("warehouseNameDisplay").innerText = data.warehouseName;
                } else {
                    alert("Failed to fetch storage conditions.");
                }
            })
            .catch((error) => {
                console.error("Error fetching storage conditions:", error);
            });
    } else {
        // Reset to default display if no warehouse is selected
        document.getElementById("temperatureDisplay").innerText = "--";
        document.getElementById("humidityDisplay").innerText = "--";
        document.getElementById("warehouseNameDisplay").innerText = "--";
    }
}

// Automatically update storage conditions when the Capacity Overview warehouse changes
document.getElementById("warehouseID").addEventListener("change", updateStorageConditionsBasedOnCapacityOverview);

// Initial load (in case a warehouse is already selected)
updateStorageConditionsBasedOnCapacityOverview();
</script>


          
        </div>

      
        <div class="table-responsive">
    <table class="table table-bordered align-middle">
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
        <tbody id="inventoryTableBody">
            <!-- Inventory rows will be populated via JavaScript -->
        </tbody>
    </table>
</div>

<!-- Pagination Controls -->
<div class="d-flex justify-content-between align-items-center mt-3">
    <button id="prevPage" class="btn btn-secondary" disabled>Previous</button>
    <span id="currentPage" class="fw-bold">Page 1</span>
    <button id="nextPage" class="btn btn-secondary">Next</button>
</div>

<script>
// Pagination Variables
let currentPage = 1;
const rowsPerPage = 10;

// Function to fetch and update the inventory table based on the selected warehouse
function updateInventoryTable(page = 1) {
    const warehouseID = document.getElementById("warehouseID").value; // Selected warehouse ID from Capacity Overview

    if (warehouseID) {
        // Send AJAX request to fetch inventory data
        fetch(`get_inventory.php?warehouseID=${warehouseID}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Calculate pagination
                    const inventoryData = data.inventory;
                    const totalRows = inventoryData.length;
                    const totalPages = Math.ceil(totalRows / rowsPerPage);

                    // Display rows for the current page
                    const startIndex = (page - 1) * rowsPerPage;
                    const endIndex = startIndex + rowsPerPage;
                    const currentRows = inventoryData.slice(startIndex, endIndex);

                    // Clear existing table rows
                    const inventoryTableBody = document.getElementById("inventoryTableBody");
                    inventoryTableBody.innerHTML = "";

                    // Populate the table with current page's inventory data
                    currentRows.forEach(item => {
                        const row = document.createElement("tr");
                        if (item.weight < 50) row.style.backgroundColor = "#f8d7da";

                        row.innerHTML = `
                            <td>${item.productID}</td>
                            <td>${item.product_name}</td>
                            <td>${item.product_type}</td>
                            <td>${item.quantity}</td>
                            <td>${item.weight}</td>
                            <td>
                                <span class="badge ${item.weight < 50 ? "bg-danger" : "bg-success"}">
                                    ${item.weight < 50 ? "Low Stock" : "In Stock"}
                                </span>
                            </td>
                        `;
                        inventoryTableBody.appendChild(row);
                    });

                    // Update pagination controls
                    document.getElementById("currentPage").innerText = `Page ${page}`;
                    document.getElementById("prevPage").disabled = page === 1;
                    document.getElementById("nextPage").disabled = page === totalPages;

                    // Update current page
                    currentPage = page;
                } else {
                    alert("Failed to fetch inventory data.");
                }
            })
            .catch(error => {
                console.error("Error fetching inventory data:", error);
            });
    } else {
        // Clear table if no warehouse is selected
        document.getElementById("inventoryTableBody").innerHTML = `
            <tr>
                <td colspan="6" class="text-center">Please select a warehouse to view inventory data.</td>
            </tr>
        `;
        document.getElementById("prevPage").disabled = true;
        document.getElementById("nextPage").disabled = true;
    }
}

// Pagination Button Event Listeners
document.getElementById("prevPage").addEventListener("click", () => {
    if (currentPage > 1) updateInventoryTable(currentPage - 1);
});

document.getElementById("nextPage").addEventListener("click", () => {
    updateInventoryTable(currentPage + 1);
});

// Automatically update the inventory table when the warehouse selection changes
document.getElementById("warehouseID").addEventListener("change", () => updateInventoryTable(1));

// Initial load (in case a warehouse is already selected)
updateInventoryTable(1);
</script>




      
    </section>

    
    


    <script>
    // Fetch PHP variables for dynamic chart data
    const totalCapacity = <?php echo $capacityData['totalCapacity']; ?>;
    const currentUtilization = <?php echo $capacityData['currentUtilization']; ?>;
    const utilizationPercentage = <?php echo $capacityData['utilizationPercentage']; ?>;

    // Configure the radial bar chart
    var options = {
        series: [utilizationPercentage],
        chart: {
            type: 'radialBar',
            height: 180, // Adjust height to make it smaller
            width: 180,  // Adjust width to make it smaller
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                track: {
                    background: "#e7e7e7",
                    strokeWidth: '90%', // Adjust track width
                    margin: 5,
                },
                dataLabels: {
                    name: {
                        show: false
                    },
                    value: {
                        offsetY: -5, // Adjust position to center the value
                        fontSize: '16px', // Reduce font size
                        formatter: function (val) {
                            return val.toFixed(2) + "%";
                        }
                    }
                }
            }
        },
        grid: {
            padding: {
                top: -10
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                shadeIntensity: 0.4,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 53, 91]
            },
        },
        labels: ['Utilization'],
    };

    // Render the chart
    var chart = new ApexCharts(document.querySelector("#capacityChart"), options);
    chart.render();
</script>




<script>

      // Line Chart for Storage Condition (Temperature & Humidity)
      var optionsStorageCondition = {
          chart: {
              type: 'line',
              height: 250
          },
          series: [
              {
                  name: 'Temperature',
                  data: [24, 23, 22, 24, 26, 25, 23] // Sample temperature data points
              },
              {
                  name: 'Humidity',
                  data: [50, 55, 60, 57, 54, 52, 50] // Sample humidity data points
              }
          ],
          xaxis: {
              categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] // Days of the week
          },
          colors: ['#ff4560', '#008ffb'],
          stroke: {
              width: 3
          }
      };

      var chartStorageCondition = new ApexCharts(document.querySelector("#storageConditionChart"), optionsStorageCondition);
      chartStorageCondition.render();
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
