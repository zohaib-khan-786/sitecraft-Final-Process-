<?php
include("../Connection/connection.php");
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}
if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];

if (isset($_GET['success'])) {
    echo "<script>alert('Update Success')</script>";
}

$user_id = $_SESSION['user_id'];
if (!empty($_SESSION['google_picture'])) {
    $profile = $_SESSION['google_picture'];

} elseif (!empty($_SESSION['user_image'])) {
    $profile = $_SESSION['user_image'];

} else {
    $profile = 'https://img.icons8.com/officel/30/person-male-skin-type-1-2.png'; 
}


$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: ../Create_Store/website_buildup.php');
    exit();
}

$data = $result->fetch_assoc(); 
}
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
    <style>
        .top-bar{
            position: relative;
        }
        
/* ADD IMAGE SECTION */

#filePreview {
  width: 40%;
  display: block;
  background-color: #f8f9fa;
  cursor: pointer;
}
.file-upload {
  position: relative;
  display: block;
  width: 100%;
  height: auto;
  min-height: 225px;
  border: 2px dashed #ddd;
  border-radius: 5px;
  text-align: center;
  padding: 20px;
  cursor: pointer;
}
.file-upload.dragover {
  border-color: #007bff;
}
.file-upload input[type="file"] {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  opacity: 0;
  cursor: pointer;
}
.file-upload .icon {
  font-size: 48px;
  color: #007bff;
  margin-bottom: 10px;
}
.file-upload img {
  max-width: 100%;
  max-height: 100%;
  display: none;
}
.file-upload p {
  margin: 0;
  font-size: 16px;
  color: #6c757d;
}
.file-upload p span {
  color: #007bff;
  text-decoration: underline;
  cursor: pointer;
}
.file-upload.hidden-siblings > *:not(img) {
  opacity: 0;
}
.card{
    border-radius: 5px;
}
    </style>
</head>
<body>
    <div class="app">
        <div class="app-wrap">
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
                                        <img src="<?php echo $profile ?>" alt="avtar-img">
                                        <span class="bg-success user-status"></span>
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
             <div class="app-container">
                <main>
                     <!-- begin sidebar-nav -->
                     
                     <div class="sidebar d-flex flex-column justify-content-between">
                        <ul class="position-relative w-100 overflow-hidden">
                        <a href="index.php?store_id=<?php echo $store_id?>"><li class="nav-item first "><i class="bi bi-pie-chart"></i><span class="nav-text">Dashboard</span></li></a>
                            <li class="nav-item sub-menu-parent  position-relative"><i class="bi bi-rocket-takeoff"></i><span class="nav-text">Setup <i class="bi bi-chevron-down position-absolute end-0 me-3 fw-bold"></i></span>
                                <ul class="sub-menu rounded-2">
                                <a href="general.php?store_id=<?php echo $store_id?>"><li class="nav-item sub-nav-item  "><i class="bi bi-gear"></i><span class="nav-text">General</span></li></a>
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
                    <div class="container-fluid" style="height: calc(100dvh - 60px); overflow: auto;">

                            <div class="row mt-4">
            <h3 class="mb-3">Account Settings</h3>
            <form method="post" action="profile_update.php" enctype="multipart/form-data">          
                 <!-- User Image -->
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Profile Picture
                    </div>
                    <div class="card-body">
                        
                            <div class="mb-3">
                                        <label for="productImage" class="form-label">Profile Image</label>
                                        <div class="file-upload position-relative mx-auto " id="fileUpload">
                                            <div class="icon">
                                                <i class="bi bi-cloud-arrow-up"></i>
                                            </div>
                                            <p>Drag file(s) here to upload.<br>Alternatively, you can select a file by <span>clicking here</span></p>
                                            <input type="file" id="fileInput" name="profileImage" hidden required>
                                        </div>
                                        <img id="filePreview" class="rounded mx-auto" src="<?php echo $data['image']?>" alt="File Preview">
                            </div>
                            
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        User Name
                    </div>
                    <div class="card-body">
                        
                            <div class="mb-3">
                                <label for="siteName" class="form-label">User Name</label>
                                <input type="text" name="username" value="<?php echo $data['username']?>" class="form-control" id="username" placeholder="Enter your user name" required>
                            </div>
                            
                        
                    </div>
                </div>
            </div>
           
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Email
                    </div>
                    <div class="card-body">
                        
                            <div class="mb-3">
                                <label for="Email" class="form-label">Email</label>
                                <input type="email" name="email" value="<?php echo $data['email']?>" class="form-control" id="email" placeholder="Enter your email" required>
                            </div>
                            
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Passowrd
                    </div>
                    <div class="card-body">
                        
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" value="" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                            </div>
                            
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3 me-auto">Save</button>
            </div>
            </form>

        </div>

    </div>
                </main>
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