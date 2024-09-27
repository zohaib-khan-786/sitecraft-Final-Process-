<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Preview</title>
    <link rel="stylesheet" href="../Styles/website_buildup.css">
    <style>
        body {
            margin: 0;
            background-color: #ececec;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }
        li , a, p{
            font-size: 10px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: #e6e6e6;
        }

        .navbar-brand img {
            max-width: 50px;
            -webkit-filter: drop-shadow(2px 2px 2px #222);
            filter: drop-shadow(2px 2px 2px #222);
        }

        .navbar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1rem;
        }

        .navbar-nav li {
            display: inline;
        }

        .navbar-nav a {
            text-decoration: none;
            color: #333;
        }

        .banner {
            background-color: #007bff;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .banner input {
            margin-top: 1rem;
            padding: 0.5rem;
            border: none;
            border-radius: 0.25rem;
            width: 100%;
            max-width: 400px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .row {
            display: flex;
            gap: 1rem;
        }

        .col-md-3 {
            flex: 1;
            max-width: 25%;
        }

        .col-md-9 {
            flex: 3;
        }

        .list-group {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list-group-item {
            padding: 0.5rem;
            background-color: #f4f4f4;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: #333;
            display: block;
            border-radius: 0.25rem;
            
        }

        .list-group-item:hover {
            background-color: #e9ecef;
        }

        .carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }

        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-item {
            min-width: 100%;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
        }

        .carousel-control-prev, .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }

        .carousel-control-prev {
            left: 0;
        }

        .carousel-control-next {
            right: 0;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            overflow: hidden;
            text-align: center;
            padding: 1rem;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img id="previewLogo" src="../Uploads/1713115047486gt47pm58-removebg-preview (1).png" alt="Store Logo">
        </a>
        <ul class="navbar-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Best Deals</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <div class="banner">
        <h2>Welcome to <span id="storeNameBanner">SiteCraft...</span></h2>
        <input type="text" placeholder="Search products...">
    </div>

    <div class="container">
        <div class="row">
            <aside class="col-md-3">
                <h3>Filter Products</h3>
                <ul class="list-group">
                    <li><a href="#" class="list-group-item">Branded Foods</a></li>
                    <li><a href="#" class="list-group-item">Households</a></li>
                    <li><a href="#" class="list-group-item">Veggies & Fruits</a></li>
                    <li><a href="#" class="list-group-item">Kitchen</a></li>
                    <li><a href="#" class="list-group-item">Short Codes</a></li>
                    <li><a href="#" class="list-group-item">Beverages</a></li>
                    <li><a href="#" class="list-group-item">Pet Food</a></li>
                    <li><a href="#" class="list-group-item">Frozen Foods</a></li>
                    <li><a href="#" class="list-group-item">Bread & Bakery</a></li>
                </ul>
            </aside>
            <main class="col-md-9">
                <div class="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/1200x400" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/1200x400" alt="Slide 2">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/1200x400" alt="Slide 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev">&lt;</button>
                    <button class="carousel-control-next">&gt;</button>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="https://via.placeholder.com/150" alt="Product 1">
                            <h5>Product 1</h5>
                            <p>Description of Product 1</p>
                            <a href="#" class="btn">View Details</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="https://via.placeholder.com/150" alt="Product 2">
                            <h5>Product 2</h5>
                            <p>Description of Product 2</p>
                            <a href="#" class="btn">View Details</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="https://via.placeholder.com/150" alt="Product 3">
                            <h5>Product 3</h5>
                            <p>Description of Product 3</p>
                            <a href="#" class="btn">View Details</a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 <span id="previewTitle">Your Store</span>. All Rights Reserved.</p>
    </footer>

    <script>
        let currentIndex = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;

        document.querySelector('.carousel-control-next').addEventListener('click', () => {
            moveToNextSlide();
        });

        document.querySelector('.carousel-control-prev').addEventListener('click', () => {
            moveToPrevSlide();
        });

        function updateCarousel() {
            items.forEach((item, index) => {
                if (index === currentIndex) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function moveToNextSlide() {
            currentIndex = (currentIndex + 1) % totalItems;
            updateCarousel();
        }

        function moveToPrevSlide() {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            updateCarousel();
        }

        updateCarousel();

    </script>
</body>
</html>
