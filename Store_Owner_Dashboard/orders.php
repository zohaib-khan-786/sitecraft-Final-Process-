<?php
include("../Connection/connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
if (isset($_SESSION['google_picture'])) {
    $profile = $_SESSION['google_picture'];
} else {
    $profile = $_SESSION['user_image'] ?? 'https://img.icons8.com/officel/30/person-male-skin-type-1-2.png'; // Provide a default image if both are not set
}
$orders = [];

if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];

    $sql = "SELECT * FROM store WHERE id = ? AND created_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $store_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header('Location: ../Create_Store/website_buildup.php');
        exit();
    }

    $sql = "SELECT orders.*, store.name AS store_name 
            FROM orders 
            JOIN store ON orders.store_id = store.id 
            WHERE store_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $store_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $orders = $result->fetch_all(MYSQLI_ASSOC);
            
        }
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }
} else {
   $orders[] = ['message' =>  'No store selected'];

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Section</title>
    <!-- app favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="../Styles/sidebar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <style>
        nav ul li:hover{
            box-shadow: 0 0 10px white;
        }
        .top-bar{
            position: relative;
        }
        .top-bar .navbar{
            width: 100%;
        }
        .custom-container {
            padding: 20px;
            background-color: #f8f9fa;
            overflow-y: scroll;
        }
        .table thead th {
            border-bottom: none;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .vertical-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
        }
        .vertical-button > span {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background-color: #343a40;
            opacity: 0.8;
        }
        .dropdown-menu {
            min-width: 8rem;
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        #filepreview{
            width: 50%;
        }
        .order_status{
            width: fit-content;
        }
    </style>
</head>
<body>
<div class="app">
    <div class="app-wrap">
         <!-- begin pre-loader -->
         <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="assets/img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>
            <!-- end pre-loader -->
            <!-- begin app-header -->
            <header class="app-header top-bar">
                <!-- begin navbar -->
                <nav class="navbar navbar-expand-md">

                    <!-- begin navbar-header -->
                    <div class="navbar-header d-flex align-items-center">
                        <a href="javascript:void:(0)" class="mobile-toggle"><i class="ti ti-align-right"></i></a>
                        <a class="navbar-brand" href="index.html">
                            <img src="assets/img/logo.png" class="img-fluid logo-desktop" alt="logo" />
                            <img src="assets/img/logo-icon.png" class="img-fluid logo-mobile" alt="logo" />
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti ti-align-left"></i>
                    </button>
                    <!-- end navbar-header -->
                                        <!-- begin navigation -->
                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navigation d-flex">
                            <ul class="navbar-nav nav-left">
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link sidebar-toggle" onclick="toggleSidebar(this)">
                                        <i class="ti ti-align-right"></i>
                                    </a>
                                </li>
                                
                               
                                <li class="nav-item full-screen d-none d-lg-block" id="btnFullscreen">
                                    <a href="javascript:void(0)" class="nav-link expand">
                                        <i class="icon-size-fullscreen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="navbar-nav nav-right ml-auto">
                            <li class="nav-item dropdown user-profile">
                                    <a href="javascript:void(0)" class="nav-link dropdown-toggle " id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo ($profile === NULL) ? 'https://img.icons8.com/officel/30/person-male-skin-type-1-2.png' : $profile ; ?>" alt="avatar-img">

                            
                                    </a>
                                    <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                                        <div class="bg-gradient px-4 py-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="mr-1">
                                                    <h4 class="text-white mb-0"><?php echo $_SESSION['user_name']?></h4>
                                                    <small class="text-white"><?php echo $_SESSION['user_email']?></small>
                                                </div>
                                                <a href="../Auth/logout.php" class="text-white font-20 tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout"> <i
                                                                class="zmdi zmdi-power"></i></a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end navigation -->
                </nav>
                <!-- end navbar -->
            </header>
            <!-- end app-header -->
            <!-- begin app-container -->
            <div class="app-container">
                <main>
                <!-- begin app-nabar -->
              
                    <!-- begin sidebar-nav -->
                     
                    <div class="sidebar d-flex flex-column justify-content-between">
                        <ul class="position-relative w-100 overflow-hidden">
                        <a href="index.php?store_id=<?php echo $store_id?>"><li class="nav-item first "><i class="bi bi-pie-chart"></i><span class="nav-text">Dashboard</span></li></a>
                            <li class="nav-item sub-menu-parent  position-relative"><i class="bi bi-rocket-takeoff"></i><span class="nav-text">Setup <i class="bi bi-chevron-down position-absolute end-0 me-3 fw-bold"></i></span>
                                <ul class="sub-menu rounded-2">
                                <a href="general.php?store_id=<?php echo $store_id?>"><li class="nav-item sub-nav-item"><i class="bi bi-gear"></i><span class="nav-text">General</span></li></a>
                                </ul>
                        </li>
                            <li class="nav-item sub-menu-parent position-relative">
                                <i class="bi bi-house"></i><span class="nav-text">Home <i class="bi bi-chevron-down position-absolute end-0 me-3 fw-bold"></i></span>
                                <ul class="sub-menu rounded-2">
                                    <a href="../Create_Store/website_buildup.php"><li class="nav-item sub-nav-item"><i class="bi bi-person-plus"></i><span class="nav-text">All Sites</span></li></a>
                                </ul>
                            </li>    
                            
                            <a href="orders.php?store_id=<?php echo $store_id?>"><li class="nav-item active"><i class="bi bi-coin"></i><span class="nav-text">Orders</span></li></a>
                            <a href="products-section.php?store_id=<?php echo $store_id?>"><li class="nav-item "><i class="bi bi-stack"></i><span class="nav-text">Products</span></li></a>
                        </ul>
                        <div class="bottom-sec ">
                        <a href="account_setting.php?store_id=<?php echo $store_id?>"><li class="nav-item border-top"><i class="bi bi-gear"></i><span class="nav-text">Account Settings</span></li></a>
                            <li class="nav-item no-hover logo mx-auto border-top"><img src="../Uploads/SiteCraft_Logo.png" alt="Logo"></li>
                        </div>
                    </div>
                    <!-- end sidebar-nav -->
               
                <!-- end app-navbar -->
    <div class="container custom-container">
        <h3>Orders <span class="text-muted mb-3"><?php echo count($orders); ?></span></h3>
        <div class="d-flex justify-content-between align-items-center ">
            
            <div>
        
            </div>
        </div>
        <table class="table table-striped mt-3 orders-table">
            <thead>
                <tr>
                   
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Store Name</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($orders)) {
                    foreach ($orders as $product) {
                        echo "<tr>";
                        echo "<td><img style='height: 100px;' src='{$product['image']}' alt='{$product['name']}'></td>";
                        echo "<td>{$product['name']}</td>";
                        echo "<td>{$product['price']}</td>";
                        echo "<td>{$product['store_name']}</td>";
                        echo "<td>
                                ". ($product['status'] == 0 ? "Pending" : "Delivered") . "
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    </div>
</div>
    <!-- plugins -->
    <script src="assets/js/vendors.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
     
    <!-- custom app -->
    <script src="assets/js/app.js"></script>
    <script src="../Js/site_setting.js"></script>
    <script src="../Js/products-section.js"></script>

</body>
</html>