<?php defined('ABSPATH') || exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOPBAR -->
<div class="topbar">
  🚚 משלוחים מהירים עד 7 ימי עסקים &nbsp;|&nbsp;
  🔒 תשלום מאובטח SSL ע"י בנק לאומי &nbsp;|&nbsp;
  📞 <a href="tel:052-422-2910">052-422-2910</a>
</div>

<!-- HEADER -->
<header id="site-header">
  <div class="header-inner">

    <!-- לוגו - ימין -->
    <a href="<?php echo home_url('/'); ?>" class="barel-logo" aria-label="בר-אל אופיר">
      <div class="barel-logo-wrap">
        <span class="barel-logo-main">בר-<span class="barel-logo-dash">אל</span></span>
        <span class="barel-logo-sub">אופיר בע״מ</span>
      </div>
    </a>

    <!-- חיפוש - אמצע -->
    <div class="search-wrap" id="searchWrap">
      <div class="search-bar">
        <button class="search-btn" type="button" id="searchSubmit">🔍 חיפוש</button>
        <input type="search" id="searchInput"
          placeholder='חפש מוצר, מותג, מק"ט...'
          autocomplete="off"/>
        <button class="search-clear" id="searchClear" type="button">✕</button>
      </div>
      <div class="search-dropdown" id="searchDropdown"></div>
    </div>
    <div class="search-overlay" id="searchOverlay"></div>

    <!-- אייקונים - שמאל -->
    <div class="nav-actions">
      <?php if (class_exists('WooCommerce')): ?>
      <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
         class="nav-action" aria-label="החשבון שלי">
        <span class="icon">👤</span>
        <span><?php echo is_user_logged_in() ? 'החשבון' : 'כניסה'; ?></span>
      </a>
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
         class="cart-btn" aria-label="עגלת קניות">
        🛒 עגלה
        <span class="cart-count">
          <?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
        </span>
      </a>
      <?php endif; ?>
    </div>

  </div>
</header>

<!-- שורת חיפוש מובייל -->
<div class="mobile-search-bar">
  <div class="search-bar" style="width:100%">
    <button class="search-btn" type="button">🔍</button>
    <input type="search" placeholder='חפש מוצר, מותג...' autocomplete="off"/>
  </div>
</div>

<?php barel_render_cat_nav(); ?>
