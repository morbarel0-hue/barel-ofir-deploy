<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOPBAR -->
<div class="barel-topbar">
  🚚 משלוחים מהירים עד 7 ימי עסקים &nbsp;|&nbsp; 🔒 תשלום מאובטח SSL &nbsp;|&nbsp; 📞 שירות לקוחות: <a href="tel:">התקשרו אלינו</a>
</div>

<!-- HEADER -->
<header class="barel-header" id="barel-header">
  <div class="barel-header-inner">

    <!-- LOGO -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="barel-logo" aria-label="<?php bloginfo('name'); ?> - דף הבית">
      <?php if (has_custom_logo()): ?>
        <?php the_custom_logo(); ?>
      <?php else: ?>
        <div class="barel-logo-wrap">
          <div class="barel-logo-text">בר-אל</div>
          <div class="barel-logo-sub">אופיר בע״מ</div>
        </div>
      <?php endif; ?>
    </a>

    <!-- SEARCH -->
    <div class="barel-search-wrap">
      <?php get_search_form(); ?>
    </div>

    <!-- ACTIONS -->
    <nav class="barel-nav-actions" aria-label="פעולות משתמש">
      <?php if (class_exists('WooCommerce')): ?>
        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="barel-nav-act">
          <span class="barel-ic">👤</span>
          <span><?php is_user_logged_in() ? _e('החשבון שלי') : _e('כניסה'); ?></span>
        </a>
      <?php endif; ?>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="barel-nav-act">
        <span class="barel-ic">📞</span>
        <span>צור קשר</span>
      </a>
      <?php if (class_exists('WooCommerce')): ?>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="barel-cart-btn" aria-label="עגלת קניות">
          <span>🛒</span>
          עגלה
          <span class="barel-cart-count"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?></span>
        </a>
      <?php endif; ?>
    </nav>

  </div>
</header>

<!-- CATEGORY NAV -->
<?php if (function_exists('barel_render_cat_nav')) barel_render_cat_nav(); ?>
