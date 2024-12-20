<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this with your database username
$password = ""; // Change this with your database password
$dbname = "traceroots"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle accept or reject actions
if (isset($_GET['action']) && isset($_GET['ID'])) {  // Ensure 'ID' is capitalized
  $userId = $_GET['ID'];  // Correct 'ID' as it is capitalized in the database
  $action = $_GET['action'];

  if ($action == 'accept') {
      // Get user data from pending_users_t table
      $sql = "SELECT * FROM pending_users_t WHERE ID = '$userId'";  // Correct 'ID' as it is capitalized
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          $user = $result->fetch_assoc();

          // Get category of the user
          $category = $user['category'];
          
          // Define the table based on category
          $table = "";
          switch ($category) {
              case 'farmer':
                  $table = "farmers_t";
                  break;
              case 'retailer':
                  $table = "retailers_t";
                  break;
              case 'quality_control_officer':
                  $table = "quality_control_officers_t";
                  break;
              case 'driver':
                  $table = "drivers_t";
                  break;
              case 'warehouse_manager':
                  $table = "warehouse_managers_t";
                  break;
              default:
                  echo "Unknown category!";
                  exit;
          }

          // Insert accepted user into the appropriate table based on category
          $insertSql = "INSERT INTO $table (firstname, lastname, email, username, password, gender, affiliation_date)
                        VALUES ('".$user['firstname']."', '".$user['lastname']."', '".$user['email']."', '".$user['username']."', '".$user['password']."', '".$user['gender']."', NOW())";

          if ($conn->query($insertSql) === TRUE) {
              // Update status of the user to "accepted" in the pending_users_t table and set the affiliation date
              $updateSql = "UPDATE pending_users_t SET status = 'accepted', affiliation_date = NOW() WHERE ID = '$userId'";  // Correct 'ID' as it is capitalized
              $conn->query($updateSql);
          }
      }
  }

  if ($action == 'reject') {
      // Update status of the rejected user to "rejected"
      $updateSql = "UPDATE pending_users_t SET status = 'rejected' WHERE ID = '$userId'";  // Correct 'ID' as it is capitalized
      $conn->query($updateSql);
  }
}


// Fetch pending and accepted users, order by status (pending at top)
$sql = "SELECT * FROM pending_users_t ORDER BY status DESC, id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe Food and Trace System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="personInOrgStyle.css"> <!-- Link to custom CSS -->
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
          </li>
          <li>
            <a href="trace_index.html">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="link_name">Trace Product</span>
            </a>
          </li>
          <li>
            <a href="personInOrg.html">
              <i class='bx bx-line-chart' ></i>
              <span class="link_name">My Organization</span>
            </a>
          </li>
          <li>
            <a href="order_index.html">
              <i class='bx bx-history'></i>
              <span class="link_name">Orders</span>
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
          </li>
          <li>
            <a href="pending.html">
              <i class='bx bx-support' ></i>
              <span class="link_name">Help and Support</span>
            </a>
          </li>
          <li>
            <div class="profile-details">
              <div class="name-job">
                <div class="profile_name">Mr. Admin</div>
                <div class="job">Administrator</div>
              </div>
            </div>
          </li>
        </ul>
    </div>

    <main class="home-section">
        <div class="container-fluid mt-5">
            <h2 class="text-center mb-4">Pending Users</h2>

            <!-- Table for Pending Users -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $user['ID']; ?></td>
                            <td><?php echo $user['firstname']; ?></td>
                            <td><?php echo $user['lastname']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['gender']; ?></td>
                            <td><?php echo $user['status'] == 'pending' ? 'Pending' : ucfirst($user['status']); ?></td>
                            <td>
    <?php if ($user['status'] == 'pending') { ?>
        <a href="?action=accept&ID=<?php echo $user['ID']; ?>" class="btn btn-success">Accept</a>
        <a href="?action=reject&ID=<?php echo $user['ID']; ?>" class="btn btn-danger">Reject</a>
    <?php } else { ?>
        <span class="badge bg-secondary">No Action Needed</span>
    <?php } ?>
</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        const sidebarToggle = document.querySelector('.sidebar');
        const toggleButton = document.querySelector('.bx');

        toggleButton.addEventListener('click', () => {
            sidebarToggle.classList.toggle('close');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
