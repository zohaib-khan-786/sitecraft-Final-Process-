<?php
session_start();
include "./Connection/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | SiteCraft</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

     <link rel="stylesheet" href="Styles/styles.css">

     <link rel="stylesheet" href="Styles/website_buildup.css">

     <link rel="stylesheet" href="./Styles/style.css">
</head>
<style>
    .contact-section {
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
    .contact-section .CH {
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
    .contact-section .para{
        font-size: 1rem;
        line-height: 1.8rem;
        text-align: justify;
        color: #29221f;
    }
    .contact-section .row img {
        max-width: 100%;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    .form-container {
        margin-left: 4rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border: none;
        border-radius: 5px;
        background-color: #cacdd0;
        padding: 13px;
        margin-top: 3rem;
        height: 25rem;
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
    .form-container h3{
        text-align: left;
        color: #29221f;
        font-weight: bold;
        margin-bottom: 2rem;
        margin-top: 3rem;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
    }
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .btn2 {
        padding: 10px;
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        background-color: #000;
        text-decoration: none;
        margin-top: 1rem;
        border-radius: 5px;
        transition: background 0.3s ease;
        border: none;
    }
    button:hover {
        background: orange;
    }
    .office{
        margin-left: 5rem;
    }
    .office h3{
        text-align: left;
        color: #29221f;
        font-weight: bold;
        margin-bottom: 2rem;
    }
    .office p{
        margin-top: 2rem;
    }
    .container-fluid {
        padding: 0 15px;
    }
    .full-width-img {
        width: 100%;
        height: auto;
    }
</style>
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
    <!-- Contact Us Content -->
    <section class="contact-section" style="margin-top: 10vh;">
        <div class="container-fluid">
            <div class="content row align-items-center">
                <div class="col-md-6 mb-4">
                    <img src="Uploads/contact.png" alt="Contact Us" class="img-fluid">
                </div>
                <div class="col-md-6 mb-4">
                    <h3 class="CH">Get in Touch with Us!</h3>
                    <p class="para">
                        We would love to hear from you! Whether you have a question about features, pricing, need a demo, or anything else, our team is ready to answer all your questions.
                    </p>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-md-6 mb-4">
                    <form action="contact-form-handler.php" method="POST" class="contact-form">
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control border-0 border-bottom no-outline" id="name" name="name" placeholder="Your Name" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="email" class="form-control border-0 border-bottom no-outline" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control border-0 border-bottom no-outline" id="subject" name="subject" placeholder="Subject" required>
                            <label for="subject">Subject</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <textarea class="form-control border-0 border-bottom no-outline" id="message" name="message" placeholder="Your Message" rows="4" required></textarea>
                            <label for="message">Message</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Send Message</button>
                    </form>
                </div>
                <div class="col-md-4 mb-4">
                    <h3>Our Office</h3>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345098974!2d144.95592321550417!3d-37.8172099797517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf5778b1b01a5d6a8!2s1234%20Main%20St%2C%20Anytown%20VIC%203000%2C%20Australia!5e0!3m2!1sen!2sus!4v1615406936812!5m2!1sen!2sus" width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    <p>1234 Main Street, Anytown, Karachi</p>
                    <p><b>Email:</b> contact@sitecraft.com</p>
                    <p><b>Phone:</b> (92) 456-7890</p>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer Start -->
<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>About SiteCraft</h5>
                <p>SiteCraft is a leading website builder that empowers you to create stunning websites with ease. From customizable templates to advanced e-commerce integration, we have all you need to succeed online.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="./index.php" class="text-white">Home</a></li>
                    <li><a href="./aboutus.php" class="text-white">About</a></li>
                    <li><a href="#" class="text-white">Services</a></li>
                    <li><a href="./contact.php" class="text-white">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Support</h5>
                <ul class="list-unstyled">
                    <li><a href="./FAQs.php" class="text-white">FAQs</a></li>
                    <li><a href="./help.php" class="text-white">Help</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</body>
</html>