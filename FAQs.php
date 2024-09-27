<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs | SiteCraft</title>

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
        /* background-color: #c3ced1;
        height: 33rem; */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .faq-section{
        padding: 60px 0;
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
.faq-section .row img {
    width: 100%;
    border-radius: 10px;
    transition: transform 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.faq-section .FH {
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
.faq-section .para{
    font-size: 1rem;
    line-height: 1.8rem;
    text-align: left;
    color: #29221f;
}
.accordion h3{
        color: #29221f;
        font-weight: bold;
        margin-bottom: 2rem;
        margin-top: 5rem;
    }
.accordion-button {
    background-color: #e9e9e9;
    color: #133559;
    font-weight: bold;
}

.accordion-button:not(.collapsed) {
    background-color: lightgray;
    color: black;
}

.accordion-button:focus {
    box-shadow: none;
}
.accordion-body{
    color: #29221f;
}
.container-fluid {
    padding: 0 15px;
}
.full-width-img {
    width: 100%;
    height: auto;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
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
                        <a class="nav-link" href="index.php">Home</a>
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

        <!-- About Us Content -->
        <main class="main-content">
            <section class="faq-section" style="margin-top: 10vh;">
                <div class="container-fluid">
                    <div class="content row align-items-center">
                        <div class="col-md-6">
                            <img src="./Uploads/FAQS.png" alt="Our Team" class="full-width-img">
                        </div>
                        <div class="col-md-6">
                            <h3 class="FH">Frequently Asked Questions</h3>
                            <p class="para">
                            Find answers to common questions about SiteCraft, our features, and how to use our website builder.
                            </p>
                        </div>
                    </div>

                    <main class="container my-5">
                        <div class="accordion" id="faqAccordion">
                            <!--General Questions-->
                            <h3>General Questions</h3>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        What is SiteCraft?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        SiteCraft is a leading website builder that allows you to create stunning, professional websites with ease. Whether you are a beginner or a professional, our platform offers all the tools and resources you need to build and manage your online presence.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Is SiteCraft suitable for beginners?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, SiteCraft is designed to be user-friendly and intuitive, making it easy for beginners to create and manage their websites without any technical knowledge.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Do I need any technical skills to use SiteCraft?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        No, you do not need any technical skills to use SiteCraft. Our platform is designed to be user-friendly and intuitive, allowing anyone to create a professional-looking website without any coding knowledge.
                                    </div>
                                </div>
                            </div>
                            <!--General Questions end-->
            
                            <!--Pricing and Plans-->
                            <h3 class="mt-5">Pricing and Plans</h3>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                        How much does SiteCraft cost?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        SiteCraft offers a variety of pricing plans to suit different needs and budgets. We have a free plan with basic features and several premium plans with advanced capabilities. You can find detailed information about our pricing on our Pricing page.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                        Can I change my plan later?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, you can upgrade or downgrade your plan at any time to better fit your needs. Changes to your plan will take effect immediately.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                        Is there a free trial available?
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, SiteCraft offers a free trial so you can explore our features and see how they work before committing to a paid plan.
                                    </div>
                                </div>
                            </div>
                            <!--pricing question end-->

                            <!--Features and Functionality-->
                            <h3 class="mt-5">Features and Functionality</h3>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                        What features does SiteCraft offer?
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse show" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        SiteCraft provides a wide range of features, including customizable templates, drag-and-drop editing, e-commerce integration, SEO tools, and much more. Our platform is designed to help you build a professional and effective online presence.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEight">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                                        Can I integrate e-commerce into my SiteCraft website?
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse show" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, SiteCraft offers robust e-commerce integration, allowing you to set up an online store, manage products, process payments, and more. Our e-commerce features are designed to help you run a successful online business.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNine">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                        Can I use my own domain name with SiteCraft?
                                    </button>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse show" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, you can use your own domain name with SiteCraft. If you don't have a domain name, you can also purchase one through our platform.
                                    </div>
                                </div>
                            </div>
                            <!--Features and Functionality end-->

                            <!--Customization-->
                            <h3 class="mt-5">Customization</h3>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTen">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
                                        How can I Customize my Website on SiteCraft?
                                    </button>
                                </h2>
                                <div id="collapseTen" class="accordion-collapse collapse show" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        SiteCraft offers a variety of customization options, including the ability to change colors, fonts, layouts, and more. Our intuitive drag-and-drop editor makes it easy to create a unique and personalized website that reflects your brand.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEleven">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="true" aria-controls="collapseEleven">
                                        Can I Edit the HTML/CSS of my SiteCraft Website?
                                    </button>
                                </h2>
                                <div id="collapseEleven" class="accordion-collapse collapse show" aria-labelledby="headingEleven" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                    Yes, advanced users can access and edit the HTML/CSS of their SiteCraft website for further customization.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwelve">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="true" aria-controls="collapseTwelve">
                                        Does SiteCraft Support Multilingual Websites?
                                    </button>
                                </h2>
                                <div id="collapseTwelve" class="accordion-collapse collapse show" aria-labelledby="headingTwelve" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, SiteCraft supports the creation of multilingual websites, allowing you to reach a wider audience.
                                    </div>
                                </div>
                            </div>
                            <!--Customization end-->

                            <!--Support and Resources-->
                            <h3 class="mt-5">Support and Resources</h3>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThirteen">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirteen" aria-expanded="true" aria-controls="collapseThirteen">
                                        What kind of support does SiteCraft offer?
                                    </button>
                                </h2>
                                <div id="collapseThirteen" class="accordion-collapse collapse show" aria-labelledby="headingThirteen" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        SiteCraft offers comprehensive support through various channels, including email, live chat, and an extensive knowledge base. Our support team is always ready to help you with any questions or issues you may encounter.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFourteen">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourteen" aria-expanded="true" aria-controls="collapseFourteen">
                                        Are there any tutorials or guides available?
                                    </button>
                                </h2>
                                <div id="collapseFourteen" class="accordion-collapse collapse show" aria-labelledby="headingFourteen" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, SiteCraft provides a variety of tutorials, guides, and resources to help you get the most out of our platform. You can access these resources through our knowledge base and blog.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFifteen">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFifteen" aria-expanded="true" aria-controls="collapseFifteen">
                                        How can I contact SiteCraft support?
                                    </button>
                                </h2>
                                <div id="collapseFifteen" class="accordion-collapse collapse show" aria-labelledby="headingFifteen" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        You can contact SiteCraft support via email, live chat, or by submitting a ticket through our support portal.
                                    </div>
                                </div>
                            </div>
                            <!--Support and Resources end-->

           
                        </div>
                    </main>
                </div>
            </section>
        </main>
        <!--faqs end-->

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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

<script>

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