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
$products = [];

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

    $sql = "SELECT products.*, store.name AS store_name 
            FROM products 
            JOIN store ON products.store_id = store.id 
            WHERE store_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $store_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $products = $result->fetch_all(MYSQLI_ASSOC);
        }
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }
} else {
    $sql = "SELECT products.*, store.name AS store_name 
            FROM products 
            JOIN store ON products.store_id = store.id 
            WHERE products.owner_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $products = $result->fetch_all(MYSQLI_ASSOC);
        }
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Section</title>
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
                            <a href="orders.php?store_id=<?php echo $store_id?>"><li class="nav-item"><i class="bi bi-coin"></i><span class="nav-text">Orders</span></li></a>
                            <a href="products-section.php?store_id=<?php echo $store_id?>"><li class="nav-item active"><i class="bi bi-stack"></i><span class="nav-text">Products</span></li></a>
                        </ul>
                        <div class="bottom-sec ">
                        <a href="account_setting.php?store_id=<?php echo $store_id?>"><li class="nav-item border-top"><i class="bi bi-gear"></i><span class="nav-text">Account Settings</span></li></a>
                            <li class="nav-item no-hover logo mx-auto border-top"><img src="../Uploads/SiteCraft_Logo.png" alt="Logo"></li>
                        </div>
                    </div>
                    <!-- end sidebar-nav -->
               
                <!-- end app-navbar -->
    <div class="container custom-container">
        <h3>Products <span class="text-muted"><?php echo count($products); ?></span></h3>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
               
            </div>
            <div>
                <button class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#productModal" id="newProductBtn">+ New Product</button>
                <!-- MODAL ADD-->
                <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel">Add Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="productForm" method="POST" action="../Create_Store/add_products.php?store_id=<?php echo $store_id; ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="storeId" id="storeId" value="<?php echo $store_id ?>">
                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">Product Image</label>
                                        <div class="file-upload position-relative mx-auto " id="fileUpload">
                                            <div class="icon">
                                                <i class="bi bi-cloud-arrow-up"></i>
                                            </div>
                                            <p>Drag file(s) here to upload.<br>Alternatively, you can select a file by <span>clicking here</span></p>
                                            <input type="file" id="fileInput" name="productImage" hidden>
                                        </div>
                                        <img id="filePreview" class="rounded mx-auto" src="" alt="File Preview">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="productName" name="productName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productCategory" class="form-label">Category</label>
                                        <select class="form-select" id="productCategory" name="productCategory">
                                            <option value="" disabled selected>Select a category</option>
                                            <!-- Add your categories here -->
                                            <option value="men">Men</option>
                                            <option value="women">Women</option>
                                            <option value="children">Children</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productDescription" class="form-label">Product Description</label>
                                        <textarea type="text" class="form-control" id="productDescription" name="productDescription"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productQuantity" class="form-label">Product Quantity</label>
                                        <input type="number" class="form-control" id="productQuantity" name="productQuantity" value="5">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label">Price $:</label>
                                        <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="1000">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productCost" class="form-label">Cost $:</label>
                                        <input type="number" class="form-control" id="productCost" name="productCost" placeholder="1000">
                                    </div>
                                    <input type="hidden" id="existingImage" name="existingImage" value="">
                                    <button type="button" class="btn btn-primary" id="saveProductBtn">Save Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL ADD-->
            </div>
        </div>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                   
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Cost</th>
                    <th scope="col">Store Name</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($products)) {
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td><img style='height: 100px;' src='{$product['image']}' alt='{$product['name']}'></td>";
                        echo "<td>{$product['name']}</td>";
                        echo "<td>{$product['description']}</td>";
                        echo "<td>{$product['category']}</td>";
                        echo "<td>{$product['quantity']}</td>";
                        echo "<td>{$product['price']}</td>";
                        echo "<td>{$product['cost']}</td>";
                        echo "<td>{$product['store_name']}</td>";
                        echo "<td>
                                <div class='dropdown'>
                                    <button class='btn btn-light dropdown-toggle vertical-button' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                    <ul class='dropdown-menu'>
                                        
                                        <li><a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#productModal' data-product-id='{$product['id']}'><i class='bi bi-gear me-3'></i> Edit Product</a></li>
                                        <li><a class='dropdown-item text-danger' href='../Create_Store/delete_product.php?product_id={$product['id']}'><i class='bi bi-trash me-3'></i> Delete Product</a></li>
                                    </ul>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No products found</td></tr>";
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
