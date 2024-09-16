<?php
session_start();
include "./connection.php";


$template = 'freshshop';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && !isset($_POST['action'])) {
    $productId = $_POST['product_id'];
    $storeId = isset($_POST['store_id']) ? $_POST['store_id'] : null;

    $sessionId = session_id();
    

    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        
        $query = "SELECT * FROM cart WHERE session_id = ? AND product_id = ? AND template_name = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sis", $sessionId, $productId, $template);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If it is, increase the quantity
            $cartItem = $result->fetch_assoc();
            $newQuantity = $cartItem['quantity'] + 1;

            $updateQuery = "UPDATE cart SET quantity = ? WHERE session_id = ? AND product_id = ? AND template_name = ?";
            $updateStmt = $conn->prepare($updateQuery);
            if (!$updateStmt) {
                die("Prepare failed: " . $conn->error);
            }
            $updateStmt->bind_param("isis", $newQuantity, $sessionId, $productId, $template);
            $updateStmt->execute();
        } else {
           
            $insertQuery = "INSERT INTO cart (session_id, store_id, product_id, product_name, product_price, product_image, quantity,cost, template_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            if (!$insertStmt) {
                die("Prepare failed: " . $conn->error);
            }
            $quantity = 1;
            
            $insertStmt->bind_param("siisssids", $sessionId, $storeId, $productId, $product['name'], $product['price'], $product['image'], $quantity,$product['cost'], $template);
            $insertStmt->execute();
        }
    }
    header("Location: cart.php");
    exit();
}

// Handle Remove from Cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $sessionId = session_id();

    $deleteQuery = "DELETE FROM cart WHERE session_id = ? AND product_id = ? AND template_name = ?";
    $stmt = $conn->prepare($deleteQuery);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sis", $sessionId, $productId, $template);
    $stmt->execute();

    header("Location: cart.php");
    exit();
}

// Handle Update Quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $productId = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);
    $sessionId = session_id();

    if ($quantity > 0) {
        $updateQuery = "UPDATE cart SET quantity = ? WHERE session_id = ? AND product_id = ? AND template_name = ?";
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("isis", $quantity, $sessionId, $productId, $template);
        $stmt->execute();
    }
}

// Handle Proceed to Checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proceed_to_checkout'])) {
    $_SESSION['cart'] = [];
    $cartQuery = "SELECT * FROM cart WHERE session_id = ? AND template_name = ?";
    $stmt = $conn->prepare($cartQuery);
    $stmt->bind_param("ss", session_id(), $template);
    $stmt->execute();
    $cartResult = $stmt->get_result();
   
    
    while ($row = $cartResult->fetch_assoc()) {
        $_SESSION['cart'][] = $row;
    }
    header("Location: checkout.php");
    exit();
}

// Fetch products for display
$query = "SELECT * FROM products";
$result = $conn->query($query);

// Fetch cart items for the current session and template
$sessionId = session_id();
$cartQuery = "SELECT * FROM cart WHERE session_id = ? AND template_name = ?";
$cartStmt = $conn->prepare($cartQuery);
if (!$cartStmt) {
    die("Prepare failed: " . $conn->error);
}
$cartStmt->bind_param("ss", $sessionId, $template);
$cartStmt->execute();
$cartResult = $cartStmt->get_result();

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <title>ThewayShop - Ecommerce Bootstrap 4 HTML Template</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="./css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/custom.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Start Main Top -->
    <div class="main-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="custom-select-box">
                        <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
							<option>¥ JPY</option>
							<option>$ USD</option>
							<option>€ EUR</option>
						</select>
                    </div>
                    <div class="right-phone-box">
                        <p>Call US :- <a href="#"> +11 900 800 100</a></p>
                    </div>
                    <div class="our-link">
                        <ul>
                            
                            <li><a href="#"><i class="fas fa-location-arrow"></i> Our location</a></li>
                            <li><a href="#"><i class="fas fa-headset"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="login-box">
						<select id="basic" class="selectpicker show-tick form-control" data-placeholder="Sign In">
							<option>Register Here</option>
							<option>Sign In</option>
						</select>
					</div>
                    <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                            <ul class="offer-box">
                                <li>
                                    <i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT80
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 50% - 80% off on Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 10%! Shop Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 50%! Shop Now
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 10%! Shop Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 50% - 80% off on Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT30
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 50%! Shop Now 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Top -->

    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                    <a class="navbar-brand" href="index.php"><img src="images/logo.png" class="logo" alt=""></a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                        <li class="dropdown active">
                            <a href="#" class="nav-link dropdown-toggle arrow" data-toggle="dropdown">SHOP</a>
                            <ul class="dropdown-menu">
								<li><a href="shop.php">Sidebar Shop</a></li>
								<li><a href="shop-detail.php">Shop Detail</a></li>
                                <li><a href="cart.php">Cart</a></li>
                                <li><a href="checkout.php">Checkout</a></li>
                                <li><a href="./login.php">Login</a></li>
								<li><a href="./register.php">Register</a></li>
                                <li><a href="wishlist.php">Wishlist</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact-us.php">Contact Us</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                        <li class="side-menu">
                            <a href="cart.php">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="badge" id="cart-count">0</span>
                                <p>My Cart</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>

            <!-- Start Side Menu -->
            <div class="side">
                <a href="#" class="close-side"><i class="fa fa-times"></i></a>
                <li class="cart-box">
                    <ul class="cart-list" id="cart-list">
                        <!-- <li>
                            <a href="#" class="photo"><img src="images/img-pro-01.jpg" class="cart-thumb" alt="" /></a>
                            <h6><a href="#">Delica omtantur </a></h6>
                            <p>1x - <span class="price">$80.00</span></p>
                        </li>
                        <li>
                            <a href="#" class="photo"><img src="images/img-pro-02.jpg" class="cart-thumb" alt="" /></a>
                            <h6><a href="#">Omnes ocurreret</a></h6>
                            <p>1x - <span class="price">$60.00</span></p>
                        </li>
                        <li>
                            <a href="#" class="photo"><img src="images/img-pro-03.jpg" class="cart-thumb" alt="" /></a>
                            <h6><a href="#">Agam facilisis</a></h6>
                            <p>1x - <span class="price">$40.00</span></p>
                        </li>
                        <li class="total">
                            <a href="./cart.php" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                            <span class="float-right"><strong>Total</strong>: $<span id="cart-total">0.00</span></span>
                        </li> -->
                    </ul>
                    <li class="total">
                        <a href="./cart.php" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                        <span class="float-right"><strong>Total</strong>: $<span id="cart-total">0.00</span></span>
                    </li>
                </li>
            </div>
            <!-- End Side Menu -->
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->

    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Cart</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                        <li class="breadcrumb-item active">Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Cart -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <!-- <th>Update</th> -->
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php while ($row = $cartResult->fetch_assoc()) {
                                    $subtotal = $row['product_price'] * $row['quantity'];
                                    $total += $subtotal; 
                                ?>
                                <tr>
                                    <td class="thumbnail-img">
                                        <a href="#">
                                            <img class="img-fluid" src="<?php echo $row['product_image']; ?>" alt="" />
                                        </a>
                                    </td>
                                    <td class="name-pr">
                                        <a href="#">
                                            <?php echo $row['product_name']; ?>
                                        </a>
                                    </td>
                                    <td class="price-pr">
                                        <p>$<?php echo $row['product_price']; ?></p>
                                    </td>
                                    <td class="quantity-box">
                                        <form action="cart.php" method="POST" class="update-quantity-form">
                                            <input type="number" size="4" value="<?php echo $row['quantity']; ?>" min="1" step="1" class="c-input-text qty text quantity-input" name="quantity" data-product-id="<?php echo $row['product_id']; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                            <input type="hidden" name="action" value="update">
                                        </form>
                                    </td>
                                    <!-- <td class="total-pr">
                                       <p>$<?php //echo $total; ?></p>
                                     </td> -->
                                    <td class="total-pr">
                                        <p>$<?php echo $subtotal; ?></p>
                                    </td>
                                    <td class="remove-pr">
                                        <a href="cart.php?action=remove&id=<?php echo $row['product_id']; ?>"> 
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 

            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <h3>Order summary</h3>
                        <div class="d-flex">
                            <h4>Sub Total</h4>
                            <div class="ml-auto font-weight-bold"> $<?php echo $total; ?> </div>
                        </div>
                        <div class="d-flex">
                            <h4>Shipping Cost</h4>
                            <div class="ml-auto font-weight-bold"> Free </div>
                        </div>
                        <hr>
                        <div class="d-flex gr-total">
                            <h5>Grand Total</h5>
                            <div class="ml-auto h5"> $<?php echo $total; ?> </div>
                        </div>
                        <hr> 
                    </div>
                </div>
                <div class="col-12 d-flex shopping-box">
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="proceed_to_checkout" value="1">
                            <button type="submit" class="btn hvr-hover" style="margin-left: 48rem;">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    <!-- <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <h3>Order summary</h3>
                        <div class="d-flex">
                            <h4>Sub Total</h4>
                            <div class="ml-auto font-weight-bold"> $<span id="sub-total">0.00</span> </div>
                        </div>
                        <div class="d-flex gr-total">
                            <h5>Grand Total</h5>
                            <div class="ml-auto h5"> $<span id="grand-total">0.00</span> </div>
                        </div>
                        <hr> 
                    </div>
                </div>
                <div class="col-12 d-flex shopping-box"> 
                    <a href="checkout.php" class="ml-auto btn hvr-hover">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div> -->
    <!-- End Cart -->

    <!-- Start Instagram Feed  -->
    <div class="instagram-box">
        <div class="main-instagram owl-carousel owl-theme">
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-01.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-02.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-03.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-04.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-05.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-06.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-07.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-08.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-09.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-05.jpg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Instagram Feed  -->


    <!-- Start Footer  -->
    <footer>
        <div class="footer-main">
            <div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Business Time</h3>
							<ul class="list-time">
								<li>Monday - Friday: 08.00am to 05.00pm</li> <li>Saturday: 10.00am to 08.00pm</li> <li>Sunday: <span>Closed</span></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Newsletter</h3>
							<form class="newsletter-box">
								<div class="form-group">
									<input class="" type="email" name="Email" placeholder="Email Address*" />
									<i class="fa fa-envelope"></i>
								</div>
								<button class="btn hvr-hover" type="submit">Submit</button>
							</form>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Social Media</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<ul>
                                <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                            </ul>
						</div>
					</div>
				</div>
				<hr>
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>About Freshshop</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> 
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p> 							
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link">
                            <h4>Information</h4>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Customer Service</a></li>
                                <li><a href="#">Our Sitemap</a></li>
                                <li><a href="#">Terms &amp; Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Delivery Information</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link-contact">
                            <h4>Contact Us</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Address: Michael I. Days 3756 <br>Preston Street Wichita,<br> KS 67213 </p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">+1-888 705 770</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="mailto:contactinfo@gmail.com">contactinfo@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class="footer-copyright">
        <p class="footer-company">All Rights Reserved. &copy; 2018 <a href="#">ThewayShop</a> Design By :
            <a href="https://html.design/">html design</a></p>
    </div>
    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const quantityInputs = document.querySelectorAll('.quantity-input');

    quantityInputs.forEach(input => {
        input.addEventListener('change', function () {
            const form = this.closest('.update-quantity-form');
            form.submit();
        });
    });
});

//cart
document.addEventListener("DOMContentLoaded", function () {
    updateCartData();

    // Function to update cart details
    function updateCartData() {
        fetch('cart_fetch.php')
            .then(response => response.json())
            .then(data => {
                // Update the cart count
                document.getElementById('cart-count').innerText = data.cartItems.length;

                // Update the cart list in the side menu
                const cartList = document.getElementById('cart-list');
                cartList.innerHTML = ''; // Clear previous list

                data.cartItems.forEach(item => {
                    const cartItemHTML = `
                        <li>
                            <a href="#" class="photo"><img src="${item.product_image}" class="cart-thumb" alt="" /></a>
                            <h6><a href="#">${item.product_name}</a></h6>
                            <p>${item.quantity}x - <span class="price">$${item.product_price}</span></p>
                        </li>
                    `;
                    cartList.innerHTML += cartItemHTML;
                });

                // Update the total price
                document.getElementById('cart-total').innerText = data.totalAmount;
            })
            .catch(error => console.error('Error fetching cart data:', error));
    }
});

    // Initialize cart from local storage or create a new one if it doesn't exist
    //  let cart = JSON.parse(localStorage.getItem('freshshopCart')) || [];

    // // Function to display the cart contents on the cart page
    // function displayCartContents() {
    //     const cartItemsContainer = document.getElementById('cart-items');
    //     cartItemsContainer.innerHTML = '';

    //     if (cart.length === 0) {
    //         cartItemsContainer.innerHTML = '<tr><td colspan="6">Your cart is empty</td></tr>';
    //         return;
    //     }

    //     let total = 0;

    //     cart.forEach((product, index) => {
    //         const subtotal = product.price * product.quantity;
    //         total += subtotal;

    //         const productRow = `
    //             <tr>
    //                 <td class="thumbnail-img"><a href="#"><img class="img-fluid" src="${product.image}" alt="" /></a></td>
    //                 <td class="name-pr"><a href="#">${product.name}</a></td>
    //                 <td class="price-pr"><p>$${product.price.toFixed(2)}</p></td>
    //                 <td class="quantity-box">
    //                     <input type="number" size="4" value="${product.quantity}" min="1" step="1" class="c-input-text qty text" data-index="${index}" onchange="updateQuantity(event)">
    //                 </td>
    //                 <td class="total-pr"><p>$${subtotal.toFixed(2)}</p></td>
    //                 <td class="remove-pr"><a href="#" data-index="${index}" onclick="removeFromCart(event)"><i class="fas fa-times"></i></a></td>
    //             </tr>
    //         `;
    //         cartItemsContainer.innerHTML += productRow;
    //     });

    //     document.getElementById('sub-total').textContent = total.toFixed(2);
    //     document.getElementById('grand-total').textContent = total.toFixed(2);
    // }

    // // Function to update the quantity of a product in the cart
    // function updateQuantity(event) {
    //     const input = event.currentTarget;
    //     const index = parseInt(input.getAttribute('data-index'));
    //     const newQuantity = parseInt(input.value);

    //     if (newQuantity > 0) {
    //         cart[index].quantity = newQuantity;
    //         localStorage.setItem('freshshopCart', JSON.stringify(cart));
    //         displayCartContents();
    //     }
    // }

    // // Function to remove a product from the cart
    // function removeFromCart(event) {
    //     event.preventDefault();

    //     const index = parseInt(event.currentTarget.getAttribute('data-index'));
    //     cart.splice(index, 1);

    //     localStorage.setItem('freshshopCart', JSON.stringify(cart));
    //     displayCartContents();
    // }

    // // Initialize cart contents on page load
    // document.addEventListener('DOMContentLoaded', displayCartContents);-->
</script> 

    <!-- ALL JS FILES -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/jquery.superslides.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/inewsticker.js"></script>
    <script src="js/bootsnav.js."></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>