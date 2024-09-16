<?php

include("../Connection/connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
// To get all the stores of the user and  display them in the table

$sql = "SELECT store.*, users.Status_Update AS status 
        FROM store 
        JOIN users ON store.created_by = users.id 
        WHERE store.created_by = ?";
$stmt = $conn->prepare($sql);

// Bind the user ID parameter
$stmt->bind_param("i", $user_id);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($item = $result->fetch_assoc()){
        $rows[] = $item;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['can_access_create_page'] = true;
    header('Location: website_intro.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Gallary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../Styles/styles.css">
</head>
<body>
    <?php include('../Components/navbar.php');?>
    <div class="container">
        <div class="row my-3">
            <div class="col-12 col-lg-6 ">
                <h3>Sites</h3>
                <p>View and manage all your websites in one place.</p>
            </div>
            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-end">
                <form method="POST" class="d-flex align-items-center justify-content-end">
                    <!-- To Check if the user doesnot verify his or her account, to redirect to  the verification page -->

                    <?php if(isset($rows[0]['status']) && $rows[0]['status'] == 'inactive'){$_SESSION['validate'] = true; echo '<a class="me-3 bg-warning px-5 py-2 rounded-pill" href="../Auth/validate-code.php">Verify</a>';}?>
                    <button type="submit" class="btn btn-primary d-block d-lg-none rounded-pill px-3 w-100"><i class="bi bi-plus-lg me-2"></i>Create New Site</button>    
                    <button type="submit" class="btn btn-primary rounded-pill px-3 d-none d-lg-block"><i class="bi bi-plus-lg me-2"></i>Create New Site</button>   
                </form>
            </div>
        </div>

        <div class="row sites-container rounded bg-light pb-3">
            <div class="col-12 d-flex align-items-center justify-content-end p-3">
                <div class="filter-cont form-control rounded-pill">
                    <i class="bi bi-search me-3"></i>
                    <input type="text" class="border border-0" placeholder="Search">
                </div>
            </div>
            <div class="dropdown-divider divider mb-3"></div>
            <div class="row items">
            <?php
if ($result->num_rows > 0) {
    foreach ($rows as $row) {
        echo '
        <div class="col-12 col-md-4 col-lg-3 mb-3 item">
            <div class="card">
                <img src="' . $row['preview_image'] . '" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <h5 class="card-title">' . $row['name'] . '</h5>
                            <span>';
                            if ($row['published'] == 0) {
                                echo 'Not Published';
                            } else {
                                echo 'Published';
                            }
                            echo '</span>
                        </div>
                        <div class="col-3 d-flex align-items-center justify-content-center">
                            <div class="options border border-primary rounded-circle" id="site-options" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </div>
                            <div class="dropdown-menu dropdown-options" aria-labelledby="site-options-' . $row['id'] . '">
                                <a href="../Store_Owner_Dashboard/index.php?store_id=' . $row['id'] . '" class="dropdown-item"><i class="bi bi-gear-wide-connected me-3"></i>Edit</a>
                                <a href="#" class="dropdown-item rename-store" data-bs-toggle="modal" data-bs-target="#renameStoreModal" data-store-id="' . $row['id'] . '"><i class="bi bi-fonts me-3"></i>Rename</a>
                                <a href="' . $row['path'] . '" target="_blank" class="dropdown-item"><i class="bi bi-eye-fill me-3"></i>Preview</a>
                                <a href="delete_store.php?id=' . $row['id'] . '" class="dropdown-item text-danger"><i class="bi bi-trash me-3"></i>Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    echo "
    <div class='create-site-section col-12 col-md-4 col-lg-3 mb-3 item'>
        <div class='icon'>
            <img src='../Uploads/Dribble.png' alt='Icon'>
        </div>
        <h2>Create your first site</h2>
        <p>Design and build high-quality sites for your clients, and manage them all in a centralized workspace.</p>
        <form method='POST' class='d-flex align-items-center justify-content-end'>
            <button class='btn btn-primary d-block d-lg-none rounded-pill px-3 w-100'><i class='bi bi-plus-lg me-2'></i>Create New Site</button>
            <button class='btn btn-primary rounded-pill px-3 d-none d-lg-block'><i class='bi bi-plus-lg me-2'></i>Create New Site</button>
        </form>
    </div>";
}
?>         
                </div>
            </div>
        </div>

        <!-- Rename Store Modal -->
        <div class="modal fade" id="renameStoreModal" tabindex="-1" aria-labelledby="renameStoreModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="renameStoreModalLabel">Rename Store</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="renameStoreForm" method="POST" action="store_name_update.php">
                            <div class="mb-3">
                                <label for="newStoreName" class="form-label">New Store Name</label>
                                <input type="text" class="form-control" id="newStoreName" name="newStoreName" required>
                            </div>
                            <input type="hidden" id="storeId" name="storeId">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
        <script>
            
            document.querySelectorAll('.rename-store').forEach(button => {
                button.addEventListener('click', function () {
                    const storeId = this.getAttribute('data-store-id');
                    document.getElementById('renameStoreForm').action = 'store_name_update.php?id=' + storeId;
                    document.getElementById('storeId').value = storeId;
                });
            });

        </script>
</body>
</html>
