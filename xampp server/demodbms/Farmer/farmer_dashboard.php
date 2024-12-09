

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
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
            <a href="index.html">
              <i class='bx bx-grid-alt' ></i>
              <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#">Category</a></li>
            </ul>
          </li>

          <li>
            <a href="#">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="link_name">Analytics</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="#">Analytics</a></li>
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
            <div class="profile_name">Rafik Ali</div>
            <div class="job">Farmer</div>
          </div>
          <a href="/demodbms/login.php">
          <i class='bx bx-log-out' ></i>
          </a>
          
        </div>
      </li>
    </ul>
      </div>
      <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Farmer Dashboard</span>
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
                        <div class="card-body" style="min-height: 210px !important;">
                            <div class="d-flex align-center">
                                <h1 style="margin-top: 15px;">
                                    "Hello, Mr. Rafik"
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
                        <div class="card-body " id="rating_chart" >
                          
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 box-col-6">
                    <div class="card inspection-card styled-card shadow-sm">
                        <div class="card-body text-center" id="types_chart">
                           <h1>Top Produced Product</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div >
              <div class="row">

<!-- Batch Entry Form -->
<div class="col-xl-4 col-lg-5 col-md-12 mb-4">
  <div class="card shadow-sm rounded-table">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Update Harvesting Product</h5>
      </div>
      <div class="card-body">
          <!-- Harvesting Product Form -->
          <form id="harvestProductForm" class="mb-4">
              <div class="mb-3">
                  <label for="product_type" class="form-label">Product Type</label>
                  <select class="form-select" id="product_type" required>
                      <option selected disabled value="">Select Type</option>
                      <option value="Vegetable">Vegetable</option>
                      <option value="Crop">Crop</option>
                      <option value="Fruit">Fruit</option>
                  </select>
              </div>
              <div class="mb-3">
                  <label for="product_name_input" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="product_name_input" required>
              </div>
              <div class="mb-3">
                <label for="shelf_life_input" class="form-label">Shelf Life</label>
                <input type="text" class="form-control" id="shelf_life_input" required>
              </div>
              <button type="button" class="btn btn-primary" onclick="addProduct()">Add Product</button>
          </form>
      </div>
  </div>
</div>



<!-- Batch Entry Form -->
<div class="col-xl-8 col-lg-7 col-md-12 mb-4">
  <div class="card shadow-sm rounded-table">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Batch Entry</h5>
      </div>
      <div class="card-body">
          <!-- Batch Entry Form -->
          <form id="batchForm" class="mb-4 row">
              <div class="col-md-6 mb-3">
                  <label for="harvest_date" class="form-label">Harvest Date</label>
                  <input type="date" class="form-control" id="harvest_date" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label for="batch_product_type" class="form-label">Type</label>
                  <select class="form-select" id="batch_product_type" onchange="populateProductNames()" required>
                      <option selected disabled value="">Select Type</option>
                      <option value="Vegetable">Vegetable</option>
                      <option value="Crop">Crop</option>
                      <option value="Fruit">Fruit</option>
                  </select>
              </div>
              <div class="col-md-6 mb-3">
                  <label for="batch_product_name" class="form-label">Product Name</label>
                  <select class="form-select" id="batch_product_name" onchange="updateProductIdAndShelfLife()" required>
                      <option selected disabled value="">Select Product</option>
                  </select>
              </div>
              <div class="col-md-6 mb-3">
                  <label for="product_id" class="form-label">Product ID</label>
                  <input type="text" class="form-control" id="product_id" readonly>
              </div>
              <div class="col-md-6 mb-3">
                  <label for="weight" class="form-label">Weight (kg)</label>
                  <input type="number" class="form-control" id="weight" min="0" step="0.1" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="harvest_area" class="form-label">Harvest Area</label>
                <input type="text" class="form-control" id="harvest_area" required>
              </div>
              <div class="col-12">
                  <button type="button" class="btn btn-primary" onclick="addBatch()">Submit Batch</button>
              </div>
          </form>
      </div>
  </div>
</div>

<!-- Batch Table in a Separate Card -->
<div class="col-xl-6 col-lg-7 col-md-12 mb-4">
  <div class="card shadow-sm rounded-table">
      <div class="card-header bg-white">
          <h5 class="mb-0">Submitted Batches</h5>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-borderless align-middle">
                  <thead>
                      <tr>
                          <th>Harvest Date</th>
                          <th>Type</th>
                          <th>Product Name</th>
                          <th>Product ID</th>
                          <th>Weight (kg)</th>
                          <th>Shelf Life</th>
                          <th>Harvest Area</th>
                      </tr>
                  </thead>
                  <tbody id="batchTableBody">
                      <!-- Rows will be added here dynamically -->
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
          </div>
        </div>
    </section>
<!-- types_chart -->
<script>
var options = {
          series: [44, 55, 13],
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: ['Corps', 'Fruits', 'Vegetables'],
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

        var chart = new ApexCharts(document.querySelector("#types_chart"), options);
        chart.render();
</script>

<!--rating_chart--->
    <script>
        var options = {
          series: [67],
          chart: {
          height: 350,
          type: 'radialBar',
          offsetY: -10
        },
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 135,
            dataLabels: {
              name: {
                fontSize: '16px',
                color: undefined,
                offsetY: 120
              },
              value: {
                offsetY: 76,
                fontSize: '22px',
                color: undefined,
                formatter: function (val) {
                  return val + "%";
                }
              }
            }
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
              shade: 'dark',
              shadeIntensity: 0.15,
              inverseColors: false,
              opacityFrom: 1,
              opacityTo: 1,
              stops: [0, 50, 65, 91]
          },
        },
        stroke: {
          dashArray: 4
        },
        labels: ['Overall Rating'],
        };

        var chart = new ApexCharts(document.querySelector("#rating_chart"), options);
        chart.render();
    </script>
    
    <script>
      // Object to store products by type
      let products = {
          Vegetable: [],
          Crop: [],
          Fruit: []
      };
  
      // Function to add a product with a unique ID
      function addProduct() {
          const type = document.getElementById("product_type").value;
          const name = document.getElementById("product_name_input").value;
          const shelfLife = document.getElementById("shelf_life_input").value;
  
          if (!type || !name || !shelfLife) {
              alert("Please fill in all fields.");
              return;
          }
  
          // Generate a unique product ID
          const productId = `P${Math.floor(Math.random() * 10000)}`;
  
          // Add product to the products list
          products[type].push({ name, productId, shelfLife });
  
          alert(`Product ${name} added with ID ${productId} and Shelf Life ${shelfLife}.`);
  
          // Clear form fields
          document.getElementById("harvestProductForm").reset();
      }
  
      // Function to populate the product names based on selected type in batch entry form
      function populateProductNames() {
          const type = document.getElementById("batch_product_type").value;
          const productSelect = document.getElementById("batch_product_name");
  
          // Clear previous options
          productSelect.innerHTML = '<option selected disabled value="">Select Product</option>';
  
          // Populate options based on selected type
          products[type].forEach(product => {
              const option = document.createElement("option");
              option.value = product.name;
              option.text = product.name;
              productSelect.appendChild(option);
          });
      }
  
      // Function to update the Product ID and Shelf Life fields based on selected product name
      function updateProductIdAndShelfLife() {
          const type = document.getElementById("batch_product_type").value;
          const productName = document.getElementById("batch_product_name").value;
          const productIdInput = document.getElementById("product_id");
  
          // Find the selected product ID and Shelf Life
          const product = products[type].find(p => p.name === productName);
          productIdInput.value = product ? product.productId : "";
      }
  
      // Function to add a batch entry to the table
      function addBatch() {
          const harvestDate = document.getElementById("harvest_date").value;
          const type = document.getElementById("batch_product_type").value;
          const productName = document.getElementById("batch_product_name").value;
          const productId = document.getElementById("product_id").value;
          const weight = document.getElementById("weight").value;
          const harvestArea = document.getElementById("harvest_area").value;
          
          // Retrieve the shelf life from the product details in the products list
          const product = products[type].find(p => p.name === productName);
          const shelfLife = product ? product.shelfLife : "";
  
          if (!harvestDate || !type || !productName || !productId || !weight || !harvestArea || !shelfLife) {
              alert("Please fill in all fields.");
              return;
          }
  
          const tableBody = document.getElementById("batchTableBody");
  
          // Insert new row in the table
          const newRow = document.createElement("tr");
          newRow.innerHTML = `
              <td>${harvestDate}</td>
              <td>${type}</td>
              <td>${productName}</td>
              <td>${productId}</td>
              <td>${weight}</td>
              <td>${shelfLife}</td>
              <td>${harvestArea}</td>
          `;
          tableBody.appendChild(newRow);
  
          // Clear form fields
          document.getElementById("batchForm").reset();
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
