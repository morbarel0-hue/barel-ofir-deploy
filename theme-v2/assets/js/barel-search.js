/* Barel Ofir – Real AJAX Search (overrides mock data in main.js) */
(function() {
  'use strict';
  if (!window.BarelData) return;
  document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('searchInput');
    var dropdown = document.getElementById('searchDropdown');
    if (!input || !dropdown) return;
    /* Clone to strip mock event listeners */
    var ni = input.cloneNode(true);
    input.parentNode.replaceChild(ni, input);
    input = ni;
    var timer = null;
    input.addEventListener('input', function(e) {
      var q = e.target.value.trim();
      var cb = document.getElementById('searchClear');
      if (cb) cb.classList.toggle('visible', q.length > 0);
      clearTimeout(timer);
      if (!q) { dropdown.classList.remove('open'); return; }
      timer = setTimeout(function() { doSearch(q); }, 280);
    });
    input.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        var q = input.value.trim();
        if (q) location.href = '/shop/?s=' + encodeURIComponent(q);
      } else if (e.key === 'Escape') {
        dropdown.classList.remove('open');
      }
    });
    var submitBtn = document.getElementById('searchSubmit');
    if (submitBtn) { submitBtn.addEventListener('click', function() {
      var q = input.value.trim();
      if (q) location.href = '/shop/?s=' + encodeURIComponent(q);
    }); }
    function doSearch(q) {
      dropdown.innerHTML = '<div class="sd-loading"><div class="sd-spinner"></div> מחפש...</div>';
      dropdown.classList.add('open');
      var url = BarelData.ajaxUrl + '?action=barel_search&q=' + encodeURIComponent(q) + '&nonce=' + BarelData.nonce;
      fetch(url).then(function(r){return r.json();}).then(function(data){
        if (!data.success || (!data.data.products.length && !data.data.cats.length)) {
          dropdown.innerHTML = '<div class="sd-no-results">לא נמצאו תוצאות עבור "' + q + '"</div>';
          return;
        }
        renderResults(data.data, q);
      }).catch(function(){});
    }
    function renderResults(data, q) {
      var html = '';
      if (data.cats && data.cats.length) {
        html += '<div class="sd-section"><div class="sd-section-title">קטגוריות</div><div class="sd-cats">';
        data.cats.forEach(function(c) {
          html += '<a class="sd-cat-chip" href="'+c.url+'"><span class="sd-cat-chip-icon">📁</span>'+c.name+'</a>';
        });
        html += '</div></div>';
      }
      if (data.products && data.products.length) {
        var seeAll = '/shop/?s='+encodeURIComponent(q);
        html += '<div class="sd-section"><div class="sd-section-title">מוצרים <a href="'+seeAll+'">כל התוצאות</a></div>';
        data.products.forEach(function(p) {
          var img = p.img ? '<img src="'+p.img+'" alt="">' : '<span style="font-size:24px">📦</span>';
          html += '<a class="sd-prod" href="'+p.url+'">'
                + '<div class="sd-prod-img">'+img+'</div>'
                + '<div class="sd-prod-info"><div class="sd-prod-name">'+p.name+'</div>'
                + '<div class="sd-prod-brand">'+(p.brand||'')+'</div></div>'
                + '<div class="sd-prod-price">'+p.price+'</div></a>';
        });
        html += '</div>';
      }
      dropdown.innerHTML = html;
    }
    document.addEventListener('click', function(e) {
      var wrap = document.getElementById('searchWrap');
      if (wrap && !wrap.contains(e.target)) dropdown.classList.remove('open');
    });
  });
})();
