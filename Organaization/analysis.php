<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traceroots";

$conn = new mysqli($servername, $username, $password, $dbname);

// Fetch data for Warehouse Utilization Chart
$warehouseQuery = "
    SELECT w.warehouseID, w.Sub_district, SUM(wi.weight) AS total_weight
    FROM w_inventory_t wi
    JOIN warehouse_t w ON wi.warehouseID = w.warehouseID
    GROUP BY w.warehouseID
";
$warehouseResult = $conn->query($warehouseQuery);
$warehouseLabels = [];
$warehouseSeries = [];
while ($row = $warehouseResult->fetch_assoc()) {
    $warehouseLabels[] = "WH-" . $row['warehouseID'] . " (" . $row['Sub_district'] . ")";
    $warehouseSeries[] = $row['total_weight'];
}

// Fetch data for Shipment Status Chart
$shipmentQuery = "
    SELECT status, COUNT(*) AS count
    FROM delivery_t
    GROUP BY status
";
$shipmentResult = $conn->query($shipmentQuery);
$shipmentLabels = [];
$shipmentSeries = [];
while ($row = $shipmentResult->fetch_assoc()) {
    $shipmentLabels[] = $row['status'];
    $shipmentSeries[] = $row['count'];
}

// Fetch data for Top Products by Weight Chart
$productQuery = "
    SELECT p.product_name, SUM(wi.weight) AS total_weight
    FROM w_inventory_t wi
    JOIN product_t p ON wi.productID = p.productID
    GROUP BY wi.productID
    ORDER BY total_weight DESC
    LIMIT 5
";
$productResult = $conn->query($productQuery);
$productLabels = [];
$productSeries = [];
while ($row = $productResult->fetch_assoc()) {
    $productLabels[] = $row['product_name'];
    $productSeries[] = $row['total_weight'];
}

// Fetch data for Orders by Retailers Chart
$retailerQuery = "
    SELECT r.firstname, COUNT(po.orderID) AS orders_count
    FROM purchase_order_t po
    JOIN retailers_t r ON po.retailerID = r.retailerID
    GROUP BY po.retailerID
";
$retailerResult = $conn->query($retailerQuery);
$retailerLabels = [];
$retailerSeries = [];
while ($row = $retailerResult->fetch_assoc()) {
    $retailerLabels[] = $row['firstname'];
    $retailerSeries[] = $row['orders_count'];
}
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
            <span class="text">Analyis</span>
        </div>
        <div class="container my-4">
        <h1 class="text-center">Admin Dashboard Analysis</h1>

        <!-- Warehouse Utilization Chart -->
        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title">Warehouse Utilization</h5>
                <div id="warehouseUtilizationChart"></div>
            </div>
        </div>

        <!-- Shipment Status Chart -->
        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title">Shipment Status</h5>
                <div id="shipmentStatusChart"></div>
            </div>
        </div>

        <!-- Top Products by Weight -->
        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title">Top Products by Weight</h5>
                <div id="topProductsChart"></div>
            </div>
        </div>

        <!-- Orders by Retailers -->
        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title">Orders by Retailers</h5>
                <div id="ordersByRetailersChart"></div>
            </div>
        </div>
    </div>

    <script>
        // Warehouse Utilization Chart
        const warehouseUtilizationOptions = {
            chart: {
                type: 'pie',
                height: 350,
            },
            series: <?php echo json_encode($warehouseSeries); ?>,
            labels: <?php echo json_encode($warehouseLabels); ?>,
            title: {
                text: 'Warehouse Utilization',
            },
        };
        const warehouseUtilizationChart = new ApexCharts(document.querySelector("#warehouseUtilizationChart"), warehouseUtilizationOptions);
        warehouseUtilizationChart.render();

        // Shipment Status Chart
        const shipmentStatusOptions = {
            chart: {
                type: 'donut',
                height: 350,
            },
            series: <?php echo json_encode($shipmentSeries); ?>,
            labels: <?php echo json_encode($shipmentLabels); ?>,
            title: {
                text: 'Shipment Status',
            },
        };
        const shipmentStatusChart = new ApexCharts(document.querySelector("#shipmentStatusChart"), shipmentStatusOptions);
        shipmentStatusChart.render();

        // Top Products by Weight Chart
        const topProductsOptions = {
            chart: {
                type: 'bar',
                height: 350,
            },
            series: [{
                name: 'Weight',
                data: <?php echo json_encode($productSeries); ?>,
            }],
            xaxis: {
                categories: <?php echo json_encode($productLabels); ?>,
            },
            title: {
                text: 'Top Products by Weight',
            },
        };
        const topProductsChart = new ApexCharts(document.querySelector("#topProductsChart"), topProductsOptions);
        topProductsChart.render();

        // Orders by Retailers Chart
        const ordersByRetailersOptions = {
            chart: {
                type: 'pie',
                height: 350,
            },
            series: <?php echo json_encode($retailerSeries); ?>,
            labels: <?php echo json_encode($retailerLabels); ?>,
            title: {
                text: 'Orders by Retailers',
            },
        };
        const ordersByRetailersChart = new ApexCharts(document.querySelector("#ordersByRetailersChart"), ordersByRetailersOptions);
        ordersByRetailersChart.render();
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
