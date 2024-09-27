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
      <title>Shoes</title>
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
.best_shoes {
    position: relative;
    overflow: hidden;
}

.add_to_cart {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #ff4e5b;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 50px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
    cursor: pointer;
}

.add_to_cart:hover {
    background-color: #ff6a7c;
}

.shoes_icon:hover .add_to_cart {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(-10px);
}

.shoes_icon img {
    /* display: block; */
    max-width: 100%;
    transition: transform 0.3s ease;
}

.shoes_icon:hover img {
    transform: scale(1.1);
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
						<div class="navbar-nav ">
								<a class="nav-item nav-link" href="index.php"  style="font-size: 17px;">Home</a>
								<!-- <a class="nav-item nav-link" href="collection.php" style="font-size: 17px;">Collection</a> -->
								<a class="nav-item nav-link" href="shoes.php" style="font-size: 17px;">Shoes</a>
								<!-- <a class="nav-item nav-link" href="racing boots.php" style="font-size: 17px;">Racing Boots</a> -->
								<a class="nav-item nav-link" href="contact.php" style="font-size: 19px;">Contact</a>
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

	<!-- New Arrivals section start -->
	<div class="collection_text">Shoes</div>
		<div class="collection_section layout_padding">
			<div class="container">
				<h1 class="new_text"><strong>New Arrivals Products</strong></h1>
				<p class="consectetur_text">consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
			</div>
		</div>
		<?php
			include "../../Connection/connection.php";

			// Fetch products from the database
			$query = "SELECT * FROM products where id >= 34 and id <=39";
			$result = $conn->query($query);
		?>
		<div class="layout_padding gallery_section">
			<div class="container">
				<div class="row">
					<?php while ($row = $result->fetch_assoc()) { ?>
					<div class="col-sm-4">
						<div class="best_shoes">
							<p class="best_text"><?php echo $row['name']; ?></p>
							<div class="shoes_icon"><img src="<?php echo $row['image']; ?>" style="height: 12rem;">
								<form action="cart.php" method="POST">
									<input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
									<button type="submit" class="add_to_cart">Add to Cart</button>
								</form>
							</div>
							<div class="star_text">
								<div class="left_part">
									<ul>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
									</ul>
								</div>
								<div class="right_part">
									<div class="shoes_price">$ <span style="color: #ff4e5b;"><?php echo $row['price']; ?></span></div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="col-sm-4">
						<div class="best_shoes">
							<p class="best_text">Best Shoes </p>
							<div class="shoes_icon"><img src="images/shoes-img5.png"></div>
							<div class="star_text">
								<div class="left_part">
									<ul>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
									</ul>
								</div>
								<div class="right_part">
									<div class="shoes_price">$ <span style="color: #ff4e5b;">400</span></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="best_shoes">
							<p class="best_text">Best Shoes </p>
							<div class="shoes_icon"><img src="images/shoes-img6.png"></div>
							<div class="star_text">
								<div class="left_part">
									<ul>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
										<li><a href="#"><img src="images/star-icon.png"></a></li>
									</ul>
								</div>
								<div class="right_part">
									<div class="shoes_price">$ <span style="color: #ff4e5b;">50</span></div>
								</div>
							</div>
						</div>
					</div>-->
					<?php } ?>
				</div> 
    		<!-- <div class="row">
    			<div class="col-sm-4">
    				<div class="best_shoes">
    					<p class="best_text">Sports Shoes</p>
    					<div class="shoes_icon"><img src="images/shoes-img7.png"></div>
    					<div class="star_text">
    						<div class="left_part">
    							<ul>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    					</ul>
    						</div>
    						<div class="right_part">
    							<div class="shoes_price">$ <span style="color: #ff4e5b;">70</span></div>
    						</div>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm-4">
    				<div class="best_shoes">
    					<p class="best_text">Sports Shoes</p>
    					<div class="shoes_icon"><img src="images/shoes-img8.png"></div>
    					<div class="star_text">
    						<div class="left_part">
    							<ul>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    					</ul>
    						</div>
    						<div class="right_part">
    							<div class="shoes_price">$ <span style="color: #ff4e5b;">100</span></div>
    						</div>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm-4">
    				<div class="best_shoes">
    					<p class="best_text">Sports Shoes</p>
    					<div class="shoes_icon"><img src="images/shoes-img9.png"></div>
    					<div class="star_text">
    						<div class="left_part">
    							<ul>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    						<li><a href="#"><img src="images/star-icon.png"></a></li>
    	    					</ul>
    						</div>
    						<div class="right_part">
    							<div class="shoes_price">$ <span style="color: #ff4e5b;">90</span></div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="buy_now_bt">
    			<button class="buy_text">Buy Now</button>
    		</div> -->
    	</div>
    </div>
   	<!-- New Arrivals section end -->
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
      <script>
         $(document).ready(function(){
         $(".fancybox").fancybox({
         openEffect: "none",
         closeEffect: "none"
         });
         
         
$('#myCarousel').carousel({
            interval: false
        });

        //scroll slides on swipe for touch enabled devices

        $("#myCarousel").on("touchstart", function(event){

            var yClick = event.originalEvent.touches[0].pageY;
            $(this).one("touchmove", function(event){

                var yMove = event.originalEvent.touches[0].pageY;
                if( Math.floor(yClick - yMove) > 1 ){
                    $(".carousel").carousel('next');
                }
                else if( Math.floor(yClick - yMove) < -1 ){
                    $(".carousel").carousel('prev');
                }
            });
            $(".carousel").on("touchend", function(){
                $(this).off("touchmove");
            });
        });
	});
      </script> 
   </body>
</html>
