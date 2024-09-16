<?php

$user_id = $_SESSION['user_id'];

$sql = "SELECT store.*, users.image AS image, users.id AS userId FROM store JOIN users ON users.id = store.created_by WHERE created_by = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
}


?>
<style>
    nav li:hover{
        box-shadow: 0 0 10px white !important;
    }
    nav li img {
        width: 30px;
        height: 30px;
        border: 1px solid;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SiteCraft</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="allSitesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">All Sites</a>
                    <div class="dropdown-menu dropdown-menu-custom create-website" aria-labelledby="allSitesDropdown">
                        <a href="./website_intro.php" class="create-site">+ Create New Site</a>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <a class="d-flex py-2 align-items-center justify-content-center" href="./dashboard.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                                    <div class="row mt-3 mx-1 rounded-3 p-2" style="box-shadow: 0 0 10px -6px #333;">
                                        <div class="col-3">
                                            <img class="w-100" src="<?php echo htmlspecialchars($row['preview_image']); ?>" alt="website" />
                                        </div>
                                        <div class="col-9 d-flex flex-column">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($row['name']); ?></h6>
                                            <small class="mt-0 mb-0 text-secondary">
                                                <?php echo $row['published'] == 0 ? 'Not Published' : 'Published'; ?>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="no-sites">
                                <p>No sites found</p>
                                <p>You don’t have any sites to show at the moment. Create a new one to see it here.</p>
                            </div>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <div class="all-sites-link">
                            <a href="./website_buildup.php">Go to All Sites</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Products</a>
                    <div class="dropdown-menu dropdown-menu-custom create-website" aria-labelledby="productsDropdown">
                        <span class="text-muted fw-light text-sm" style="font-size: 14px;">Click on the store to view Products:</span>
                        <?php $result->data_seek(0); ?>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <a class="d-flex py-2 align-items-center justify-content-center" href="../Store_Owner_Dashboard/products-section.php?store_id=<?php echo htmlspecialchars($row['id']); ?>">
                                    <div class="row mt-3 mx-1 rounded-3 p-2" style="box-shadow: 0 0 10px -6px #333;">
                                        <div class="col-3">
                                            <img class="w-100" src="<?php echo htmlspecialchars($row['preview_image']); ?>" alt="website" />
                                        </div>
                                        <div class="col-9 d-flex flex-column">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($row['name']); ?></h6>
                                            <small class="mt-0 mb-0 text-secondary">
                                                <?php echo $row['published'] == 0 ? 'Not Published' : 'Published'; ?>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="no-sites">
                                <p>No sites found</p>
                                <p>You don’t have any sites to view products. Create a new one to see it here.</p>
                            </div>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="hireDropdown">Hire a Professional</a>
                </li>
                <li class="nav-item dropdown d-block d-lg-none">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Notifications</a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-notification dropdown-menu-custom" aria-labelledby="notificationDropdown">
                        <div class="container notification">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bell-fill" style="font-size:40px;"></i>
                                </div>
                                <div class="col-12 text-center">
                                    <p>This is where you’ll see all your notifications from site.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown d-block d-lg-none">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-custom" aria-labelledby="accountDropdown">
                        <div class="row">
                            <div class="col-2 d-flex align-items-center justify-content-center">
                            <img width="30" height="30" src="<?php if (isset($_SESSION['google_picture'])) {
                            echo htmlspecialchars($_SESSION['google_picture']);
                        } else if (isset($data['image'])){
                            echo $data['image'];
                        } else if (isset($_SESSION['user_image'])) {
                            echo $_SESSION['user_image'];
                        }; ?>" class="rounded-circle" alt="Profile">
                            </div>
                            <div class="col-10">
                                <h6 class="m-0"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h6>
                                <p class="m-0"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-8">
                                <a href="../Store_Owner_Dashboard/account_setting.php?store_id=<?php echo isset($data['id']) ? htmlspecialchars($data['id']) : htmlspecialchars($user_id); ?>" class="nav-link m-0 p-0 d-flex gap-2 align-items-center justify-content-center">
                                    <i class="bi bi-gear"></i>Account Settings
                                </a>
                            </div>
                            <div class="col-4">
                                <form method="post" action="../Auth/logout.php">
                                    <button type="submit" name="logout" class="btn d-none d-sm-block text-primary rounded-pill ms-auto px-2 py-0 border border-primary"><span>Log Out</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav nav-icons">
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link dropdown-toggle me-3" href="#" id="bellDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell position-relative">
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-notification dropdown-menu-custom" aria-labelledby="bellDropdown">
                        <div class="header p-1">
                            <h5>Notifications</h5>
                        </div>
                        <div class="dropdown-divider mb-3"></div>
                        <div class="container notification">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bell-fill" style="font-size:40px;"></i>
                                </div>
                                <div class="col-12 text-center">
                                    <p>This is where you’ll see all your notifications from site.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item profile-icon d-none d-lg-block">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img width="30" height="30" src="<?php if (isset($_SESSION['google_picture'])) {
                            echo htmlspecialchars($_SESSION['google_picture']);
                        } else if (isset($data['image'])){
                            echo $data['image'];
                        } else if (isset($_SESSION['user_image'])) {
                            echo $_SESSION['user_image'];
                        }; ?>" class="rounded-circle" alt="Profile">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-custom" aria-labelledby="profileDropdown">
                        <div class="row">
                            <div class="col-2 d-flex align-items-center justify-content-center">
                            <img width="30" height="30" src="<?php if (isset($_SESSION['google_picture'])) {
                            echo htmlspecialchars($_SESSION['google_picture']);
                        } else if (isset($data['image'])){
                            echo $data['image'];
                        } else if (isset($_SESSION['user_image'])) {
                            echo $_SESSION['user_image'];
                        }; ?>" class="rounded-circle" alt="Profile">
                            </div>
                            <div class="col-10">
                                <h6 class="m-0"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h6>
                                <p class="m-0"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-8">
                                <a href="../Store_Owner_Dashboard/account_setting.php?store_id=<?php echo isset($data['id']) ? htmlspecialchars($data['id']) : htmlspecialchars($user_id); ?>" class="nav-link m-0 p-0 d-flex gap-2 align-items-center justify-content-center">
                                    <i class="bi bi-gear"></i>Account Settings
                                </a>
                            </div>
                            <div class="col-4">
                                <form method="post" action="../Auth/logout.php">
                                    <button type="submit" name="logout" class="btn d-none d-sm-block text-primary rounded-pill ms-auto px-2 py-0 border border-primary"><span>Log Out</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
