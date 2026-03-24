<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#c0001a">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOPBAR -->
<div class="barel-topbar">
  🚚 משלוחים מהירים לכל הארץ &nbsp;|&nbsp; 🔒 תשלום מאובטח SSL &nbsp;|&nbsp; 📞 <a href="tel:052-422-2910">052-422-2910</a> &nbsp;|&nbsp; ↩️ החזרה ב-30 יום
</div>

<!-- HEADER -->
<header class="barel-header" id="barel-header">
  <div class="barel-header-inner">

    <!-- LOGO -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="barel-logo" aria-label="<?php bloginfo('name'); ?> - דף הבית">
      <?php if (has_custom_logo()): the_custom_logo(); else: ?>
        <div class="barel-logo-wrap">
          <div class="barel-logo-text">בר-אל אופיר</div>
          <div class="barel-logo-sub">אספקה טכנית בע״מ</div>
        </div>
      <?php endif; ?>
    </a>

    <!-- SEARCH -->
    <div class="barel-search-wrap">
      <?php get_search_form(); ?>
    </div>

    <!-- ACTIONS -->
    <nav class="barel-nav-actions" aria-label="פעולות משתמש">
      <a href="tel:052-422-2910" class="barel-nav-act" aria-label="התקשר אלינו">
        <span class="barel-ic">📞</span>
        <span>050-422-2910</span>
      </a>
      <?php if (class_exists('WooCommerce')): ?>
        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="barel-nav-act" aria-label="חשבון">
          <span class="barel-ic">👤</span>
          <span><?php echo is_user_logged_in() ? 'החשבון שלי' : 'כניסה'; ?></span>
        </a>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="barel-nav-act barel-cart-wrap" aria-label="עגלת קניות">
          <span class="barel-ic">🛒</span>
          <span class="barel-cart-count"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?></span>
          <span>עגלה</span>
        </a>
      <?php endif; ?>
    </nav>

  </div>
</header>

<!-- CATEGORY NAV -->
<?php barel_render_cat_nav(); ?>

<script>
// Sticky header shadow on scroll
(function(){
  var h = document.getElementById('barel-header');
  if (!h) return;
  window.addEventListener('scroll', function(){
    h.classList.toggle('scrolled', window.scrollY > 10);
  }, {passive: true});
})();
</script>
