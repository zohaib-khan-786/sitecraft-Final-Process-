<?php
 session_start();
include "./Connection/connection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiteCrat-Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

     <link rel="stylesheet" href="Styles/styles.css">
     <link rel="stylesheet" href="Styles/website_buildup.css">
     <link rel="stylesheet" href="./Styles/style.css">
     <style>
        body{
            overflow-x: hidden;
        }
     </style>
</head>
<body>
<div class="main-container">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow position-fixed w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./Uploads/SiteCraft_Logo.png" alt="SiteCraft Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="FAQs.php">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="help.php">Help</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <?php
                        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                            echo '
                            <span class="link-underline"><a href="./Auth/logout.php">Logout</a></span>
                            <button class="btn btn-primary rounded-pill"><a href="./Create_store/website_buildup.php" class="text-light">Create</a></button>';
                        } else {
                            echo '
                            <span class="link-underline"><a href="./Auth/login.php">Login</a></span>
                            <button class="btn btn-primary rounded-pill"><a href="./Auth/register.php" class="text-light">Get Started</a></button>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </nav>
</header>

    <main class="main-content">

    <div class="section col-12">
            <div class="container-fluid d-flex align-items-center flex-column gap-3 text-light">
                <h2 class="leading-text text-center ">Create Your Store With SiteCraft</h2>
                <p class="text-center">Build and scale with confidence. From a powerful website builder to <br> advanced business solutions—we’ve got you covered.</p>
                <div class="group">
                    <button class="btn btn-light mx-auto px-5 py-3 get-started rounded-pill"><a href="./Auth/login.php">Get Started</a></button>
                    <p class="mt-1">Start for free. No credit card required</p>
                </div>
                <img class="mb-5 mt-3 w-50" src="https://static.wixstatic.com/media/0784b1_c0ab312fc95448b6b14aa403fd46fb15~mv2.jpg/v1/fill/w_537,h_337,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/Desktop%20-%20Main%20Image.jpg" alt="store builder">
            </div>
        </div>

        <!--About us -->
        <section id="about" class="text-center py-5 px-5 bg-dark ">
            <div class="about-container">
                
                <div class="row align-items-center  text-light">
                    <div class="col-md-6">
                        <video autoplay loop muted playsinline src="Uploads/about-us.mp4" class="about-video slide-in-left" style="width:90%;  box-shadow: 0 8px 16px rgba(0,0,0,0.2); margin-bottom:3rem;"></video>
                    </div>
                    <div class="col-md-6">
                    <h2 class="slide-in-left fw-bold" style="font-size: 5vw;">About Us</h2>
                        <p class="slide-in-right lh-lg">
                            Welcome to SiteCraft, your ultimate solution for creating stunning websites effortlessly. Our platform empowers you to build professional, creative, and business websites with ease. Whether you're a small business owner, a creative professional, or anyone in between, SiteCraft provides all the tools you need to design and launch your website quickly and efficiently.</p>
                      <button class="btn btn-light text-dark rounded-pill px-5 py-2 fw-bolder mt-5"><span style="font-size: 1.3rem;">Join Us</span></button>
                    </div>
                </div>
                <div class="row mt-5 slide-in-up">
                    <div class="col-md-4 ">
                        <div class="card">
                            <img src="Uploads/easy-to-use.webp" class="card-img-top" alt="Card Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Easy to Use</h5>
                                <p class="card-text">Our intuitive drag-and-drop interface makes it simple for anyone to create a beautiful website without any coding knowledge.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="Uploads/templates.PNG" class="card-img-top" alt="Card Image 2">
                            <div class="card-body">
                                <h5 class="card-title">Customizable Templates</h5>
                                <p class="card-text">Choose from a variety of professionally designed templates and customize them to match your unique style and brand.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="Uploads/seo-tools.png" class="card-img-top" alt="Card Image 3">
                            <div class="card-body">
                                <h5 class="card-title">Powerful Features</h5>
                                <p class="card-text">From e-commerce capabilities to SEO tools, SiteCraft offers all the features you need to create a fully functional and successful website.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--about us end-->

        <!-- Service Start -->
        <section id="services" class="bg-light text-center py-5 slide-right">
            <div class="container">
                <h2>Our Services</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-5 rounded">
                            <h3 class="card-title">Customizable Templates</h3>
                            <p class="card-text">Choose from a wide range of professional templates and customize them to suit your brand and style effortlessly.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-5 rounded">
                            <h3 class="card-title">Drag-and-Drop Builder</h3>
                            <p class="card-text">Easily create and edit your website with our intuitive drag-and-drop builder, no coding skills required.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-5 rounded">
                                <h3 class="card-title">E-Commerce Integration</h3>
                                <p class="card-text">Set up an online store with ease using our comprehensive e-commerce features and tools.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-5 rounded">
                                <h3 class="card-title">SEO Tools</h3>
                                <p class="card-text">Improve your website’s visibility with built-in SEO tools to help you rank higher on search engines.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-5 rounded">
                            <h3 class="card-title">Responsive Design</h3>
                            <p class="card-text">Ensure your website looks great on all devices with our fully responsive design features.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-5 rounded">
                            <h3 class="card-title">24/7 Support</h3>
                            <p class="card-text">Get round-the-clock support from our dedicated team to help you with any issues or questions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       <!-- Service End -->

        <!--all in one start -->
        <section id="all-in-one" class="text-center py-5 slide-left">
            <div class="all-in-one-container">
                <h2>All-In-One Website Builder</h2>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="Uploads/build-websites.PNG" class="card-img-top-d" alt="Card Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Prebuilt Websites</h5>
                                <p class="card-text">
                                Prebuilt websites are designed to save you time. Import with a few clicks & customize it to suit your requirements.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="Uploads/Mobile-friendly.PNG" class="card-img-top-d" alt="Card Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Mobile Friendly</h5>
                                <p class="card-text">
                                SiteCraft is 100% fluid & responsive across all device types, from mobile to desktop.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="Uploads/Online-store-builder.PNG" class="card-img-top-d" alt="Card Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Online Store Builder</h5>
                                <p class="card-text">
                                SiteCraft is allowing you to build successful online stores to sell anything online.</p>
                            </div>
                        </div>
                    </div>
                    <a href=""><button id="learnMoreBtn" class="btn1 btn-primary">Start Building</button></a>
                </div>
            </div>
        </section>
        <!--all in one end-->

        <!-- FAQs Section -->
        <section id="faqs" class="py-5">
            <div class="container">
                <h2>Frequently Asked Questions</h2>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h5 class="mb-0 accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                What is SiteCraft?
                            </button>
                        </h5>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                SiteCraft is a leading website builder that empowers you to create stunning websites with ease. From customizable templates to advanced e-commerce integration, we have all you need to succeed online.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="mb-0 accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                How much does it cost to use SiteCraft?
                            </button>
                        </h5>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                SiteCraft offers various pricing plans to suit different needs and budgets. You can choose from our free plan or upgrade to one of our premium plans for additional features and capabilities.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="mb-0 accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                Do I need any technical skills to use SiteCraft?
                            </button>
                        </h5>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                No, you do not need any technical skills to use SiteCraft. Our platform is designed to be user-friendly and intuitive, allowing anyone to create a professional-looking website without any coding knowledge.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="mb-0 accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                Can I integrate e-commerce features into my SiteCraft website?
                            </button>
                        </h5>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Yes, SiteCraft offers advanced e-commerce integration, allowing you to set up an online store, manage products, process payments, and more. Our platform supports various e-commerce features to help you run a successful online business.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

       <!-- Contact Section Start -->
       <section id="contact" class="text-center py-5">
            <div class="container">
            <h2>Contact Us</h2>
                <form id="contactForm">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </section>
        <!-- Contact Section End -->

             <!--cta start -->
            <section class="promo-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 promo-text">
                            <h2>Ready to Create Your Website?</h2>
                            <p>Get started with SiteCraft today and build your dream website in no time!</p>
                            <a href="<?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ? './Create_store/website_buildup.php' : './Auth/login.php'; ?>"><button id="learnMoreBtn" class="btn btn-primary">Start Building</button></a>
                        </div>
                        <div class="col-md-6 promo-image">
                            <img src="Uploads/promo.PNG" style="width: 100%;" alt="SiteCraft Interface">
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer Start -->
        <footer class="bg-dark text-white">
            <div class="container text-center p-5">
                <div class="row">
                    <div class="col-md-4">
                        <h5>About SiteCraft</h5>
                        <p>SiteCraft is a leading website builder that empowers you to create stunning websites with ease. From customizable templates to advanced e-commerce integration, we have all you need to succeed online.</p>
                    </div>
                    <div class="col-md-4 border-start border-end">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="./index.php" class="text-white">Home</a></li>
                            <li><a href="./aboutus.php" class="text-white">About</a></li>
                            <li><a href="#" class="text-white">Services</a></li>
                            <li><a href="./contact.php" class="text-white">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Support</h5>
                        <ul class="list-unstyled">
                            <li><a href="./FAQs.php" class="text-white">FAQs</a></li>
                            <li><a href="./help.php" class="text-white">Help</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Follow Us</h5>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="text-white"><i class="fab fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="text-white"><i class="fab fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bg-primary text-center">
                <p>&copy; 2024 SiteCraft. All Rights Reserved.</p>
            </div>
        </footer>
        <!-- Footer End -->
</div>

<!-- ===== JS Files ===== -->
<script src="./Js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js" referrerpolicy="no-referrer"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include Bootstrap and jQuery (optional, for dropdown) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

<script>
    var typed = new Typed(".automated-words", {
        strings: ["Creative", "Unique", "Modern"],
        typeSpeed: 100,
        backSpeed: 60,
        loop: true
    });

document.addEventListener('DOMContentLoaded', function () {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('slide-in-left');
      }
    });
  });

  document.querySelectorAll('.slide-in-left').forEach((section) => {
    observer.observe(section);
  });
});

document.addEventListener("DOMContentLoaded", function () {
    const accordionButtons = document.querySelectorAll('.accordion-button');

    accordionButtons.forEach(button => {
        button.addEventListener('click', () => {
            const activeButton = document.querySelector('.accordion-button:not(.collapsed)');
            if (activeButton && activeButton !== button) {
                activeButton.click();
            }
        });
    });
});

</script> 
</body>
</html>