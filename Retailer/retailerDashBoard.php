
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
            <a href="retailerDashBoard.php">
              <i class='bx bx-grid-alt' ></i>
              <span class="link_name">Dashboard</span>
            </a>
          </li>
          <li>
        <a href="retailerInventroy.php">
          <i class='bx bx-history'></i>
          <span class="link_name">Inventory</span>
        </a>
          <li>
            <a href="receiveOrder.php">
            <i class='bx bx-transfer' ></i>
              <span class="link_name">Recive Product</span>
            </a>
            <
          </li>
          <li>
            <a href="New_Order.php">
            <i class='bx bxs-store'></i>
              <span class="link_name">Retailer Order</span>
            </a>
          </li>
          <li>
            <a href="history.php">
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

                <!-- Pie Chart Card -->
                <div class="col-xl-4 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h5 class="card-title">Sales Distribution</h5>
                        </div>
                        <div class="card-body">
                            <div id="salesPieChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Line Chart Card -->
                <div class="col-xl-4 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h5 class="card-title">Sales Trend</h5>
                        </div>
                        <div class="card-body">
                            <div id="salesLineChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Table -->
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Inventory</h5>
                            <input type="text" id="searchInventory" class="form-control w-25" placeholder="Search Inventory">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="inventoryTableBody">
                                        <!-- Dynamic inventory rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Timer Function
        function updateTime() {
            const timerElement = document.getElementById("timer");
            const now = new Date();
            timerElement.textContent = now.toLocaleString();
        }
        setInterval(updateTime, 1000);

        // Pie Chart Data
        const pieChartData = {
            labels: ["Vegetables", "Fruits", "Fish", "Meat", "Frozen Food"],
            series: [30, 25, 20, 15, 10]
        };

        // Pie Chart Configuration
        const pieChartOptions = {
            chart: { type: "pie", height: 250 },
            labels: pieChartData.labels,
            series: pieChartData.series,
            colors: ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0"],
        };
        new ApexCharts(document.querySelector("#salesPieChart"), pieChartOptions).render();

        // Line Chart Data
        const lineChartData = {
            categories: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
            series: [
                { name: "Vegetables", data: [10, 20, 15, 25, 30] },
                { name: "Fruits", data: [15, 25, 20, 30, 35] },
            ]
        };

        // Line Chart Configuration
        const lineChartOptions = {
            chart: { type: "line", height: 250 },
            xaxis: { categories: lineChartData.categories },
            series: lineChartData.series,
            colors: ["#008FFB", "#FEB019"],
        };
        new ApexCharts(document.querySelector("#salesLineChart"), lineChartOptions).render();

        // Inventory Data
        const inventoryData = [
            { productName: "Apples", category: "Fruits", quantity: 5 },
            { productName: "Carrots", category: "Vegetables", quantity: 2 },
            { productName: "Chicken", category: "Meat", quantity: 8 },
            { productName: "Fish", category: "Seafood", quantity: 10 },
            { productName: "Ice Cream", category: "Frozen Food", quantity: 4 },
        ];

        // Load Inventory Data
        function loadInventory() {
            const tbody = document.getElementById("inventoryTableBody");
            tbody.innerHTML = "";
            inventoryData.forEach(item => {
                const status = item.quantity < 5 ? "Low Stock" : "In Stock";
                const statusClass = item.quantity < 5 ? "bg-danger" : "bg-success";
                tbody.innerHTML += `
                    <tr>
                        <td>${item.productName}</td>
                        <td>${item.category}</td>
                        <td>${item.quantity}</td>
                        <td><span class="badge ${statusClass}">${status}</span></td>
                    </tr>
                `;
            });
        }

        // Search Inventory
        document.getElementById("searchInventory").addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll("#inventoryTableBody tr");
            rows.forEach(row => {
                const productName = row.cells[0].textContent.toLowerCase();
                const category = row.cells[1].textContent.toLowerCase();
                if (productName.includes(searchTerm) || category.includes(searchTerm)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        // Initialize Inventory on Page Load
        document.addEventListener("DOMContentLoaded", function () {
            loadInventory();
        });
    </script>
  </section>

 


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