(function($) {
    "use strict";
	window.myScriptUrl = document.currentScript.src;
	let storeName = '';
	
	if (window.myScriptUrl) {
		const url = window.myScriptUrl;
		const parts = url.split('/');
	
		const userStoresIndex = parts.indexOf('User_Stores');
	
		if (userStoresIndex !== -1) {
			const storeAndRest = parts.slice(userStoresIndex + 1).join('/');
			const storeNamePart = storeAndRest.split('freshshop')[0]; 
			storeName = storeNamePart.replace(/ /g, '_') ; 
		} else {
			console.error('The "User_Stores" segment was not found in the URL.');
		}
	}
	/* ..............................................
	   Products 
	   ................................................. */
	   $(document).ready(function() {
		let allProducts = [];
	
		$.getJSON(`php/products_fetch.php?storeName=${encodeURIComponent(storeName)}`)
			.done(function(data) {
				if (data.error) {
					console.error(data.error);
					return;
				}
	
				allProducts = data.products;
	
				const pageType = $('body').data('page-type');
	
				if (pageType === 1) {
					
					renderProducts(allProducts.slice(0, 4));
				} else {
					renderProducts(allProducts);
				}
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.error('Error fetching products:', errorThrown);
			});
	
		$.getJSON(`php/store_data.php?storeName=${encodeURIComponent(storeName)}`)
			.done(function(data) {
				if (data.error) {
					console.error(data.error);
				} else {
					$('#previewLogo').attr('src', data.logo);
				}
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.error('Error fetching store data:', errorThrown);
			});
	});
	
	function renderProducts(products) {
		const $list = $('.productList');
		$list.empty();
	
		if (products.length === 0) {
			$list.html('No products found.');
		} else {
			products.forEach(function(product) {
				const card = `
					 <div class="col-lg-3 col-md-6 special-grid best-seller">
                    <div class="products-single fix">
                        <div class="box-img-hover">
                            <div class="type-lb">
							${product.isNew === 'New' ? '<p class="new">New</p>' : ''} 
                            </div>
                            <img src="${product.image}"  class="img-fluid" alt="${product.name}">
                            <div class="mask-icon">
                                <ul>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                </ul>
                                <form action="cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="${product.name}">
                                    <button type="submit" class="cart">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                        <div class="why-text">
                            <h4>${product.description}</h4>
                            <h5> $${product.price}</h5>
                        </div>
                    </div>
                </div>`;
				$list.append(card);
			});
		}
	}
	



	
	/* ..............................................
	   Loader 
	   ................................................. */
	$(window).on('load', function() {
		$('.preloader').fadeOut();
		$('#preloader').delay(550).fadeOut('slow');
		$('body').delay(450).css({
			'overflow': 'visible'
		});




	});

	/* ..............................................
	   Fixed Menu
	   ................................................. */

	$(window).on('scroll', function() {
		if ($(window).scrollTop() > 50) {
			$('.main-header').addClass('fixed-menu');
		} else {
			$('.main-header').removeClass('fixed-menu');
		}
	});

	/* ..............................................
	   Gallery
	   ................................................. */

	$('#slides-shop').superslides({
		inherit_width_from: '.cover-slides',
		inherit_height_from: '.cover-slides',
		play: 5000,
		animation: 'fade',
	});

	$(".cover-slides ul li").append("<div class='overlay-background'></div>");

	/* ..............................................
	   Map Full
	   ................................................. */

	$(document).ready(function() {
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > 100) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		$('#back-to-top').click(function() {
			$("html, body").animate({
				scrollTop: 0
			}, 600);
			return false;
		});
	});

	/* ..............................................
	   Special Menu
	   ................................................. */

	var Container = $('.container');
	Container.imagesLoaded(function() {
		var portfolio = $('.special-menu');
		portfolio.on('click', 'button', function() {
			$(this).addClass('active').siblings().removeClass('active');
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({
				filter: filterValue
			});
		});
		var $grid = $('.special-list').isotope({
			itemSelector: '.special-grid'
		});
	});

	/* ..............................................
	   BaguetteBox
	   ................................................. */

	baguetteBox.run('.tz-gallery', {
		animation: 'fadeIn',
		noScrollbars: true
	});

	/* ..............................................
	   Offer Box
	   ................................................. */

	$('.offer-box').inewsticker({
		speed: 3000,
		effect: 'fade',
		dir: 'ltr',
		font_size: 13,
		color: '#ffffff',
		font_family: 'Montserrat, sans-serif',
		delay_after: 1000
	});

	/* ..............................................
	   Tooltip
	   ................................................. */

	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});

	/* ..............................................
	   Owl Carousel Instagram Feed
	   ................................................. */

	$('.main-instagram').owlCarousel({
		loop: true,
		margin: 0,
		dots: false,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
		navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
		responsive: {
			0: {
				items: 2,
				nav: true
			},
			600: {
				items: 3,
				nav: true
			},
			1000: {
				items: 5,
				nav: true,
				loop: true
			}
		}
	});

	/* ..............................................
	   Featured Products
	   ................................................. */

	$('.featured-products-box').owlCarousel({
		loop: true,
		margin: 15,
		dots: false,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
		navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
		responsive: {
			0: {
				items: 1,
				nav: true
			},
			600: {
				items: 3,
				nav: true
			},
			1000: {
				items: 4,
				nav: true,
				loop: true
			}
		}
	});

	/* ..............................................
	   Scroll
	   ................................................. */

	$(document).ready(function() {
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > 100) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		$('#back-to-top').click(function() {
			$("html, body").animate({
				scrollTop: 0
			}, 600);
			return false;
		});
	});


	/* ..............................................
	   Slider Range
	   ................................................. */

	$(function() {
		$("#slider-range").slider({
			range: true,
			min: 0,
			max: 4000,
			values: [1000, 3000],
			slide: function(event, ui) {
				$("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
			}
		});
		$("#amount").val("$" + $("#slider-range").slider("values", 0) +
			" - $" + $("#slider-range").slider("values", 1));
	});

	/* ..............................................
	   NiceScroll
	   ................................................. */

	$(".brand-box").niceScroll({
		cursorcolor: "#9b9b9c",
	});
	
	
}(jQuery));