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

// Fetch warehouses for the filter
$warehouseQuery = "SELECT DISTINCT wi.warehouseID, w.Sub_district 
                   FROM w_inventory_t wi
                   JOIN warehouse_t w ON wi.warehouseID = w.warehouseID";
$warehouseResult = $conn->query($warehouseQuery);

// Fetch batches based on the selected warehouse
$selectedWarehouse = isset($_POST['warehouseFilter']) ? $_POST['warehouseFilter'] : 'all';
$batchQuery = "
    SELECT 
        wi.pbatchID, wi.productID, p.product_name, p.mrp, wi.warehouseID, w.Sub_district, 
        wi.weight AS available_weight, wi.quantity AS available_quantity, 
        DATE_ADD(l.production_date, INTERVAL p.shelf_life DAY) AS expire_date 
    FROM 
        w_inventory_t wi
    JOIN 
        product_t p ON wi.productID = p.productID
    JOIN 
        warehouse_t w ON wi.warehouseID = w.warehouseID
    JOIN 
        processed_batch_t pb ON wi.pbatchID = pb.pbatchID
    JOIN 
        lot_t l ON pb.lotID = l.lotID
    WHERE wi.weight > 0"; // Only show batches with available weight

if ($selectedWarehouse !== 'all') {
    $batchQuery .= " AND wi.warehouseID = " . intval($selectedWarehouse);
}
$batchResult = $conn->query($batchQuery);

// Fetch retailers
$retailerQuery = "SELECT retailerID, lastname FROM retailers_t";
$retailerResult = $conn->query($retailerQuery);

// Handle Place Order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    $retailerID = (int)$_POST['retailerID'];
    $cartItems = isset($_POST['cartItems']) ? json_decode($_POST['cartItems'], true) : [];

    if ($retailerID && !empty($cartItems)) {
        foreach ($cartItems as $item) {
            $pbatchID = (int)$item['pbatchID'];
            $warehouseID = (int)$item['warehouseID'];
            $quantity = (int)$item['quantity'];
            $weight = (float)$item['weight'];

            // Fetch the available weight from w_inventory_t
            $checkBatchQuery = "SELECT weight FROM w_inventory_t WHERE pbatchID = ? AND warehouseID = ?";
            $checkStmt = $conn->prepare($checkBatchQuery);
            $checkStmt->bind_param("ii", $pbatchID, $warehouseID);
            $checkStmt->execute();
            $batchData = $checkStmt->get_result()->fetch_assoc();

            if ($batchData['weight'] < $weight) {
                echo "<script>alert('Order exceeds available batch weight for Batch ID: $pbatchID');</script>";
                continue; // Skip this batch if the order exceeds available weight
            }

            $status = 'Pending';
            $orderDate = date('Y-m-d');
            $orderTime = date('H:i:s');

            // Insert order into purchase_order_t
            $insertOrderQuery = "
                INSERT INTO purchase_order_t (retailerID, warehouseID, pbatchID, weight, quantity, order_date, order_time, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertOrderQuery);
            $stmt->bind_param("iiiidsss", $retailerID, $warehouseID, $pbatchID, $weight, $quantity, $orderDate, $orderTime, $status);
            $stmt->execute();

            // Update w_inventory_t
            $updateInventoryQuery = "
                UPDATE w_inventory_t 
                SET weight = weight - ?, quantity = quantity - ? 
                WHERE pbatchID = ? AND warehouseID = ?";
            $updateStmt = $conn->prepare($updateInventoryQuery);
            $updateStmt->bind_param("diid", $weight, $quantity, $pbatchID, $warehouseID);
            $updateStmt->execute();
        }
        echo "<script>alert('Order placed successfully!');</script>";
    } else {
        echo "<script>alert('Cart is empty or Retailer not selected.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Order page</title>
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
          <span class="logo_name">TraceRoot</span>
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
            <div class="job">Reatiler</div>
          </div>
          <i class='bx bx-log-out' ></i>
        </div>
      </li>
    </ul>
      </div>
      <section class="home-section">

        
        <div class="home-content">
          <i class='bx bx-menu' ></i>
          <span class="text">Reatiler Orders</span>
        </div>

        <div class="container mt-4">
    <div class="row">
        <!-- Filter Section -->
        <div class="col-md-3">
            <h5>Filters</h5>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="warehouseFilter" class="form-label">Warehouse:</label>
                    <select id="warehouseFilter" name="warehouseFilter" class="form-select" onchange="this.form.submit()">
                        <option value="all" <?php echo $selectedWarehouse === 'all' ? 'selected' : ''; ?>>All Warehouses</option>
                        <?php while ($row = $warehouseResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['warehouseID']; ?>" <?php echo $row['warehouseID'] == $selectedWarehouse ? 'selected' : ''; ?>>
                                WH-<?php echo $row['warehouseID'] . " (" . $row['Sub_district'] . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </form>
        </div>

        <!-- Batch List -->
        <div class="col-md-9">
            <h5>Available Batches</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Batch ID</th>
                            <th>Product Name</th>
                            <th>Warehouse</th>
                            <th>Available Weight</th>
                            <th>Available Quantity</th>
                            <th>Expire Date</th>
                            <th>MRP</th>
                            <th>Buy Weight</th>
                            <th>Buy Quantity</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $batchResult->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-link batch-details"
                                            data-bs-toggle="modal" data-bs-target="#batchDetailsModal"
                                            data-pbatch-id="<?php echo $row['pbatchID']; ?>"
                                            data-product-name="<?php echo $row['product_name']; ?>"
                                            data-warehouse="<?php echo 'WH-' . $row['warehouseID'] . ' (' . $row['Sub_district'] . ')'; ?>"
                                            data-weight="<?php echo $row['available_weight']; ?>"
                                            data-quantity="<?php echo $row['available_quantity']; ?>"
                                            data-expire-date="<?php echo $row['expire_date']; ?>"
                                            data-mrp="<?php echo $row['mrp']; ?>">
                                        <?php echo $row['pbatchID']; ?>
                                    </button>
                                </td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo "WH-" . $row['warehouseID'] . " (" . $row['Sub_district'] . ")"; ?></td>
                                <td><?php echo $row['available_weight']; ?> KG</td>
                                <td><?php echo $row['available_quantity']; ?></td>
                                <td><?php echo $row['expire_date']; ?></td>
                                <td><?php echo $row['mrp']; ?> BDT</td>
                                <td><input type="number" class="form-control form-control-sm buying-weight" min="0"></td>
                                <td><input type="number" class="form-control form-control-sm buying-quantity" min="0"></td>
                                <td><input type="checkbox" class="select-batch" data-batch="<?php echo htmlspecialchars(json_encode($row)); ?>"></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Shopping Cart -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h5>Shopping Cart</h5>
            <div id="cartContainer"></div>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="retailerID" class="form-label">Select Retailer:</label>
                    <select id="retailerID" name="retailerID" class="form-select" required>
                        <option value="">-- Select Retailer --</option>
                        <?php while ($row = $retailerResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['retailerID']; ?>"><?php echo $row['lastname']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <input type="hidden" name="cartItems" id="cartItemsInput">
                <button type="submit" name="placeOrder" class="btn btn-success w-100">Place Order</button>
            </form>
        </div>
    </div>
</div>

<!-- Batch Details Modal -->
<div class="modal fade" id="batchDetailsModal" tabindex="-1" aria-labelledby="batchDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="batchDetailsModalLabel">Batch Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Batch ID:</strong> <span id="modalBatchID"></span></li>
                    <li class="list-group-item"><strong>Product Name:</strong> <span id="modalProductName"></span></li>
                    <li class="list-group-item"><strong>Warehouse:</strong> <span id="modalWarehouse"></span></li>
                    <li class="list-group-item"><strong>Available Weight:</strong> <span id="modalWeight"></span></li>
                    <li class="list-group-item"><strong>Available Quantity:</strong> <span id="modalQuantity"></span></li>
                    <li class="list-group-item"><strong>Expire Date:</strong> <span id="modalExpireDate"></span></li>
                    <li class="list-group-item"><strong>MRP:</strong> <span id="modalMRP"></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
let cart = [];

// Show modal with batch details
document.querySelectorAll('.batch-details').forEach(button => {
    button.addEventListener('click', function () {
        document.getElementById('modalBatchID').textContent = this.getAttribute('data-pbatch-id');
        document.getElementById('modalProductName').textContent = this.getAttribute('data-product-name');
        document.getElementById('modalWarehouse').textContent = this.getAttribute('data-warehouse');
        document.getElementById('modalWeight').textContent = this.getAttribute('data-weight') + ' KG';
        document.getElementById('modalQuantity').textContent = this.getAttribute('data-quantity') + ' Units';
        document.getElementById('modalExpireDate').textContent = this.getAttribute('data-expire-date');
        document.getElementById('modalMRP').textContent = this.getAttribute('data-mrp') + ' BDT';
    });
});

// Add selected batch to cart
document.querySelectorAll('.select-batch').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const batchData = JSON.parse(this.getAttribute('data-batch'));
        const row = this.closest('tr');
        const weight = parseFloat(row.querySelector('.buying-weight').value) || 0;
        const quantity = parseInt(row.querySelector('.buying-quantity').value) || 0;
        const totalMRP = batchData.mrp * (weight > 0 ? weight : quantity);

        if (this.checked) {
            cart.push({
                pbatchID: batchData.pbatchID,
                warehouseID: batchData.warehouseID,
                weight,
                quantity,
                totalMRP,
            });
        } else {
            cart = cart.filter(item => item.pbatchID !== batchData.pbatchID);
        }
        updateCart();
    });
});

// Update shopping cart
function updateCart() {
    const cartContainer = document.getElementById('cartContainer');
    cartContainer.innerHTML = cart.map(item => `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>Batch ${item.pbatchID} (${item.weight > 0 ? `${item.weight} KG` : `${item.quantity} Units`})</div>
            <div>${item.totalMRP.toFixed(2)} BDT</div>
        </div>
    `).join('');
    document.getElementById('cartItemsInput').value = JSON.stringify(cart);
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


function calculateAndDisplayBreakdown() {
  const rows = document.querySelectorAll("#upcomingListBody tr"); // Select all rows in the table
  let totalQuantity = 0;
  let totalPrice = 0;
  const breakdownContainer = document.getElementById("breakdownContainer"); // Container to display breakdown
  breakdownContainer.innerHTML = ""; // Clear previous breakdown

  let serialNumber = 1; // Counter for numbering

  // Loop through each row to calculate and generate breakdown
  rows.forEach((row) => {
    const quantityInput = row.querySelector('input[type="number"]'); // Find the quantity input
    const unitPriceText = row.cells[5]?.textContent?.trim(); // Get the unit price text
    const productName = row.cells[1]?.textContent?.trim(); // Get the product name
    const quantity = parseInt(quantityInput?.value || 0); // Parse quantity as integer
    const unitPrice = parseFloat(unitPriceText?.replace(/[^0-9.-]+/g, "")) || 0; // Parse unit price as float

    if (quantity > 0) {
      const productTotal = quantity * unitPrice; // Calculate total for the product
      totalQuantity += quantity; // Add to total quantity
      totalPrice += productTotal; // Add to total price

      // Append breakdown for this product
      breakdownContainer.innerHTML += `
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div>${serialNumber}. ${productName} (x${quantity})</div>
          <div>${productTotal.toFixed(2)} BDT</div>
        </div>
      `;

      serialNumber++; // Increment serial number only for rows with valid quantity
    }
  });

  // Append total quantity and price at the end
  breakdownContainer.innerHTML += `
    <hr>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div><strong>Total Items:</strong></div>
      <div><strong>${totalQuantity}</strong></div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div><strong>Total Amount:</strong></div>
      <div><strong>${totalPrice.toFixed(2)} BDT</strong></div>
    </div>
  `;
}

document.querySelector(".btn-success").addEventListener("click", calculateAndDisplayBreakdown); // Attach to ADD button

// Function for "Order" button click
function handleOrder() {
  const totalAmount = document.querySelector("#breakdownContainer").innerText.includes("Total Amount") 
    ? document.querySelector("#breakdownContainer").lastElementChild.lastElementChild.textContent 
    : "0 BDT";

  if (parseFloat(totalAmount.replace(/[^0-9.-]+/g, "")) > 0) {
    alert(`Your order has been placed. Total Amount: ${totalAmount}`);
  } else {
    alert("Your cart is empty. Please add items to your cart before placing an order.");
  }
}

// Function for "Refresh" button click
function handleRefresh() {
  const rows = document.querySelectorAll("#upcomingListBody tr input[type='number']");
  rows.forEach((input) => {
    input.value = 0; // Reset quantity to 0
  });

  calculateAndDisplayBreakdown(); // Refresh the breakdown section
}

// Attach event listeners to buttons
document.getElementById("orderButton").addEventListener("click", handleOrder);
document.getElementById("refreshButton").addEventListener("click", handleRefresh);


      </script>

</body>

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
