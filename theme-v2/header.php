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

<!-- ══ TOPBAR ══ -->
<div class="topbar">
  🚚 משלוח חינם בקנייה מעל ₪500 &nbsp;|&nbsp; 🔧 כלי עבודה מקצועיים &nbsp;|&nbsp; 📞 <a href="tel:052-422-2910">052-422-2910</a>
</div>

<!-- ══ HEADER ══ -->
<header id="site-header">
  <div class="header-inner">

    <!-- לוגו -->
    <a href="<?php echo home_url('/'); ?>" class="logo-wrap" aria-label="בר-אל אופיר בע״מ">
      <?php
      $logo_id = get_theme_mod('custom_logo');
      if ($logo_id) :
        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
      ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt='בר-אל אופיר בע"מ' />
      <?php else : ?>
        <div class="logo-css">
          <span class="logo-css-main">בר-<span class="logo-css-red">אל</span></span>
          <span class="logo-css-sub">אופיר בע״מ</span>
        </div>
      <?php endif; ?>
    </a>

    <!-- חיפוש -->
    <div class="search-bar" id="searchWrap">
      <input type="search" id="searchInput"
        placeholder="חפש מוצרים, מותגים, קטגוריות..."
        autocomplete="off" />
      <button type="button" id="searchSubmit" aria-label="חיפוש">🔍</button>
    </div>

    <!-- כפתורי פעולה -->
    <?php if (class_exists('WooCommerce')) : ?>
    <div class="header-actions">
      <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
         class="action-btn login" aria-label="החשבון שלי">
        👤 <span class="btn-text"><?php echo is_user_logged_in() ? 'החשבון' : 'כניסה'; ?></span>
      </a>
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
         class="action-btn cart" aria-label="עגלת קניות">
        🛒 <span class="btn-text">סל קניות</span>
        <span class="cart-count">
          <?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
        </span>
      </a>
    </div>
    <?php endif; ?>

  </div>
</header>

<!-- ══ NAV קטגוריות ══ -->
<?php barel_render_cat_nav(); ?>
