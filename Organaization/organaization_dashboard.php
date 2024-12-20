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

// Fetch Top Farmers
$topFarmersQuery = "
    SELECT 
        f.farmerID, 
        f.firstname, 
        f.lastname, 
        f.gender, 
        f.affiliation_date, 
        fa.farmID, 
        fa.farmName, 
        l.product_type AS main_product, 
        SUM(l.quantity) AS total_production
    FROM farmers_t f
    JOIN farm_t fa ON f.farmerID = fa.farmerID
    JOIN lot_t l ON fa.farmID = l.farmID
    GROUP BY f.farmerID, fa.farmID, l.product_type
    ORDER BY total_production DESC
    LIMIT 5";
$topFarmersResult = $conn->query($topFarmersQuery);


// Fetch Top Retailers
$topRetailersQuery = "
    SELECT 
        r.retailerID, 
        r.firstname, 
        r.lastname, 
        r.gender, 
        r.trade_license_no, 
        r.contactNO, 
        CONCAT(r.sub_district, ', ', r.district, ', ', r.division) AS location, 
        COUNT(po.orderID) AS total_orders, 
        SUM(po.quantity) AS products_sold
    FROM retailers_t r
    LEFT JOIN purchase_order_t po ON r.retailerID = po.retailerID
    GROUP BY r.retailerID
    ORDER BY total_orders DESC
    LIMIT 5";
$topRetailersResult = $conn->query($topRetailersQuery);

$topWarehousesQuery = "
    SELECT 
        w.warehouseID, 
        wm.firstname AS manager_name, 
        wm.managerID, 
        w.phone, 
        CONCAT(w.sub_district, ', ', w.district, ', ', w.division) AS location, 
        w.storage_capacity ,
        IFNULL(SUM(wi.weight), 0) AS current_utilization,
        COUNT(d.shipmentID) AS total_deliveries
    FROM warehouse_t w
    JOIN warehouse_managers_t wm ON w.managerID = wm.managerID
    LEFT JOIN w_inventory_t wi ON w.warehouseID = wi.warehouseID
    LEFT JOIN delivery_t d ON w.warehouseID = d.warehouseID
    GROUP BY w.warehouseID
    ORDER BY current_utilization DESC
    LIMIT 5";
$topWarehousesResult = $conn->query($topWarehousesQuery);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organaization</title>
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
            <a href="warehouseManagement.php">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">Warehouse Management</span>
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
            <a href="pending_users.php">
              <i class='bx bx-support' ></i>
              <span class="link_name">Users</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class='bx bx-cog' ></i>
              <span class="link_name">Settings</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#"></a></li>
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
                        <div class="card-body">
                            <div class="d-flex align-center">
                                <h1>
                                    "Hello, Mr. Admin"
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
    
                <!-- Summary Cards with Styled Background -->
                <div class="col-xl-4 col-md-6 box-col-6">
                    <div class="card inspection-card styled-card shadow-sm">
                        <div class="card-body text-center"id="safety_chart">
                          <h2>Purity and Safety</h2>
                            
                        </div>
                        
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 box-col-6">
                    <div class="card inspection-card styled-card shadow-sm">
                        <div class="card-body text-center"id="top_sale">
                            <h2>Top Sales</h2>
                          

                        </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div >
               <!-- Top Farmers -->
            <div class="row">
                <div class="col-xl-4 col-md-6 box-col-6">
                    <div class="card shadow-sm styled-card">
                        <div class="card-header">
                            <h5 class="mb-0">Top Farmers</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Farmer ID</th>
                                        <th>Name</th>
                                        <!-- <th>Location</th> -->
                                        <th>Product</th>
                                        <th>Production</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $topFarmersResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['farmerID']; ?></td>
                                            <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                            <!-- <td><?php echo $row['district']; ?></td> -->
                                            <td><?php echo $row['main_product']; ?></td>
                                            <td><?php echo $row['total_production']; ?> KG</td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Retailers -->
                <div class="col-xl-4 col-md-6 box-col-6">
                    <div class="card shadow-sm styled-card">
                        <div class="card-header">
                            <h5 class="mb-0">Top Retailers</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Retailer ID</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Orders</th>
                                        <th>Products Sold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $topRetailersResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['retailerID']; ?></td>
                                            <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                            <td><?php echo $row['location']; ?></td>
                                            <td><?php echo $row['total_orders']; ?></td>
                                            <td><?php echo $row['products_sold']; ?> Units</td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Warehouses -->
                <div class="col-xl-4 col-md-6 box-col-6">
                    <div class="card shadow-sm styled-card">
                        <div class="card-header">
                            <h5 class="mb-0">Top Warehouses</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Warehouse ID</th>
                                        <th>Manager</th>
                                        <th>Contact</th>
                                        <th>Location</th>
                                        <th>Capacity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $topWarehousesResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['warehouseID']; ?></td>
                                            <td><?php echo $row['manager_name']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['location']; ?></td>
                                            <td><?php echo $row['storage_capacity']; ?> Tons</td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>


    <script>
      var options = {
        series: [75],
        chart: {
        height: 300,
        type: 'radialBar',
        toolbar: {
          show: true
        }
      },
      plotOptions: {
        radialBar: {
          startAngle: -135,
          endAngle: 225,
           hollow: {
            margin: 0,
            size: '70%',
            background: '#fff',
            image: undefined,
            imageOffsetX: 0,
            imageOffsetY: 0,
            position: 'front',
            dropShadow: {
              enabled: true,
              top: 3,
              left: 0,
              blur: 4,
              opacity: 0.24
            }
          },
          track: {
            background: '#fff',
            strokeWidth: '67%',
            margin: 0, // margin is in pixels
            dropShadow: {
              enabled: true,
              top: -3,
              left: 0,
              blur: 4,
              opacity: 0.35
            }
          },
      
          dataLabels: {
            show: true,
            name: {
              offsetY: -10,
              show: true,
              color: '#888',
              fontSize: '17px'
            },
            value: {
              formatter: function(val) {
                return parseInt(val);
              },
              color: '#111',
              fontSize: '36px',
              show: true,
            }
          }
        }
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#ABE5A1'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
        }
      },
      stroke: {
        lineCap: 'round'
      },
      labels: ['Percent'],
      };

      var chart = new ApexCharts(document.querySelector("#safety_chart"), options);
      chart.render();
    
    </script>

    <script>
      var options = {
        series: [14, 15, 16],
        chart: {
          height: 300,
        type: 'polarArea',
      },
      labels: ['Corps', 'Fruits', 'Vegetables'],
      stroke: {
        colors: ['#fff']
        
      },
      fill: {
        opacity: 0.8
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
      };

      var chart = new ApexCharts(document.querySelector("#top_sale"), options);
      chart.render();
    </script>
    

    <script>
      // Sample Data for Upcoming Inspection List
let upcomingListData = [
    { id: 'INSP001', batchId: 'BATCH123', where: 'Warehouse', productName: 'Organic Apples', status: 'Scheduled' },
    { id: 'INSP002', batchId: 'BATCH456', where: 'Retailer', productName: 'Fresh Tomatoes', status: 'Pending' },
    { id: 'INSP003', batchId: 'BATCH789', where: 'Transport', productName: 'Frozen Fish', status: 'In Transit' },
    { id: 'INSP004', batchId: 'BATCH101', where: 'Warehouse', productName: 'Canned Beans', status: 'Scheduled' },
    { id: 'INSP005', batchId: 'BATCH202', where: 'Retailer', productName: 'Lettuce', status: 'Pending' },
    { id: 'INSP006', batchId: 'BATCH303', where: 'Warehouse', productName: 'Oranges', status: 'Completed' }
];

let batchLocationData = [
    { batchId: 'BATCH123', location: 'Warehouse - Downtown' },
    { batchId: 'BATCH456', location: 'Retailer - Uptown' },
    { batchId: 'BATCH789', location: 'Transport Storage' },
    { batchId: 'BATCH101', location: 'Warehouse - East Side' },
    { batchId: 'BATCH202', location: 'Retailer - Midtown' },
    { batchId: 'BATCH303', location: 'Warehouse - West End' }
];

// Counters to track the number of items displayed
let upcomingListCounter = 5;
let batchLocationCounter = 5;

// Function to load initial rows for Upcoming Inspection List
function loadUpcomingList() {
    const tbody = document.getElementById('upcomingListBody');
    tbody.innerHTML = '';
    for (let i = 0; i < upcomingListCounter; i++) {
        if (upcomingListData[i]) {
            tbody.innerHTML += `<tr>
                <td><input type="checkbox"></td>
                <td>${upcomingListData[i].id}</td>
                <td>${upcomingListData[i].batchId}</td>
                <td>${upcomingListData[i].where}</td>
                <td>${upcomingListData[i].productName}</td>
                <td><span class="badge bg-success">${upcomingListData[i].status}</span></td>
            </tr>`;
        }
    }
}

// Function to load initial rows for Batch Location Record
function loadBatchLocation() {
    const tbody = document.getElementById('batchLocationBody');
    tbody.innerHTML = '';
    for (let i = 0; i < batchLocationCounter; i++) {
        if (batchLocationData[i]) {
            tbody.innerHTML += `<tr>
                <td>${batchLocationData[i].batchId}</td>
                <td>${batchLocationData[i].location}</td>
            </tr>`;
        }
    }
}

// Load More Functions
function loadMoreUpcoming() {
    upcomingListCounter += 5;
    loadUpcomingList();
}

function loadMoreBatchLocation() {
    batchLocationCounter += 5;
    loadBatchLocation();
}

// Update Functions (simulate data refresh)
function updateUpcomingList() {
    alert("Updating upcoming inspection list...");
    // Here, you could fetch updated data from a server
    loadUpcomingList(); // For now, just reload the existing data
}

function updateBatchLocation() {
    alert("Updating batch location record...");
    // Here, you could fetch updated data from a server
    loadBatchLocation(); // For now, just reload the existing data
}

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
