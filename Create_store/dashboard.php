<?php
session_start();

if (isset($_GET['id'])) {
    include('../Connection/connection.php');
    
    $store_id = $_GET['id'];    
    $user_id = $_SESSION['user_id'];

    if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
        header('Location: ../Auth/login.php');
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM store WHERE id = ? AND created_by = ?");
    $stmt->bind_param("ii", $store_id , $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        $store_data = array();
        if ($result->num_rows > 0) {
            $store_data = $result->fetch_assoc();
            $_SESSION['store_data'] = $store_data;

        } else {
           header('location: website_buildup.php');
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();



    
} else {
    echo "ID not set in GET request.";
    header('location: website_buildup.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Theme Changer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../Styles/styles.css">
    

  </head>
  <body>
    
      <?php include("../Components/navbar.php");?>
      <div class="container-fluid">
    <div class="row secondary-nav py-2 bg-light">
        <div class="col-12 col-lg-6 ">
            <div class="row d-flex align-items-center justify-content-center justify-content-lg-start fw-bold gap-3">
                <label class="col-2 col-lg-1" for="pageSelector">Page:</label>
                <div class="col-9 col-lg-6">
                    <select class="form-select rounded px-4 py-2 border" name="pages" id="pageSelector">
                        <option value="" disabled selected>Select a page</option>
                        <?php
                        $dir = '../User_Stores/' . $store_data['template'];
                        $files = scandir($dir);
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..' && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                                echo "<option value='{$file}'>{$file}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>  
        </div>
        <form method="POST" class="col-12 col-lg-6 d-flex align-items-center justify-content-between justify-content-lg-end ">
            <button type="button" class="px-3 py-1 border-0 bg-light fw-bold text-primary"><a href="<?php echo $store_data['path'];?>" target="_blank">Preview</a></button>
            <button type="button" id="next" class="btn btn-primary px-5 py-1 rounded-pill fw-bold" <?php if ($store_data['template'] == '') echo 'disabled';?>  >Next</button>
            <a id="finishBtn" class="btn btn-primary px-5 py-1 ms-3 rounded-pill fw-bold d-none text-light text-decoration-none" 
            href="../Store_Owner_Dashboard/index.php?store_id=<?php echo $store_data['id']; ?>&owner_id=<?php echo $store_data['created_by']; ?>">
            Finish
            </a>

        </form>
    </div>
</div>

<div class="container-fluid">


    <div class="row mt-4 " style="height: 75vh;">
        <div id="theme-sec" class="col-3" style="height: 100%; overflow-y: scroll;">
            <h5 class="fw-bold mb-3">Change Theme</h5>
            <ul id="themeList" class="list-group"></ul>
        </div>
<!-- ADD PRODUCT SECTION -->

        <div class="col-3 d-none" id="product-sec" style="height: 100%; overflow-y: scroll;">
                <h5 class="fw-bold mb-3">Add Product</h5>
                <form id="productForm" method="POST" action="add_products.php?store_id=<?php echo $store_id;?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <div class="file-upload position-relative" id="fileUpload">
                            <div class="icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </div>
                            <p>Drag file(s) here to upload.<br>Alternatively, you can select a file by <span>clicking here</span></p>
                            <input type="file" id="fileInput" name="productImage" hidden>
                            <img id="filePreview" class="position-absolute top-50 start-50 translate-middle" src="" alt="File Preview">
                        </div>
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
                        <label for="ProductDescription" class="form-label">Product Description</label>
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
                    <div class="mb-3">
                        <label for="productCost" class="form-label">Cost $:</label>
                        <input type="number" class="form-control" id="productCost" name="productCost" placeholder="1000">
                    </div>
                    <button type="button" class="btn btn-primary" id="addProductBtn">Add Product</button>
                    <button type="button" class="btn btn-primary"><a class="text-light" href="../Store_Owner_Dashboard/products-section.php?store_id=<?php echo $store_id?>">View All Product</a></button>
                </form>
        </div>
<!-- ADD PRODUCT SECTION -->
        <div class="col-9">
            <?php  echo' <iframe class="rounded-3 shadow-lg" id="previewFrame" src="../User_Stores/';echo($store_data['template']);echo'/index.php" style="width: 100%; height: 100%; border: none;"></iframe>';?>
        </div>

        <button type="button" class="btn border rounded-pill shadow px-4 py-1 col-1 position-absolute bottom-0 end-0 mx-3 my-3 fw-bold d-none" id="back" style="background: white;"><i class="bi bi-arrow-left me-1 mt-3"></i> Back</button>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="../Js/dashboard.js"></script>

    <script>
    $(document).ready(function() {
        
        function updatePreviewContent() {
            var previewFrame = $('#previewFrame')[0];

            if (previewFrame) {
                var previewDoc = previewFrame.contentWindow.document;

                var previewLogo = $(previewDoc).find('#previewLogo')[0];
                if (previewLogo) {
                    previewLogo.src = '<?php echo $store_data['logo']; ?>'; 
                }

                $(previewDoc).find('a').each(function() {
                    $(this).on('click', function(event) {
                        event.preventDefault();
                    });
                });
            }
        }

        function updatePageSelector(currentSrc) {
            var templatePath = <?php echo json_encode("../User_Stores/" . $store_data['template'] . "/"); ?>;
            var currentPage = currentSrc.replace(templatePath, '');
            $('#pageSelector').val(currentPage);
        }

        $('#pageSelector').on('change', function() {
            var selectedPage = $(this).val();
            var templatePath = <?php echo json_encode("../User_Stores/" . $store_data['template'] . "/"); ?>;
            var newSrc = templatePath + selectedPage;

            $('#previewFrame').attr('src', newSrc);
        });

        $('#previewFrame').on('load', function() {
            updatePreviewContent();
            var currentSrc = $('#previewFrame').attr('src');

            updatePageSelector(currentSrc);
        });

        var initialPage = $('#pageSelector').val();
        if (initialPage) {
            var templatePath = <?php echo json_encode("../User_Stores/" . $store_data['template'] . "/"); ?>;
            var initialSrc = templatePath + initialPage;
 
            $('#previewFrame').attr('src', initialSrc);
        }


        // Next section

        $('#next').on('click', nextSec)
        function nextSec() {
            $('#theme-sec').addClass('d-none');
            $('#product-sec').removeClass('d-none');
            $('#finishBtn').removeClass('d-none');
            $('#back').removeClass('d-none');
            $('#next').addClass('d-none');
        }
        
        $('#back').on('click', function(){
            $('#product-sec').addClass('d-none');
            $('#theme-sec').removeClass('d-none');
            $('#finishBtn').addClass('d-none');
            $('#back').addClass('d-none');
            $('#next').removeClass('d-none');
        })

// File Upload 

const fileUpload = $('#fileUpload');
      const fileInput = $('#fileInput');
      const filePreview = $('#filePreview');

      fileUpload.on('click', function(e) {
        if (e.target.tagName !== 'INPUT') {
          fileInput.trigger('click');
        }
      });

      fileInput.on('change', function(e) {
        handleFiles(e.target.files);
      });

      fileUpload.on('dragover', function(e) {
        e.preventDefault();
        fileUpload.addClass('dragover');
      });

      fileUpload.on('dragleave', function() {
        fileUpload.removeClass('dragover');
      });

      fileUpload.on('drop', function(e) {
        e.preventDefault();
        fileUpload.removeClass('dragover');
        handleFiles(e.originalEvent.dataTransfer.files);
      });

      function handleFiles(files) {
        const file = files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            filePreview.attr('src', e.target.result);
            filePreview.show();
            fileUpload.addClass('hidden-siblings');
          };
          reader.readAsDataURL(file);
        }
      }

    //   Form Validate


    $('#addProductBtn').on('click', function() {
        if (validateForm()) {
          $('#productForm').submit();
        } else {
          alert('Please fill in all fields.');
        }
      });

      function validateForm() {
        var productName = $('#productName').val().trim();
        var productDescription = $('#productDescription').val().trim();
        var productCategory = $('#productCategory').val();
        var productQuantity = $('#productQuantity').val().trim();
        var productPrice = $('#productPrice').val().trim();
        var fileInput = document.getElementById('fileInput');

        if (productName === '' || productDescription === '' || productCategory === '' || productQuantity=== '' || productPrice === '' || !fileInput.files.length) {
          return false;
        }
        return true;
      }
    //   VIEW PRODUCTS

    $('#viewProductBtn').on('click', function() {
        $('#productModal').modal('show');
        loadProducts(); 
    });

    function loadProducts() {
        $.ajax({
            url:  'fetch_products.php?store_id=<?php echo($store_id);?>', 
            method: 'GET',
            success: function(response) {
                $('#productList').html(response);
            }
        });
    }

    $(document).on('click', '.edit-product', function() {
        var productId = $(this).data('product-id');
    });

    $(document).on('click', '.delete-product', function() {
        var productId = $(this).data('product-id');
    });

    $('#saveChangesBtn').on('click', function() {
        $('#productModal').modal('hide');
    });


    });
</script>

    
<?php $conn->close(); ?>
  </body>
</html>