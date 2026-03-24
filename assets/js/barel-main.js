/**
 * barel-ofir Main JavaScript
 * https://barelofir.co.il
 */
(function($) {
    'use strict';

    // ── Cart count update ─────────────────────────────────
    $(document.body).on('wc_fragments_refreshed wc_fragments_loaded', function() {
        var count = $('.barel-cart-count').text();
        if (count) {
            $('.barel-cart-count').text(count);
        }
    });

    // ── Sticky header shadow ──────────────────────────────
    $(window).on('scroll', function() {
        var header = $('.barel-header');
        if ($(this).scrollTop() > 80) {
            header.addClass('barel-scrolled');
        } else {
            header.removeClass('barel-scrolled');
        }
    });

    // ── Search bar focus ──────────────────────────────────
    $('.barel-search-bar input').on('focus', function() {
        $(this).closest('.barel-search-bar').addClass('focused');
    }).on('blur', function() {
        $(this).closest('.barel-search-bar').removeClass('focused');
    });

    // ── Mobile menu ───────────────────────────────────────
    $('.barel-menu-toggle').on('click', function() {
        $('.barel-mobile-menu').toggleClass('open');
        $(this).toggleClass('active');
    });

    // ── Qty buttons ───────────────────────────────────────
    $(document).on('click', '.qty-btn', function() {
        var $input = $(this).siblings('.qty-num, input.qty');
        var val = parseInt($input.val()) || 1;
        if ($(this).text() === '+') {
            $input.val(val + 1).trigger('change');
        } else if (val > 1) {
            $input.val(val - 1).trigger('change');
        }
    });

    // ── Product image gallery ─────────────────────────────
    $(document).on('click', '.thumb', function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });

    // ── Back to top ───────────────────────────────────────
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 500) {
            $('.barel-back-top').fadeIn();
        } else {
            $('.barel-back-top').fadeOut();
        }
    });
    $(document).on('click', '.barel-back-top', function() {
        $('html, body').animate({scrollTop: 0}, 300);
    });

    // ── WooCommerce AJAX add to cart notification ─────────
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
        var productName = $button.closest('.product').find('.woocommerce-loop-product__title').text();
        if (productName) {
            showNotification('✅ ' + productName + ' נוסף לעגלה!');
        }
    });

    function showNotification(msg) {
        var $n = $('<div class="barel-notification">' + msg + '</div>');
        $('body').append($n);
        setTimeout(function() { $n.addClass('show'); }, 10);
        setTimeout(function() { $n.removeClass('show'); setTimeout(function() { $n.remove(); }, 300); }, 3000);
    }

    // ── Init ──────────────────────────────────────────────
    $(document).ready(function() {
        // Add notification styles if not present
        if (!$('#barel-notification-style').length) {
            $('<style id="barel-notification-style">.barel-notification{position:fixed;bottom:24px;right:24px;background:#111;color:#fff;padding:12px 20px;border-radius:8px;font-family:"Heebo",sans-serif;font-size:14px;font-weight:600;z-index:9999;opacity:0;transform:translateY(12px);transition:all .3s;box-shadow:0 4px 16px rgba(0,0,0,.2)}.barel-notification.show{opacity:1;transform:translateY(0)}.barel-scrolled{box-shadow:0 4px 20px rgba(0,0,0,.15)!important}</style>').appendTo('head');
        }
    });

})(jQuery);
