<?php

include("../Connection/connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM store WHERE created_by = '$user_id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($item = $result->fetch_assoc()){
        $rows[] = $item;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="../Styles/sidebar.css">

</head>
<body>
    <?php include('../Components/navbar.php'); ?>
    <main>
    <div class="sidebar d-flex flex-column justify-content-between">
        <button class="toggle-btn" onclick="toggleSidebar(this)"><i class="bi bi-caret-right-fill"></i></button>
        <ul class="position-relative w-100 overflow-hidden">
        <li class="nav-item first active"><i class="bi bi-pie-chart"></i><span class="nav-text">Dashboard</span></li>
            <li class="nav-item sub-menu-parent  position-relative"><i class="bi bi-rocket-takeoff"></i><span class="nav-text">Setup <i class="bi bi-chevron-down position-absolute end-0 me-3 fw-bold"></i></span>
                <ul class="sub-menu rounded-2">
                    <li class="nav-item sub-nav-item"><i class="bi bi-gear"></i><span class="nav-text">General</span></li>
                </ul>
        </li>
            <li class="nav-item sub-menu-parent position-relative">
                <i class="bi bi-house"></i><span class="nav-text">Home <i class="bi bi-chevron-down position-absolute end-0 me-3 fw-bold"></i></span>
                <ul class="sub-menu rounded-2">
                    <li class="nav-item sub-nav-item"><i class="bi bi-person-plus"></i><span class="nav-text">Add New</span></li>
                    <li class="nav-item sub-nav-item"><i class="bi bi-person-square"></i><span class="nav-text">View All</span></li>
                    <li class="nav-item sub-nav-item"><i class="bi bi-person-x"></i><span class="nav-text">Delete</span></li>
                </ul>
            </li>    
            <li class="nav-item"><i class="bi bi-currency-dollar"></i><span class="nav-text">Getting Paid</span></li>
            <li class="nav-item"><i class="bi bi-coin"></i><span class="nav-text">Sales</span></li>
            <li class="nav-item"><i class="bi bi-stack"></i><span class="nav-text">Products</span></li>
        </ul>
        <div class="bottom-sec ">
            <li class="nav-item border-top"><i class="bi bi-gear"></i><span class="nav-text">Account Settings</span></li>
            <li class="nav-item no-hover logo mx-auto border-top"><img src="../Uploads/SiteCraft_Logo.png" alt="Logo"></li>
        </div>
    </div>
<!-- MAIN CONTENT -->
 <div class="main-content">
    <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
            
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['store_name'];?></h5>
                            <p class="card-text">Created by: <?php echo $row['created_by'];?></p>
                            <a href="#" class="btn btn-primary">View Store</a>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
    <div class="modal fade" id="addStoreModal" tabindex="-1" aria-labelledby="addStoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStoreModalLabel">Add Store</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="mb-3">
                            <label for="storeName" class="form-label">Store Name</label>
                            <input type="text" class="form-control" id="storeName" name="storeName" required>
                        </div>
                        <div class="mb-3">
                            <label for="storeAddress" class="form-label">Store Address</label>
                            <input type="
                            <textarea class="form-control" id="storeAddress" name="storeAddress" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="storeEmail" class="form-label">Store Email</label>
                                <input type="email" class="form-control" id="storeEmail" name="storeEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="storePhone" class="form-label">Store Phone</label>
                                <input type="tel" class="form-control" id="storePhone" name="storePhone" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Store</button>
                            </div>
                            </form>
                            </div>


                            </main>







    <script src="../Js/site_setting.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
        
</body>
</html>
