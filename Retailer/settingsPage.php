

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

// Fetch all retailers for selection
$retailersQuery = "SELECT retailerID, firstname, lastname FROM retailers_t";
$retailersResult = $conn->query($retailersQuery);

// Fetch selected retailer details
$retailerID = isset($_GET['retailerID']) ? (int)$_GET['retailerID'] : null;
$retailer = null;

if ($retailerID) {
    $retailerQuery = "SELECT * FROM retailers_t WHERE retailerID = ?";
    $stmt = $conn->prepare($retailerQuery);
    $stmt->bind_param("i", $retailerID);
    $stmt->execute();
    $retailerResult = $stmt->get_result();
    $retailer = $retailerResult->fetch_assoc();
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateRetailer'])) {
    $retailerID = (int)$_POST['retailerID'];
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $status = $conn->real_escape_string($_POST['status']);
    $trade_license_no = $conn->real_escape_string($_POST['trade_license_no']);
    $contactNO = $conn->real_escape_string($_POST['contactNO']);
    $sub_district = $conn->real_escape_string($_POST['sub_district']);
    $district = $conn->real_escape_string($_POST['district']);
    $division = $conn->real_escape_string($_POST['division']);
    

    $updateQuery = "
        UPDATE retailers_t 
        SET 
            firstname = ?, 
            lastname = ?, 
            gender = ?, 
            username = ?, 
            email = ?, 
            password = ?, 
            status = ?, 
            trade_license_no = ?, 
            contactNO = ?, 
            sub_district = ?, 
            district = ?, 
            division = ?, 
           
        WHERE 
            retailerID = ?
    ";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param(
        "ssssssssssssi",
        $firstname,
        $lastname,
        $gender,
        $username,
        $email,
        $password,
        $status,
        $trade_license_no,
        $contactNO,
        $sub_district,
        $district,
        $division,
        $retailerID
    );

    if ($stmt->execute()) {
        $successMessage = "Retailer details updated successfully!";
    } else {
        $errorMessage = "Failed to update retailer details: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer</title>
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
            <div class="profile_name">Rafik Ali</div>
            <div class="job">Farmer</div>
          </div>
          <i class='bx bx-log-out' ></i>
        </div>
      </li>
    </ul>
      </div>
      <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
          
        </div>
        <div class="container-fluid default-dashboard">
            <div class="row">
                <!-- Welcome Banner Card -->
            </div>


        </div>
      


            
      
        <div class="container mt-5">
    <h2 class="text-center">Update Retailer Details</h2>
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- Retailer Selection -->
    <form method="GET" action="">
        <div class="mb-3">
            <label for="retailerID" class="form-label">Select Retailer:</label>
            <select id="retailerID" name="retailerID" class="form-select" onchange="this.form.submit()">
                <option value="">-- Select Retailer --</option>
                <?php while ($row = $retailersResult->fetch_assoc()): ?>
                    <option value="<?php echo $row['retailerID']; ?>" <?php echo ($retailerID == $row['retailerID']) ? 'selected' : ''; ?>>
                        <?php echo $row['firstname'] . " " . $row['lastname']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </form>

    <!-- Retailer Details Form -->
    <?php if ($retailer): ?>
        <form method="POST" action="">
            <input type="hidden" name="retailerID" value="<?php echo $retailer['retailerID']; ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $retailer['firstname']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $retailer['lastname']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="gender" name="gender" class="form-select" disabled>
                        <option value="male" <?php echo $retailer['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo $retailer['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo $retailer['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo $retailer['username']; ?>" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo $retailer['email']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" value="<?php echo $retailer['password']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="active" <?php echo $retailer['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $retailer['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="trade_license_no" class="form-label">Trade License No</label>
                    <input type="text" id="trade_license_no" name="trade_license_no" class="form-control" value="<?php echo $retailer['trade_license_no']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="contactNO" class="form-label">Contact No</label>
                    <input type="text" id="contactNO" name="contactNO" class="form-control" value="<?php echo $retailer['contactNO']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="sub_district" class="form-label">Sub District</label>
                    <input type="text" id="sub_district" name="sub_district" class="form-control" value="<?php echo $retailer['sub_district']; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="district" class="form-label">District</label>
                    <input type="text" id="district" name="district" class="form-control" value="<?php echo $retailer['district']; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="division" class="form-label">Division</label>
                    <input type="text" id="division" name="division" class="form-control" value="<?php echo $retailer['division']; ?>" required>
                </div>
            </div>
            <button type="submit" name="updateRetailer" class="btn btn-primary w-100">Update Retailer Details</button>
        </form>
    <?php else: ?>
        <p class="text-center text-danger">Please select a retailer to view details.</p>
    <?php endif; ?>
</div>
</body>
    

      

     
  
                <!-- end of the page -->

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
