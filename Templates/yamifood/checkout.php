<!DOCTYPE html>
<html lang="en"><!-- Basic -->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <!-- Site Metas -->
    <title>Yamifood Restaurant - Responsive HTML5 Template</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">    
	<!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">    
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<style>
    .nav-item .dropdown-item.active{
        background: #d0a772;
	color: #ffffff;
	border-radius: 4px;
    }
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
    .order {
      margin-top: 2rem;
      margin-bottom: 5rem;
        background-color: #d0a772;
        color: #ffffff;
        border: 1px solid #d0a772;
        border-radius: 5px;
        -webkit-transition: all .3s;
        transition: all .3s;
        cursor: pointer;
    }
    .order:hover{
      border: 1px solid #d0a772;
        background-color: transparent;
        color: #d0a772;
    }
  </style>
  <body>
    <!-- Start header -->
	<header class="top-navbar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="index.html">
					<img src="images/logo.png" alt="" />
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbars-rs-food">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active"><a class="nav-link" href="index.html">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="menu.html">Menu</a></li>
						<li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Pages</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="reservation.html">Order Now</a>
								<a class="dropdown-item" href="stuff.html">Stuff</a>
								<a class="dropdown-item" href="gallery.html">Gallery</a>
								<a class="dropdown-item" href="./cart.html">Cart</a>
								<a class="dropdown-item active" href="./checkout.html">Checkout</a>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Blog</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="blog.html">blog</a>
								<a class="dropdown-item" href="blog-details.html">blog Single</a>
							</div>
						</li>
						<li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- End header -->

    <div class="container mt-5">
        <h1>Checkout</h1>
        <div class="row">
            <div class="col-50">
                <h3>Billing Address</h3>
                <form id="checkout-form">
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
                </div>
                <h3>Payment</h3>
                <label for="fname">Accepted Cards</label>
                <div>
                    <img src="images/payment-icon/5.png" alt="Accepted Cards">
                </div>
                <form id="payment-form">
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
                    <button type="button" class="btn order" onclick="placeOrder(event)">Place Order</button>
                </form>
            </div>
        </div>
    </div>

     <!-- Start Footer -->
	<footer class="footer-area bg-f">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3>About Us</h3>
					<p>Integer cursus scelerisque ipsum id efficitur. Donec a dui fringilla, gravida lorem ac, semper magna. Aenean rhoncus ac lectus a interdum. Vivamus semper posuere dui, at ornare turpis ultrices sit amet. Nulla cursus lorem ut nisi porta, ac eleifend arcu ultrices.</p>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3>Opening hours</h3>
					<p><span class="text-color">Monday: </span>Closed</p>
					<p><span class="text-color">Tue-Wed :</span> 9:Am - 10PM</p>
					<p><span class="text-color">Thu-Fri :</span> 9:Am - 10PM</p>
					<p><span class="text-color">Sat-Sun :</span> 5:PM - 10PM</p>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3>Contact information</h3>
					<p class="lead">Ipsum Street, Lorem Tower, MO, Columbia, 508000</p>
					<p class="lead"><a href="#">+01 2000 800 9999</a></p>
					<p><a href="#"> info@admin.com</a></p>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3>Subscribe</h3>
					<div class="subscribe_form">
						<form class="subscribe_form">
							<input name="EMAIL" id="subs-email" class="form_input" placeholder="Email Address..." type="email">
							<button type="submit" class="submit">SUBSCRIBE</button>
							<div class="clearfix"></div>
						</form>
					</div>
					<ul class="list-inline f-social">
						<li class="list-inline-item"><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<p class="company-name">All Rights Reserved. &copy; 2018 <a href="#">Yamifood Restaurant</a> Design By : 
					<a href="https://html.design/">html design</a></p>
					</div>
				</div>
			</div>
		</div>
		
	</footer>
	<!-- End Footer -->
	
	<a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

      <script>
          document.addEventListener('DOMContentLoaded', function () {
              const orderSummary = document.getElementById('order-summary');
              const cart = JSON.parse(localStorage.getItem('checkoutYamifoodCart')) || [];
  
              function renderOrderSummary() {
                  orderSummary.innerHTML = '';
                  let subtotal = 0;
  
                  cart.forEach(product => {
                      const price = parseFloat(product.price);
                      const total = price * product.quantity;
                      subtotal += total;
  
                      const item = `
                          <p>${product.name} - $${price.toFixed(2)} x ${product.quantity} = $${total.toFixed(2)}</p>
                      `;
                      orderSummary.insertAdjacentHTML('beforeend', item);
                  });
  
                  const summary = `
                      <p>Subtotal: $${subtotal.toFixed(2)}</p>
                      <p>Shipping: Free</p>
                      <p>Total: $${subtotal.toFixed(2)}</p>
                  `;
                  orderSummary.insertAdjacentHTML('beforeend', summary);
              }
  
              renderOrderSummary();
          });
  
          function placeOrder(event) {
              // Prevent default form submission behavior
              event.preventDefault();
  
              // Add logic to handle placing the order
              alert('Order placed successfully!');
  
              // Optionally clear cart data from localStorage after order is placed
              localStorage.removeItem('checkoutYamifoodCart');
  
              // Optionally redirect to a confirmation page
              window.location.href = 'index.html';
          }
      </script>

 <!-- Include jQuery and Bootstrap JS -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
      <!-- ALL JS FILES -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
	<script src="js/jquery.superslides.min.js"></script>
	<script src="js/images-loded.min.js"></script>
	<script src="js/isotope.min.js"></script>
	<script src="js/baguetteBox.min.js"></script>
	<script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>