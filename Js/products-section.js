document.addEventListener('DOMContentLoaded', function() {
    const storeId = document.getElementById('storeId') ? document.getElementById('storeId').value : null;
    const fileInput = document.getElementById('fileInput');
    const fileUpload = document.getElementById('fileUpload');
    const filePreview = document.getElementById('filePreview');
    const productModal = document.getElementById('productModal');
    const productForm = document.getElementById('productForm');
    const saveProductBtn = document.getElementById('saveProductBtn');

    if (filePreview && fileUpload) {
        if (filePreview.src) {
            fileUpload.style.display = 'none';
        }else {
            fileUpload.style.display = 'block'; 
        }
    }

    if (fileUpload) {
        fileUpload.addEventListener('click', () => fileInput.click());
    }

    if (filePreview) {
        filePreview.addEventListener('click', () => fileInput.click());
    }

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    if (filePreview) {
                        filePreview.src = event.target.result;
                        filePreview.style.display = 'block';
                    }
                    if (fileUpload) {
                        fileUpload.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (saveProductBtn && productForm) {
        saveProductBtn.addEventListener('click', function() {
            if (storeId) {
                productForm.action = `../Create_Store/add_products.php?store_id=${storeId}`;
            }
            productForm.submit();
        });
    }

    if (productModal) {
        productModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-product-id');
            if (productId) {
                fetch(`../Create_Store/fetch_products.php?product_id=${productId}`)
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
                        document.getElementById('productCost').value = data.product.cost;
            
                        // Set existing image in a hidden input field
                        const existingImageInput = document.getElementById('existingImage');
                        if (existingImageInput) {
                            existingImageInput.value = data.product.image;
                        }
            
                        if (filePreview) {
                            filePreview.src = data.product.image;
                            filePreview.style.display = 'block';
                        }
                        if (fileUpload) {
                            fileUpload.style.display = 'none';
                        }
                    } else {
                        alert('Error fetching product data: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
             else {
                productForm.reset();
                productForm.action = 'add_product.php';
                document.getElementById('productModalLabel').textContent = 'Add Product';

                if (filePreview) {
                    filePreview.style.display = 'none';
                }
                if (fileUpload) {
                    fileUpload.style.display = 'block';
                }
            }
        });
    }
});
