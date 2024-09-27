<?php
 session_start();
 include "./Connection/connection.php"
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | SiteCraft</title>
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
        width: 100%;

        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.about-section{
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
.about-section .AH {
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
.about-section .para{
    font-size: 1rem;
    line-height: 1.8rem;
    text-align: justify;
    color: #29221f;
}
.about-section h3{
    text-align: center;
    color: #29221f;
    font-weight: bold;
    margin-bottom: 2rem;
    margin-top: 3rem;
}
.about-section p{
    text-align: justify;
    line-height: 2rem;
    margin-bottom: 2rem;
    font-size: 1rem;
    color: #29221f;
}
.about-section .row img {
    width: 100%;
    border-radius: 10px;
    transition: transform 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.about-section .values ul, .about-section .offers ul {
    list-style-type: none;
    font-size: 1.1rem;
    padding: 0;
}
.effect{
    margin-left: 3rem;
    margin-right: 3rem;
    margin-top: 5rem;
    margin-bottom: 5rem;
}
.about-section .values{
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    background-color: #e2e4e5;
    color: #29221f;
}
.about-section .offers{
    margin-top: 3rem;
    color: #29221f;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.about-section .values ul li, .about-section .offers ul li {
    padding: 10px 0;
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
.team-section, .testimonials-section {
    padding: 60px 0;
    animation: fadeInUp 1s ease-in-out;
}
.team-section h3, .testimonials-section h3 {
    text-align: center;
    margin-bottom: 40px;
}
/* .team-member {
    text-align: center;
    margin-bottom: 20px;
}
.team-member img {
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin-bottom: 10px;
} */
.testimonials .card {
    margin-bottom: 20px;
}
.testimonials-section .card{
    background-color:#e2e4e5;;
    border: none;
    height: 15rem;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    animation: slideInLeft 5s ease-in-out;
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
.container-fluid {
    padding: 0 15px;
}
.full-width-img {
    width: 100%;
    height: auto;
}
.video-container {
    text-align: center;
    margin-top: 7rem;
}
.video-container video {
    width: 100%;
    height: 30rem;
    max-width: 800px;
    border-radius: 10px;
    background-color: #1f1d1f;
    box-shadow: 0 4px 8px rgba(0,0,0,0.6);
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

    <!-- About Us Content -->
    <main class="main-content">
        <section class="about-section">
            <div class="container-fluid">
                <div class="content row align-items-center">
                    <div class="col-md-6">
                        <img src="./Uploads/About us.png" class="full-width-img" alt="Our Team">
                    </div>
                    <div class="col-md-6">
                        <h3 class="AH">Welcome to SiteCraft</h3>
                        <p class="para">
                            At SiteCraft, we believe that building a website should be easy, accessible, and affordable for everyone. Our platform empowers users to create stunning websites with minimal effort, leveraging a wide range of templates, tools, and features to bring your vision to life.
                        </p>
                        <p class="para">
                            Whether you are a small business owner, a creative professional, or an entrepreneur, SiteCraft provides the perfect solution for all your website needs. Our mission is to provide an intuitive and powerful website builder that caters to the needs of users of all skill levels.
                        </p>
                    </div>
                </div>
                <div class="effect row my-5">
                    <div class="col-md-12" style="border-right: 1px solid #29221f; border-bottom:1px solid #29221f; background-color:#e2e4e5; margin-top:3rem;">
                        <h3>Our Mission</h3>
                        <p>
                            Our mission is to democratize web design by making it accessible to everyone, regardless of technical expertise. We aim to provide the tools and resources necessary to create beautiful, functional Stores that can help individuals and businesses succeed online.
                        </p>
                    </div>
                    <div class=" col-md-6 video-container">
                        <video autoplay loop muted playsinline src="Uploads/about.mp4" class="about-video slide-in-left" style="width:90%;  box-shadow: 0 8px 16px rgba(0,0,0,0.2); margin-bottom:3rem;"></video>
                    </div> 
                    <div class="col-md-6" style="margin-top:10rem;">
                        <h3>Our Vision</h3>
                        <p>
                            We envision a world where anyone can build a Online Store with ease, without the need for expensive developers or complicated software. We strive to be the go-to platform for Online Store Creation, offering unmatched flexibility, customization, and support.
                        </p>
                    </div>
                </div>
                <div class="effect row my-5">
                    <div class="col-md-12 values">
                        <h3 style="text-align: left;">Our Values</h3>
                        <ul>
                            <li><strong>Innovation:</strong> We constantly innovate to bring the best features and tools to our users.</li>
                            <li><strong>User-Centric:</strong> Our platform is designed with the user in mind, ensuring a seamless and intuitive experience.</li>
                            <li><strong>Affordability:</strong> We offer competitive pricing to make web design accessible to everyone.</li>
                            <li><strong>Support:</strong> Our dedicated support team is always here to help you with any questions or issues.</li>
                            <li><strong>Community:</strong> We foster a community of users who can share ideas, tips, and support each other.</li>
                        </ul>
                    </div>
                    <div class="effect col-md-12 offers">
                        <h3>What We Offer</h3>
                        <p>
                            At SiteCraft, we offer a comprehensive suite of tools and features to help you build and manage your Store:
                        </p>
                        <ul>
                            <li><strong>Customizable Templates:</strong> Choose from a variety of professionally designed templates that you can easily customize to fit your brand.</li>
                            <li><strong>Drag-and-Drop Builder:</strong> Our intuitive drag-and-drop builder makes it easy to create and edit your website without any coding skills.</li>
                            <li><strong>E-commerce Integration:</strong> Set up an online store with ease using our powerful e-commerce tools.</li>
                            <li><strong>SEO Tools:</strong> Improve your website's visibility on search engines with our built-in SEO features.</li>
                            <li><strong>Responsive Design:</strong> Ensure your website looks great on all devices with our fully responsive templates.</li>
                            <li><strong>24/7 Support:</strong> Get round-the-clock support from our dedicated team to help you with any issues or questions.</li>
                        </ul>
                    </div>
                </div>

                <!-- <div class="row team-section">
                    <div class="col-12">
                        <h3>Meet Our Team</h3>
                    </div>
                    <div class="col-md-3 team-member">
                        <img src="Uploads/team-member1.jpg" alt="Team Member 1">
                        <h5>John Doe</h5>
                        <p>Founder & CEO</p>
                    </div>
                    <div class="col-md-3 team-member">
                        <img src="Uploads/team-member2.jpg" alt="Team Member 2">
                        <h5>Jane Smith</h5>
                        <p>Chief Technology Officer</p>
                    </div>
                    <div class="col-md-3 team-member">
                        <img src="Uploads/team-member3.jpg" alt="Team Member 3">
                        <h5>Robert Brown</h5>
                        <p>Head of Design</p>
                    </div>
                    <div class="col-md-3 team-member">
                        <img src="Uploads/team-member4.jpg" alt="Team Member 4">
                        <h5>Emily White</h5>
                        <p>Customer Support Lead</p>
                    </div>
                </div> -->

                <div class="effect row testimonials-section">
                    <div class="col-12">
                        <h3>Testimonials</h3>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">"SiteCraft has transformed the way I do business online. The platform is easy to use and the support team is incredibly helpful."</p>
                                <h5 class="card-title">- Sarah Johnson</h5>
                                <p class="card-text"><small>Entrepreneur</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">"I built my website in just a few hours with SiteCraft. The templates are beautiful and the customization options are endless."</p>
                                <h5 class="card-title">- Michael Lee</h5>
                                <p class="card-text"><small>Freelancer</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">"The e-commerce integration made it so easy to set up my online store. I've seen a significant increase in sales since using SiteCraft."</p>
                                <h5 class="card-title">- Anna Williams</h5>
                                <p class="card-text"><small>Small Business Owner</small></p>
                            </div>
                        </div>
                    </div>
                </div>

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
                                <img src="Uploads/promo.PNG" alt="SiteCraft Interface">
                            </div>
                        </div>
                    </div>
                </section>
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

    <script>
        new WOW().nit();
    </script>

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