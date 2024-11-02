<?php
session_start();
include 'connection.php';

$template = 'giftos';

$requestUri = $_SERVER['REQUEST_URI'];

$pathParts = explode('/', $requestUri);

$storeName = $pathParts[3];

require '../../loadenv.php';
require '../../vendor/autoload.php';
loadEnv(__DIR__ . '/../../.env');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header('Location: login.php');
    exit();
}

function sendMail($to, $subject, $message) {
  $mail = new PHPMailer(true);
  
  try {
     
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';  
      $mail->SMTPAuth = true;
      $mail->Username = getenv('MAIL_USERNAME');  
      $mail->Password = getenv('MAIL_PASSWORD');  
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      // Recipients
      $mail->setFrom('killerzobi893@gmail.com', 'Site Craft');  
      $mail->addAddress($to);  

      // Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $message;

      $mail->send();
      return true;
  } catch (Exception $e) {
      return false;  
  }
}

// Ensure cart items are available in the session
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$totalAmount = 0; 

// Debugging: Output cart items and total amount calculation
error_log("Debug: Cart Items: " . print_r($cartItems, true));

foreach ($cartItems as $item) {
    $totalAmount += $item['product_price'] * $item['quantity']; 
}

// Debugging: Output total amount
error_log("Debug: Total Amount: $totalAmount");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_loggedin'])  || $_SESSION['user_loggedin'] != true) {
        header('location: login.php');
        exit();
    }

    $paymentMethod = 'cod';   

    // Check if the cart is empty
    if (empty($cartItems)) {
        header("Location: cart.php?error=empty_cart");
        exit();
    }

    // Check if total amount is valid
    if ($totalAmount <= 0) {
        header("Location: cart.php?error=invalid_amount");
        exit();
    }

    $paymentStatus = 'Pending'; // COD status is pending

    // Prepare the SQL statement for inserting orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, store_id, name, image, price, cost, quantity, total_amount, payment_method, payment_status, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    if (!$stmt) {
        // Debugging: Output SQL error
        error_log("Debug: Prepare failed: " . $conn->error);
        die("Prepare failed: " . $conn->error);
    }

    // Debugging: Log the number of items in the cart
    error_log("Debug: Number of cart items: " . count($cartItems));

    // Insert each item into orders and order_details
    foreach ($cartItems as $item) {
        $productName = $item['product_name'];
        $productImage = $item['product_image'];
        $price = $item['product_price'];
        $cost = $item['cost'];
        $quantity = $item['quantity'];
        $productId = $item['product_id'];
        $storeId = $item['store_id'];
        
        // Bind parameters for the order insert
        $stmt->bind_param("iissddidss", $userId, $storeId,  $productName, $productImage, $price, $cost, $quantity, $totalAmount, $paymentMethod, $paymentStatus);

        if (!$stmt->execute()) {
            // Debugging: Output SQL execution error
            error_log("Debug: Execute failed: " . $stmt->error);
            die("Execute failed: " . $stmt->error);
        }

        $orderId = $stmt->insert_id;

        // Debugging: Log the created order ID
        error_log("Debug: Order ID created: $orderId");

        // Insert order details
        $stmtDetail = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        if (!$stmtDetail) {
            // Debugging: Output SQL error
            error_log("Debug: Prepare failed (order_details): " . $conn->error);
            die("Prepare failed: " . $conn->error);
        }

        $stmtDetail->bind_param("iiid", $orderId, $productId, $quantity, $price);

        if (!$stmtDetail->execute()) {
            // Debugging: Output SQL execution error
            error_log("Debug: Execute failed (order_details): " . $stmtDetail->error);
            die("Execute failed: " . $stmtDetail->error);
        }

        $stmtDetail->close(); // Close the order details statement for each item
    }

    // Close the main statement
    $stmt->close();

    // Debugging: Log session ID and template name before deleting cart
    $sessionId = session_id();
    error_log("Debug: Session ID: $sessionId, Template: $template");

    // Delete cart items
    $deleteCartStmt = $conn->prepare("DELETE FROM cart WHERE session_id = ? AND template_name = ?");
    if (!$deleteCartStmt) {
        // Debugging: Output SQL error
        error_log("Debug: Prepare failed (delete cart): " . $conn->error);
        die("Prepare failed: " . $conn->error);
    }

    $deleteCartStmt->bind_param("ss", $sessionId, $template);
    if (!$deleteCartStmt->execute()) {
        // Debugging: Output SQL execution error
        error_log("Debug: Execute failed (delete cart): " . $deleteCartStmt->error);
        die("Execute failed: " . $deleteCartStmt->error);
    }

    $deleteCartStmt->close();

    // Clear cart session
    unset($_SESSION['cart']);

    $sql = "SELECT users.email AS email FROM store JOIN users ON users.id = store.created_by WHERE store.template = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s',$storeName);
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $orderDetails = "<h3>Order Details</h3>";
      $orderDetails .= "<p><strong>Order ID:</strong> {$orderId}</p>";
      $orderDetails .= "<p><strong>Total Amount:</strong> {$totalAmount}</p>";
      $orderDetails .= "<p><strong>Payment Method:</strong> {$paymentMethod}</p>";
      $orderDetails .= "<h4>Items Ordered:</h4><ul>";
  
      foreach ($cartItems as $item) {
          $orderDetails .= "<li>{$item['product_name']} - Quantity: {$item['quantity']} - Price: {$item['product_price']}</li>";
      }
      $orderDetails .= "</ul>";
  
      // Send email to store owner
      $subject = "New Order Placed - Order ID: {$orderId}";
      if (sendMail($row['email'], 'New order recieved', $orderDetails)) {
        error_log("Debug: Order details sent to store owner.");
    } else {
        error_log("Debug: Failed to send order details to store owner.");
    }
    }
    

    echo '<script>alert("Order placed successfully!")</script>';

    // Redirect to index with order success
    header("Location: index.php?order_success=1&order_id=$orderId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <title id="previewTitle">
    Giftos
  </title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="./css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>
<style>
  .container {
      width: 80%;
      margin: auto;
  }
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
  }
  #order-summary{
    font-size: 0.9rem;
    line-height: 1.5rem;
  }
 

</style>
<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="index.php">
        <img id="previewLogo" src="./images/logo.png" width="80" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse innerpage_navbar" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <li class="nav-item ">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <div class="btn-group nav-item active">
              <a class="btn nav-link" href="shop.html" role="button" id="dropdownMenuLink">
                Shop
              </a>
              <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./cart.php">Cart</a></li>
                <li><a class="dropdown-item active" href="./checkout.php">Checkout</a></li>
              </ul>
            </div>
            <li class="nav-item">
              <a class="nav-link" href="why.php">
                Why Us
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="testimonial.php">
                Testimonial
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
          </ul>
          <div class="user_option">
          <?php
                    if (isset($_SESSION['user_loggedin'])) {
                      echo '<a href="./logout.php" class="d-flex align-items-center text-danger me-3">
                                <i class="fa fa-power" aria-hidden="true"></i>
                                <span>Logout</span>
                            </a>';
                    } else {
                      echo '<a href="./login.php" class="d-flex align-items-center me-3">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Login</span>
                            </a>';
                    } ?>
            <a href="cart.php">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              <span class="cart-count">0</span>
            </a>
            <form class="form-inline ">
              <button class="btn nav_search-btn" type="submit">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </form>
          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->

  </div>
  <!-- end hero area -->

  <?php if (isset($_GET['order_success']) && $_GET['order_success'] == 1) { ?>
    <p>Your order number is: <?php echo htmlspecialchars($_GET['order_id']); ?></p> 
    <?php } else { ?>
  <div class="container mt-5">
    <h1>Checkout</h1>
    <div class="row">
      <div class="col-50">
        <h3>Billing Address</h3>
        <form action="checkout.php" method="POST" class="needs-validation" >
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
        <form action="checkout.php" method="POST" class="needs-validation" >
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

 <!-- info section -->

  <section class="info_section  layout_padding2-top">
    <div class="social_container">
      <div class="social_box">
        <a href="">
          <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a href="">
          <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>
        <a href="">
          <i class="fa fa-instagram" aria-hidden="true"></i>
        </a>
        <a href="">
          <i class="fa fa-youtube" aria-hidden="true"></i>
        </a>
      </div>
    </div>
    <div class="info_container ">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <h6>
              ABOUT US
            </h6>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="info_form ">
              <h5>
                Newsletter
              </h5>
              <form action="#">
                <input type="email" placeholder="Enter your email">
                <button>
                  Subscribe
                </button>
              </form>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>
              NEED HELP
            </h6>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>
              CONTACT US
            </h6>
            <div class="info_link-box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span> Gb road 123 london Uk </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>+01 12345678901</span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span> demo@gmail.com</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- footer section -->
    <footer class=" footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html Templates</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->

  </section>

<script>
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

//cart
document.addEventListener("DOMContentLoaded", function () {
    const templateName = 'giftos'; // Set the template name to 'giftos'
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>

<script src="js/custom.js"></script>

</body>
</html>
