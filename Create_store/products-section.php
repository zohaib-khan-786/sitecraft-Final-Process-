<?php
include("../Connection/connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

$products = [];

if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];
    $sql = "SELECT products.*, store.name AS store_name 
            FROM products 
            JOIN store ON products.store_id = store.id 
            WHERE store_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $store_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $products = $result->fetch_all(MYSQLI_ASSOC);
        }
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }
} else {
    $sql = "SELECT products.*, store.name AS store_name 
            FROM products 
            JOIN store ON products.store_id = store.id 
            WHERE products.owner_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $products = $result->fetch_all(MYSQLI_ASSOC);
        }
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../Styles/styles.css">
    <style>
        .custom-container {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .table thead th {
            border-bottom: none;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .vertical-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
        }
        .vertical-button > span {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background-color: #343a40;
            opacity: 0.8;
        }
        .dropdown-menu {
            min-width: 8rem;
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        #filePreview {
            width: 40%;
            background-color: #f8f9fa;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include("../Components/navbar.php"); ?>
    <div class="container custom-container">
        <h3>Products <span class="text-muted"><?php echo count($products); ?></span></h3>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <select class="form-select form-select-sm" aria-label="Filter products">
                    <option selected>All products (<?php echo count($products); ?>)</option>
                    <option value="1">Physical</option>
                    <option value="2">Digital</option>
                </select>
            </div>
            <div>
                <button class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#productModal" id="newProductBtn">+ New Product</button>
                <!-- MODAL -->
                <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel">Add Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="productForm" method="POST" action="add_products.php?store_id=<?php echo $store_id; ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="storeId" id="storeId" value="<?php echo $store_id ?>">
                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">Product Image</label>
                                        <div class="file-upload position-relative w-50 mx-auto " id="fileUpload">
                                            <div class="icon">
                                                <i class="bi bi-cloud-arrow-up"></i>
                                            </div>
                                            <p>Drag file(s) here to upload.<br>Alternatively, you can select a file by <span>clicking here</span></p>
                                            <input type="file" id="fileInput" name="productImage" hidden>
                                        </div>
                                        <img id="filePreview" class="rounded mx-auto" src="" alt="File Preview">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="productName" name="productName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productCategory" class="form-label">Category</label>
                                        <select class="form-select" id="productCategory" name="productCategory">
                                            <option value="" disabled selected>Select a category</option>
                                            <!-- Add your categories here -->
                                            <option value="men">Men</option>
                                            <option value="women">Women</option>
                                            <option value="children">Children</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productDescription" class="form-label">Product Description</label>
                                        <textarea type="text" class="form-control" id="productDescription" name="productDescription"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productQuantity" class="form-label">Product Quantity</label>
                                        <input type="number" class="form-control" id="productQuantity" name="productQuantity" value="5">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label">Price $:</label>
                                        <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="1000">
                                    </div>
                                    <button type="button" class="btn btn-primary" id="saveProductBtn">Save Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL -->
            </div>
        </div>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Store Name</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($products)) {
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td><input class='form-check-input' type='checkbox'></td>";
                        echo "<td><img style='height: 100px;' src='{$product['image']}' alt='{$product['name']}'></td>";
                        echo "<td>{$product['name']}</td>";
                        echo "<td>{$product['description']}</td>";
                        echo "<td>{$product['category']}</td>";
                        echo "<td>{$product['quantity']}</td>";
                        echo "<td>{$product['price']}</td>";
                        echo "<td>{$product['store_name']}</td>";
                        echo "<td>
                                <div class='dropdown'>
                                    <button class='btn btn-light dropdown-toggle vertical-button' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                    <ul class='dropdown-menu'>
                                        
                                        <li><a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#productModal' data-product-id='{$product['id']}'><i class='bi bi-gear me-3'></i> Edit Product</a></li>
                                        <li><a class='dropdown-item text-danger' href='delete_product.php?product_id={$product['id']}'><i class='bi bi-trash me-3'></i> Delete Product</a></li>
                                    </ul>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const storeId = document.getElementById('storeId').value;
            const fileInput = document.getElementById('fileInput');
            const fileUpload = document.getElementById('fileUpload');
            const filePreview = document.getElementById('filePreview');
            const productModal = document.getElementById('productModal');
            const productForm = document.getElementById('productForm');
            const saveProductBtn = document.getElementById('saveProductBtn');
            
            fileUpload.addEventListener('click', () => fileInput.click());
            filePreview.addEventListener('click', () => fileInput.click());

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        filePreview.src = event.target.result;
                        filePreview.style.display = 'block';
                        fileUpload.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });

            saveProductBtn.addEventListener('click', function() {
                productForm.action = `add_products.php?store_id=${storeId}`;
                productForm.submit();
            });

            productModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-product-id');

                if (productId) {
                    fetch(`fetch_products.php?product_id=${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('productModalLabel').textContent = 'Edit Product';
                            productForm.action = 'edit_product.php';
                            document.getElementById('productName').value = data.product.name;
                            document.getElementById('productCategory').value = data.product.category;
                            document.getElementById('productDescription').value = data.product.description;
                            document.getElementById('productQuantity').value = data.product.quantity;
                            document.getElementById('productPrice').value = data.product.price;
                            filePreview.src = data.product.image;
                            filePreview.style.display = 'block';
                            fileUpload.style.display = 'none';
                        } else {
                            alert('Error fetching product data: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                } else {
                    productForm.reset();
                    productForm.action = 'add_product.php';
                    document.getElementById('productModalLabel').textContent = 'Add Product';
                    filePreview.style.display = 'none';
                    fileUpload.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>
