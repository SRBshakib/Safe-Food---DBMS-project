<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Retailer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Retailar.css"> <!-- Link to custom CSS -->
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
        <a href="index.html">
          <i class='bx bx-grid-alt'></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Category</a></li>
        </ul>
      </li>

      <li>
        <a href="#">
          <i class='bx bx-pie-chart-alt-2'></i>
          <span class="link_name">Analytics</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Analytics</a></li>
        </ul>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-line-chart'></i>
          <span class="link_name">Chart</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Chart</a></li>
        </ul>
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
          <i class='bx bx-cog'></i>
          <span class="link_name">Setting</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Setting</a></li>
        </ul>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-support'></i>
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
            <div class="profile_name">Abdullah Yousuf</div>
            <div class="job">Retailer</div>
          </div>
          <i class='bx bx-log-out'></i>
        </div>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu'></i>
      <span class="text">Retailer Dashboard</span>
    </div>
    <div class="container-fluid default-dashboard">
      <div class="row">
        <!-- Welcome Banner Card -->
        <div class="col-xl-4 proorder-xxl-1 col-sm-6 box-col-6">
          <div class="card welcome-banner">
            <div class="card-header p-0 card-no-border">
              <div class="welcome-card">
                <img class="w-100 img-fluid" src="images/welcome-bg.png" alt="">
                <img class="position-absolute img-1 img-fluid" src="" alt="">
                <img class="position-absolute img-2 img-fluid" src="Image/Cover.jpg" alt="">
                <img class="position-absolute img-3 img-fluid" src="images/img-3.png" alt="">
                <img class="position-absolute img-4 img-fluid" src="images/img-4.png" alt="">
                <img class="position-absolute img-5 img-fluid" src="images/img-5.png" alt="">
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex align-center">
                <h1>
                  "Hello, Mr. Yousuf"
                  <img src="images/hand.png" alt="">
                </h1>
              </div>
              <p>Good to have you back, Yousuf! Let’s make today productive..</p>
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
            <div id="inspectionImageSlider" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="Image/New vegi.jpg" class="d-block w-100" alt="First Inspection">
                </div>
                <div class="carousel-item">
                  <img src="Image/Chicken.jpg" class="d-block w-100" alt="Second Inspection">
                </div>
                <div class="carousel-item">
                  <img src="Image/Meat.jpg" class="d-block w-100" alt="Third Inspection">
                </div>
                <div class="carousel-item">
                  <img src="Image/NEw Fruit img.jpg" class="d-block w-100" alt="Fourth Inspection">
                </div>
                <div class="carousel-item">
                  <img src="Image/Pal Fresh header_edited.jpg" class="d-block w-100" alt="Fifth Inspection">
                </div>
                
                
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#inspectionImageSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#inspectionImageSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 box-col-6">
          <div class="card inspection-card styled-card shadow-sm">
            <div class="card-header text-center">
              <h5 class="card-title">Summary of Sold Products</h5>
            </div>
            <div class="card-body">
              <ul id="soldProductsList" class="product-list">
                <!-- Items will be populated here dynamically -->
              </ul>
            </div>
          </div>
        </div>
      <div>
        <div class="row">
          <!-- First Card: Upcoming Inspection List -->
          <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
            <div class="card shadow-sm rounded-table">
              <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Product List</h5>
                <button class="btn btn-sm btn-primary" onclick="updateUpcomingList()">Update</button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-borderless align-middle">
                    <thead>
                      <tr >
                        <th><input type="checkbox"></th>
                        <th>Product Name</th>
                        <th>Inspection ID</th>
                        <th>Batch ID</th>
                        <th>Where</th>
                        <th>Exp.Date</th>
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
                <h5 class="mb-0">Selling History</h5>
                <button class="btn btn-sm btn-primary" onclick="updateBatchLocation()">Update</button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-borderless align-middle">
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th>Batch ID</th>
                        <th>Quantity</th>
                        <th>Exp.Date</th>
                        <th>Price</th>
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
      { productName: 'Organic Apples', id: 'INSP001', batchId: 'BATCH123', where: 'Warehouse', Exp_Date: '25 Dec 2024', status: 'Available' },
      { productName: 'Fresh Tomatoes', id: 'INSP002', batchId: 'BATCH456', where: 'Retailer', Exp_Date: '20 Jan 2025', status: 'Available' },
      { productName: 'Frozen Fish', id: 'INSP003', batchId: 'BATCH789', where: 'Transport', Exp_Date: '25 Dec 2024', status: 'Available' },
      { productName: 'Canned Beans', id: 'INSP004', batchId: 'BATCH101', where: 'Warehouse', Exp_Date: '20 Jan 2025', status: 'Available' },
      { productName: 'Lettuce', id: 'INSP005', batchId: 'BATCH202', where: 'Retailer', Exp_Date: '25 Dec 2024', status: 'Available' },
      { productName: 'Oranges', id: 'INSP006', batchId: 'BATCH303', where: 'Warehouse', Exp_Date: '20 Jan 2025', status: 'Available' },



    ];

    let batchLocationData = [
      { productName: 'Organuic Apple', batchId: 'BATCH143', Quantity: '2 KG', Exp_Date:'20 Jan 2025',Price:'400.00 BDT' },
      { productName: 'Mango', batchId: 'BATCH423', Quantity: '1 KG', Exp_Date:'20 Mar 2025',Price:'250.00 BDT' },
      { productName: 'Rui Fish', batchId: 'BATCH323', Quantity: '3.5 KG', Exp_Date:'N/A',Price:'900.00 BDT' },
      { productName: 'Beans', batchId: 'BATCH163', Quantity: '0.5 KG', Exp_Date:'N/A',Price:'40.00 BDT' },
      { productName: 'Orange', batchId: 'BATCH123', Quantity: '1 KG', Exp_Date:'20 Jan 2025',Price:'200.00 BDT' },
      { productName: 'Meat ball', batchId: 'BATCH333', Quantity: '0.5 KG', Exp_Date:'25 Jul 2025',Price:'340.00 BDT' },
      
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
            <td>${upcomingListData[i].productName}</td>
            <td>${upcomingListData[i].id}</td>
            <td>${upcomingListData[i].batchId}</td>
            <td>${upcomingListData[i].where}</td>
            <td>${upcomingListData[i].Exp_Date}</td>
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
            <td>${batchLocationData[i].productName}</td>
            <td>${batchLocationData[i].batchId}</td>
            <td>${batchLocationData[i].Quantity}</td>
            <td>${batchLocationData[i].Exp_Date}</td>
            <td>${batchLocationData[i].Price}</td>
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
    document.addEventListener("DOMContentLoaded", function () {
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


    // Sample data with quantities for each product category
const soldProductsData = {
  Vegetables: "50 kg",
  Fruits: "30 kg",
  Fish: "20 kg",
  Meats: "25 kg",
  Frozen_Food: "40 kg"
};

// Function to populate the list
function loadSoldProductsSummary() {
  const soldProductsList = document.getElementById("soldProductsList");
  soldProductsList.innerHTML = ''; // Clear existing content

  // Loop through each category in the data and create a list item
  for (const [category, quantity] of Object.entries(soldProductsData)) {
    const listItem = document.createElement("li");
    listItem.textContent = `${category}: ${quantity}`;
    soldProductsList.appendChild(listItem);
  }
}

// Call the function to load the summary on page load
document.addEventListener("DOMContentLoaded", loadSoldProductsSummary);

    // Initialize the time immediately on load
    updateTime();
  </script>
</body>

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>