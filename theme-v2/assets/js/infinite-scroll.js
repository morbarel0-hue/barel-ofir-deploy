/**
 * Barel Ofir - Infinite Scroll
 */
(function($) {
  'use strict';
  if (!window.BarelInfinite) return;
  var maxPages  = parseInt(BarelInfinite.maxPages, 10) || 1;
  var currPage  = parseInt(BarelInfinite.currPage, 10) || 1;
  var isLoading = false;
  var $grid     = $('#productsGrid');
  var $sentinel = $('#infiniteScrollSentinel');
  var $spinner  = $('#infiniteSpinner');
  if (!$grid.length || maxPages <= 1) return;

  function getPageUrl(page) {
    var url = window.location.href.replace(/\/page\/\d+\/?/, '/').replace(/\?.*$/, '');
    var qs  = window.location.search;
    if (page > 1) url = url.replace(/\/$/, '') + '/page/' + page + '/';
    return url + qs;
  }

  function loadNextPage() {
    if (isLoading || currPage >= maxPages) return;
    isLoading = true; currPage++;
    $spinner.show();
    $.ajax({ url: getPageUrl(currPage), success: function(html) {
      var $newCards = $($.parseHTML(html, document, true)).find('#productsGrid .prod-card');
      if ($newCards.length) {
        $newCards.css('opacity', 0);
        $grid.append($newCards);
        $newCards.animate({ opacity: 1 }, 300);
        $newCards.find('.prod-atc').on('click', handleATC);
        $newCards.find('.prod-wishlist').on('click', handleWishlist);
      }
      $spinner.hide(); isLoading = false;
      if (currPage >= maxPages) { $sentinel.remove(); $grid.after('<div class="infinite-end">סוף הרשימה</div>'); }
    }, error: function() { $spinner.hide(); isLoading = false; currPage--; } });
  }

  function handleATC() {
    var $btn = $(this), pid = $btn.data('product-id');
    if (!pid) return;
    $btn.prop('disabled', true).text('...');
    $.post(BarelData.ajaxUrl, { action: 'barel_add_to_cart', product_id: pid, quantity: 1, nonce: BarelData.nonce }, function(r) {
      $btn.prop('disabled', false).text('+ עגלה');
      if (r.success) { $('.cart-n').text(r.data.count); }
    });
  }

  function handleWishlist() {
    var $btn = $(this), pid = $btn.data('id');
    $.post(BarelData.ajaxUrl, { action: 'barel_toggle_wishlist', product_id: pid, nonce: BarelData.nonce }, function(r) {
      if (r.success) { $btn.text(r.data.added ? String.fromCharCode(9829) : String.fromCharCode(9825)); }
    });
  }

  if ('IntersectionObserver' in window) {
    var obs = new IntersectionObserver(function(entries) {
      if (entries[0].isIntersecting && !isLoading && currPage < maxPages) loadNextPage();
    }, { rootMargin: '0px 0px 400px 0px', threshold: 0.1 });
    if ($sentinel.length) obs.observe($sentinel[0]);
  } else {
    $(window).on('scroll.barel_infinite', function() {
      if (isLoading || currPage >= maxPages) return;
      if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) loadNextPage();
    });
  }

  $grid.find('.prod-atc').on('click', handleATC);
  $grid.find('.prod-wishlist').on('click', handleWishlist);
})(jQuery);
