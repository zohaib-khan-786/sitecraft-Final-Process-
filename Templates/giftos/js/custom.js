window.myScriptUrl = document.currentScript.src;
let storeName = '';

if (window.myScriptUrl) {
    const url = window.myScriptUrl;
    const parts = url.split('/');

    const userStoresIndex = parts.indexOf('User_Stores');

    if (userStoresIndex !== -1) {
        const storeAndRest = parts.slice(userStoresIndex + 1).join('/');
        const storeNamePart = storeAndRest.split('_giftos')[0]; 
        storeName = storeNamePart.replace(/ /g, '_') ; 
        
    } else {
        console.error('The "User_Stores" segment was not found in the URL.');
    }
}

document.addEventListener("DOMContentLoaded", function() {
    let allProducts = [];

    // Fetch products
    fetch(`php/products_fetch.php?storeName=${encodeURIComponent(storeName)}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error fetching products:', data.error);
                return;
            }

            allProducts = data.products;
            
          
            const pageType = document.querySelector('body').dataset.pageType;

            if (pageType === '1') {
                renderProducts(allProducts.slice(0, 8));
            } else {
                renderProducts(allProducts);
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });

    // Fetch store data
    fetch(`php/store_data.php?storeName=${encodeURIComponent(storeName)}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error fetching store data:', data.error);
            } else {
                document.getElementById('previewLogo').src = data.logo;
                console.log('Store logo:', data.logo);
            }
        })
        .catch(error => {
            console.error('Error fetching store data:', error);
        });
});
function renderProducts(products) {

        const list = document.querySelector('.productList');
        list.innerHTML = '';
        console.log(products);
        
        if (products.length === 0) {
            list.innerHTML = 'No products found.';
        } else {
            products.forEach(product => {
                
                
                let card = document.createElement('div');
                card.classList.add('col-sm-6', 'col-md-4', 'col-lg-3');
                card.innerHTML = `
                    <div class="box">
                        <a href="">
                            <div class="img-box">
                                <img src="${product.image}" alt="${product.name}">
                            </div>
                            <div class="detail-box">
                                <h6>${product.name}</h6>
                                <h6>
                                    Price <span>$${product.price}</span>
                                </h6>
                            </div>
                            ${product.isNew === 'New' && '<div class="new"><span>New</span></div>'} 
                             
                        </a>
                         <form action="cart.php" method="POST">
                            <input type="hidden" name="product_id" value="${product.id}">
                            <input type="hidden" name="store_id" value="${product.store_id}">
                            <button type="submit" class="btn btn-primary add-to-cart">Add to Cart</button>
                        </form>
                    </div>
                `;
                list.appendChild(card);
            });
        }
}

// to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();

// owl carousel 
$('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 6
        }
    }
});
