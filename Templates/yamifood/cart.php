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
    .add-to-cart{
      display: inline-block;
      width: 100%;
      margin-top: 1rem;
      background-color: #d0a772;
      color: #ffffff;
      border: 1px solid #d0a772;
      border-radius: 5px;
      -webkit-transition: all .3s;
      transition: all .3s;
    }
    .add-to-cart:hover{
      border: 1px solid #d0a772;
      background-color: transparent;
      color: #d0a772;
    }
    .container h3{
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 800;
        margin-top: 2rem;
        margin-bottom: 3rem;
    }
    .table{
        margin-top: 5rem;
        width: 100%;
    }
    .table th{
        background-color: #d0a772;
    }
    .heading{
        margin-top: 2rem;
        border-top: 1px solid gray;
    }
    h4{
        margin-top: 2rem;
        font-weight: 800;
    }
    .heading button{
      margin-top: 1rem;
      background-color: #d0a772;
      color: #ffffff;
      border: 1px solid #d0a772;
      border-radius: 5px;
      -webkit-transition: all .3s;
      transition: all .3s;
      margin-bottom: 5rem;
    }
    .heading button:hover{
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
						<li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="menu.html">Menu</a></li>
						<li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Pages</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="reservation.html">Order Now</a>
								<a class="dropdown-item" href="stuff.html">Stuff</a>
								<a class="dropdown-item" href="gallery.html">Gallery</a>
								<a class="dropdown-item active" href="./cart.html">Cart</a>
								<a class="dropdown-item" href="./checkout.html">Checkout</a>
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
        <h2 class="text-center">Shopping Cart</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Cart items will be displayed here -->
            </tbody>
        </table>
        <div class="heading">
            <h4>Order Summary</h4>
            <p>Sub Total: $<span id="subtotal">0.00</span></p>
            <p>Shipping Cost: Free</p>
            <h4>Grand Total: $<span id="grandtotal">0.00</span></h4>
            <button class="btn btn-proceed btn-primary" onclick="proceedToCheckout()">Proceed to Checkout</button>
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
         const cartItemsContainer = document.getElementById('cart-items');
         let cart = JSON.parse(localStorage.getItem('yamifoodCart')) || [];

         function updateCartDisplay() {
             if (cart.length === 0) {
                 cartItemsContainer.innerHTML = '<tr><td colspan="6" class="text-center">Your cart is empty.</td></tr>';
                 document.getElementById('subtotal').textContent = '0.00';
                 document.getElementById('grandtotal').textContent = '0.00';
                 return;
             }

             let cartHtml = '';
             let subtotal = 0;

             cart.forEach((product, index) => {
                 const price = parseFloat(product.price);
                 const total = price * product.quantity;
                 subtotal += total;

                 cartHtml += `
                     <tr>
                         <td><img src="${product.image}" alt="${product.name}" style="width: 50px;"></td>
                         <td>${product.name}</td>
                         <td>$${price.toFixed(2)}</td>
                         <td>
                             <input type="number" value="${product.quantity}" min="1" data-index="${index}" class="quantity-input form-control">
                         </td>
                         <td>$${total.toFixed(2)}</td>
                         <td><button class="btn btn-danger remove-from-cart" data-index="${index}">&times;</button></td>
                     </tr>
                 `;
             });

             cartItemsContainer.innerHTML = cartHtml;
             document.getElementById('subtotal').textContent = subtotal.toFixed(2);
             document.getElementById('grandtotal').textContent = subtotal.toFixed(2);

             // Update quantity
             document.querySelectorAll('.quantity-input').forEach(input => {
                 input.addEventListener('change', function () {
                     const index = this.getAttribute('data-index');
                     const newQuantity = parseInt(this.value);
                     if (newQuantity > 0) {
                         cart[index].quantity = newQuantity;
                         localStorage.setItem('yamifoodCart', JSON.stringify(cart));
                         updateCartDisplay(); // Update the display without reloading the page
                     }
                 });
             });

             // Remove from cart
             document.querySelectorAll('.remove-from-cart').forEach(button => {
                 button.addEventListener('click', function () {
                     const index = this.getAttribute('data-index');
                     cart.splice(index, 1);
                     localStorage.setItem('yamifoodCart', JSON.stringify(cart));
                     updateCartDisplay(); // Update the display without reloading the page
                 });
             });
         }

         updateCartDisplay(); // Initial call to display the cart items
     });

     function proceedToCheckout() {
         // Store cart data in localStorage for checkout
         localStorage.setItem('checkoutYamifoodCart', JSON.stringify(JSON.parse(localStorage.getItem('yamifoodCart')) || []));
         window.location.href = 'checkout.html';
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