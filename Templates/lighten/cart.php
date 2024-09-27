<?php
session_start();
include "../../Connection/connection.php";

// Set the current template
$template = 'lighten';

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && !isset($_POST['action'])) {
    $productId = $_POST['product_id'];
    $sessionId = session_id();
    
    // Fetch product details from the database
    $query = "select * from products where id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Check if the product is already in the cart for the current template
        $query = "select * from cart where session_id = ? AND product_id = ? AND template_name = ?";
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

            $updateQuery = "update cart set quantity = ? where session_id = ? AND product_id = ? AND template_name = ?";
            $updateStmt = $conn->prepare($updateQuery);
            if (!$updateStmt) {
                die("Prepare failed: " . $conn->error);
            }
            $updateStmt->bind_param("isis", $newQuantity, $sessionId, $productId, $template);
            $updateStmt->execute();
        } else {
            // else, add the product to the cart with quantity 1
            $insertQuery = "insert into cart (session_id, product_id, product_name, product_price, product_image, quantity, template_name) values (?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            if (!$insertStmt) {
                die("Prepare failed: " . $conn->error);
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
        $updateQuery = "update cart set quantity = ? where session_id = ? AND product_id = ? AND template_name = ?";
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
    die("Prepare failed: " . $conn->error);
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
    .add-to-cart {
        display: inline-block;
        width: 100%;
        margin-top: 1rem;
        background-color:  #ffc221;
        color: #000;
        border: 1px solid  #ffc221;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .add-to-cart:hover {
        border: 1px solid  #000;
        background-color: #000;
        color: #ffc221;
    }
    /* .collection_text{
        margin-bottom: 5rem;
    } */
    .table {
        margin-top: 2rem;
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background-color: #000;
        color: #ffffff;
        padding: 1rem;
        border-radius: 5px;
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
        background-color: #f9f9f9;
    }

    .table tr:nth-child(even) {
        background-color: #f4f4f4;
    }
    .heading {
        margin-top: 2rem;
        border-top: 1px solid gray;
        padding-top: 1rem;
        margin-bottom: 3rem;
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
        background-color: #ffc221;
        color: #000;
        border: 1px solid #ffc221;
        border-radius: 5px;
        padding: 0.75rem 1.5rem; 
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 5rem;
        cursor: pointer;
    }

    .heading button:hover {
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
                            <p><a href="./cart.php"><i class="bi bi-bag-check-fill" style="font-size: 20px;"></i></a>
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
                        <h2>Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-bordered">
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
        <div class="heading text-end">
            <h4>Order summary</h4>
            <p>Sub Total: <span id="subtotal">$<?php echo $total; ?></span></p>
            <p>Shipping Cost: Free</p>
            <h4>Grand Total: <span id="grandtotal"> $<?php echo $total; ?> </span></h4>
            <form method="POST" action="cart.php">
                <input type="hidden" name="proceed_to_checkout" value="1">
                <button type="submit" class="btn hvr-hover">Proceed to Checkout</button>
            </form>
        </div>
    </div>

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

         //update cart quantity
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