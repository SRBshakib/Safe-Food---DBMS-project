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

// Fetch all managers for the selection dropdown
$managersQuery = "SELECT managerID, firstname, lastname FROM warehouse_managers_t";
$managersResult = $conn->query($managersQuery);

// Handle selected managerID (from session or form submission)
session_start();
$selectedManagerID = isset($_POST['managerID']) 
    ? (int)$_POST['managerID'] 
    : (isset($_SESSION['selectedManagerID']) ? $_SESSION['selectedManagerID'] : null);
$_SESSION['selectedManagerID'] = $selectedManagerID;

// Fetch selected manager details
$managerData = null;
if ($selectedManagerID) {
    $managerQuery = "SELECT * FROM warehouse_managers_t WHERE managerID = ?";
    $stmt = $conn->prepare($managerQuery);
    $stmt->bind_param("i", $selectedManagerID);
    $stmt->execute();
    $managerResult = $stmt->get_result();
    $managerData = $managerResult->fetch_assoc();
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateManager'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];

    $updateQuery = "
        UPDATE warehouse_managers_t 
        SET username = ?, password = ?, firstname = ?, lastname = ?, email = ?, phone = ?, gender = ?, status = ?
        WHERE managerID = ?
    ";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssssssi", $username, $password, $firstname, $lastname, $email, $phone, $gender, $status, $selectedManagerID);

    if ($stmt->execute()) {
        echo "<script>alert('Manager profile updated successfully!');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to update profile: " . $conn->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Manger</title>
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
            <a href="#">
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
        <h2 class="text-center">Select and Update Manager Details</h2>

        <!-- Manager Selection -->
        <form method="POST" action="" class="mt-4">
            <div class="row mb-4">
                <div class="col-md-6 offset-md-3">
                    <label for="managerID" class="form-label">Select Manager</label>
                    <select class="form-select" id="managerID" name="managerID" onchange="this.form.submit()">
                        <option value="">-- Select Manager --</option>
                        <?php while ($row = $managersResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['managerID']; ?>" 
                                <?php echo ($selectedManagerID == $row['managerID']) ? 'selected' : ''; ?>>
                                <?php echo $row['firstname'] . " " . $row['lastname']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
        </form>

        <!-- Manager Details Form -->
        <?php if ($managerData): ?>
            <form method="POST" action="" class="mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="managerID" class="form-label">Manager ID</label>
                            <input type="text" class="form-control" id="managerID" name="managerID" value="<?php echo $managerData['managerID']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="affiliation_date" class="form-label">Affiliation Date</label>
                            <input type="text" class="form-control" id="affiliation_date" name="affiliation_date" value="<?php echo $managerData['affiliation_date']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $managerData['username']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $managerData['password']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $managerData['firstname']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $managerData['lastname']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $managerData['email']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $managerData['phone']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" disabled>
                                <option value="male" <?php echo ($managerData['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo ($managerData['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                                <option value="other" <?php echo ($managerData['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?php echo ($managerData['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo ($managerData['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" name="updateManager" class="btn btn-primary w-100">Update Profile</button>
            </form>
        <?php else: ?>
            <p class="text-center mt-4">Please select a manager to view and update details.</p>
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
