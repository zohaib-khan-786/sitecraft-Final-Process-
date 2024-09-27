<?php
session_start();
include '../../Connection/connection.php';

$template = 'pullshoes';

// Ensure cart items are available in the session
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$totalAmount = 0;

foreach ($cartItems as $item) {
    $totalAmount += $item['product_price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve post data
    $paymentMethod = 'cod';

    // Validate if cart is not empty
    if (empty($cartItems) || $totalAmount <= 0) {
        header("Location: cart.php?error=empty_cart");
        exit();
    }

    $userId = 1;

    // set payment status based on payment method
    $paymentStatus = 'Pending'; 

    // Inserting data into orders table
    $stmt = $conn->prepare("insert into orders (user_id, total_amount, payment_method, payment_status, order_date) values (?, ?, ?, ?, NOW())");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("idss", $userId, $totalAmount, $paymentMethod, $paymentStatus);

    if ($stmt->execute()) {
        $orderId = $stmt->insert_id;

        // Insert order details
        $stmtDetail = $conn->prepare("insert into order_details (order_id, product_id, quantity, price) values (?, ?, ?, ?)");
        if (!$stmtDetail) {
            die("Prepare failed: " . $conn->error);
        }

        // Insert each item into order_details
        foreach ($cartItems as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['product_price'];

            $stmtDetail->bind_param("iiid", $orderId, $productId, $quantity, $price);
            if (!$stmtDetail->execute()) {
                die("Execute failed: " . $stmtDetail->error);
            }
        }

        // Close statements
        $stmt->close();
        $stmtDetail->close();

        // Delete products from the cart after order placement
        $sessionId = session_id();
        $deleteCartStmt = $conn->prepare("delete from cart where session_id = ? and template_name = ?");
        if (!$deleteCartStmt) {
            die("Prepare failed: " . $conn->error);
        }
        $deleteCartStmt->bind_param("ss", $sessionId, $template);
        $deleteCartStmt->execute();
        $deleteCartStmt->close();

        // Clear the cart from the session
        unset($_SESSION['cart']);

        // Redirect to a success page
        echo '<script> alert("Order placed successfully!") </script>';
        header("location: index.php?user_id=".$_SESSION['user_id']);
        // You can uncomment this to redirect after success
        // header("Location: checkout.php");
        // exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Collection</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
<style>
   /* .container {
        width: 80%;
        margin: auto;
    } */
    .row {
        display: flex;
        justify-content: space-between;
    }
    .col-50 {
        width: 48%;
    }
    .container h1{
      font-family: Arial, Helvetica, sans-serif;
          font-weight: 800;
          margin-top: 2rem;
          margin-bottom: 3rem;
    }
    .container h3{
      font-family: Arial, Helvetica, sans-serif;
          margin-bottom: 2rem;
          font-size: 1rem;
          font-weight: 800;
          border-bottom: 2px solid black;
    }
    .collection_text{
    margin-bottom: 5rem;
}
    form label{
      margin-bottom: 0.7rem;
      margin-top: 0.7rem;
    }
    #order-summary{
      font-size: 0.9rem;
      line-height: 1.5rem;
    }
    .order {
        margin-top: 2rem;
        margin-bottom: 5rem;
        background-color: #0c0116;
        color: #ffffff;
        border: 1px solid #0c0116;
        border-radius: 5px;
        padding: 0.75rem 1.5rem; 
        -webkit-transition: all .3s;
        transition: all .3s;
        cursor: pointer;
    }
    .order:hover{
        border: 1px solid #0c0116;
        background-color: transparent;
        color: #0c0116;
    }
    .dropbtn {
	background-color: #0c0116;
	color: #fff;
	padding: 8px;
	font-size: 17px;
	border: none;
	cursor: pointer;
	margin-left: 1rem;
}
.dropdown {
    position: relative;
    display: inline-block;
}
  
.dropdown-content {
    top: 50px;
    border-radius: 5px;
    display: none;
	 background-color: #fff;
	position: absolute;
	  color: black;
	min-width: 140px;
	box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	z-index: 1;
}
  
.dropdown-content a {
	color: #000;
	padding: 12px 16px;
	text-decoration: none;
	display: block;
}

.dropdown-content a:hover {
	background-color: #ff6a7c;
}

.dropdown:hover .dropdown-content {
	display: block;
}

.dropdown:hover .dropbtn {
	background-color: #0c0116;
}


/* Responsive adjustments */
@media (max-width: 768px) {
    .dropdown {
        width: 100%;
    }

    .dropbtn {
        width: 100%;
        text-align: center;
        margin-left: 0;
    }

    .dropdown-content {
        position: static;
        width: 100%;
        box-shadow: none;
    }
}

@media (max-width: 576px) {
    .dropbtn {
        font-size: 14px;
        margin-top: 1.5rem;
        margin-left: 1.2rem;
    }

    .dropbtn {
        font-size: 14px;
    }

    .dropdown-content a {
        padding: 5px 7px;
    }
}
  </style>
   <!-- body -->
   <body class="main-layout">
	<!-- header section start -->
	<div class="header_section header_main">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="logo"><a href="./index.php"><img src="images/logo.png"></a></div>
				</div>
				<div class="col-sm-9">
					<nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        	<span class="navbar-toggler-icon"></span>
                        </button>
						<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
							<div class="navbar-nav">
                            <a class="nav-item nav-link" href="index.php?user_id=<?php if(isset($_SESSION['user_id']))echo($_SESSION['user_id']);?>"  style="font-size: 17px;">Home</a>
								<!-- <a class="nav-item nav-link" href="collection.php" style="font-size: 17px;">Collection</a> -->
								<a class="nav-item nav-link" href="shoes.php" style="font-size: 17px;">Shoes</a>
								<!-- <a class="nav-item nav-link" href="racing boots.php" style="font-size: 17px;">Racing Boots</a> -->
								<a class="nav-item nav-link" href="contact.php" style="font-size: 17px;">Contact</a>
                                <div class="dropdown">
									<button class="dropbtn">
										<i class="bi bi-person-circle" ></i>
									</button>
									<div class="dropdown-content">
										<a href="./login.php" >Login</a>
										<a href="./register.php" >Register</a>
										<?php
										//  if(isset($_SESSION['user_id'])){
										// 		echo '
										// 			<a href="./logout.php">Logout</a>';
										// 	 } else {
										// 		echo '
										// 		<a href="./login.php" >Login</a>
										// 		<a href="./register.php" >Register</a>';
										// 	}
										?>
									</div>
								</div>
								<a class="nav-item nav-link last" href="#" style="font-size: 17px;"><img src="images/search_icon.png"></a>
								<a class="nav-item nav-link last" href="cart.php" style="font-size: 17px;"><img src="images/shop_icon.png"><span class="cart-count" style="margin-left: 0.5rem;">0</span></a>
							</div>
						</div>
                    </nav>
				</div>
			</div>
		</div>
	</div>

    <div class="collection_text">Checkout</div>
        <?php if (isset($_GET['order_success']) && $_GET['order_success'] == 1) { ?>
        <p>Your order number is: <?php echo htmlspecialchars($_GET['order_id']); ?></p> 
        <?php } else { ?>
            <div class="container">
        <!-- <h1>Checkout</h1> -->
        <div class="row">
            <div class="col-50">
                <h3>Billing Address</h3>
                <form id="checkout-form" action="checkout.php" method="POST" class="needs-validation" novalidate>
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="firstname" required class="form-control">

                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lastname" required class="form-control">

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required class="form-control">

                    <label for="adr">Address</label>
                    <input type="text" id="adr" name="address" required class="form-control">

                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required class="form-control">

                    <div class="row">
                        <div class="col-50">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" required class="form-control">
                        </div>
                        <div class="col-50">
                            <label for="zip">Zip</label>
                            <input type="text" id="zip" name="zip" required class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-50">
                <h3>Order Summary</h3>
                <div id="order-summary">
                    <?php foreach ($cartItems as $item) { ?>
                        <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="" style="height: 50px; width:50px; border-radius:50%;">
                        <a href="#" style="color: #333; font-weight:bold;"><?php echo htmlspecialchars($item['product_name']); ?></a> <br>
                        <p>Price: $<?php echo htmlspecialchars($item['product_price']); ?>
                        <span class="mx-2">|</span> 
                        Qty: <?php echo htmlspecialchars($item['quantity']); ?>
                        <span class="mx-2">|</span> 
                        Subtotal: $<?php echo htmlspecialchars($item['product_price'] * $item['quantity']); ?></p>
                        <p>Shipping Fee: Free</p>
                        <p>Grand Total: $<?php echo htmlspecialchars($totalAmount + 10.00); ?>  Total + shipping fee</p>
                    <?php } ?>
                </div>
                <h3>Payment</h3>
                <label for="fname">Accepted Cards</label>
                <div>
                    <img src="images/payment-icon/5.png" alt="Accepted Cards">
                </div>
                <form id="payment-form" action="checkout.php" method="POST" class="needs-validation" novalidate>
                    <label for="cname">Name on Card</label>
                    <input type="text" id="cname" name="cardname" required class="form-control">

                    <label for="ccnum">Credit card number</label>
                    <input type="text" id="ccnum" name="cardnumber" required class="form-control">

                    <label for="expmonth">Exp Month</label>
                    <input type="text" id="expmonth" name="expmonth" required class="form-control">

                    <div class="row">
                        <div class="col-50">
                            <label for="expyear">Exp Year</label>
                            <input type="text" id="expyear" name="expyear" required class="form-control">
                        </div>
                        <div class="col-50">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" required class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn order">Place Order</button>
                </form>
            </div>
        </div>
    </div>
    <?php } ?> 

    <!-- section footer start -->
    <div class="section_footer">
    	    <div class="container">
                <div class="mail_section">
                    <div class="row">
                        <div class="col-sm-6 col-lg-2">
                            <div><a href="#"><img src="images/footer-logo.png"></a></div>
                        </div>
                        <div class="col-sm-6 col-lg-2">
                            <div class="footer-logo"><img src="images/phone-icon.png"><span class="map_text">(71) 1234567890</span></div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="footer-logo"><img src="images/email-icon.png"><span class="map_text">Demo@gmail.com</span></div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="social_icon">
                                <ul>
                                    <li><a href="#"><img src="images/fb-icon.png"></a></li>
                                    <li><a href="#"><img src="images/twitter-icon.png"></a></li>
                                    <li><a href="#"><img src="images/in-icon.png"></a></li>
                                    <li><a href="#"><img src="images/google-icon.png"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div> 
                <div class="footer_section_2">
                    <div class="row">
                        <div class="col-sm-4 col-lg-2">
                            <p class="dummy_text"> ipsum dolor sit amet, consectetur ipsum dolor sit amet, consectetur  ipsum dolor sit amet,</p>
                        </div>
                        <div class="col-sm-4 col-lg-2">
                            <h2 class="shop_text">Address </h2>
                            <div class="image-icon"><img src="images/map-icon.png"><span class="pet_text">No 40 Baria Sreet 15/2 NewYork City, NY, United States.</span></div>
                        </div>
                        <div class="col-sm-4 col-md-6 col-lg-3">
                            <h2 class="shop_text">Our Company </h2>
                            <div class="delivery_text">
                                <ul>
                                    <li>Delivery</li>
                                    <li>Legal Notice</li>
                                    <li>About us</li>
                                    <li>Secure payment</li>
                                    <li>Contact us</li>
                                </ul>
                            </div>
                        </div>
                    <div class="col-sm-6 col-lg-3">
                        <h2 class="adderess_text">Products</h2>
                        <div class="delivery_text">
                                <ul>
                                    <li>Prices drop</li>
                                    <li>New products</li>
                                    <li>Best sales</li>
                                    <li>Contact us</li>
                                    <li>Sitemap</li>
                                </ul>
                            </div>
                    </div>
                    <div class="col-sm-6 col-lg-2">
                        <h2 class="adderess_text">Newsletter</h2>
                        <div class="form-group">
                            <input type="text" class="enter_email" placeholder="Enter Your email" name="Name">
                        </div>
                        <button class="subscribr_bt">Subscribe</button>
                    </div>
                    </div>
                    </div> 
                </div>
            </div>
        </div>
        <!-- section footer end -->
        <div class="copyright">2019 All Rights Reserved. <a href="https://html.design">Free html  Templates</a></div>

<script>
//cart
document.addEventListener("DOMContentLoaded", function () {
    const templateName = 'pullshoes'; 
    updateCartData(templateName);

    // Function to update cart details
    function updateCartData(template) {
   
        fetch(`cart_fetch.php?template=${template}`)
            .then(response => response.json())
            .then(data => {
              
                const cartCountElement = document.querySelector('.cart-count');
                cartCountElement.innerText = data.cartItems.length;

                const cartList = document.getElementById('cart-list');
                if (cartList) {
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
                }

                // Update the total price if needed
                const cartTotalElement = document.getElementById('cart-total');
                if (cartTotalElement) {
                    cartTotalElement.innerText = data.totalAmount;
                }
            })
            .catch(error => console.error('Error fetching cart data:', error));
    }
});
</script>

          <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
   </body>
</html>