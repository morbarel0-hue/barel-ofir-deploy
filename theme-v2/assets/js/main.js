/**
 * בר-אל אופיר v2 — main.js
 */

(function ($) {
  'use strict';

  /* =========================================================
     1. HEADER SCROLL SHADOW
     ========================================================= */
  var header = document.getElementById('site-header');

  if (header) {
    var scrollHandler = function () {
      if (window.scrollY > 10) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    };

    window.addEventListener('scroll', scrollHandler, { passive: true });
    scrollHandler(); // run on load
  }

  /* =========================================================
     2. MOBILE MENU TOGGLE
     ========================================================= */
  var mobileMenu    = document.getElementById('mobile-menu');
  var mobileOverlay = document.getElementById('mobile-menu-overlay');
  var menuToggle    = document.getElementById('mobile-menu-toggle');
  var menuClose     = document.getElementById('mobile-menu-close');

  function openMobileMenu() {
    if (!mobileMenu) return;
    mobileMenu.classList.add('is-open');
    mobileMenu.setAttribute('aria-hidden', 'false');
    if (mobileOverlay) mobileOverlay.classList.add('is-active');
    if (menuToggle) {
      menuToggle.classList.add('is-active');
      menuToggle.setAttribute('aria-expanded', 'true');
    }
    document.body.style.overflow = 'hidden';
  }

  function closeMobileMenu() {
    if (!mobileMenu) return;
    mobileMenu.classList.remove('is-open');
    mobileMenu.setAttribute('aria-hidden', 'true');
    if (mobileOverlay) mobileOverlay.classList.remove('is-active');
    if (menuToggle) {
      menuToggle.classList.remove('is-active');
      menuToggle.setAttribute('aria-expanded', 'false');
    }
    document.body.style.overflow = '';
  }

  if (menuToggle) menuToggle.addEventListener('click', openMobileMenu);
  if (menuClose)  menuClose.addEventListener('click', closeMobileMenu);
  if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);

  // Close on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMobileMenu();
  });

  /* =========================================================
     3. CART AJAX FRAGMENT REFRESH
     ========================================================= */
  $(document.body).on('added_to_cart removed_from_cart', function () {
    $.ajax({
      url: (typeof wc_cart_fragments_params !== 'undefined') ? wc_cart_fragments_params.wc_ajax_url.replace('%%endpoint%%', 'get_refreshed_fragments') : '',
      type: 'POST',
      success: function (data) {
        if (data && data.fragments) {
          $.each(data.fragments, function (key, value) {
            $(key).replaceWith(value);
          });
        }
      }
    });
  });

  /* =========================================================
     4. SMOOTH SCROLL FOR ANCHOR LINKS
     ========================================================= */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var href = this.getAttribute('href');
      if (href === '#') return;

      var target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        var headerHeight = header ? header.offsetHeight : 0;
        var catNavHeight = document.querySelector('.cat-nav-wrap') ? document.querySelector('.cat-nav-wrap').offsetHeight : 0;
        var offset = headerHeight + catNavHeight + 16;
        var top = target.getBoundingClientRect().top + window.scrollY - offset;

        window.scrollTo({ top: top, behavior: 'smooth' });
      }
    });
  });

  /* =========================================================
     5. PRODUCT IMAGE LAZY LOAD OBSERVER
     ========================================================= */
  if ('IntersectionObserver' in window) {
    var lazyImages = document.querySelectorAll('img[loading="lazy"]');
    var imageObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          imageObserver.unobserve(entry.target);
        }
      });
    }, { rootMargin: '200px 0px' });

    lazyImages.forEach(function (img) {
      imageObserver.observe(img);
    });
  }

  /* =========================================================
     6. ADD TO CART BUTTON FEEDBACK
     ========================================================= */
  $(document.body).on('click', '.add_to_cart_button', function () {
    var $btn = $(this);
    $btn.addClass('loading');
  });

  $(document.body).on('added_to_cart', function (e, fragments, cart_hash, $btn) {
    if ($btn) {
      $btn.removeClass('loading').addClass('added');
      setTimeout(function () {
        $btn.removeClass('added');
      }, 2000);
    }
  });

  /* =========================================================
     7. STICKY HEADER HEIGHT CSS VAR UPDATE
     ========================================================= */
  function updateHeaderHeightVar() {
    if (header) {
      var topbar = document.querySelector('.topbar');
      var topbarH = topbar ? topbar.offsetHeight : 0;
      document.documentElement.style.setProperty('--topbar-h', topbarH + 'px');
    }
  }

  window.addEventListener('resize', updateHeaderHeightVar, { passive: true });
  updateHeaderHeightVar();

})(jQuery);
