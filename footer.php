<?php
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
?>

<!-- FOOTER -->
<footer class="barel-footer" itemscope itemtype="https://schema.org/WPFooter">
  <div class="barel-footer-grid">

    <!-- Brand -->
    <div class="barel-footer-col barel-footer-brand">
      <div class="barel-logo-text">בר-אל אופיר</div>
      <p>חנות כלי עבודה מקצועיים מובילה בישראל. אנחנו מספקים כלי עבודה איכותיים לקבלנים, בעלי מקצוע ולקוחות פרטיים כבר מעל 15 שנה.</p>
      <div class="barel-footer-contact">
        <a href="tel:052-422-2910" aria-label="טלפון">📞 052-422-2910</a>
        <a href="https://wa.me/972524222910" target="_blank" rel="noopener" aria-label="WhatsApp">💬 WhatsApp</a>
        <a href="mailto:info@barelofir.co.il" aria-label="אימייל">✉️ info@barelofir.co.il</a>
      </div>
    </div>

    <!-- Categories -->
    <div class="barel-footer-col">
      <h4>קטגוריות</h4>
      <ul>
        <?php
        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'number' => 6, 'orderby' => 'count', 'order' => 'DESC']);
        if (!is_wp_error($cats)) foreach ($cats as $cat) {
          if ($cat->slug === 'uncategorized') continue;
          echo '<li><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a></li>';
        }
        ?>
        <li><a href="<?php echo esc_url($shop_url); ?>">כל המוצרים</a></li>
      </ul>
    </div>

    <!-- Service -->
    <div class="barel-footer-col">
      <h4>שירות לקוחות</h4>
      <ul>
        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">החשבון שלי</a></li>
        <li><a href="<?php echo esc_url(wc_get_page_permalink('cart')); ?>">עגלת קניות</a></li>
        <li><a href="<?php echo esc_url(home_url('/מדיניות-החזרה/')); ?>">מדיניות החזרה</a></li>
        <li><a href="<?php echo esc_url(home_url('/משלוחים/')); ?>">מדיניות משלוח</a></li>
        <li><a href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">צור קשר</a></li>
        <li><a href="<?php echo esc_url(home_url('/שאלות-נפוצות/')); ?>">שאלות נפוצות</a></li>
      </ul>
    </div>

    <!-- About -->
    <div class="barel-footer-col">
      <h4>אודות</h4>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/אודות/')); ?>">אודות החברה</a></li>
        <li><a href="<?php echo esc_url(home_url('/מותגים/')); ?>">המותגים שלנו</a></li>
        <li><a href="<?php echo esc_url(home_url('/תנאי-שימוש/')); ?>">תנאי שימוש</a></li>
        <li><a href="<?php echo esc_url(home_url('/פרטיות/')); ?>">מדיניות פרטיות</a></li>
        <li><a href="<?php echo esc_url(home_url('/נגישות/')); ?>">הצהרת נגישות</a></li>
      </ul>
    </div>

  </div>

  <!-- Bottom Bar -->
  <div class="barel-footer-bottom">
    <span>© <?php echo date('Y'); ?> בר-אל אופיר אספקה טכנית בע"מ. כל הזכויות שמורות.</span>
    <div class="barel-footer-payments">
      <span>💳 ויזה</span>
      <span>💳 מאסטרקארד</span>
      <span>💳 אמקס</span>
      <span>🔒 SSL</span>
    </div>
  </div>
</footer>

<!-- WHATSAPP FLOAT -->
<a href="https://wa.me/972524222910?text=שלום%2C%20אני%20מעוניין%20לברר%20על%20מוצר"
   class="barel-whatsapp-float" target="_blank" rel="noopener" aria-label="פנה אלינו ב-WhatsApp">
  💬
</a>

<?php wp_footer(); ?>
</body>
</html>
