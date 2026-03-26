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

<div class="barel-topbar">
  <div class="barel-topbar-inner">
    <span>🚚 משלוחים מהירים עד 7 ימי עסקים</span>
    <span class="barel-sep">|</span>
    <span>🔒 תשלום מאובטח SSL ע"י בנק לאומי</span>
    <span class="barel-sep">|</span>
    <span>📞 <a href="tel:052-422-2910">052-422-2910</a></span>
  </div>
</div>

<header id="barel-header">
  <div class="barel-hdr-inner">

    <a href="<?php echo home_url('/'); ?>" class="barel-logo">
      <div class="barel-logo-main">
        <span class="bl-black">בר-אל </span><span class="bl-red">אופיר</span>
      </div>
      <span class="barel-logo-sub">בע״מ · כלי עבודה מקצועיים</span>
    </a>

    <div class="barel-search-wrap" id="searchWrap">
      <div class="barel-search-box">
        <input type="search" id="searchInput" autocomplete="off"
          placeholder='חפש מוצר, מותג, מק"ט...'/>
        <button type="button" id="searchSubmit" class="barel-search-btn">🔍 חיפוש</button>
      </div>
      <div class="barel-search-dropdown" id="searchDropdown"></div>
    </div>

    <div class="barel-acts">
      <?php if (class_exists('WooCommerce')): ?>
      <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="barel-act">
        <span class="barel-act-ic">👤</span>
        <span class="barel-act-lbl"><?php echo is_user_logged_in() ? 'החשבון' : 'כניסה'; ?></span>
      </a>
      <a href="#" class="barel-act">
        <span class="barel-act-ic">❤️</span>
        <span class="barel-act-lbl">מועדפים</span>
      </a>
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="barel-cart">
        🛒 עגלה
        <span class="barel-cart-b">
          <?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
        </span>
      </a>
      <?php endif; ?>
    </div>

  </div>

  <div class="barel-mob-search">
    <div class="barel-search-box">
      <input type="search" placeholder='חפש מוצר, מותג...' autocomplete="off"/>
      <button type="button" class="barel-search-btn">🔍 חיפוש</button>
    </div>
  </div>

</header>

<?php barel_render_cat_nav(); ?>
