<?php
/**
 * Template Name: צור קשר - עיצוב מלא
 */
get_header();
?>
<main id="barel-main" class="barel-main">

  <!-- HERO -->
  <section class="barel-page-hero">
    <h1>צור <span>קשר</span></h1>
    <p>אנחנו כאן לעזור! ייעוץ מקצועי, שאלות על מוצרים ומשלוחים – פשוט פנו אלינו</p>
  </section>

  <!-- CONTACT CARDS -->
  <div class="barel-contact-cards">
    <div class="barel-contact-card">
      <div class="barel-contact-icon">📞</div>
      <div class="barel-contact-title">טלפון</div>
      <div class="barel-contact-val"><a href="tel:">התקשרו אלינו</a></div>
      <div class="barel-contact-sub">א'–ה' 08:00–18:00</div>
    </div>
    <div class="barel-contact-card">
      <div class="barel-contact-icon">📧</div>
      <div class="barel-contact-title">מייל</div>
      <div class="barel-contact-val"><a href="mailto:info@barelofir.co.il">info@barelofir.co.il</a></div>
      <div class="barel-contact-sub">מענה תוך 24 שעות</div>
    </div>
    <div class="barel-contact-card">
      <div class="barel-contact-icon">💬</div>
      <div class="barel-contact-title">וואטסאפ</div>
      <div class="barel-contact-val"><a href="https://wa.me/972" target="_blank">שלח הודעה</a></div>
      <div class="barel-contact-sub">מענה מהיר</div>
    </div>
    <div class="barel-contact-card">
      <div class="barel-contact-icon">🕐</div>
      <div class="barel-contact-title">שעות פעילות</div>
      <div class="barel-contact-val">א'–ה' 08:00–18:00</div>
      <div class="barel-contact-sub">ו' ושבת סגור</div>
    </div>
  </div>

  <!-- FORM + MAP -->
  <div class="barel-contact-main">
    <div class="barel-contact-form-box">
      <h2 class="barel-form-title">שלח הודעה</h2>
      <p class="barel-form-sub">נחזור אליך בהקדם האפשרי</p>

      <?php if (shortcode_exists('contact-form-7')): ?>
        <?php
        $forms = get_posts(['post_type' => 'wpcf7_contact_form', 'numberposts' => 1]);
        if ($forms) {
            echo do_shortcode('[contact-form-7 id="' . $forms[0]->ID . '" title="' . $forms[0]->post_title . '"]');
        } else {
            echo barel_fallback_contact_form();
        }
        ?>
      <?php else: ?>
        <?php echo barel_fallback_contact_form(); ?>
      <?php endif; ?>
    </div>

    <div class="barel-contact-sidebar">
      <div class="barel-contact-info-box">
        <h3>מידע נוסף</h3>
        <div class="barel-contact-info-item">📍 <strong>כתובת:</strong> ישראל</div>
        <div class="barel-contact-info-item">📞 <strong>טלפון:</strong> <a href="tel:">התקשרו אלינו</a></div>
        <div class="barel-contact-info-item">📧 <strong>מייל:</strong> <a href="mailto:info@barelofir.co.il">info@barelofir.co.il</a></div>
        <div class="barel-contact-info-item">🕐 <strong>שעות:</strong> א'–ה' 08:00–18:00</div>
      </div>
      <div class="barel-contact-faq-box">
        <h3>שאלות נפוצות</h3>
        <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="barel-faq-link">→ לכל השאלות הנפוצות</a>
      </div>
    </div>
  </div>

</main>
<?php get_footer(); ?>

<?php
function barel_fallback_contact_form() {
    ob_start();
    ?>
    <form class="barel-contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
      <?php wp_nonce_field('barel_contact', 'barel_nonce'); ?>
      <input type="hidden" name="action" value="barel_contact_form">
      <div class="barel-form-grid">
        <div class="barel-form-group">
          <label class="barel-form-label">שם מלא <span>*</span></label>
          <input type="text" name="name" class="barel-form-input" required placeholder="שם מלא" />
        </div>
        <div class="barel-form-group">
          <label class="barel-form-label">טלפון</label>
          <input type="tel" name="phone" class="barel-form-input" placeholder="050-0000000" />
        </div>
        <div class="barel-form-group barel-full">
          <label class="barel-form-label">אימייל <span>*</span></label>
          <input type="email" name="email" class="barel-form-input" required placeholder="your@email.com" />
        </div>
        <div class="barel-form-group barel-full">
          <label class="barel-form-label">הנושא</label>
          <select name="subject" class="barel-form-input">
            <option>שאלה על מוצר</option>
            <option>בעיה עם הזמנה</option>
            <option>החזרה / החלפה</option>
            <option>אחר</option>
          </select>
        </div>
        <div class="barel-form-group barel-full">
          <label class="barel-form-label">הודעה <span>*</span></label>
          <textarea name="message" class="barel-form-input" rows="5" required placeholder="כתוב את הודעתך כאן..."></textarea>
        </div>
      </div>
      <button type="submit" class="barel-form-submit">שלח הודעה 📨</button>
    </form>
    <?php
    return ob_get_clean();
}
?>
