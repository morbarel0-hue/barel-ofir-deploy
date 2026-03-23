<!-- FOOTER -->
<footer class="barel-footer">
  <div class="barel-footer-inner">

    <!-- BRAND COL -->
    <div class="barel-footer-brand">
      <div class="barel-footer-logo">בר-אל אופיר בע״מ</div>
      <p class="barel-footer-desc">מעל 15 שנות ניסיון בייבוא ושיווק כלי עבודה מקצועיים. מחויבים לאיכות, שירות ומחיר הוגן לכל לקוח.</p>
      <div class="barel-footer-contact-item">📍 <strong>כתובת:</strong> ישראל</div>
      <div class="barel-footer-contact-item">📧 <strong>מייל:</strong> <a href="mailto:info@barelofir.co.il">info@barelofir.co.il</a></div>
      <div class="barel-footer-contact-item">🕐 <strong>שעות:</strong> א'–ה' 08:00–18:00</div>
    </div>

    <!-- CATEGORIES COL -->
    <div>
      <div class="barel-footer-col-title">קטגוריות</div>
      <div class="barel-footer-links">
        <?php
        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'number' => 6, 'orderby' => 'count', 'order' => 'DESC']);
        if (!is_wp_error($cats)) {
            foreach ($cats as $cat) {
                if ($cat->slug === 'uncategorized') continue;
                echo '<a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a>';
            }
        }
        ?>
        <?php if (function_exists('wc_get_page_permalink')): ?>
        <a href="<?php echo esc_url(add_query_arg('orderby', 'date', wc_get_page_permalink('shop'))); ?>">מבצעים</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- SERVICE COL -->
    <div>
      <div class="barel-footer-col-title">שירות לקוחות</div>
      <div class="barel-footer-links">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>">צור קשר</a>
        <a href="<?php echo esc_url(home_url('/refund_returns/')); ?>">מדיניות החזרות</a>
        <?php if (class_exists('WooCommerce')): ?>
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>">מעקב הזמנה</a>
        <?php endif; ?>
        <a href="<?php echo esc_url(home_url('/faq/')); ?>">שאלות נפוצות</a>
        <a href="<?php echo esc_url(home_url('/shipping/')); ?>">מדיניות משלוח</a>
      </div>
    </div>

    <!-- ABOUT COL -->
    <div>
      <div class="barel-footer-col-title">אודות</div>
      <div class="barel-footer-links">
        <a href="<?php echo esc_url(home_url('/about/')); ?>">אודות בר-אל אופיר</a>
        <a href="<?php echo esc_url(home_url('/blog/')); ?>">בלוג מקצועי</a>
        <?php
        $privacy = get_privacy_policy_url();
        if ($privacy): ?>
        <a href="<?php echo esc_url($privacy); ?>">מדיניות פרטיות</a>
        <?php endif; ?>
        <a href="<?php echo esc_url(home_url('/terms/')); ?>">תנאי שימוש</a>
        <a href="<?php echo esc_url(home_url('/accessibility/')); ?>">נגישות</a>
      </div>
    </div>

  </div><!-- /.barel-footer-inner -->

  <div class="barel-footer-bottom">
    <div class="barel-footer-bottom-inner">
      <span class="barel-footer-copy">© <?php echo date('Y'); ?> בר-אל אופיר בע״מ | כל הזכויות שמורות</span>
      <div class="barel-footer-badges">
        <span class="barel-badge-item">🔒 SSL מאובטח</span>
        <span class="barel-badge-item">✅ רשום ברשם החברות</span>
        <span class="barel-badge-item">💳 תשלום מאובטח</span>
      </div>
      <div class="barel-footer-bottom-links">
        <?php if ($privacy): ?>
        <a href="<?php echo esc_url($privacy); ?>">פרטיות</a>
        <?php endif; ?>
        <a href="<?php echo esc_url(home_url('/terms/')); ?>">תנאי שימוש</a>
        <a href="<?php echo esc_url(home_url('/accessibility/')); ?>">נגישות</a>
      </div>
    </div>
  </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
