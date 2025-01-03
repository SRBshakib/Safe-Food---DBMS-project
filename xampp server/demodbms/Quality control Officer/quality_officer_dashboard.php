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
          <li>
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
            <span class="text">Quality Control Officer Dashboard</span>
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
                                    "Hello, Mr. Adnan"
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
                        <div class="card-body text-center">
                            <h5 class="card-title" style="margin-top: 10px !important;" >Total Inspections Today</h5>
                            <p class="display-4">25</p>
                        </div>
                        <div class="card-body text-center">
                          <h5 class="card-title" style="margin-top: -45px !important; " >Inspections panding Today</h5>
                          <p class="display-4">5</p>
                      </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 box-col-6">
                    <div class="card inspection-card styled-card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Inspections This Month</h5>
                            <p class="display-4">150</p>
                        </div>
                    </div>
                </div>
            </div>
            <div >
              <div class="row">
                  <!-- First Card: Upcoming Inspection List -->
                  <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
                      <div class="card shadow-sm rounded-table">
                          <div class="card-header bg-white d-flex justify-content-between align-items-center">
                              <h5 class="mb-0">Upcoming Inspection List</h5>
                              <button class="btn btn-sm btn-primary" onclick="updateUpcomingList()">Update</button>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-borderless align-middle">
                                      <thead>
                                          <tr>
                                              <th><input type="checkbox"></th>
                                              <th>Inspection ID</th>
                                              <th>Batch ID</th>
                                              <th>Where</th>
                                              <th>Product Name</th>
                                              <th>Status</th>
                                          </tr>
                                      </thead>
                                      <tbody id="upcomingListBody">
                                          <!-- Sample Rows (Limited to 5 initially) -->
                                      </tbody>
                                  </table>
                              </div>
                              <button class="btn btn-primary" onclick="loadMoreUpcoming()">Load More</button>
                          </div>
                      </div>
                  </div>
          
                  <!-- Second Card: Batch Location Record -->
                  <div class="col-xl-4 col-lg-5 col-md-12">
                      <div class="card shadow-sm rounded-table">
                          <div class="card-header bg-white d-flex justify-content-between align-items-center">
                              <h5 class="mb-0">Batch Location Record</h5>
                              <button class="btn btn-sm btn-primary" onclick="updateBatchLocation()">Update</button>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-borderless align-middle">
                                      <thead>
                                          <tr>
                                              <th>Batch ID</th>
                                              <th>Where It Is</th>
                                          </tr>
                                      </thead>
                                      <tbody id="batchLocationBody">
                                          <!-- Sample Rows (Limited to 5 initially) -->
                                      </tbody>
                                  </table>
                              </div>
                              <button class="btn btn-primary" onclick="loadMoreBatchLocation()">Load More</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          
          
          
          
          
          
          
          
          
        </div>
    </section>
    
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
