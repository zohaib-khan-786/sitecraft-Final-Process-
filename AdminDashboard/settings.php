<?php
session_start();
include "../Connection/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_SESSION['admin_id']; // Ensure session variable name matches
    $name = $_POST['username'];

    // Handle profile picture upload
    if ($_FILES['profile_picture']['name']) {
        $folder = "images/faces/";
        $image = basename($_FILES["profile_picture"]["name"]);
        $final = $folder . $image;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $final)) {
            // Update the profile picture and name in the database
            $query = "update admin set username = ?, profile_picture = ? where id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $name, $image, $admin_id);
        } else {
            // Handle file upload error
            echo "Failed to upload the profile picture.";
            exit();
        }
    } else {
        // Only update name if no new profile picture is uploaded
        $query = "update admin set username = ? where id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $name, $admin_id);
    }

    // Execute the update statement
    if ($stmt->execute()) {
        // Update session variables
        $_SESSION['admin_name'] = $name;
        if (isset($image)) {
            $_SESSION['admin_profile_picture'] = $image;
        }

        // Redirect to dashboard with a success message
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to update the profile.";
    }

    $stmt->close();
    $conn->close();
}

// Fetch current admin details for the form
$admin_id = $_SESSION['admin_id'];
$query = "select username, profile_picture from admin where id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="http://www.urbanui.com/"/>
</head>
<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="./index.php"><h3 style="color: #ff8260;">DASHBOARD</h3></a>
                <a class="navbar-brand brand-logo-mini" href="./index.php"><h3 style="color: #ff8260;">DB</h3></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="fas fa-bars"></span>
                </button>
            </div>
        </nav>
        <!-- theme-setting -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="fas fa-fill-drip"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close fa fa-times"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles primary"></div>
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>

            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <div class="nav-link">
                            <div class="profile-image">
                                <img src="./images/faces/<?php echo $_SESSION['admin_profile_picture']; ?>" alt="profile" />
                            </div>
                            <div class="profile-name">
                                <p class="name">
                                <?php echo $_SESSION['admin_name']; ?>
                                </p>
                                <p class="designation">
                                Super Admin
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="./index.php"><i class="fa fa-home menu-icon"></i>
                        <span class="menu-title">Dashboard Overview</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#user-management" aria-expanded="false" aria-controls="user-management">
                        <i class="icon-sm fa fa-user menu-icon"></i>
                        <span class="menu-title"> User Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="user-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="./pages/users/active-inactive.php">Active Users and <br> Inactive Users</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="/admin/users/inactive">Inactive Users</a></li> -->
                                <li class="nav-item"><a class="nav-link" href="./pages/users/total_users.php">User Roles</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#store-management" aria-expanded="false" aria-controls="store-management"><i class="fa-solid fa-store menu-icon"></i><span class="menu-title">Store Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="store-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="./pages/stores/allStores.php">All Stores</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="./pages/stores/pending-published.php">Pending and <br>Published Stores</a></li> -->
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#website-builder-management" aria-expanded="false" aria-controls="website-builder-management"><i class="fa-solid fa-globe menu-icon"></i><span class="menu-title"> Website Builder <br> Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="website-builder-management">
                            <ul class="nav flex-column sub-menu">
                                <!-- <li class="nav-item"><a class="nav-link" href="/admin/websites/all">All Websites</a></li> -->
                                <li class="nav-item"><a class="nav-link" href="./pages/Website/templates.php">Templates</a></li>
                                <li class="nav-item"><a class="nav-link" href="./pages/Website/customization.php">Customization Options</a></li>
                            </ul>
                        </div>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#Analytics-management" aria-expanded="false" aria-controls="Analytics-management"><i class="fa-solid fa-chart-line menu-icon"></i><span class="menu-title">Reports & Analytics</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="Analytics-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="/admin/reports/sales">Sales Reports</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/reports/user-activity">User Activity</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/reports/website-performance">Website Performance</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#Settings-management" aria-expanded="false" aria-controls="Settings-management"><i class="fa-solid fa-gear menu-icon"></i><span class="menu-title">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="Settings-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="/admin/settings/general">General Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/settings/payment">Payment Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/settings/email">Email Settings</a></li>
                            </ul>
                        </div>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#Profile-management" aria-expanded="false" aria-controls="Profile-management"><i class="fa fa-user menu-icon"></i><span class="menu-title"> Profile</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="Profile-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="./settings.php">Edit Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="./change_password.php">Change Password</a></li>
                                <li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Settings</h3>
                    </div>
                    <div class="row w-100">
                        <div class="col-md-6 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                <div class="brand-logo text-center">
                                    <img src="images/faces/<?php echo $admin['profile_picture']; ?>" alt="profile" class="rounded-circle img-fluid" style="width: 150px; height: 150px;" />
                                </div>
                                <h4 class="text-center mt-3"><?php echo $admin['username']; ?></h4>
                                <form class="pt-4" action="settings.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control form-control-lg" name="username" value="<?php echo $admin['username']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="profile_picture">Profile Picture:</label>
                                        <input type="file" class="form-control form-control-lg" name="profile_picture" accept="image/*">
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->

                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="far fa-heart text-danger"></i></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/misc.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="./js/dashboard.js"></script>
<!-- End custom js for this page-->
</body>
</html>