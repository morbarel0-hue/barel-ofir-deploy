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
<div class="topbar">
  ✈ משלוח חינם בקנייה מעל ₪299 &nbsp;|&nbsp; ⏱ משלוח מהיר תוך 3-5 ימים &nbsp;|&nbsp; 📞 <a href="tel:052-422-2910">052-422-2910</a>
</div>

<!-- HEADER -->
<header id="site-header">
  <div class="header-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php bloginfo('name'); ?> - דף הבית">
      <?php if (has_custom_logo()): the_custom_logo(); else: ?>
        <div class="logo-text-wrap">
          <div class="logo-text">בר-<span>אל</span> אופיר</div>
          <div class="logo-sub">אספקה טכנית בע׳מ</div>
        </div>
      <?php endif; ?>
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

<!-- MOBILE SEARCH ROW (hidden on desktop via CSS) -->
<div class="mobile-search-row">
  <input type="search" placeholder="חפש מוצר, מותג, מק&quot;ט..." name="s" />
  <button type="submit" onclick="this.closest('div').querySelector('input').form && this.closest('div').querySelector('input').form.submit(); window.location='/?s='+encodeURIComponent(this.previousElementSibling.value)">🔍 חיפוש</button>
</div>

<!-- CATEGORY NAV -->
<?php barel_render_cat_nav(); ?>
