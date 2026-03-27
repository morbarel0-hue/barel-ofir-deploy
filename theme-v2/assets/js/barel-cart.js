/* barel-cart.js — cart counter update */
(function($) {
  'use strict';

  function updateCounter(count) {
    $('.barel-cart-b, .cart-n, .cart-count, .barel-cart-count').text(count);
  }

  function refreshFragments() {
    $.get('/?wc-ajax=get_refreshed_fragments', function(data) {
      if (data && data.fragments) {
        $.each(data.fragments, function(key, val) {
          $(key).replaceWith(val);
        });
      }
    });
  }

  // ── Handle .prod-atc (grid) and .atc-btn (product page) ──
  $(document).on('click', '.prod-atc, .atc-btn', function(e) {
    e.preventDefault();
    var $btn = $(this);
    if ($btn.hasClass('loading')) return;

    var pid   = $btn.data('product-id');
    var nonce = $btn.data('nonce');
    if (!pid) return;

    $btn.data('orig-text', $btn.text()).addClass('loading').text('...');

    $.post(
      (typeof BarelData !== 'undefined' ? BarelData.ajaxUrl : '/wp-admin/admin-ajax.php'),
      {
        action:     'barel_add_to_cart',
        product_id: pid,
        quantity:   1,
        nonce:      nonce || (typeof BarelData !== 'undefined' ? BarelData.nonce : '')
      },
      function(res) {
        $btn.removeClass('loading');
        var origText = $btn.data('orig-text') || $btn.text();
        $btn.data('orig-text', origText);
        if (res && res.success) {
          $btn.text('\u2713 \u05e0\u05d5\u05e1\u05e3'); // ✓ נוסף
          updateCounter(res.data.count);
          setTimeout(function() { $btn.text(origText); }, 2000);
          refreshFragments();
        } else {
          $btn.text(origText);
        }
      }
    ).fail(function() {
      var origText = $btn.data('orig-text') || $btn.text();
      $btn.removeClass('loading').text(origText);
    });
  });

  // ── Handle WooCommerce added_to_cart (product page) ──
  $(document.body).on('added_to_cart', function(e, fragments) {
    if (fragments) {
      $.each(fragments, function(key, val) {
        $(key).replaceWith(val);
      });
    }
    setTimeout(refreshFragments, 300);
  });

  $(document.body).on('wc_fragments_refreshed', function() {
    // WC already applied fragments
  });

})(jQuery);
