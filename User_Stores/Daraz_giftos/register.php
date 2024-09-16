<?php
session_start();
include "./connection.php";

// Determine the protocol (HTTP/HTTPS)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Parse the URL to extract the path
    $parsed_url = parse_url($url);
    $path = $parsed_url['path']; 
    
    // Break the path into parts
    $path_parts = explode('/', $path);
    $store_name = $path_parts[3]; // Store name from the path

    if (!empty($store_name)) {
        // Check if the store exists in the database
        $sql = "SELECT id FROM store WHERE template = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $store_name);

        if($stmt->execute()) {
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $store_id = $row['id']; // Store ID from the database
            } else {
                echo "Store not found!";
                exit;
            }
        } else {
            echo "Error executing store query: " . $conn->error;
            exit;
        }
    } else {
        echo "Store name not provided!";
        exit;
    }

    // Check if username or email already exists
    $check_user_email = $conn->prepare("SELECT * FROM t_users WHERE (username = ? OR email = ?) AND store_id = ?");
    $check_user_email->bind_param("ssi", $username, $email, $store_id);
    $check_user_email->execute();
    $check_user_email_result = $check_user_email->get_result();    
    $check_user_email_data = $check_user_email_result->fetch_assoc();

    if ($check_user_email_result->num_rows > 0) {
        // Either username or email already exists
        echo '<script>alert("Username or Email already exists. Please choose another.");</script>';
    } else {
        // Insert user into the database
        $query = $conn->prepare("INSERT INTO t_users (username, email, password, store_id) VALUES (?, ?, ?, ?)");
        $query->bind_param("sssi", $username, $email, $password, $store_id);
        
        if ($query->execute()) {
            // Redirect after successful registration
            echo '<script>alert("Registration Successful")</script>';
            echo '<script>window.location.href = "login.php";</script>';
            exit;
        } else {
            echo "Registration failed: " . $conn->error;
        }
    }
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
    Register
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
              <img id="previewLogo" src="./images/logo.png" width="50" height="30" alt="logo">
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
                  <li><a class="dropdown-item active" href="./cart.php">Cart</a></li>
                  <li><a class="dropdown-item" href="./checkout.php">Checkout</a></li>
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Register</h2>
                <form action="register.php" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div> -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger mt-3">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary mt-3">Register</button>
                </form>
                <p class="mt-3 text-center">Already have an account? <a href="./login.php">Login here</a></p>
            </div>
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