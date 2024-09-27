<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

     <link rel="stylesheet" href="../Styles/styles.css">
     <link rel="stylesheet" href="../Styles/website_buildup.css">
     <link rel="stylesheet" href="../style.css">
     <link rel="stylesheet" href="../Styles/auth.css">
</head>
<body>

    <!-- Header -->
    <header class=" py-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="../index.php"><img src="../Uploads/SiteCraft_Logo.png" alt="SiteCraft"></a>
        </div>
    </header>

    <div class="container-fluid d-flex flex-column mt-5">
        <div class="w-100 p-lg-5  container mx-auto my-auto">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 offset-md-4 form">
                        <form action="reset-code.php" method="POST" autocomplete="off">
                            <h2 class="text-center" style="font-weight: bold;  margin-bottom:1rem;">Code Verification</h2>
                            <?php 
                            if(isset($_SESSION['info'])){
                                ?>
                                <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                                    <?php echo $_SESSION['info']; ?>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if(count($errors) > 0){
                                ?>
                                <div class="alert alert-danger text-center">
                                    <?php
                                    foreach($errors as $showerror){
                                        echo $showerror;
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group mt-4">
                                <input class="form-control" type="number" name="otp" placeholder="Enter code" required>
                            </div>
                            <div class="form-group">
                            <input class="form-control button btn-primary mt-5" type="submit" name="check-reset-otp" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>