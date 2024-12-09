<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe Food and Trace System</title>
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
            <a href="index.html">
              <i class='bx bx-grid-alt' ></i>
              <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#">Category</a></li>
            </ul>
          </li>

          <li>
            <a href="trace_index.html">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="link_name">Trace Product</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#"></a></li>
            </ul>
          </li>
          <li>
            <a href="#">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">Chart</span>
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
              <div class="row">
                 <!-- Top Farmer Table -->
<div class="col-xl-4 col-md-6 box-col-6">
  <div class="card shadow-sm styled-card">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Top Farmers</h4>
      </div>
      <div class="card-body p-0">
          <div class="table-responsive">
              <table class="table table-borderless table-striped">
                  <thead class="bg-light">
                      <tr>
                          <th>Farmer ID</th>
                          <th>Name</th>
                          <th>Location</th>
                          <th>Product (Grow)</th>
                          <th>Production</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Sample data, replace with dynamic content -->
                      <tr>
                          <td>F123</td>
                          <td>Abul Mia</td>
                          <td>Rajshahi</td>
                          <td>Mango</td>
                          <td>1,200 kg</td>
                      </tr>
                      <tr>
                          <td>F456</td>
                          <td>Badsha Chowdhury</td>
                          <td>Barishal</td>
                          <td>Coconut Water</td>
                          <td>950 kg</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<!-- Top Retailer Table -->
<div class="col-xl-4 col-md-6 box-col-6">
  <div class="card shadow-sm styled-card">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Top Retailers</h5>
      </div>
      <div class="card-body p-0">
          <div class="table-responsive">
              <table class="table table-borderless table-striped">
                  <thead class="bg-light">
                      <tr>
                          <th>Retailer ID</th>
                          <th>Name</th>
                          <th>Location</th>
                          <th>Products Sold</th>
                          <th>Order</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Sample data, replace with dynamic content -->
                      <tr>
                          <td>R789</td>
                          <td>Apon Mart</td>
                          <td>Bashundhara</td>
                          <td>Fruits</td>
                          <td>450</td>
                      </tr>
                      <tr>
                          <td>R234</td>
                          <td>Shorshe Ilish</td>
                          <td>IUB Canteen</td>
                          <td>Food</td>
                          <td>45</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<!-- Top Warehouse Table -->
<div class="col-xl-4 col-md-6 box-col-6">
  <div class="card shadow-sm styled-card">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Top Warehouses</h5>
      </div>
      <div class="card-body p-0">
          <div class="table-responsive">
              <table class="table table-borderless table-striped">
                  <thead class="bg-light">
                      <tr>
                          <th>Warehouse ID</th>
                          <th>Manager Name</th>
                          <th>Manager ID</th>
                          <th>Contact No.</th>
                          <th>Location</th>
                          <th>Capacity</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Sample data, replace with dynamic content -->
                      <tr>
                          <td>W001</td>
                          <td>Dip Kundu</td>
                          <td>M123</td>
                          <td>+8801749822422</td>
                          <td>Bashundhara</td>
                          <td>5,000 tons</td>
                      </tr>
                      <tr>
                          <td>W002</td>
                          <td>Shakibur Rahman</td>
                          <td>M456</td>
                          <td>+1 987-654-321</td>
                          <td>Dinajpur</td>
                          <td>4,500 tons</td>
                      </tr>
                  </tbody>
              </table>
          </div>
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