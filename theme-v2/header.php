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
<div class="topbar" style="background:#c0001a;color:#fff;text-align:center;font-size:13px;font-weight:600;padding:8px 0;width:100%;overflow:hidden;">
  <div style="max-width:1280px;margin:0 auto;padding:0 20px;display:flex;align-items:center;justify-content:center;gap:32px;flex-wrap:nowrap;">
    <span>📞 052-422-2910</span>
    <span>|</span>
    <span>🚚 משלוח מהיר תוך 3-5 ימים</span>
    <span>|</span>
    <span>✈️ משלוח חינם בקנייה מעל ₪299</span>
  </div>
</div>

<!-- HEADER -->
<header id="site-header">
  <div class="header-inner">
    <a href="<?php echo home_url(); ?>" class="site-logo" aria-label="בר-אל אופיר בע״מ">
      <div class="logo-wrap">
        <span class="logo-main">בר<span class="logo-dash">-</span>אל</span>
        <span class="logo-sub">אופיר בע״מ</span>
      </div>
    </a>
    <div class="search-wrap">
      <?php get_search_form(); ?>
    </div>
    <nav class="nav-acts" aria-label="פעולות משתמש">
      <a href="tel:052-422-2910" class="nav-act" aria-label="התקשר אלינו">
        <span class="ic">📞</span><span>052-422-2910</span>
      </a>
      <?php if (class_exists('WooCommerce')): ?>
        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="nav-act" aria-label="החשבון שלי">
          <span class="ic">👤</span>
          <span><?php echo is_user_logged_in() ? 'החשבון שלי' : 'כניסה'; ?></span>
        </a>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-btn" aria-label="עגלת קניות">
          <span>🛒</span>
          <span class="cart-n"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?></span>
          <span>עגלה</span>
        </a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<!-- CATEGORY NAV -->
<?php barel_render_cat_nav(); ?>
