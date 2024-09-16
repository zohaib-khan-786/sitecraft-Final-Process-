<?php
session_start();
require_once '../Connection/connection.php'; // Ensure this file contains the correct connection parameters

// Initialize variables for feedback messages
$success = '';
$error = '';
$admin = null;

// Fetch admin's profile picture, email, and password using mysqli
if ($conn) {
    $stmt = $conn->prepare('select profile_picture, email, password from admin where id = ?');
    $stmt->bind_param('i', $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
}

// Handling the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = trim($_POST['current_password']);
    $new_password     = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate new password length and complexity
    if (strlen($new_password) < 8) {
        $error = 'New password must be at least 8 characters long.';
    } elseif (!preg_match('/[A-Z]/', $new_password)) {
        $error = 'New password must contain at least one uppercase letter.';
    } elseif (!preg_match('/[a-z]/', $new_password)) {
        $error = 'New password must contain at least one lowercase letter.';
    } elseif (!preg_match('/[0-9]/', $new_password)) {
        $error = 'New password must contain at least one number.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New password and confirm password do not match.';
    } else {
        // Verify the current password and update the new password
        if ($admin && password_verify($current_password, $admin['password'])) {
            // Hash the new password
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $stmt = $conn->prepare('UPDATE admin SET password = ? WHERE id = ?');
            $stmt->bind_param('si', $new_password_hash, $_SESSION['admin_id']);
            if ($stmt->execute()) {
                $success = 'Password has been changed successfully.';
            } else {
                $error = 'An error occurred while updating the password. Please try again later.';
            }
            $stmt->close();
        } else {
            $error = 'Current password is incorrect.';
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="./vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./vendors/css/vendor.bundle.addons.css">
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
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
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
            <!-- partial -->

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
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php"><i class="fa fa-home menu-icon"></i>
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
                                <!-- <li class="nav-item"><a class="nav-link" href="./users/active-inactive.php">Inactive Users</a></li> -->
                                <li class="nav-item"><a class="nav-link" href="./pages/users/total_users.php">Total User</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#store-management" aria-expanded="false" aria-controls="store-management"><i class="fa-solid fa-store menu-icon"></i>
                            <span class="menu-title">Store Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="store-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="./pages/stores/allStores.php">All Stores</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="./pending-published.php">Pending and <br>Published Stores</a></li> -->
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#website-builder-management" aria-expanded="false" aria-controls="website-builder-management"><i class="fa-solid fa-globe menu-icon"></i>
                            <span class="menu-title"> Website Builder <br> Management</span>
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
                        <a class="nav-link" data-toggle="collapse" href="#Analytics-management" aria-expanded="false" aria-controls="Analytics-management"><i class="fa-solid fa-chart-line menu-icon"></i>
                            <span class="menu-title">Reports & Analytics</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="Analytics-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="/admin/reports/sales">Sales Reports</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/reports/user-activity">User Activity</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/reports/website-performance">Website Performance</a></li>
                            </ul>
                        </div>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#Settings-management" aria-expanded="false" aria-controls="Settings-management"><i class="fa-solid fa-gear menu-icon"></i>
                            <span class="menu-title">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="Settings-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="/admin/settings/general">General Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/settings/email">Email Settings</a></li>
                            </ul>
                        </div>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#Profile-management" aria-expanded="false" aria-controls="Profile-management"><i class="fa fa-user menu-icon"></i>
                            <span class="menu-title"> Profile</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="Settings-management">
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
                    <!-- <div class="page-header">
                        <h3 class="page-title">Change Password</h3>
                    </div> -->
                    <div class="row w-100">
                        <div class="col-md-6 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                <div class="profile-image text-center">
                                    <img src="./images/faces/<?php echo htmlspecialchars($admin['profile_picture']); ?>" alt="profile" class="rounded-circle img-fluid" style="width: 50px; height: 50px;" />
                                </div>
                                <h4 class="text-center mt-3 mb-5" style="font-size:1rem;"><?php echo htmlspecialchars($admin['email']); ?></h4>
                                <!-- <div class="container mt-5"> -->
                                <h2 style="font-size: 1.5rem; text-align:center;">Change Password</h2>
                                <hr
                                <?php if ($success): ?>
                                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                                <?php endif; ?>

                                <?php if ($error): ?>
                                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                                <?php endif; ?>

                                <form action="" method="POST" class="mt-4 col-md-6">
                                    <div class="form-group">
                                        <label for="current_password">Current Password:</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password">New Password:</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        <small class="form-text text-muted">Must be at least 8 characters long and include uppercase, lowercase, and numbers.</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password">Confirm New Password:</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->

                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024. All rights reserved.</span>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>