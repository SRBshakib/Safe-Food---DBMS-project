<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'traceroots';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to insert data into processed_batch_t and update lot_t
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $lotID = $_POST['lotID'];
    $new_weight = $_POST['new_weight'];
    $new_quantity = $_POST['new_quantity'];
    $certification = $_POST['certification'];
    $rating = $_POST['rating'];
    $processing_date = date('Y-m-d'); // Current date for processing

    // Insert data into processed_batch_t
    $insert_query = "INSERT INTO processed_batch_t (processing_Date, Certification, weight, quantity, rating, product_type, lotID) 
                     VALUES ('$processing_date', '$certification', '$new_weight', '$new_quantity', '$rating', 
                             (SELECT product_type FROM lot_t WHERE lotID = '$lotID'), '$lotID')";

    if ($conn->query($insert_query) === TRUE) {
        // Update status to 'processed' in lot_t
        $update_query = "UPDATE lot_t SET status = 'processed' WHERE lotID = '$lotID'";
        if ($conn->query($update_query) === TRUE) {
            echo "Record processed successfully.";
        } else {
            echo "Error updating status: " . $conn->error;
        }
    } else {
        echo "Error inserting record: " . $conn->error;
    }
}

// Fetch pending data from lot_t
$sql = "SELECT * FROM lot_t WHERE status = 'pending'";
$result = $conn->query($sql);


?>

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
            <span class="text">Set Shelf-life, Temp and Humidity</span>
        </div>
      
    </section>
    <div class="container">
        <h2 class="mb-4">Pending Lots</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Lot ID</th>
                    <th>Production Date</th>
                    <th>Harvest Area</th>
                    <th>Weight</th>
                    <th>Quantity</th>
                    <th>Product ID</th>
                    <th>Farm ID</th>
                    <th>Product Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['lotID'] . '</td>';
                        echo '<td>' . $row['production_date'] . '</td>';
                        echo '<td>' . $row['harvest_area'] . '</td>';
                        echo '<td>' . $row['weight'] . '</td>';
                        echo '<td>' . $row['quantity'] . '</td>';
                        echo '<td>' . $row['productID'] . '</td>';
                        echo '<td>' . $row['farmID'] . '</td>';
                        echo '<td>' . $row['product_type'] . '</td>';
                        echo '<td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal' . $row['lotID'] . '">Update</button>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="9">No pending lots found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for Updating Data -->
    <?php
    // Fetch again for modals
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
    ?>
    <div class="modal fade" id="updateModal<?php echo $row['lotID']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Lot <?php echo $row['lotID']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" name="lotID" value="<?php echo $row['lotID']; ?>">

                        <div class="mb-3">
                            <label for="new_weight" class="form-label">New Weight</label>
                            <input type="number" name="new_weight" class="form-control" value="<?php echo $row['weight']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_quantity" class="form-label">New Quantity</label>
                            <input type="number" name="new_quantity" class="form-control" value="<?php echo $row['quantity']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="certification" class="form-label">Certification</label>
                            <input type="text" name="certification" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" name="rating" class="form-control" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
     <!-- Modal for updating processed batch data -->
     <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Pending Lot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" id="lotID" name="lotID">

                        <div class="form-group">
                            <label for="new_weight">New Weight</label>
                            <input type="number" class="form-control" id="new_weight" name="new_weight" required>
                        </div>

                        <div class="form-group">
                            <label for="new_quantity">New Quantity</label>
                            <input type="number" class="form-control" id="new_quantity" name="new_quantity" required>
                        </div>

                        <div class="form-group">
                            <label for="certification">Certification</label>
                            <input type="text" class="form-control" id="certification" name="certification" required>
                        </div>

                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <input type="float" class="form-control" id="rating" name="rating" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
        <h2 class="text-center mb-4">Processed Batch Table</h2>
        
        <!-- Table to display processed batches -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Batch ID</th>
                    <th scope="col">Processing Date</th>
                    <th scope="col">Certification</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Product Type</th>
                    <th scope="col">Lot ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data from processed_batch_t to display
$fetch_query = "SELECT pbatchID, processing_Date, Certification, weight, quantity, rating, product_type, lotID FROM processed_batch_t";
$result = $conn->query($fetch_query);
                // Check if there are rows returned from the query
                if ($result->num_rows > 0) {
                    // Loop through each row and display the data in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['pbatchID'] . "</td>";
                        echo "<td>" . $row['processing_Date'] . "</td>";
                        echo "<td>" . $row['Certification'] . "</td>";
                        echo "<td>" . $row['weight'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['rating'] . "</td>";
                        echo "<td>" . $row['product_type'] . "</td>";
                        echo "<td>" . $row['lotID'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // If no data is found
                    echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<script>
// Script to populate the modal with existing lot data
$('#updateModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var lotID = button.data('lotid');
    var weight = button.data('weight');
    var quantity = button.data('quantity');
    var product_type = button.data('product_type');
    
    // Update modal's form values
    var modal = $(this);
    modal.find('.modal-body #lotID').val(lotID);
    modal.find('.modal-body #new_weight').val(weight);
    modal.find('.modal-body #new_quantity').val(quantity);
    modal.find('.modal-body #certification').val('');
    modal.find('.modal-body #rating').val('');
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

 
</body>

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>
