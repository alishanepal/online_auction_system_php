 <?php
session_start();
include '../includes/connection.php'; // Ensure the database connection is included

// Query for Upcoming Auctions (status is 'upcoming')
$upcomingAuctions = mysqli_query($conn, "
    SELECT p.product_id, p.product_name, pi.image_url, a.start_date
    FROM auctions a
    JOIN product p ON p.product_id = a.product_id
    JOIN product_images pi ON pi.product_id = p.product_id
    WHERE a.status = 'upcoming'
");

// Query for Live Auctions (status is 'live')
$liveAuctions = mysqli_query($conn, "
    SELECT p.product_id, p.product_name, pi.image_url, a.end_date
    FROM auctions a
    JOIN product p ON p.product_id = a.product_id
    JOIN product_images pi ON pi.product_id = p.product_id
    WHERE a.status = 'live'
");

// Query for Closed Auctions (status is 'closed')
$closedAuctions = mysqli_query($conn, "
    SELECT p.product_id, p.product_name, pi.image_url, a.end_date
    FROM auctions a
    JOIN product p ON p.product_id = a.product_id
    JOIN product_images pi ON pi.product_id = p.product_id
    WHERE a.status = 'closed'
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Auction System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- External CSS -->
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Online Auction</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Live Auction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Upcoming Auction</a>
                    </li>
                </ul>

                <div class="d-flex">
                    <?php
                    // Check if the user is logged in by checking the session
                    if (isset($_SESSION['username'])) {
                        // User is logged in, show username and logout button
                        echo '<span class="navbar-text me-3">Hello, ' . $_SESSION['username'] . '</span>';
                        echo '<button class="btn btn-outline-danger me-2" onclick="window.location.href=\'../process/logout.php\';">Logout</button>';
                    } else {
                        // User is not logged in, show login and sign up buttons
                        echo '<button class="btn btn-outline-success me-2" onclick="window.location.href=\'login.php\';">Login</button>';
                        echo '<button class="btn btn-outline-success me-2" onclick="window.location.href=\'signup.php\';">Sign Up</button>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>

   
 <div class="container mt-5">
        <h1>Welcome to the Online Auction System</h1>
        <p>Explore our exciting auctions and stay tuned for upcoming events!</p>

        <!-- Upcoming Auctions Section -->
        <h2>Upcoming Auctions</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($upcomingAuctions)) { ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['product_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                            <p class="card-text">Starts: <?php echo $row['start_date']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Live Auctions Section -->
        <h2>Live Auctions</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($liveAuctions)) { ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['product_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                            <p class="card-text">Ends: <?php echo $row['end_date']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Closed Auctions Section -->
        <h2>Closed Auctions</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($closedAuctions)) { ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['product_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                            <p class="card-text">Ended: <?php echo $row['end_date']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
