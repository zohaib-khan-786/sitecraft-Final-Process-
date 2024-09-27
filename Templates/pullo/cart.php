<?php
session_start();
include "../../Connection/connection.php";

// Set the current template
$template = 'pullshoes';

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && !isset($_POST['action'])) {
    $productId = $_POST['product_id'];
    $sessionId = session_id();
    
    // Fetch product details from the database
    $query = "select * from products where id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: 1" . $conn->error);
    }
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        
        $query = "select * from cart where session_id = ? AND product_id = ? AND template_name = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: 2" . $conn->error);
        }
        $stmt->bind_param("sis", $sessionId, $productId, $template);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If it is, increase the quantity
            $cartItem = $result->fetch_assoc();
            $newQuantity = $cartItem['quantity'] + 1;

            $updateQuery = "update cart set quantity = ? where session_id = ? AND product_id = ? AND template_name = ?";
            $updateStmt = $conn->prepare($updateQuery);
            if (!$updateStmt) {
                die("Prepare failed: 3" . $conn->error);
            }
            $updateStmt->bind_param("isis", $newQuantity, $sessionId, $productId, $template);
            $updateStmt->execute();
        } else {
            // else, add the product to the cart with quantity 1
            $insertQuery = "insert into cart (session_id, product_id, product_name, product_price, product_image, quantity, template_name) values (?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            if (!$insertStmt) {
                die("Prepare failed: 4 " . $conn->error);
            }
            $quantity = 1;
            $insertStmt->bind_param("sisssis", $sessionId, $productId, $product['name'], $product['price'], $product['image'], $quantity, $template);
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

    $deleteQuery = "delete from cart where session_id = ? AND product_id = ? AND template_name = ?";
    $stmt = $conn->prepare($deleteQuery);
    if (!$stmt) {
        die("Prepare failed: 5" . $conn->error);
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
        $updateQuery = "update cart set quantity = ? where session_id = ? AND product_id = ? AND template_name = ?";
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            die("Prepare failed: 6" . $conn->error);
        }
        $stmt->bind_param("isis", $quantity, $sessionId, $productId, $template);
        $stmt->execute();
    }
}

// Handle Proceed to Checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proceed_to_checkout'])) {
    $_SESSION['cart'] = [];
    $cartQuery = "select * from cart where session_id = ? AND template_name = ?";
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
$query = "select * from products";
$result = $conn->query($query);

// Fetch cart items for the current session and template
$sessionId = session_id();
$cartQuery = "select * from cart where session_id = ? AND template_name = ?";
$cartStmt = $conn->prepare($cartQuery);
if (!$cartStmt) {
    die("Prepare failed: 7" . $conn->error);
}
$cartStmt->bind_param("ss", $sessionId, $template);
$cartStmt->execute();
$cartResult = $cartStmt->get_result();

$total = 0;
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
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
.add-to-cart {
    display: inline-block;
    width: 100%;
    margin-top: 1rem;
    background-color:  #0c0116;
    color: #ffffff;
    border: 1px solid  #0c0116;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.add-to-cart:hover {
    border: 1px solid  #0c0116;
    background-color: transparent;
    color: #0c0116;
}
.collection_text{
    margin-bottom: 5rem;
}
.table {
    margin-top: 12rem;
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background-color: #0c0116;
    color: #ffffff;
    padding: 1rem; /* Padding for better appearance */
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid #0c0116;
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid #ddd;
    text-align: center;
    font-weight: 500;
    font-size: 1rem;
    color: #333;
}

.table tr:hover {
    background-color: #f9f9f9; /* Subtle hover effect */
}

.table tr:nth-child(even) {
    background-color: #f4f4f4;
}

.heading {
    margin-top: 2rem;
    border-top: 1px solid gray;
    padding-top: 1rem;
    margin-bottom: 3rem; /* Added margin to ensure space between heading and table */
}

h4 {
    margin-top: 2rem;
    font-weight: 800;
    text-align: left;
    font-size: 1.5rem;
    color: #333;
}
p{
    font-size: 1rem;
    color: #333;
    font-weight: 400;
}

.heading button {
    margin-top: 1rem;
    background-color: #0c0116;
    color: #ffffff;
    border: 1px solid #0c0116;
    border-radius: 5px;
    padding: 0.75rem 1.5rem; 
    transition: all 0.3s ease;
    margin-bottom: 5rem;
    cursor: pointer;
}

.heading button:hover {
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
					<div class="logo"><a href="#"><img src="images/logo.png"></a></div>
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

	<!-- cart section start -->
  	<div class="collection_text">Shopping Cart</div>
        <div class="container">
            <!-- <h2 class="text-center">Shopping Cart</h2> -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Images</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <?php while ($row = $cartResult->fetch_assoc()) {
                        $subtotal = $row['product_price'] * $row['quantity'];
                        $total += $subtotal; 
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo $row['product_image']; ?>" width="50">
                        </td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>$<?php echo $row['product_price']; ?></td>
                        <td>
                            <form action="cart.php" method="POST" class="update-quantity-form">
                                <input type="number" size="4" value="<?php echo $row['quantity']; ?>" min="1" step="1" class="c-input-text qty text quantity-input" name="quantity" data-product-id="<?php echo $row['product_id']; ?>">
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <input type="hidden" name="action" value="update">
                            </form>
                        </td>
                        <td>$<?php echo $subtotal; ?></td>
                        <td>
                            <a href="cart.php?action=remove&id=<?php echo $row['product_id']; ?>">
                                <i class="fa fa-times" style="color: black;"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="heading">
                <h4>Order Summary</h4>
                <p>Sub Total: $<span id="subtotal"><?php echo $total; ?></span></p>
                <p>Shipping Cost: Free</p>
                <h4>Grand Total: $<span id="grandtotal"><?php echo $total; ?></span></h4>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="proceed_to_checkout" value="1">
                    <button type="submit" class="btn hvr-hover">Proceed to Checkout</button>
                </form>
            </div>
        </div>

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