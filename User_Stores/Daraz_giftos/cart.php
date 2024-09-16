<?php
session_start();
include "./connection.php";

// Set the current template
$template = 'giftos';

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && !isset($_POST['action'])) {
  $productId = $_POST['product_id'];
  $storeId = isset($_POST['store_id']) ? $_POST['store_id'] : null;

  $sessionId = session_id();

  // Fetch the product details including quantity
  $query = "SELECT * FROM products WHERE id = ? AND store_id != 0";
  $stmt = $conn->prepare($query);
  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("i", $productId);
  $stmt->execute();
  $result = $stmt->get_result();
  $product = $result->fetch_assoc();

  if ($product) {
      // Fetch the cart item details if it already exists
      $query = "SELECT * FROM cart WHERE session_id = ? AND product_id = ? AND template_name = ?";
      $stmt = $conn->prepare($query);
      if (!$stmt) {
          die("Prepare failed: " . $conn->error);
      }
      $stmt->bind_param("sis", $sessionId, $productId, $template);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {

          $cartItem = $result->fetch_assoc();
          $newQuantity = $cartItem['quantity'] + 1;

          if ($newQuantity > $product['quantity']) {
              $newQuantity = $product['quantity'];
              echo"<script>document.querySelector(''.c-input-text).value=".$newQuantity."</script>"; // Set to max available quantity
          }

          $updateQuery = "UPDATE cart SET quantity = ? WHERE session_id = ? AND product_id = ? AND template_name = ?";
          $updateStmt = $conn->prepare($updateQuery);
          if (!$updateStmt) {
              die("Prepare failed: " . $conn->error);
          }
          $updateStmt->bind_param("isis", $newQuantity, $sessionId, $productId, $template);
          $updateStmt->execute();
      } else {
          // If the product doesn't exist in the cart, insert it with quantity 1
          $insertQuery = "INSERT INTO cart (session_id, store_id, product_id, product_name, product_price, product_image, quantity, cost, template_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $insertStmt = $conn->prepare($insertQuery);
          if (!$insertStmt) {
              die("Prepare failed: " . $conn->error);
          }
          $quantity = 1; // Default quantity when inserting
          $insertStmt->bind_param("siisssids", $sessionId, $storeId, $productId, $product['name'], $product['price'], $product['image'], $quantity, $product['cost'], $template);
          $insertStmt->execute();
      }
  }
  // Redirect to cart page after handling the request
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
    Cart
  </title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="./css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="./css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="./css/responsive.css" rel="stylesheet" />
</head>

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
                <a class="btn nav-link" href="shop.php" role="button" id="dropdownMenuLink">
                  Shop
                </a>
                <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item active" href="cart.php">Cart</a></li>
                  <li><a class="dropdown-item" href="checkout.php">Checkout</a></li>
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
  
    <div class="container mt-5">
      <h2 class="text-center">Shopping Cart</h2> 
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
          <button type="submit" class="btn btn-primary hvr-hover">Proceed to Checkout</button>
        </form>
    </div>
  </div>

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

    // document.addEventListener('DOMContentLoaded', function () {
    //     const cartItemsContainer = document.getElementById('cart-items');
    //     let cart = JSON.parse(localStorage.getItem('giftosCart')) || [];

    //     function updateCartDisplay() {
    //         if (cart.length === 0) {
    //             cartItemsContainer.innerHTML = '<tr><td colspan="6" class="text-center">Your cart is empty.</td></tr>';
    //             document.getElementById('subtotal').textContent = '0.00';
    //             document.getElementById('grandtotal').textContent = '0.00';
    //             return;
    //         }

    //         let cartHtml = '';
    //         let subtotal = 0;

    //         cart.forEach((product, index) => {
    //             const price = parseFloat(product.price);
    //             const total = price * product.quantity;
    //             subtotal += total;

    //             cartHtml += `
    //                 <tr>
    //                     <td><img src="${product.image}" alt="${product.name}" style="width: 50px;"></td>
    //                     <td>${product.name}</td>
    //                     <td>$${price.toFixed(2)}</td>
    //                     <td>
    //                         <input type="number" value="${product.quantity}" min="1" data-index="${index}" class="quantity-input">
    //                     </td>
    //                     <td>$${total.toFixed(2)}</td>
    //                     <td><button class="btn btn-danger remove-from-cart" data-index="${index}">&times;</button></td>
    //                 </tr>
    //             `;
    //         });

    //         cartItemsContainer.innerHTML = cartHtml;
    //         document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    //         document.getElementById('grandtotal').textContent = subtotal.toFixed(2);

    //         // Update quantity
    //         document.querySelectorAll('.quantity-input').forEach(input => {
    //             input.addEventListener('change', function () {
    //                 const index = this.getAttribute('data-index');
    //                 const newQuantity = parseInt(this.value);
    //                 if (newQuantity > 0) {
    //                     cart[index].quantity = newQuantity;
    //                     localStorage.setItem('giftosCart', JSON.stringify(cart));
    //                     updateCartDisplay(); // Update the display without reloading the page
    //                 }
    //             });
    //         });

    //         // Remove from cart
    //         document.querySelectorAll('.remove-from-cart').forEach(button => {
    //             button.addEventListener('click', function () {
    //                 const index = this.getAttribute('data-index');
    //                 cart.splice(index, 1);
    //                 localStorage.setItem('giftosCart', JSON.stringify(cart));
    //                 updateCartDisplay(); // Update the display without reloading the page
    //             });
    //         });
    //     }

    //     updateCartDisplay(); // Initial call to display the cart items
    // });

    // function proceedToCheckout() {
    //     // Store cart data in localStorage for checkout
    //     localStorage.setItem('checkoutGiftosCart', JSON.stringify(JSON.parse(localStorage.getItem('giftosCart')) || []));
    //     window.location.href = 'checkout.html';
    // }
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