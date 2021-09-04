$(document).ready(function () {

    $('.owl-carousel-one').owlCarousel({
        nav: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>', '<span class="fas fa-chevron-right fa-2x"></span>'],
        dots: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: false,
            },
            600: {
                items: 2,
                nav: true,
                dots: false,
            },
            991: {
                items: 2,
                nav: true,
                dots: false,
            },
            1280: {
                items: 3,
                nav: false,
                dots: true,
            }
        }
    });

    $('.owl-carousel-two').owlCarousel({
        nav: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>', '<span class="fas fa-chevron-right fa-2x"></span>'],
        dots: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: false,
            },
            600: {
                items: 2,
                nav: true,
                dots: false,
            },
            1280: {
                items: 4,
                nav: false,
                dots: true,
            }
        }
    });
    $('.owl-carousel-three').owlCarousel({
        nav: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>', '<span class="fas fa-chevron-right fa-2x"></span>'],
        dots: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: false,
            },
            600: {
                items: 2,
                nav: true,
                dots: false,
            },
            1280: {
                items: 4,
                nav: false,
                dots: true,
            }
        }
    });
    $('.product-slider').owlCarousel({
        dots: false,
        nav: true,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>', '<span class="fas fa-chevron-right fa-2x"></span>'],
        loop: true,
        items: 1,
        thumbs: true,
        thumbImage: true,
        thumbContainerClass: 'owl-thumbs',
        thumbItemClass: 'owl-thumb-item'
    });
    $('[data-fancybox]').fancybox({
        closeExisting: true,

    });

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
    $('.add-to-cart-button, .compare-page__table-add-cart').click(function (e) {
        e.preventDefault();

        var quantity = Number($(this).data('quantity')) || 1;
        if ($(this).hasClass('incrementally')) {
            quantity = Number($('.qty-input:first input').val()) || 1;
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
                    $('.cart-items').text(count + quantity);
                } else {
                    alert('Ошибка: ' + data.errors.join(', '));
                }
            },
            [],
            ''
        );
    });
    $('.product-content__add-to-fav, .fav-button').click(function (e) {
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

                $('.fav-items').text(++count);
                if (!$('.personal-area__fav').hasClass('active')) {
                    $('.personal-area__fav').addClass('active');
                }
                $(this).find('.add-to-fav-tooltip-text').text('Убрать из избранного');

                if (listId === 0) {
                    $('.product-content__add-to-fav, .fav-button').data('list-id', data.listId);
                }

                $this.addClass('active');
                //$('.add-to-fav-tooltip-text, .fav-button-text').text('Добавить в избранное');
            } else {
                alert('Ошибка: ' + data.errorMessage);
            }
        });
    });

    $('.product-tabs .tabs-nav .item-tab').click(function (e) {
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
$('.qty-input').each(function () {
    var spinner = $(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.more'),
        btnDown = spinner.find('.less'),
        min = input.attr('min'),
        max = input.attr('max');

    btnUp.click(function () {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });

    btnDown.click(function () {
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
$('.delivery-type-select').click(function () {
    $('input.radio-input').prop('checked', false);

    $('.delivery-address__default').hide();
    $('.delivery-address__new').hide();

    $(this).parent().find('.delivery-type-select').removeClass('selected');
    $(this).addClass('selected');
    var val = $(this).attr('data-value');
    $(this).closest().find('input').val(val);
    if (val == '1' || val == '3') {
        $('.delivery-address__wrapper').show();
    } else {
        $('.delivery-address__wrapper').hide();
    }
    if (val == '2') {
        $('.delivery-button').show();
    } else {
        $('.delivery-button').hide();
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
    $(this).closest().find('input').val(val);
    if (val == '1' || val == '2') {
        $('.payment-total__wrapper').show();
    } else {
        $('.payment-total__wrapper').hide();
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

$('.fav-button-del, .fav-mass-button-del').on('click', function (e) {
    e.preventDefault();
    var $this = $(this);
    var productIds = [];
    var massDelete = $(this).hasClass('fav-mass-button-del');

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
        var productId = Number($(this).data('product-id'));

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
            } else {
                alert('Ошибка при удалении');
            }
        },
        error: function() {
            alert('Ошибка при удалении');
        }
    });
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

$(function () {
    var cart = $('.personal-area');
    var menu = $('.logo-wrapper');
    var hieghtThreshold = $("main").offset().top;
    var hieghtThreshold_end = $("main").offset().top + $("main").height();
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();

        if (scroll >= hieghtThreshold && scroll <= hieghtThreshold_end) {
            cart.addClass('sticky-bottom');
            menu.addClass('sticky-top');
        } else {
            cart.removeClass('sticky-bottom');
            menu.removeClass('sticky-top');
        }
    });
})

if ($('.personal-area__login').hasClass('active')) {
    $('.personal-area__register').css('display', 'none');
}


document.addEventListener("DOMContentLoaded", () => {
    fadin('.fade')
});

