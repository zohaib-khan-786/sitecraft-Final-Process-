<?php
session_start();
include "../../Connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = $conn->prepare("insert into t_users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $query->bind_param("sss", $username, $email, $password);
    if ($query->execute()) {
        echo '<script>
        alert("Registration Successful")
        </script>';
        header("Location:login.php");
    } else {
        echo '<script>
        alert("Registration Failed")
        </script>';
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
    .form-group1 label{
        font-size: 18px;
        font-weight: 600;
        color: #000;
    }
    .form-group1 input{
        border-radius: 5px;
        border: none;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    .form-group1 input:focus{
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    .btn1.btn-primary{
        background-color: #ffc221;
        color: #000;
        border: none;
        padding: 10px 15px;
    }
    .btn1.btn-primary:hover{
        background-color: #000;
        color: #ffc221;
        border: 1px solid #000;
        border-radius: 5px;
        padding: 10px 15px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    .para{
        color: #000;
        font-size: 17px;
        margin-top: 5rem;
        margin-bottom: 2rem;

    }
    .log{
        color: #000;
        font-weight: 600;
    }
    .log:hover{
        color: #333;
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
                                        <li class="mean-last active"> <a href="./signup.php">signup</a> </li>
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
        </div>
    </header>
    <!-- end header -->

    <div class="brand_color">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Create an Account!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- signup section start -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="signup.php" method="post">
                    <div class="form-group1">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="form-group1">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group1">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger mt-3">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn1 btn-primary mt-3">Register</button>
                </form>
                <p class="mt-3 para text-center">Already have an account? <a class="log" href="./login.php">Login here</a></p>
            </div>
        </div>
    </div>

    <!--  footer --> 
    <footer>
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
                            </ul>
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
    </footer>
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