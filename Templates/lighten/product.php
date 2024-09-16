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
.product-box {
   position: relative;
    background-color: #fff;
    padding: 20px;
    border: 1px solid #eee;
    text-align: center;
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    height: 22rem;
}

.product-box i img {
    max-width: 100%;
    height: 12rem;
    border-radius: 5px;
    transition: transform 0.3s ease;
}

.product-box h3 {
    margin-top: 13px;
    font-size: 1.1rem;
    color: #333;
    word-wrap: wordwrap;
}

.product-box span {
    font-size: 1rem;
    color: #d0a772;
    font-weight: bold;
}

.product-box:hover {
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    transform: translateY(-10px);
}

.product-box:hover i img {
    transform: scale(1.1);
}

.add-to-cart-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); 
    opacity: 0;
    transition: opacity 0.3s ease;
}

.add-to-cart-btn button {
    background-color: #ffc221;
    color: black;
    border: none;
    padding: 8px 10px;
    font-size: 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-to-cart-btn button:hover {
    background-color: #000;
    color: #ffc221;
}


.product-box:hover .add-to-cart-btn {
    opacity: 1;
}

.product-box {
    transition: all 0.3s ease-in-out;
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
                              <li class="active"> <a href="product.php">product</a> </li>
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
                        <h2>our products</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!-- our product -->
      <?php
      	include "../../Connection/connection.php";

      	// Fetch products from the database
      	$query = "SELECT * FROM products where id >= 40 and id <=51";
      	$result = $conn->query($query);
      ?>
      <div class="product">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                     <span>We package the products with best services to make you a happy customer.</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="product-bg">
         <div class="product-bg-white">
            <div class="container">
               <div class="row">
                  <?php while ($row = $result->fetch_assoc()) { ?>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="<?php echo $row['image']; ?>"/ style="background-color: white;"></i>
                        <h3><?php echo $row['name']; ?></h3>
                        <span>$<?php echo $row['price']; ?></span>
                        <div class="add-to-cart-btn">
                           <form action="cart.php" method="POST">
                              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                              <button type="submit" class="add_to_cart">Add to Cart</button>
                           </form>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p2.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p3.png"/></i>
                        <h3>Norton Internet Security</h3>
                     <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p4.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p5.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p2.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p6.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p7.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p6.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p1.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p2.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                     <div class="product-box">
                        <i><img src="icon/p4.png"/></i>
                        <h3>Norton Internet Security</h3>
                        <span>$25.00</span>
                     </div>
                  </div> -->
                  <?php } ?>
               </div>
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