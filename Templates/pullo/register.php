<?php
session_start();
include "../../Connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = $conn->prepare("insert into t_users (username, email, password) VALUES (?, ?, ?)");
    $query->bind_param("sss", $username, $email, $password);
    if ($query->execute()) {
        echo '<script>
        alert("Registration Successful")
        </script>';
        header("Location:login.php");
    } else {
        echo 'Registration failed!';
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
      <title>Pullshoes</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="./css/style.css">
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
    .form-group label{
        font-size: 18px;
        font-weight: 600;
        color: #0c0116;
    }
    .form-group input{
        border-radius: 5px;
    }
    .form-group input:focus{
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    .btn.btn-primary{
        background-color: #0c0116;
        color: #fff;
        border: none;
        padding: 10px 15px;
    }
    .btn.btn-primary:hover{
        background-color: #fff;
        color: #000;
        border: 1px solid #0c0116;
        border-radius: 5px;
        padding: 10px 15px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    p{
        color: #000;
        font-size: 17px;
        margin-top: 5rem;
        margin-bottom: 2rem;

    }
    a{
        color: #0c0116;
        font-weight: 600;
    }
    a:hover{
        color: #ff6a7c;
    }
    .collection_text{
        margin-bottom: 5rem;
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
	<div class="header_section">
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
								<a class="nav-item nav-link" href="index.php"  style="font-size: 17px;">Home</a>
								<!-- <a class="nav-item nav-link" href="collection.php" style="font-size: 17px;">Collection</a> -->
								<a class="nav-item nav-link" href="shoes.php" style="font-size: 17px;">Shoes</a>
								<!-- <a class="nav-item nav-link" href="racing boots.php" style="font-size: 17px;">Racing Boots</a> -->
								<a class="nav-item nav-link" href="contact.php" style="font-size: 19px;">Contact</a>
								<div class="dropdown">
									<button class="dropbtn">
										<i class="bi bi-person-circle" ></i>
									</button>
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

     <!-- signup section start -->
  	<div class="collection_text">Register</div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
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