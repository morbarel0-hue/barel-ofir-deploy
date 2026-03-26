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
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="28" height="28">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
  </svg>
  <span class="whatsapp-float-txt">WhatsApp</span>
</a>

<?php wp_footer(); ?>
</body>
</html>
