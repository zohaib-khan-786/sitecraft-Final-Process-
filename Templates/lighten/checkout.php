<?php
session_start();
include '../../Connection/connection.php';

$template = 'lighten';

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
    <title>lighten</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<style>
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
    form label{
      margin-bottom: 0.7rem;
      margin-top: 0.7rem;
      font-size: 16px;
        font-weight: 600;
        color: #333;
    }
    .needs-validation input{
        border: none;
        border-radius: 5px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    .needs-validation input:focus{
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    #order-summary{
      font-size: 0.9rem;
      line-height: 1.5rem;
    }
    .order {
        margin-top: 2rem;
        margin-bottom: 5rem;
        background-color: #ffc221;
        color: #000;
        border: 1px solid #ffc221;
        border-radius: 5px;
        padding: 0.75rem 1.5rem; 
        -webkit-transition: all .3s;
        transition: all .3s;
        cursor: pointer;
    }
    .order:hover{
        border: 1px solid #000;
        background-color: #000;
        color: #ffc221;
    }
</style>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <!-- <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div> -->
      <!-- end loader --> 
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="head_top">
               <div class="container">
                  <div class="row">
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="top-box">
                           <ul class="sociel_link">
                              <li>
                                 <a href="#"><i class="fa fa-facebook-f"></i></a>
                              </li>
                              <li>
                                 <a href="#"><i class="fa fa-twitter"></i></a></li>
                              <li>
                                 <a href="#"><i class="fa fa-instagram"></i></a>
                              </li>
                              <li>
                                 <a href="#"><i class="fa fa-linkedin"></i></a>
                              </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="top-box">
                            <p><a href="./cart.php"><i class="bi bi-bag-check-fill" style="font-size: 20px;"></i><span class="cart-count" style="margin-left: 0.5rem;">0</span></a>
                            </p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
               <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                  <div class="full">
                     <div class="center-desk">
                        <div class="logo"> <a href="index.php"><img src="images/logo.jpg" alt="logo"/></a> </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-7 col-lg-7 col-md-9 col-sm-9">
                  <div class="menu-area">
                     <div class="limit-box">
                        <nav class="main-menu">
                           <ul class="menu-area-main">
                              <li> <a href="index.php">Home</a> </li>
                              <li> <a href="about.php">About</a> </li>
                              <li> <a href="product.php">product</a> </li>
                              <li> <a href="blog.php"> Blog</a> </li>
                              <li> <a href="contact.php">Contact</a> </li>
                              <li class="mean-last"> <a href="./signup.php">signup</a> </li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
               <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                  <li><a class="buy" href="./login.php">Login</a></li>
               </div>
            </div>
         </div>
         <!-- end header inner --> 
    </header>
    <!-- end header -->

    <div class="brand_color">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Checkout</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <?php if (isset($_GET['order_success']) && $_GET['order_success'] == 1) { ?>
        <p>Your order number is: <?php echo htmlspecialchars($_GET['order_id']); ?></p> 
        <?php } else { ?>
            <div class="container mt-5">
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
                        <!-- <div class="col-50">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" required class="form-control">
                        </div> -->
                        <div class="col-50">
                            <label for="zip">Zip</label>
                            <input type="text" id="zip" name="zip" required class="form-control" >
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
                <br>
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

    <!--  footer --> 
    <footr>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-6 offset-md-3">
                     <ul class="sociel">
                         <li> <a href="#"><i class="fa fa-facebook-f"></i></a></li>
                         <li> <a href="#"><i class="fa fa-twitter"></i></a></li>
                         <li> <a href="#"><i class="fa fa-instagram"></i></a></li>
                         <li> <a href="#"><i class="fa fa-instagram"></i></a></li>
                     </ul>
                  </div>
            </div>
            <div class="row">
               <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                  <div class="contact">
                     <h3>conatct us</h3>
                     <span>123 Second Street Fifth Avenue,<br>
                       Manhattan, New York
                        +987 654 3210</span>
                  </div>
               </div>
                 <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                  <div class="contact">
                     <h3>ADDITIONAL LINKS</h3>
                     <ul class="lik">
                         <li> <a href="#">About us</a></li>
                         <li> <a href="#">Terms and conditions</a></li>
                         <li> <a href="#">Privacy policy</a></li>
                         <li> <a href="#">News</a></li>
                          <li> <a href="#">Contact us</a></li>
                     </ul>
                  </div>
               </div>
                 <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                  <div class="contact">
                     <h3>service</h3>
                      <ul class="lik">
                    <li> <a href="#"> Data recovery</a></li>
                         <li> <a href="#">Computer repair</a></li>
                         <li> <a href="#">Mobile service</a></li>
                         <li> <a href="#">Network solutions</a></li>
                          <li> <a href="#">Technical support</a></li>
                  </div>
               </div>
                 <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                  <div class="contact">
                     <h3>IT NEXT THEME</h3>
                     <span>Tincidunt elit magnis <br>
                     nulla facilisis. Dolor <br>
                  sagittis maecenas. <br>
               Sapien nunc amet <br>
            ultrices, </span>
                  </div>
               </div>
            </div>
         </div>
            <div class="copyright">
               <p>Copyright 2019 All Right Reserved By <a href="https://html.design/">Free html Templates</a></p>
            </div>
         
      </div>
      </footr>
      <!-- end footer -->
      <!-- Javascript files--> 
      <script src="js/jquery.min.js"></script> 
      <script src="js/popper.min.js"></script> 
      <script src="js/bootstrap.bundle.min.js"></script> 
      <script src="js/jquery-3.0.0.min.js"></script> 
      <script src="js/plugin.js"></script> 
      <!-- sidebar --> 
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script> 
      <script src="js/custom.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
      <script>
         $(document).ready(function(){
         $(".fancybox").fancybox({
         openEffect: "none",
         closeEffect: "none"
         });
         
         $(".zoom").hover(function(){
         
         $(this).addClass('transition');
         }, function(){
         
         $(this).removeClass('transition');
         });
         });

        //cart
document.addEventListener("DOMContentLoaded", function () {
    const templateName = 'lighten'; 
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
   </body>
</html>