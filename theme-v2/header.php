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

    <!-- המבורגר - מובייל בלבד -->
    <button class="mob-hamburger" id="mobHam" aria-label="תפריט">
      <span></span><span></span><span></span>
    </button>

  </div>

  <div class="barel-mob-search">
    <div class="barel-search-box">
      <input type="search" placeholder='חפש מוצר, מותג...' autocomplete="off"/>
      <button type="button" class="barel-search-btn">🔍 חיפוש</button>
    </div>
  </div>

</header>

<div class="mob-drawer-overlay" id="mobOverlay"></div>
<div class="mob-drawer" id="mobDrawer">
  <div class="mob-drawer-hd">
    <span class="mob-drawer-title">תפריט ניווט</span>
    <button class="mob-drawer-close" id="mobClose">✕</button>
  </div>

  <div class="mob-menu-item" data-mob="m1">
    <div class="mob-menu-link">
      <span>🔧 כל הכלים</span><span class="mob-arr">›</span>
    </div>
    <div class="mob-sub-menu">
      <?php
      $all_cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,'orderby'=>'count','order'=>'DESC','number'=>20]);
      if (!is_wp_error($all_cats)) foreach($all_cats as $cat) {
        if ($cat->slug === 'uncategorized') continue;
        echo '<a href="'.esc_url(get_term_link($cat)).'" class="mob-sub-link">'.esc_html($cat->name).' <span style="font-size:10px;color:#bbb;margin-right:auto">'.$cat->count.'</span></a>';
      }
      ?>
      <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="mob-sub-see-all">← לכל הכלים</a>
    </div>
  </div>

  <?php
  $main_cats = [
    ['name'=>'כלי עבודה חשמליים', 'icon'=>'⚡', 'slug'=>'kley-avoda-hashmaliyim'],
    ['name'=>'כלי עבודה ידניים',  'icon'=>'🔨', 'slug'=>'kley-avoda-yadaniyim'],
    ['name'=>'הטמבוריה',           'icon'=>'🏪', 'slug'=>'tamboria'],
  ];
  foreach($main_cats as $i => $mc):
    $term = get_term_by('slug', $mc['slug'], 'product_cat');
    $children = $term ? get_terms(['taxonomy'=>'product_cat','parent'=>$term->term_id,'hide_empty'=>true]) : [];
    if (!$term) continue;
  ?>
  <div class="mob-menu-item" data-mob="m<?php echo $i+2; ?>">
    <div class="mob-menu-link">
      <span><?php echo $mc['icon'].' '.esc_html($mc['name']); ?></span><span class="mob-arr">›</span>
    </div>
    <div class="mob-sub-menu">
      <?php foreach((array)$children as $child): if (is_wp_error($child)) continue; ?>
        <a href="<?php echo esc_url(get_term_link($child)); ?>" class="mob-sub-link">
          <?php echo esc_html($child->name); ?>
          <span style="font-size:10px;color:#bbb;margin-right:auto"><?php echo $child->count; ?></span>
        </a>
      <?php endforeach; ?>
      <a href="<?php echo esc_url(get_term_link($term)); ?>" class="mob-sub-see-all">← לכל <?php echo esc_html($mc['name']); ?></a>
    </div>
  </div>
  <?php endforeach; ?>

  <div class="mob-menu-item">
    <a href="<?php echo esc_url(add_query_arg('orderby','date',get_permalink(wc_get_page_id('shop')))); ?>" class="mob-menu-link sale">
      <span>🔥 מבצעים</span>
    </a>
  </div>
</div>

<?php barel_render_cat_nav(); ?>
