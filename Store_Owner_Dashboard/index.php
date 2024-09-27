<?php
ob_start();
include("../Connection/connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}
$profile='';
$user_id = $_SESSION['user_id'];
if (isset($_SESSION['google_picture'])) {
    $profile = $_SESSION['google_picture'];
} else {
    $profile = $_SESSION['user_image'] ?? 'https://img.icons8.com/officel/30/person-male-skin-type-1-2.png'; // Provide a default image if both are not set
}

$overview_data = [];
$registered_customer = 0;
if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];
    
    $sql = "SELECT * FROM store WHERE id = ? AND created_by = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("ii", $store_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Error executing the query: " . $stmt->error);
    }

    if ($result->num_rows === 0) {
        header('Location: ../Create_Store/website_buildup.php');
        exit();
    }

    $store_data = $result->fetch_assoc();

    $template = $store_data['template'];

    $templatePath = "../User_Stores/" . $template . "/check_visits.php";
    if (file_exists($templatePath)) {
        $url_with_id = "http://localhost/Aptech_Vision/User_Stores/" . $template . "/check_visits.php?store_id=" . urlencode($store_id);
        $overview_data_json = file_get_contents($url_with_id);

        if ($overview_data_json === false) {
            echo "<script>console.error('Failed to fetch data from URL');</script>";
            exit();
        }

        $overview_data = json_decode($overview_data_json, true);
    } else {
        echo "<script>console.error('Template Not Found');</script>";
        exit();
    }

    $stmt->close();

    $sql = "SELECT * FROM t_users WHERE store_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i',$store_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $data = $result->num_rows;
            $registered_customer = $data;
        }
    }

} else {
    header("Location: ../Create_store/website_buildup.php");
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Admin template that can be used to build dashboards for CRM, CMS, etc." />
    <meta name="author" content="Potenza Global Solutions" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- app favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous"> 
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" href="../Styles/sidebar.css">
</head>
<body>
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
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
                <!-- begin app-nabar -->
                <aside class="app-navbar">
                    <!-- begin sidebar-nav -->
                    <div class="sidebar d-flex flex-column justify-content-between">
                        <ul class="position-relative w-100 overflow-hidden">
                        <a href="index.php?store_id=<?php echo $store_id?>"><li class="nav-item first active "><i class="bi bi-pie-chart"></i><span class="nav-text">Dashboard</span></li></a>
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
                            
                            <a href="orders.php?store_id=<?php echo $store_id?>"><li class="nav-item"><i class="bi bi-coin"></i><span class="nav-text">Orders</span></li></a>
                            <a href="products-section.php?store_id=<?php echo $store_id?>"><li class="nav-item"><i class="bi bi-stack"></i><span class="nav-text">Products</span></li></a>
                        </ul>
                        <div class="bottom-sec ">
                        <a href="account_setting.php?store_id=<?php echo $store_id?>"><li class="nav-item border-top"><i class="bi bi-gear"></i><span class="nav-text">Account Settings</span></li></a>
                            <li class="nav-item no-hover logo mx-auto border-top"><img src="../Uploads/SiteCraft_Logo.png" alt="Logo"></li>
                        </div>
                    </div>
                    <!-- end sidebar-nav -->
                </aside>
                <!-- end app-navbar -->

                <!-- begin app-main -->
                <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    <div class="container-fluid">
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-md-12 m-b-30">
                                <!-- begin page title -->
                                <div class="d-block d-lg-flex flex-nowrap align-items-center">
                                    <div class="page-title mr-4 pr-4 border-right">
                                        <h1>Dashboard</h1>
                                    </div>
                                    <div class="breadcrumb-bar align-items-center">
                                        <nav>
                                            <ol class="breadcrumb p-0 m-b-0">
                                                <li class="breadcrumb-item">
                                                    <a href="index.html"><i class="ti ti-home"></i></a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    Dashboard
                                                </li>
                                                <li class="breadcrumb-item active text-primary" aria-current="page">Default</li>
                                            </ol>
                                        </nav>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center secondary-menu text-center">
                                        <a href="javascript:void(0);" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Todo list">
                                            <i class="fe fe-edit btn btn-icon text-primary"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Projects">
                                            <i class="fa fa-lightbulb-o btn btn-icon text-success"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Task">
                                            <i class="fa fa-check btn btn-icon text-warning"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Calendar">
                                            <i class="fa fa-calendar-o btn btn-icon text-cyan"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Analytics">
                                            <i class="fa fa-bar-chart-o btn btn-icon text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- end page title -->
                            </div>
                        </div>

                        <!-- end row -->

                        <!-- begin row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-statistics">
                                    <div class="row no-gutters">
                                        <div class="col-xxl-4 col-lg-12">
                                            <div class="p-20 border-lg-right border-bottom border-xxl-bottom-0">
                                                <div class="d-flex m-b-10">
                                                    <p class="mb-0 font-regular text-muted font-weight-bold">Total Visits</p>
                                                    <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                                                </div>
                                                <div class="d-block d-sm-flex h-100 align-items-center">
                                                    <div class="apexchart-wrapper">
                                                        <div id="analytics7"></div>
                                                    </div>
                                                    <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                                        <h3 class="mb-0"><i class="icon-arrow-up-circle"></i> 
                                                            <?php echo $overview_data['total_visits']; ?>
                                                        </h3>
                                                        <p>Monthly visitor</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-lg-12">
                                            <div class="p-20 border-xxl-right border-bottom border-xxl-bottom-0">
                                                <div class="d-flex m-b-10">
                                                    <p class="mb-0 font-regular text-muted font-weight-bold">Total Sales</p>
                                                    <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                                                </div>
                                                <div class="d-block d-sm-flex h-100 align-items-center">
                                                    <div class="apexchart-wrapper">
                                                        <div id="analytics8"></div>
                                                    </div>
                                                    <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                                        <h3 class="mb-0"><i class="icon-arrow-up-circle"></i> <?php echo $overview_data['total_sales']?></h3>
                                                        <p>This month</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-lg-12">
                                            <div class="p-20 border-lg-right border-bottom border-lg-bottom-0">
                                                <div class="d-flex m-b-10">
                                                    <p class="mb-0 font-regular text-muted font-weight-bold">Total Sales</p>
                                                    <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                                                </div>
                                                <div class="d-block d-sm-flex h-100 align-items-center">
                                                    <div class="apexchart-wrapper">
                                                        <div id="analytics9"></div>
                                                    </div>
                                                    <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                                        <h3 class="mb-0"><i class="icon-arrow-up-circle"></i><?php echo $overview_data['average_sales'];?></h3>
                                                        <p>Avg. Sales per day</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xxl-7 m-b-30">
                                <div class="card card-statistics h-100 mb-0 apexchart-tool-force-top">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-heading">
                                            <h4 class="card-title">Site activity</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 col-xs-6 col-lg-3">
                                                <div class="row mb-2 pb-3 align-items-end">
                                                    <div class="col">
                                                        <p>Registered Customers</p>
                                                        <h3 class="tex-dark mb-0"><?php echo $registered_customer;?></h3>
                                                    </div>
                                                    <div class="col ml-auto">
                                                        <span><i class="fa fa-arrow-down"></i> 5%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-xs-6 col-lg-3">
                                                <div class="row mb-2 pb-3 align-items-end">
                                                    <div class="col">
                                                        Orders</p>
                                            <h3 class="tex-dark mb-0"><?php echo $overview_data['total_orders']?></h3>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-6 col-xs-6 col-lg-3">
                                                <div class="row mb-2 pb-3 align-items-end">
                                                    <div class="col">
                                                        <p>Total Sales</p>
                                            <h3 class="tex-dark mb-0">$<?php echo $overview_data['total_sales']?></h3>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-6 col-xs-6 col-lg-3">
                                                <div class="row mb-2 pb-3 align-items-end">
                                                    <div class="col">
                                                        <p>Total Profit</p>
                                            <h3 class="tex-dark mb-0">$<?php  echo $overview_data['total_profit']?></h3>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 px-0">
                                                <div class="apexchart-wrapper p-inherit">
                                                    <div id="analytics1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-5 m-b-30">
                                <div class="card card-statistics h-100 mb-0">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-heading">
                                            <h4 class="card-title">Sales Analysis</h4>
                                        </div>
                                        <div class="dropdown">
                                            <a class="p-2" href="#!" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <h2>$<?php echo $overview_data['total_sales']?></h2>
                                                <span class="d-block mb-2 font-16">Total Sales</span>
                                                
                                                <p class="mb-3">Analysis of total sales revenue, including a breakdown by product category.</p>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="apexchart-wrapper">
                                                    <div id="analytics2" class="chart-fit"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top my-4"></div>
                                        <h4 class="card-title">Sales by Product Category</h4>
                                        <div class="row">
                                            <div class="col-12 col-md-3">
                                                <span>Electronics: <b>$12,475</b></span>
                                                <div class="progress my-3" style="height: 4px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <span>Clothing: <b>$23,475</b></span>
                                                <div class="progress my-3" style="height: 4px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 66%;" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <span>Home Goods: <b>$8,658</b></span>
                                                <div class="progress my-3" style="height: 4px;">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <span>Beauty: <b>$6,489</b></span>
                                                <div class="progress my-3" style="height: 4px;">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->
            <!-- begin footer -->
            <footer class="footer">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center text-sm-left">
                        <p>&copy; Copyright 2024. All rights reserved.</p>
                    </div>
                   <div class="col  col-sm-6 ml-sm-auto text-center text-sm-right">
                        <p><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></p>
                    </div>
                </div>
            </footer>
            <!-- end footer -->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->

    <!-- plugins -->
    <script src="assets/js/vendors.js"></>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
     

    <!-- custom app -->
    <script src="assets/js/app.js"></script>
    <script src="../Js/site_setting.js"></script>
</body>


</html>