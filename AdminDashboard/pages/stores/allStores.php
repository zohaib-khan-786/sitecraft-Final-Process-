<?php
session_start();
include "../../../Connection/connection.php";

$query_all_stores = "select * from store";
$result_all_stores = $conn->query($query_all_stores);
$all_stores = [];
if ($result_all_stores && $result_all_stores->num_rows > 0) {
    $all_stores = $result_all_stores->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Stores</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="http://www.urbanui.com/"/>
</head>
<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="../../index.php"><h3 style="color: #ff8260;">DASHBOARD</h3></a>
                <a class="navbar-brand brand-logo-mini" href="../../index.php"><h3 style="color: #ff8260;">DB</h3></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="fas fa-bars"></span>
                </button>
                <ul class="navbar-nav">
                    <li class="nav-item nav-search d-none d-md-flex">
                        <div class="nav-link">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                    <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item d-none d-lg-flex">
                        <a class="nav-link" href="../../register.php">
                            <span class="btn btn-primary">+ Create new</span>
                        </a>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="../../images/faces/<?php echo $_SESSION['admin_profile_picture'];?>" alt="profile">
                            <span><?php echo $_SESSION['admin_name'];?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="../../settings.php">
                                <i class="fas fa-cog text-primary"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../../logout.php">
                                <i class="fas fa-power-off text-primary"></i>
                                    Logout
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-settings d-none d-lg-block">
                        <a class="nav-link" href="#">
                            <i class="fas fa-ellipsis-h"></i>
                        </a>
                    </li>
                </ul>
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

            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close fa fa-times"></i>
                <ul class="nav nav-tabs" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li> -->
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task-todo">Add</button>
                                </div>
                            </form>
                        </div>
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
                                <img src="../../images/faces/<?php echo $_SESSION['admin_profile_picture']; ?>" alt="profile" />
                            </div>
                            <div class="profile-name">
                                <p class="name">
                                    <?php echo $_SESSION['admin_name']; ?>
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php"><i class="fa fa-home menu-icon"></i>
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
                                <li class="nav-item"><a class="nav-link" href="../users/active-inactive.php">Active Users and <br> Inactive Users</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="./users/active-inactive.php">Inactive Users</a></li> -->
                                <li class="nav-item"><a class="nav-link" href="../users/total_users.php">Total User</a></li>
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
                                <li class="nav-item"><a class="nav-link" href="./allStores.php">All Stores</a></li>
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
                                <li class="nav-item"><a class="nav-link" href="../Website/templates.php">Templates</a></li>
                                <li class="nav-item"><a class="nav-link" href="../Website/customization.php">Customization Options</a></li>
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
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#Settings-management" aria-expanded="false" aria-controls="Settings-management"><i class="fa-solid fa-gear menu-icon"></i>
                            <span class="menu-title">Settings</span>
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
                        <a class="nav-link" data-toggle="collapse" href="#Profile-management" aria-expanded="false" aria-controls="Profile-management"><i class="fa fa-user menu-icon"></i>
                            <span class="menu-title"> Profile</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="Settings-management">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="../../settings.php">Edit Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="../../change_password.php">Change Password</a></li>
                                <li class="nav-item"><a class="nav-link" href="../../logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>

           <!-- Dashboard -->
           <div class="main-panel">
                <div class="content-wrapper">
                    <!-- <div class="page-header">
                        <h3 class="page-title">
                            Dashboard
                        </h3>
                    </div> -->
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                    <i class="fas fa-list"></i>
                                    All Stores</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Store Name</th>
                                                    <th>Category</th>
                                                    <th>Logo</th>
                                                    <th>Published</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($all_stores as $store): ?>
                                                    <tr>
                                                        <td><?php echo $store['id']; ?></td>
                                                        <td><?php echo $store['name']; ?></td>
                                                        <td><?php echo $store['category']; ?></td>
                                                        <td><?php echo ucfirst($store['logo']); ?></td>
                                                        <td><?php echo '<span class="badge ' . ($store['published'] == 1 ? 'badge-success' : 'badge-danger') . '">' . ($store['published'] == 1 ? 'Published' : 'Non-Published') . '</span>';?></td>
                                                        <td><?php echo $store['created_by']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
<script src="../../vendors/js/vendor.bundle.base.js"></script>
<script src="../../vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="../../js/off-canvas.js"></script>
<script src="../../js/hoverable-collapse.js"></script>
<script src="../../js/misc.js"></script>
<script src="../../js/settings.js"></script>
<script src="../../js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="../../js/dashboard.js"></script>
<!-- End custom js for this page-->
</body>
</html>