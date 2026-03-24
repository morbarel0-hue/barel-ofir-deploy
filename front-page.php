<?php
/**
 * Template Name: דף הבית - עיצוב מלא
 * Homepage template for בר-אל אופיר בע"מ
 */
get_header();
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
?>

<main id="barel-main" class="barel-main">

  <!-- HERO -->
  <section class="barel-hero" aria-label="באנר ראשי">
    <div class="barel-hero-inner">
      <div class="barel-hero-main">
        <span class="barel-hero-eyebrow">✦ בר-אל אופיר בע״מ – הבית של אנשי המקצוע</span>
        <h1 class="barel-hero-title">כלי עבודה מקצועיים.<br /><span>מחיר שמגיע לך.</span></h1>
        <p class="barel-hero-desc">אלפי כלי עבודה ממותגים מובילים – DeWalt, Bosch, Makita, Stanley ועוד. הכל במקום אחד, עם משלוח מהיר לכל הארץ.</p>
        <div class="barel-hero-ctas">
          <a href="<?php echo esc_url($shop_url); ?>" class="barel-btn-primary">🔧 לכל המוצרים</a>
          <a href="<?php echo esc_url(add_query_arg('orderby', 'date', $shop_url)); ?>" class="barel-btn-ghost">מבצעי השבוע →</a>
        </div>
        <div class="barel-hero-trust">
          <span>✅ אחריות יצרן</span>
          <span>🚚 משלוח מהיר</span>
          <span>🔒 תשלום מאובטח</span>
          <span>↩️ החזרה ב-30 יום</span>
        </div>
      </div>
      <div class="barel-hero-side">
        <div class="barel-hero-card">
          <div class="barel-hero-card-icon">🔧</div>
          <div class="barel-hero-card-title">מבצע השבוע</div>
          <div class="barel-hero-card-sub">כלי חשמל DeWalt</div>
          <a href="<?php echo esc_url($shop_url); ?>" class="barel-hero-card-btn">לכל המבצעים</a>
        </div>
        <div class="barel-hero-badges">
          <div class="barel-hero-badge">⭐ 4.9 דירוג לקוחות</div>
          <div class="barel-hero-badge">🏆 15+ שנות ניסיון</div>
          <div class="barel-hero-badge">📦 +5,000 מוצרים</div>
        </div>
      </div>
    </div>
  </section>

  <!-- CATEGORIES SHOWCASE -->
  <section class="barel-cats-section">
    <div class="barel-section-inner">
      <div class="barel-section-header">
        <h2 class="barel-section-title">קטגוריות <span>ראשיות</span></h2>
        <a href="<?php echo esc_url($shop_url); ?>" class="barel-see-all">לכל הקטגוריות →</a>
      </div>
      <div class="barel-cats-grid">
        <?php
        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0,
                           'number' => 8, 'orderby' => 'count', 'order' => 'DESC']);
        $icons = ['🔌','🔨','🪛','🪚','📏','🦺','🔩','📦'];
        if (!is_wp_error($cats)) {
            $i = 0;
            foreach ($cats as $cat) {
                if ($cat->slug === 'uncategorized') continue;
                $thumb = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $img = $thumb ? wp_get_attachment_url($thumb) : '';
                echo '<a href="' . esc_url(get_term_link($cat)) . '" class="barel-cat-card">';
                if ($img) {
                    echo '<div class="barel-cat-img" style="background-image:url(' . esc_url($img) . ')">' . ($icons[$i] ?? '🔧') . '</div>';
                } else {
                    echo '<div class="barel-cat-img">' . ($icons[$i] ?? '🔧') . '</div>';
                }
                echo '<div class="barel-cat-name">' . esc_html($cat->name) . '</div>';
                echo '<div class="barel-cat-count">' . $cat->count . ' מוצרים</div>';
                echo '</a>';
                $i++;
                if ($i >= 8) break;
            }
        }
        ?>
      </div>
    </div>
  </section>

  <!-- FEATURED PRODUCTS -->
  <section class="barel-products-section barel-section-gray">
    <div class="barel-section-inner">
      <div class="barel-section-header">
        <h2 class="barel-section-title">מוצרים <span>מומלצים</span></h2>
        <a href="<?php echo esc_url($shop_url); ?>" class="barel-see-all">לכל המוצרים →</a>
      </div>
      <?php if (class_exists('WooCommerce')): ?>
        <?php echo do_shortcode('[featured_products per_page="8" columns="4" orderby="date" order="DESC"]'); ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- NEW ARRIVALS -->
  <section class="barel-products-section">
    <div class="barel-section-inner">
      <div class="barel-section-header">
        <h2 class="barel-section-title">חדש <span>בחנות</span></h2>
        <a href="<?php echo esc_url($shop_url); ?>" class="barel-see-all">לכל המוצרים →</a>
      </div>
      <?php if (class_exists('WooCommerce')): ?>
        <?php echo do_shortcode('[recent_products per_page="8" columns="4" orderby="date" order="DESC"]'); ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- BRANDS BANNER -->
  <section class="barel-brands-section barel-section-dark">
    <div class="barel-section-inner">
      <div class="barel-section-header barel-light">
        <h2 class="barel-section-title">המותגים <span>שלנו</span></h2>
        <p style="color:rgba(255,255,255,.6)">אנחנו מייצגים את המותגים המקצועיים הגדולים בעולם</p>
      </div>
      <div class="barel-brands-grid">
        <div class="barel-brand-item">DeWalt</div>
        <div class="barel-brand-item">Bosch</div>
        <div class="barel-brand-item">Makita</div>
        <div class="barel-brand-item">Stanley</div>
        <div class="barel-brand-item">Hilti</div>
        <div class="barel-brand-item">Milwaukee</div>
        <div class="barel-brand-item">Festool</div>
        <div class="barel-brand-item">Metabo</div>
      </div>
    </div>
  </section>

  <!-- FEATURES / WHY US -->
  <section class="barel-features-section">
    <div class="barel-section-inner">
      <h2 class="barel-section-title text-center">למה <span>בר-אל אופיר?</span></h2>
      <div class="barel-features-grid">
        <div class="barel-feature-item">
          <div class="barel-feature-icon">🚚</div>
          <div class="barel-feature-title">משלוח מהיר</div>
          <div class="barel-feature-desc">עד 7 ימי עסקים לכל הארץ, עם אפשרות לאיסוף עצמי</div>
        </div>
        <div class="barel-feature-item">
          <div class="barel-feature-icon">🔒</div>
          <div class="barel-feature-title">תשלום מאובטח</div>
          <div class="barel-feature-desc">SSL מוצפן, תשלום דרך בנק לאומי. כל כרטיסי האשראי</div>
        </div>
        <div class="barel-feature-item">
          <div class="barel-feature-icon">🏆</div>
          <div class="barel-feature-title">מוצרים מקוריים</div>
          <div class="barel-feature-desc">כל המוצרים מקוריים, עם אחריות יצרן מלאה</div>
        </div>
        <div class="barel-feature-item">
          <div class="barel-feature-icon">💬</div>
          <div class="barel-feature-title">שירות מקצועי</div>
          <div class="barel-feature-desc">צוות מומחים זמין לייעוץ ותמיכה א'–ה' 08:00-18:00</div>
        </div>
        <div class="barel-feature-item">
          <div class="barel-feature-icon">↩️</div>
          <div class="barel-feature-title">החזרה ב-30 יום</div>
          <div class="barel-feature-desc">לא מרוצה? נחזיר לך את הכסף ללא שאלות</div>
        </div>
        <div class="barel-feature-item">
          <div class="barel-feature-icon">💰</div>
          <div class="barel-feature-title">מחירים הוגנים</div>
          <div class="barel-feature-desc">ישירות מהיצרן לצרכן. ללא מתווכים מיותרים</div>
        </div>
      </div>
    </div>
  </section>

  <!-- SALE PRODUCTS -->
  <?php if (class_exists('WooCommerce')): ?>
  <section class="barel-products-section barel-section-gray">
    <div class="barel-section-inner">
      <div class="barel-section-header">
        <h2 class="barel-section-title">🔥 מבצעים <span>מיוחדים</span></h2>
        <a href="<?php echo esc_url($shop_url); ?>" class="barel-see-all">לכל המבצעים →</a>
      </div>
      <?php echo do_shortcode('[sale_products per_page="4" columns="4"]'); ?>
    </div>
  </section>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
