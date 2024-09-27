<?php
 session_start();
 include "./Connection/connection.php"
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help | SiteCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

     <link rel="stylesheet" href="Styles/styles.css">
     <link rel="stylesheet" href="Styles/website_buildup.css">
     <link rel="stylesheet" href="./Styles/style.css">
</head>
    <style>
        .content{
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .help-section {
            /* padding: 60px 0; */
            animation: fadeInUp 1s ease-in-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .help-section .HC {
            text-align: left;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: bold;
            color: #29221f;
            animation: slideInLeft 1s ease-in-out;
        }
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .help-section .para{
            font-size: 1rem;
            line-height: 1.8rem;
            text-align: justify;
            color: #29221f;
        }
        .help-section .row img {
            max-width: 100%;
            border-radius: 10px;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .help-section h3{
            text-align: center;
            color: #29221f;
            font-weight: bold;
            margin-bottom: 2rem;
            margin-top: 3rem;
        }
        .help-section p{
            text-align: justify;
            line-height: 2rem;
            margin-bottom: 2rem;
            font-size: 1rem;
            color: #29221f;
        }
        .faq{
            margin-left: 3rem;
            margin-right: 3rem;
            margin-top: 5rem;
            margin-bottom: 5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-image:linear-gradient(#e2e4e5, #fff);
            animation: fadeInUp 1s ease-in-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .help-section .faq ul {
            text-align: left;
            list-style-type: none;
            margin-left: 3rem;
            font-size: 1.1rem;
            padding: 0;
        }
        .help-section .faq ul li {
            padding: 10px 0;
            line-height: 2rem;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .resources-section, .contact-section {
            padding: 60px 0;
            animation: fadeInUp 1s ease-in-out;
        }
        .resources-section h3, .contact-section h3 {
            text-align: center;
            margin-bottom: 40px;
        }
        .contact-section p{
            text-align: center;
        }
        .resources .card {
            margin-bottom: 20px;
        }
        .resources-section .card{
            background-color:#e2e4e5;;
            border: none;
            height: 12rem;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: slideInLeft 7s ease-in-out;
        }
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .contact-section {
            background-color: #a8f39b;
            color: #000;
            justify-content: center;
            align-items: center;
            padding: 20px;
            padding-bottom: 30px;
            animation: slideInRight 1s ease-in-out;
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .contact-section h3 {
            margin-bottom: 20px;
        }
        .contact-section a {
            padding: 15px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #000;
            text-decoration: none;
            margin-top: 1rem;
            text-align: center;
            margin-left: 44%;
            margin-bottom: 2rem;
            border-radius: 5px;
            border: none;
            transition: background 0.3s ease;
        }
        .contact-section a:hover {
            background: orange;
        }
        .container-fluid {
            padding: 0 15px;
        }
        .full-width-img {
            width: 100%;
            height: auto;
        }
        .video-container {
            text-align: center;
            margin-top: 5rem;
            margin-bottom: 5rem;
        }
        .video-container video {
            width: 100%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        @keyframes scale-a-lil {
            from {
            scale: .5;
            }
        }

        @media (
            prefers-reduced-motion: no-preference) {
            .effect {
            animation: scale-a-lil linear both;
            animation-timeline: view();
            animation-range: 25vh 75vh;
            }
        }
    </style>
<body>
    <div class="main-container">
        <!-- Header -->
        <header class="bg-dark text-white py-3">
            <div class="container d-flex justify-content-between align-items-center">
                <h1><span>S</span>ite<span>C</span>raft</h1>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a href="./index.php" class="nav-link text-white">Home</a></li>
                        <li class="nav-item"><a href="./aboutus.php" class="nav-link text-white">About</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Services</a></li>
                        <li class="nav-item"><a href="contact.php" class="nav-link text-white">Contact</a></li>
                        <div class="dropdown">
                        <button class="btn dropdown-toggle text-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="margin-left: 2rem;">
                            Account
                        </button>
                        <ul class="dropdown-menu text-white" aria-labelledby="dropdownMenuButton1">
                        <?php
                        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                            echo '
                            <li class="nav-item"><a href="./Auth/logout.php" class="nav-link text-dark">Logout</a></li>
                            <li class="nav-item"><a href="./Create_store/website_buildup.php" class="nav-link text-dark">Dashboard</a></li>';
                        } else {
                            echo '
                            <li class="nav-item"><a href="./Auth/login.php" class="nav-link text-dark">Login</a></li>
                            <li class="nav-item"><a href="./Auth/register.php" class="nav-link text-dark">Register</a></li>';
                        }
                        ?>
                        </ul>
                        </div>
                        <li class="nav-item"><a href="./Create_store/website_buildup.php" class="btn text-dark rounded-lg text-light" style="border:none; background-color:orange; margin-left:2rem;">Create Store</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Help Content -->
        <main class="main-content">
            <section class="help-section">
                <div class="container-fluid">
                    <div class="content row align-items-center">
                        <div class="col-md-6">
                            <img src="Uploads/help.png" alt="Help and Support" class="full-width-img">
                        </div>
                        <div class="col-md-6">
                            <h3 class="HC">Welcome to SiteCraft Help Center</h3>
                            <p class="para">
                                At SiteCraft, we are committed to providing our users with the best support possible. Whether you're just getting started or need advanced help, our comprehensive Help Center has everything you need to succeed.
                            </p>
                            <p class="para">
                                Explore our FAQs, video tutorials, and user guides to find the answers you're looking for. If you need further assistance, our dedicated support team is here to help you 24/7.
                            </p>
                        </div>
                    </div>
                    <div class="row faq">
                        <div class="col-12">
                            <h3>Frequently Asked Questions</h3>
                            <ul>
                                <li><strong>How do I create an account?</strong> <br> To create an account, click on the "Register" button on the top right corner and fill out the registration form.</li>
                                <li><strong>How do I reset my password?</strong> <br> Click on the "Forgot Password" link on the login page and follow the instructions to reset your password.</li>
                                <li><strong>How can I customize my website?</strong> <br> Use our drag-and-drop builder to easily customize your website. You can add images, text, and other elements to make your site unique.</li>
                                <li><strong>How do I set up an online store?</strong> <br> Our e-commerce integration makes it simple to set up an online store. Just add your products, set prices, and start selling!</li>
                                <li><strong>How do I contact support?</strong> <br> You can contact our support team by clicking on the "Contact Us" link and filling out the support form. We are available 24/7 to assist you.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="video-container">
                        <video autoplay loop muted playsinline src="Uploads/about.mp4" class="about-video slide-in-left" style="width:100%;  box-shadow: 0 8px 16px rgba(0,0,0,0.2);"></video>
                    </div>

                    <!-- <div class="row resources-section">
                        <div class="col-12">
                            <h3>Additional Resources</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">User Guides</h5>
                                    <p class="card-text">Detailed guides to help you navigate and make the most out of our platform.</p>
                                    <a href="user-guides.php" class="btn btn-primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Video Tutorials</h5>
                                    <p class="card-text">Watch our video tutorials to get step-by-step instructions on various features.</p>
                                    <a href="video-tutorials.php" class="btn btn-primary">Watch Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Community Forum</h5>
                                    <p class="card-text">Join our community forum to ask questions and share tips with other users.</p>
                                    <a href="community-forum.php" class="btn btn-primary">Join Now</a>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="contact-section">
                        <h3>Need More Help?</h3>
                        <p>If you can't find the answers you're looking for, don't hesitate to reach out to our support team. We're here to help you succeed.</p>
                        <a href="contact.php">Contact Support</a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer Start -->
        <footer class="bg-dark text-white py-4">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-4">
                        <h5>About SiteCraft</h5>
                        <p>SiteCraft is a leading website builder that empowers you to create stunning websites with ease. From customizable templates to advanced e-commerce integration, we have all you need to succeed online.</p>
                    </div>
                    <div class="col-md-4">
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
                <div style="margin-top: 7rem;">
                    <p>&copy; 2024 SiteCraft. All Rights Reserved.</p>
                </div>
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

</body>
</html>