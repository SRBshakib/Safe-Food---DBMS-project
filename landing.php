<?php
// Database connection
$host = "localhost";
$dbname = "traceroots";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch counts dynamically
    $farmerCount = $pdo->query("SELECT COUNT(*) FROM farmers_t")->fetchColumn();
    $warehouseCapacity = $pdo->query("SELECT SUM(storage_capacity) FROM warehouse_t")->fetchColumn();
    $qualityControlOfficers = $pdo->query("SELECT COUNT(*) FROM quality_control_officers_t")->fetchColumn();
    $retailerCount = $pdo->query("SELECT COUNT(*) FROM retailers_t")->fetchColumn();
    $driverCount = $pdo->query("SELECT COUNT(*) FROM drivers_t")->fetchColumn(); // Fetch driver count

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>TraceRoots</title>
</head>

<body>
    <header class="site-navbar" role="banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-11 col-xl-2">
                    <h1 class="mb-0 site-logo"><a href="index.html" style="color: black; font-weight: bold;">TraceRoots</a></h1>
                </div>
                <div class="col-12 col-md-10 d-none d-xl-block">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                            <li class="active"><a href="index.html">Home</a></li>
                            <li><a href="listings.html">Services</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="contact.html">Contact</a></li>
                            <li><a href="login.php" class="btn btn-dark">Login</a></li>
                            <li><a href="signup.php" class="btn btn-dark">Sign Up</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="hero" style="background-image: url(images/bg%20image.jpg);"></div>

    <div class="container py-4">
        <!-- Farmers Section -->
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <img src="images/farmer.jpg" class="img-fluid rounded" alt="Farmers">
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-3">Farmers Connected With Us</h3>
                        <p class="card-text mb-4">
                            We are proud to be connected with a vibrant community of farmers, working together to improve agricultural practices, share knowledge, and drive growth.
                        </p>
                        <div class="counter-box text-center mb-4">
                            <i class="fa fa-group me-2" style="font-size: 2rem;"></i>
                            <span class="counter" style="font-size: 2rem; font-weight: bold; color: #007bff;"><?php echo $farmerCount; ?></span>
                            <h3>Registered Farmers</h3>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Work With Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warehouse Section -->
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-3">Warehouse Capacity</h3>
                        <p class="card-text mb-4">
                            Our state-of-the-art warehouses are equipped to handle a large volume of goods, ensuring safe storage and efficient logistics for all products.
                        </p>
                        <div class="counter-box text-center mb-4">
                            <i class="fa fa-building me-2" style="font-size: 2rem;"></i>
                            <span class="counter" style="font-size: 2rem; font-weight: bold; color: #007bff;"><?php echo $warehouseCapacity; ?></span>
                            <h3>Square Meters of Storage</h3>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Explore Our Warehouse</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <img src="images/warehouse.jpg" class="img-fluid rounded" alt="Warehouse">
            </div>
        </div>

        <!-- Quality Control Section -->
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <img src="images/quality officer.jpg" class="img-fluid rounded" alt="Quality Control Officer">
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-3">Quality Control Officer</h3>
                        <p class="card-text mb-4">
                            Our Quality Control Officers ensure that all products meet the highest standards of quality and safety.
                        </p>
                        <div class="counter-box text-center mb-4">
                            <i class="fa fa-user-check me-2" style="font-size: 2rem;"></i>
                            <span class="counter" style="font-size: 2rem; font-weight: bold; color: #007bff;"><?php echo $qualityControlOfficers; ?></span>
                            <h3>Quality Control Officers</h3>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Meet Our Team</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Retailers Section -->
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-3">Retailers Connected With Us</h3>
                        <p class="card-text mb-4">
                            Our network of retailers plays a key role in distributing our products to the market.
                        </p>
                        <div class="counter-box text-center mb-4">
                            <i class="fa fa-store me-2" style="font-size: 2rem;"></i>
                            <span class="counter" style="font-size: 2rem; font-weight: bold; color: #007bff;"><?php echo $retailerCount; ?></span>
                            <h3>Retailers</h3>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Become a Retailer</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <img src="images/retailer.jpg" class="img-fluid rounded" alt="Retailers">
            </div>
        </div>
        <!-- Driver Section -->
<div class="row align-items-center">
     <!-- Right Column (Image) -->
     <div class="col-md-6 mb-4">
        <img src="images/driver-hire-min.webp" class="img-fluid rounded" alt="Drivers">
    </div>
<!-- Left Column (Text Content) -->
    
    <div class="col-md-6 mb-4">
        <div class="card shadow-lg border-light rounded">
            <div class="card-body">
                <h3 class="card-title text-center mb-3" style="font-family: 'Open Sans', sans-serif; color: #3a3a3a;">Drivers Connected With Us</h3>
                <p class="card-text mb-4" style="font-family: 'Open Sans', sans-serif; color: #555;">
                    Our professional drivers ensure safe and timely delivery of goods, playing a vital role in maintaining the efficiency of our logistics operations.
                </p>
                <div class="counter-box text-center mb-4">
                    <i class="fa fa-truck me-2" style="font-size: 2rem; color: #6c757d;"></i>
                    <span class="counter" style="font-size: 2rem; font-weight: bold; color: #007bff;"><?php echo $driverCount; ?></span>
                    <h3>Registered Drivers</h3>
                </div>
                <div class="text-center">
                    <a href="#" class="btn btn-primary">Meet Our Drivers</a>
                </div>
            </div>
        </div>
    </div>

   
</div>
    </div>
</body>
</html>
