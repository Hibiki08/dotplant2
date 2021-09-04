$(document).ready(function () {

// Start Sliders
    
    $('.owl-carousel-one').owlCarousel({
        nav: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>','<span class="fas fa-chevron-right fa-2x"></span>'],
        dots: true,
        loop: true,
        margin: 10,
        responsiveClass:true,
        responsive:{
            0:{
                items: 2,
                nav: false,
                dots: false,
            },
            600:{
                items: 2,
                nav: false,
                dots: false,
            },
            991:{
                items: 2,
                nav: true,
                dots: false,
            },
            1280:{
                items: 3,
                nav: true,
                dots: false,
            }
        }
    });
    $('.owl-carousel-benefits').owlCarousel({
        autoplay: true, 
        autoplayTimeout: 4000,
        autoplaySpeed: 2000,
        //smartSpeed: 2000,
        autoplayHoverPause: true,
        nav: true,
        navText: ['<span class="fas fa-chevron-left fa-2x" style="color:#fff"></span>','<span class="fas fa-chevron-right fa-2x" style="color:#fff"></span>'],
        dots: true,
        loop: true,
        margin: 10,
        responsiveClass:true,
        responsive:{
            0:{
                items: 1,
                nav: false,
                dots: false,
            },
            600:{
                items: 2,
                nav: false,
                dots: false,
            },
            1280:{
                items: 4,
                nav: true,
                dots: false,
            }
        }
    });
    $('.owl-carousel-two').owlCarousel({
        nav: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>','<span class="fas fa-chevron-right fa-2x"></span>'],
        dots: true,
        loop: true,
        margin: 10,
        responsiveClass:true,
        responsive:{
            0:{
                items: 2,
                nav: false,
                dots: false,
            },
            600:{
                items: 2,
                nav: false,
                dots: false,
            },
            1280:{
                items: 4,
                nav: true,
                dots: false,
            }
        }
    });
    $('.owl-carousel-three').owlCarousel({
        nav: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>','<span class="fas fa-chevron-right fa-2x"></span>'],
        dots: true,
        loop: true,
        margin: 10,
        responsiveClass:true,
        responsive:{
            0:{
                items: 2,
                nav: false,
                dots: false,
            },
            600:{
                items: 2,
                nav: false,
                dots: false,
            },
            1280:{
                items: 4,
                nav: true,
                dots: false,
            }
        }
    });
    $('.product-slider').owlCarousel({
        dots: true,
        nav: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>','<span class="fas fa-chevron-right fa-2x"></span>'],
        loop: true,
        items: 1,
    });    
    $('.order-items').owlCarousel({
        nav: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>','<span class="fas fa-chevron-right fa-2x"></span>'],
        dots: false,
        loop: false,
        margin: 10,
        thumbs: false, //disable .owl-thumbs (unused)
        responsiveClass:true,
        responsive:{
            0:{
                nav: false,
                dots: false,
            },
            600:{
                nav: true,
                dots: false,
            },
            1280:{
                nav: true,
                dots: false,
            }
        }
    });
        
    // End Sliders    

    $('[data-fancybox]').fancybox({
        closeExisting: true,
        
    });
    
    //
    $('.compare-button').click(function (e) {
        e.preventDefault();
        var count = Number($('.compare-items').text()) || 0;
        var productId = Number($(this).data('product-id')) || 0;
        var $this = $(this);
        var $body = $('body');

        if (productId <= 0) {
            alert('Ошибка добавления в сравнение');
            return;
        }

        $body.trigger({
            'type': 'addToCompareClicked',
            'productId': productId,
            'button': $this
        });
        Shop.addToCompare(productId, function(data) {
            $body.trigger({
                'type': 'addToCompare',
                'productId': productId,
                'button': $this
            });
            if (!$('.personal-area__compare').hasClass('active')) {
                $('.personal-area__compare').addClass('active');

            }
            $('.compare-items').text(++count);
        });
    });

    //
    $('.add-to-cart-button, .compare-page__table-add-cart').click(function (e) {
        e.preventDefault();

        var quantity = Number($(this).data('quantity')) || 1;
        if (typeof $(this).data('incrementally') != 'undefined') {
            quantity = Number($(this).parents('[data-incrementally-box]').find('.qty-input:first input').val()) || 1;
        }
        var productId = Number($(this).data('product-id')) || 0;
        var $this = $(this);
        var $body = $('body');

        if (productId <= 0) {
            alert('Ошибка добавления в корзину');
            return;
        }
        $body.trigger({
            'type': 'addBatchToCartClicked',
            'productId': productId,
            'button': $this
        });

        Shop.addToCart(
            productId,
            quantity,
            function (data) {
                $body.trigger({
                    'type': 'addBatchToCart',
                    'productId': productId,
                    'quantity': quantity,
                    'orderData': data,
                    'button': $this
                });
                if (data.success === true) {
                    var count = Number($('.cart-items').text().trim()) || 0;
                    if (!$('.personal-area__cart').hasClass('active')) {
                        $('.personal-area__cart').addClass('active');
                    }
                    $('.cart-items, .cart-items-mobile').text(count + quantity);
                } else {
                    alert('Ошибка: ' + data.errors.join(', '));
                }
            },
            [],
            ''
        );
    });

    //
    $('.js__product-content__add-to-fav, .js__fav-button').click(function (e) {
        if(!$(this).hasClass('active')) {
            e.preventDefault();
            var $this = $(this);
            var $body = $('body');
            var count = Number($('.fav-items').text().trim()) || 0;
            var productId = Number($(this).data('product-id')) || 0;
            var listId = Number($(this).data('list-id')) || 0;
            var title = 'Основной';
            if (productId <= 0) {
                alert('Ошибка добавления в избранное');
                return;
            }

            $body.trigger({
                'type': 'addToWishlistClicked',
                'productId': productId,
                'wishlistId': listId,
                'title': title,
                'button': $this
            });

            Shop.addToWishlist(productId, listId, title, function(data) {
                if (data.isSuccess === true) {
                    $body.trigger({
                        'type': 'addToWishlist',
                        'productId': productId,
                        'wishlistId': listId,
                        'title': title,
                        'button': $this
                    });

                    $('.fav-items, .fav-items-mobile').text(++count);
                    if (!$('.personal-area__fav').hasClass('active')) {
                        $('.personal-area__fav').addClass('active');
                    }
                    $this.find('.add-to-fav-tooltip-text').text('Убрать из избранного');
                    $this.find('.fav-button-text').text('Убрать из избранного');

                    if (listId === 0) {
                        $('.js__product-content__add-to-fav, .js__fav-button').data('list-id', data.listId);
                    }

                    $this.addClass('active');
                    //$('.add-to-fav-tooltip-text, .fav-button-text').text('Добавить в избранное');
                } else {
                    alert('Ошибка: ' + data.errorMessage);
                }
            });
        } else {
            e.preventDefault();
            var $this = $(this);
            favDel($this);
        }
        
    });

    //
    $('.fav-button-del, .fav-mass-button-del').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        favDel($this);
    });

    //
    function favDel($this) {
        var productIds = [];
        var massDelete = $this.hasClass('fav-mass-button-del');
    
        if (massDelete) {
            if ($('.fav__selected_item').length === 0) {
                return;
            }
    
            $('.fav__selected_item').each(function(){
                var productId = Number($(this).data('product-id'));
                if (productId > 0) {
                    productIds.push(productId);
                }
            });
        } else {
            var productId = Number($this.data('product-id'));
    
            if (productId <= 0) {
                alert('Ошибка при удалении');
                return;
            }
            productIds.push(productId);
        }
    
        if (productIds.length === 0) {
            alert('Ошибка при удалении');
            return;
        }
    
        $.ajax({
            type: 'GET',
            url: '/shop/wishlist/remove',
            data: {ids:productIds},
            success: function(answer) {
                if (answer.success) {
                    if (massDelete) {
                        $('.fav__selected_item').each(function(){
                            $(this).parents('.fav-page__item-col').remove();
                        });
                    } else {
                        $this.parents('.fav-page__item-col').remove();
                    }
    
                    if ($('.fav-page__item-col').length === 0) {
                        $('.fav-mass-buttons').hide();
                        $('.wishlists-are-empty').show();
                    }

                    if(massDelete) {
                        $('.fav-items').text('0');
                    } else {
                        $this.removeClass('active');
                        var count = Number($('.fav-items').text().trim()) || 1;
                        $('.fav-items').text(--count);
                        $this.find('.add-to-fav-tooltip-text').text('Добавить в избранное');
                        $this.find('.fav-button-text').text('Добавить в избранное');
                    }
                } else {
                    alert('Ошибка при удалении');
                }
            },
            error: function() {
                alert('Ошибка при удалении');
            }
        });
    }
    
    $('.product-tabs .tabs-nav .item-tab').click(function(e) {
        var $this = $(this);
        $tabs = $('.product-tabs').show(),
        $tabs_content = $tabs.find('.tabs-content'); 
        if (!$this.hasClass('active-tab')) {
            $this.addClass('active-tab').siblings().removeClass('active-tab');
            $tabs_content.find('.tab-content').hide().eq($this.index()).fadeIn(400);
        }
    }); 
    
   /* $('div.qty-input i').click(function() {
		val = parseInt($('.qty-input input').val());

		if ($(this).hasClass('less')) {
				val = val - 1;
		} else if ($(this).hasClass('more')) {
				val = val + 1;
		}

		if (val < 1) {
				val = 1;
		}

    $('.qty-input input').val(val);
    });
    */

});
    $('.qty-input').each(function() {
        var spinner = $(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.more'),
        btnDown = spinner.find('.less'),
        min = input.attr('min'),
        max = input.attr('max');

        btnUp.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        btnDown.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });
    });

    $('#deliveryinformation-city_id').change(function () {
        function getDeliveryInfo(cityId, isPickup) {
            var selector = '.js__delivery_info' + (isPickup ? '.js__pickup' : '.js__curier')
            var $container = $(selector);

            $.ajax({
                type: "GET",
                url: "get-pickup-price",
                data: { cityId: cityId, isPickup: isPickup}
            }).done(function( msg ) {
                $container.html(msg);
            }) .error(function() {
                $container.html("");
                alert('Для выбранного города произошла ошибка вычисления стоимости доставки');
            });
        }

        $this = $(this);
        if($this.val() > 0) {
            getDeliveryInfo($this.val(), 1);
            getDeliveryInfo($this.val(), 0);
            $('#delivery-type').val('');
            $('.delivery-type-select').removeClass('selected');
        }

    })

    $('.delivery-button').show();

    $('.delivery-type-select').click(function () {
        if(!$(this).hasClass('disabled')) {
            $('input.radio-input').prop('checked', false);
        
            $('#shop-stage').yiiActiveForm('validate', false)
            $('.delivery-address__default #address-field').hide();
            $('.delivery-address__new #address-field').hide();
        
            $(this).parent().find('.delivery-type-select').removeClass('selected');
            $(this).addClass('selected');
            var val = $(this).attr('data-value');
            $('#delivery-type').val(val);
            
            if (val == '1' || val == '3') {
                $('#isPickup').val(0);
                $('.delivery-address__wrapper #address-field').show();
                $('.delivery-address__new #address-field').show();
            } else {
                $('#isPickup').val(1);
                $('.delivery-address__wrapper #address-field').hide();
            }
            //if (val == '2') {
                $('.delivery-button').show();
            //} else {
            //    $('.delivery-button').hide();
            //}
        }
    });
    $(".radio-input").change(function () {
        var id = this.id;
        var checked = this.checked;
    
        if (id == 'current' && checked == '1') {
            $('.delivery-address__new').hide();
            $('.delivery-address__default').show();
            $('.delivery-button').show();
        }
    
        if (id == 'new' && checked == '1') {
            $('.delivery-address__default').hide();
            $('.delivery-address__new').show();
            $('.delivery-button').show();
        }
    });
    $('.payment-type-select').click(function () {
        $(this).parent().find('.payment-type-select').removeClass('selected');
        $(this).addClass('selected');
        var val = $(this).attr('data-value');
        $('#payment-type').val(val);
        
        if (val == '1' || val == '2') {
            $('.payment-total__wrapper').show();
            $('.next-button').show();
        } else {
            $('.payment-total__wrapper').hide();
            $('.next-button').hide();
        }
    
    });
    $('.fav-button-select').on('click', function (e) {
        e.preventDefault();
        if ($(this).attr('data-click-state') == 0) {
            $(this).attr('data-click-state', 1);
            $(this).addClass('active');
            $(this).parent('.category__item').addClass('fav__selected_item');
        } else {
            $(this).attr('data-click-state', 0);
            $(this).removeClass('active');
            $(this).parent('.category__item').removeClass('fav__selected_item');
        }
    });
    
    
    
    $('.mass-add-to-cart').on('click', function(){
        var items = $('.fav__selected_item');
        var products = [];
    
        if (items.length === 0) {
            return;
        }
    
        items.each(function(){
            var productId = Number($(this).data('product-id'));
            if (productId > 0) {
                products.push({
                    'id' : productId,
                    'quantity' : 1,
                });
            }
        });
    
        if (products.length === 0) {
            alert('Ошибка при удалении');
            return;
        }
        Shop.addBatchToCart(products, function(data){
            if (data.success === true) {
                var count = Number($('.cart-items').text().trim()) || 0;
                if (!$('.personal-area__cart').hasClass('active')) {
                    $('.personal-area__cart').addClass('active');
                }
                $('.cart-items').text(count + products.length);
            } else {
                alert('Ошибка: ' + data.errors.join(', '));
            }
        });
    });

    // show more/less in tabs

    var qty = 16;

    if ($("#properties.tab-content").children().not(".show").length > qty) {
        $(".show.more").css("display", "inline-block");
    }


    $(".show.more").on("click", function() {
        $(this).parent().children().not(".show").css("display", "block");
        $(this).parent().find(".show.less").css("display", "inline-block");
        $(this).hide();
        $('.tab-content').getNiceScroll().resize();
    });

    $(".show.less").on("click", function() {
        $(this).parent().children(":nth-child(n+" + (qty + 1) + ")").not(".show").hide();
        $(this).parent().find(".show.more").css("display", "inline-block");
        $(this).hide();
        $('.tab-content').getNiceScroll().resize();
    });
    
    /* New Menu */

    $('.catalog li.has-sub>a').on('click', function(){
		$(this).removeAttr('href');
		var element = $(this).parent('li');
		if (element.hasClass('open')) {
			element.removeClass('open');
			element.find('li').removeClass('open');
			element.find('ul').slideUp();
		}
		else {
			element.addClass('open');
			element.children('ul').slideDown();
			element.siblings('li').children('ul').slideUp();
			element.siblings('li').removeClass('open');
			element.siblings('li').find('li').removeClass('open');
			element.siblings('li').find('ul').slideUp();
		}
	});

	$('.catalog>ul>li.has-sub>a').append('<i class="fa fa-chevron-down"></i>');
    $('.personal-area__catalog').click(function(e) {
        
        $(this).toggleClass('opened');
        $('.catalog-mobile-wrapper').toggleClass('active');
        $('.personal-area__catalog').toggleClass('active');
        $('body').toggleClass('overflow-hidden');
    });

    $('.close-menu').click(function() { 
        if ($('.catalog-mobile-wrapper').hasClass('active')) {
            $('.catalog-mobile-wrapper').removeClass('active');
            $('.personal-area__catalog').removeClass('active');
            $('body').removeClass('overflow-hidden');
        }
    });
        
        
    $(window).resize(function() {
      if($('.catalog-mobile-wrapper').hasClass('active') && $(window).width() >= 992) {
        $('.catalog-mobile-wrapper').removeClass('active');
        $('.personal-area__catalog').removeClass('opened');
        $('body').removeClass('overflow-hidden');
      }
    });

    $('main .catalog-header.toggle').click(function(e) {
        $('main .catalog').slideToggle();
        $('main .catalog-header').toggleClass('catalog-active'); // Arrow to Catalog-header when clicked
    });

    // Arrow to Catalog-header
    if ($('main .catalog').css('display') !== 'none') { 
        $('main .catalog-header').addClass('catalog-active') 
    };

    /* Display list */
    $('.category__list-options_display-list').click(function(e) {
        $('.category__list-column').each(function() {
            var grid = 'category__list-column col-xl-4 col-md-6 col-12';
            var list = 'category__list-column col-12';
        if ($(this).hasClass(grid)) {
            $(this).toggleClass('col-xl-4 col-md-6', false);
        }
         $('.category__list-options_display-grid').removeClass('active');
         $('.category__list-options_display-list').addClass('active');
    })
        $('.slider-item').addClass('grid-to-row');
        
    });

    $('.category__list-options_display-grid').click(function(e) {
        $('.category__list-column').each(function() {
            var grid = 'category__list-column col-xl-4 col-md-6 col-12';
            var list = 'category__list-column col-12';
        if ($(this).hasClass(list)) {
            $(this).removeClass(list);
            $(this).addClass(grid);
        }
         $('.category__list-options_display-list').removeClass('active');
         $('.category__list-options_display-grid').addClass('active');
    })
        $('.slider-item').removeClass('grid-to-row');
        
    });

document.addEventListener("DOMContentLoaded", () => {
  fadin('.fade');
});

/**
 * Не заменять! Это вне верстки!
 */

function productListInits() {
    $('#js_cat_sort').change(function() {
        window.location = $(this).find('option:selected').data('url');
    })
    
    $('#js_display .js_set').click(function() {
        var $displaySet = $(this);
        var listDisplay = $displaySet.data('val');
    
        $('#js_cat_sort option').each(function() {
            setUrl($(this), 'data-url');
        });
    
        $('#js_limit_set .js_set').each(function() {
            setUrl($(this), 'href');
        });
    
        $('#js__pagination li a').each(function() {
            setUrl($(this), 'href');
        })
    
        function setUrl($a, href_attr) {
            var href = new URL($a.attr(href_attr), window.location.origin);
            href.searchParams.set('listDisplay', listDisplay);
            var link = href.toString();
            $a.attr(href_attr, link);
        }
    
    
    });
    
    // Mobile Filter sort
    
    $('.filters__mobile-sort-button, .filters__mobile-sort-menu').click(function(e) {
        $('.filters__mobile-sort-menu').slideToggle().toggleClass('active');
        $('.filters__mobile-sort-button').toggleClass('active');
        $('.personal-area').toggleClass('hide');
        $('body').toggleClass('overflow-hidden');
    });
    
    $(window).resize(function() {
        if($('.filters__mobile-sort-menu').hasClass('active') && $(window).width() >= 992) {
            $('.filters__mobile-sort-menu').removeClass('active');
            $('.filters__mobile-sort-button').removeClass('active');
            $('body').removeClass('overflow-hidden');
        }
    });
    
    // Mobile Filter filter
    
    $('.filter-has-submenu').append('<i class="fa fa-chevron-right"></i>');
    $('.filter-back a:first-child').prepend('<i class="fa fa-chevron-left"></i>');
    $('.close-filter').append('<i class="fas fa-times"></i>');
    
    $('.filters__mobile-filter-button').click(function(e) {
        // Close Filter sort if opened
        if($('.filters__mobile-sort-menu').hasClass('active')) {
            $('.filters__mobile-sort-menu').removeClass('active');
            $('.filters__mobile-sort-menu').css('display','none');
            $('.filters__mobile-sort-button').removeClass('active');
            $('body').removeClass('overflow-hidden');
        }
    
        $('.filters__mobile-filter-menu').toggleClass('active');
        $('.filters__mobile-filter-button').toggleClass('active');
        $('body').toggleClass('overflow-hidden');
    });
    
    $(window).resize(function() {
        if($('.filters__mobile-filter-menu').hasClass('active') && $(window).width() >= 992) {
            $('.filters__mobile-filter-menu').removeClass('active');
            $('body').removeClass('overflow-hidden');
        }
    });
    
    $('.close-filter').click(function() {
        if ($('.filters__mobile-filter-menu').hasClass('active')) {
            $('.filters__mobile-filter-menu').removeClass('active');
            $('body').removeClass('overflow-hidden');
        }
    });
    
    $('.filter-has-submenu').on('click', function(e){
        $(this).next().addClass('open');
    });
    
    $('.filter-back a:first-child').on('click', function(e){
        $(this).closest('.filter-submenu').removeClass('open');
    });
    
    // Desktop Filter Toggle Slide
    $('.filters__desktop-property-name').append('<i class="fa fa-chevron-right"></i>');
    $('.filters__desktop-property-name').each(function(e) {
        $(this).click(function(e) {
            $(this).next('.filters__desktop-property-data').slideToggle().toggleClass('active');
            $(this).toggleClass('active');
        });
    });    
}

productListInits();
