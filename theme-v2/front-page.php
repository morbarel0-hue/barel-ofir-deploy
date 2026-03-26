<?php
/**
 * Homepage Template — matches barel-homepage.html original design
 */
get_header();
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
?>

<!-- HERO -->
<section class="hero" aria-label="באנר ראשי">
  <div class="hero-inner">

    <div class="hero-main">
      <span class="hero-eyebrow">✦ בר-אל אופיר בע״מ – הבית של אנשי המקצוע</span>
      <h1 class="hero-title">כלי עבודה מקצועיים.<br /><span>מחיר שמגיע לך.</span></h1>
      <p class="hero-desc">
        אלפי כלי עבודה ממותגים מובילים – Worx, Kress, Hunter Tools, Signet ועוד.
        הכל במקום אחד, עם משלוח מהיר לכל הארץ.
      </p>
      <div class="hero-ctas">
        <a href="<?php echo esc_url($shop_url); ?>" class="btn-primary">🔧 לכל המוצרים</a>
        <a href="<?php echo esc_url(add_query_arg('orderby', 'sale', $shop_url)); ?>" class="btn-ghost">מבצעי השבוע →</a>
      </div>
    </div>

    <div class="hero-side">
      <a href="<?php echo esc_url(add_query_arg('product_cat', 'hunter-tools', $shop_url)); ?>" class="side-banner s1">
        <div class="side-banner-tag">🔥 מבצע השבוע</div>
        <div class="side-banner-title">Hunter Tools<br />עד 40% הנחה</div>
        <div class="side-banner-sub">על סדרת הקורדלס המלאה</div>
        <div class="side-banner-link">לכל המבצעים →</div>
        <div class="side-banner-icon">⚡</div>
      </a>
      <a href="<?php echo esc_url(add_query_arg('product_cat', 'mevragot', $shop_url)); ?>" class="side-banner s2">
        <div class="side-banner-tag">🔴 מחירי חיסול</div>
        <div class="side-banner-title">מברגות<br />במחירי חיסול</div>
        <div class="side-banner-sub">מלאי מוגבל – תפסו לפני שנגמר</div>
        <div class="side-banner-link">לכל המברגות →</div>
        <div class="side-banner-icon">🪛</div>
      </a>
    </div>

  </div>
</section>

<!-- TRUST BAR -->
<div class="trust-bar" aria-label="יתרונות רכישה">
  <div class="trust-inner">
    <div class="trust-item">
      <div class="trust-ic">🚚</div>
      <div>
        <div class="trust-title">משלוחים מהירים</div>
        <div class="trust-sub">עד 7 ימי עסקים לכל הארץ</div>
      </div>
    </div>
    <div class="trust-item">
      <div class="trust-ic">🔄</div>
      <div>
        <div class="trust-title">החזרה תוך 30 יום</div>
        <div class="trust-sub">ללא שאלות, ללא טרחה</div>
      </div>
    </div>
    <div class="trust-item">
      <div class="trust-ic">🛡️</div>
      <div>
        <div class="trust-title">תשלום מאובטח</div>
        <div class="trust-sub">תעודת SSL מוגנת</div>
      </div>
    </div>
    <div class="trust-item">
      <div class="trust-ic">🏆</div>
      <div>
        <div class="trust-title">15+ שנות ניסיון</div>
        <div class="trust-sub">אלפי לקוחות מרוצים</div>
      </div>
    </div>
  </div>
</div>

<?php
// Show most-populated sub-categories (exclude root containers + uncategorized)
$_top = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,'fields'=>'ids']);
$_exclude = array_merge($_top, [1424]);
$cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => $_exclude, 'depth' => 1]);
if (is_wp_error($cats) || count($cats) < 2) {
  // fallback: show any top categories
  $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => [1424]]);
}
$cat_icons = [
  'כלי עבודה ידניים' => '🔨', 'כלי יד' => '🔨', 'ידניים' => '🔨',
  'כלי עבודה חשמליים' => '🔌', 'חשמליים' => '🔌', 'חשמל' => '⚡', 'אלקטרוניקה' => '⚡',
  'כלי מדידה' => '📐', 'מדידה' => '📐',
  'גינון' => '🌿', 'גן' => '🌿',
  'אינסטלציה' => '🚿', 'ברזים' => '🚿', 'אמבטיה' => '🛁',
  'בטיחות' => '🦺', 'ציוד מגן' => '🦺',
  'מסורים' => '🪚', 'מסור' => '🪚',
  'מברגות' => '🪛', 'ברגים' => '🔩',
  'צביעה' => '🎨', 'צבע' => '🎨',
  'ניקיון' => '🧹', 'ניקוי' => '🧹',
  'דבקים' => '🔗', 'הדברה' => '🐛',
  'אחסון' => '🧰', 'ארגזים' => '🧰',
  'תאורה' => '💡', 'נורות' => '💡',
  'כבלים' => '🔋', 'מאריכים' => '🔋',
];
if (!is_wp_error($cats) && count($cats)): ?>
<section class="section" aria-labelledby="cats-title">
  <div class="section-head">
    <div class="section-head-left">
      <h2 class="section-title" id="cats-title">קנה לפי קטגוריה</h2>
      <div class="section-sub">כל סוג כלי עבודה – תחת קורף אחד</div>
    </div>
    <a href="<?php echo esc_url($shop_url); ?>" class="see-all" aria-label="לכל הקטגוריות">כל הקטגוריות →</a>
  </div>
  <div class="cats-grid">
    <?php foreach ($cats as $cat):
      if ($cat->slug === 'uncategorized') continue;
      // pick best matching icon
      $icon = '🛠️';
      foreach ($cat_icons as $kw => $ic) {
        if (mb_strpos($cat->name, $kw) !== false) { $icon = $ic; break; }
      }
    ?>
      <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="cat-card">
        <div class="cat-icon" aria-hidden="true"><?php echo $icon; ?></div>
        <div class="cat-name"><?php echo esc_html($cat->name); ?></div>
        <div class="cat-count"><?php echo $cat->count; ?>+ מוצרים</div>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php
// Filter products to כלי עבודה (123) and all children only
$_tool_cat_ids = array_merge([123], get_term_children(123, 'product_cat'));
$_tool_tax_q = [['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $_tool_cat_ids, 'operator' => 'IN']];

$bestsellers = (new WP_Query(['post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 8, 'orderby' => 'meta_value_num', 'meta_key' => 'total_sales', 'order' => 'DESC', 'tax_query' => $_tool_tax_q, 'fields' => 'ids']))->posts;
if ($bestsellers): ?>
<section class="section" style="padding-top:0" aria-labelledby="bestsellers-title">
  <div class="section-head">
    <div class="section-head-left">
      <h2 class="section-title" id="bestsellers-title">הנמכרים ביותר</h2>
      <div class="section-sub">המוצרים שאנשי המקצוע בוחרים</div>
    </div>
    <a href="<?php echo esc_url(add_query_arg('orderby', 'popularity', $shop_url)); ?>" class="see-all">כל המוצרים →</a>
  </div>
  <div class="products-grid">
    <?php foreach ($bestsellers as $pid) { barel_render_product_card($pid); } ?>
  </div>
</section>
<?php endif; ?>

<!-- PROMOTIONAL BANNERS -->
<div class="promo-banners">
  <a href="<?php echo esc_url(add_query_arg('product_cat', 'mevragot', $shop_url)); ?>" class="promo-banner b1">
    <div class="promo-tag">⚡ מחירי חיסול</div>
    <h2 class="promo-title">מברגות במחירים<br>שלא יחזרו</h2>
    <p class="promo-sub">מלאי מוגבל – תפסו לפני שנגמר!</p>
    <span class="promo-cta">לכל המברגות →</span>
  </a>
  <a href="<?php echo esc_url($shop_url); ?>" class="promo-banner b2">
    <div class="promo-tag">⚡ מחירי פצצה</div>
    <h2 class="promo-title">מבצעי סוף עונה</h2>
    <p class="promo-sub">עד 50% הנחה על מותגים נבחרים</p>
    <span class="promo-cta">לכל המבצעים →</span>
  </a>
</div>

<?php
$new_products = (new WP_Query(['post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 8, 'orderby' => 'date', 'order' => 'DESC', 'tax_query' => $_tool_tax_q, 'fields' => 'ids']))->posts;
if ($new_products): ?>
<section class="section" aria-labelledby="new-title">
  <div class="section-head">
    <div class="section-head-left">
      <h2 class="section-title" id="new-title">חדש במלאי</h2>
      <div class="section-sub">הגיע עכשיו לחנות</div>
    </div>
    <a href="<?php echo esc_url(add_query_arg('orderby', 'date', $shop_url)); ?>" class="see-all">לכל החדש →</a>
  </div>
  <div class="products-grid">
    <?php foreach ($new_products as $pid) { barel_render_product_card($pid); } ?>
  </div>
</section>
<?php endif; ?>

<?php
$_all_sale = wc_get_product_ids_on_sale();
$sale_ids = [];
if (!empty($_all_sale)) {
  $_sq = new WP_Query(['post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 8, 'post__in' => $_all_sale, 'orderby' => 'rand', 'tax_query' => $_tool_tax_q, 'fields' => 'ids']);
  $sale_ids = $_sq->posts;
}
if ($sale_ids):
?>
<section class="section" aria-labelledby="sale-title">
  <div class="section-head">
    <div class="section-head-left">
      <h2 class="section-title" id="sale-title">🔥 במבצע עכשיו</h2>
      <div class="section-sub">הזדמנויות מוגבלות</div>
    </div>
    <a href="<?php echo esc_url($shop_url); ?>" class="see-all">לכל המבצעים →</a>
  </div>
  <div class="products-grid">
    <?php foreach ($sale_ids as $pid) { barel_render_product_card($pid); } ?>
  </div>
</section>
<?php endif; ?>

<section class="brands-section">
  <div class="brands-inner">
    <div class="brands-title">המותגים שאנחנו נושאים</div>
    <div class="brands-row">
      <div class="brand-item">DeWalt</div>
      <div class="brand-item">Bosch</div>
      <div class="brand-item">Makita</div>
      <div class="brand-item">Kress</div>
      <div class="brand-item">Worx</div>
      <div class="brand-item">Stanley</div>
      <div class="brand-item">Hunter Tools</div>
      <div class="brand-item">Signet</div>
    </div>
  </div>
</section>

<section class="cta-banner">
  <div class="cta-inner">
    <h2>צריך עזרה בבחירה?</h2>
    <p>הצוות המקצועי שלנו כאן לעזור לך למצוא את הכלי המתאים.</p>
    <div class="cta-btns">
      <a href="https://wa.me/972524222910" class="btn-primary" target="_blank" rel="noopener">💬 WhatsApp</a>
      <a href="tel:052-422-2910" class="btn-outline">📞 התקשר עכשיו</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
