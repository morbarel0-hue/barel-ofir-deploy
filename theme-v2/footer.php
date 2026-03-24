<?php
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'number' => 6, 'orderby' => 'count', 'order' => 'DESC']);
?>
<footer>
  <div class="footer-top">
    <div>
      <div class="footer-brand-logo">בר-<span>אל</span> אופיר בע׳מ</div>
      <p class="footer-desc">החנות המקצועית לכלי עבודה בישראל.</p>
      <div class="footer-contact-item">📞 <strong>טלפון:</strong> <a href="tel:052-422-2910">052-422-2910</a></div>
      <div class="footer-contact-item">📧 <strong>אימייל:</strong> <a href="mailto:info@barelofir.co.il">info@barelofir.co.il</a></div>
      <div class="footer-contact-item">🕐 <strong>שעות:</strong> א׳-ה׳ 08:00-18:00</div>
    </div>
    <div>
      <div class="footer-col-title">קטגוריות</div>
      <div class="footer-links">
        <?php if (!is_wp_error($cats)) foreach ($cats as $cat) { if ($cat->slug === 'uncategorized') continue; echo '<a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a>'; } ?>
        <a href="<?php echo esc_url($shop_url); ?>">כל המוצרים</a>
      </div>
    </div>
    <div>
      <div class="footer-col-title">שירות לקוחות</div>
      <div class="footer-links">
        <?php if (class_exists('WooCommerce')): ?>
          <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">החשבון שלי</a>
          <a href="<?php echo esc_url(wc_get_cart_url()); ?>">עגלת קניות</a>
        <?php endif; ?>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>">צור קשר</a>
        <a href="<?php echo esc_url(home_url('/refund_returns/')); ?>">מדיניות החזרות</a>
        <a href="<?php echo esc_url(home_url('/faq/')); ?>">שאלות נפוצות</a>
      </div>
    </div>
    <div>
      <div class="footer-col-title">אודות</div>
      <div class="footer-links">
        <a href="<?php echo esc_url(home_url('/about/')); ?>">אודות החברה</a>
        <a href="<?php echo esc_url(home_url('/terms/')); ?>">תנאי שימוש</a>
        <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">מדיניות פרטיות</a>
        <a href="<?php echo esc_url(home_url('/accessibility/')); ?>">הצהרת נגישות</a>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>&copy; <?php echo date('Y'); ?> בר-אל אופיר אספקה טכנית בע"מ. כל הזכויות שמורות.</span>
    <div class="footer-payments">
      <span>💳 ויזה</span>
      <span>💳 מאסטרקארד</span>
      <span>🔒 SSL מאובטח</span>
    </div>
  </div>
</footer>

<a href="https://wa.me/972524222910?text=%D7%A9%D7%9C%D7%95%D7%9D%2C%20%D7%90%D7%A0%D7%99%20%D7%9E%D7%A2%D7%95%D7%A0%D7%99%D7%99%D7%9F%20%D7%9C%D7%91%D7%A8%D7%A8"
   class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
  <span>💬</span><span class="whatsapp-float-txt">WhatsApp</span>
</a>

<?php wp_footer(); ?>
</body>
</html>
