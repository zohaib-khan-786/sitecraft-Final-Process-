<?php

include("../Connection/connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../Styles/styles.css">
    <style>
        .template-image {
            width: 100%;
            height: auto;
        }
    </style>
  </head>
  <body>
    

<?php include('../Components/navbar.php');?>


<div class="container mt-5">
    <h1 class="h3 fw-bold mb-4">Pick the Website Template You Love</h1>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm position-relative" id="template1" onclick="selectTemplate(this)">
                <input type="radio" class="input-radio" name="template_checked" id="radio1">
                <div class="custom-radio"></div>
                <img src="../Uploads/template-1.jpg" class="card-img-top template-image" alt="VegeFoods">
                <div class="card-body">
                    <h5 class="card-title">VegeFoods Landing Page</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm position-relative" id="template2" onclick="selectTemplate(this)">
                <input type="radio" class="input-radio" name="template_checked" id="radio2">
                <div class="custom-radio"></div>
                <img src="https://images-wixmp-a87e9a901094cb6400f2e0ce.wixmp.com/images/site-defualt-icon.png/v1/fit/w_370,h_370/file.jpg" class="card-img-top template-image" alt="Home Goods Store">
                <div class="card-body">
                    <h5 class="card-title">Home Goods Store</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm position-relative" id="template3" onclick="selectTemplate(this)">
                <input type="radio" class="input-radio" name="template_checked" id="radio3">
                <div class="custom-radio"></div>
                <img src="https://images-wixmp-a87e9a901094cb6400f2e0ce.wixmp.com/images/site-defualt-icon.png/v1/fit/w_370,h_370/file.jpg" class="card-img-top template-image" alt="AI Company">
                <div class="card-body">
                    <h5 class="card-title">AI Company</h5>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" class="position-fixed bottom-0 end-0 mb-3 me-3">
        <button type="submit" disabled class="btn btn-primary btn-next d-flex align-items-center justify-content-between px-5 py-2 rounded-pill fw-bold">Next <i class="bi bi-arrow-right ms-2"></i></button>
    </form>
</div>

<script>
    function selectTemplate(cardElement) {
        const radioButton = cardElement.querySelector('input[type="radio"]');

        if (radioButton.checked) {
            radioButton.checked = false;
            document.querySelector('.btn-next').disabled = true;
        } else {
            
            document.querySelectorAll('.card input[type="radio"]').forEach(rb => rb.checked = false);
            
            radioButton.checked = true;
            document.querySelector('.btn-next').disabled = false;
        }
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>