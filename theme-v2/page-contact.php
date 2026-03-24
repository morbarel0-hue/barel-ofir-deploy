<?php
/**
 * Template Name: Contact Page
 * Contact page template matching barel-contact.html design
 */
get_header();
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
?>

<div class="page-hero">
  <h1>צור <span>קשר</span> איתנו</h1>
  <p>שאלות? ייעוץ? בעיה עם הזמנה? אנחנו כאן לעזור – מהר ובמקצועיות</p>
</div>

<div class="contact-cards">
  <div class="contact-card">
    <div class="contact-card-icon">📞</div>
    <div class="contact-card-title">טלפון</div>
    <div class="contact-card-val"><a href="tel:052-422-2910">052-422-2910</a></div>
    <div class="contact-card-sub">א'–ה' 08:00–18:00</div>
  </div>
  <div class="contact-card">
    <div class="contact-card-icon">📧</div>
    <div class="contact-card-title">אימייל</div>
    <div class="contact-card-val"><a href="mailto:info@barelofir.co.il">info@barelofir.co.il</a></div>
    <div class="contact-card-sub">מענה תוך 2–4 שעות</div>
  </div>
  <div class="contact-card">
    <div class="contact-card-icon">💬</div>
    <div class="contact-card-title">וואטסאפ</div>
    <div class="contact-card-val"><a href="https://wa.me/972524222910" target="_blank" rel="noopener">052-422-2910</a></div>
    <div class="contact-card-sub">זמין בשעות העסקים</div>
  </div>
  <div class="contact-card">
    <div class="contact-card-icon">📍</div>
    <div class="contact-card-title">כתובת</div>
    <div class="contact-card-val">ישראל</div>
    <div class="contact-card-sub">איסוף בתיאום מראש</div>
  </div>
</div>

<div class="contact-main">
  <div class="contact-form-box">
    <div class="form-title">שלח לנו הודעה</div>
    <div class="form-sub">נחזור אליך תוך שעות ספורות בימי עסקים</div>
    <?php if (function_exists('wpcf7_contact_form')): ?>
      <?php echo do_shortcode('[contact-form-7 id="1" title="Contact form 1"]'); ?>
    <?php else: ?>
    <form class="contact-form-inner" method="post" action="<?php echo esc_url(home_url('/contact/')); ?>">
      <?php wp_nonce_field('contact_form', 'contact_nonce'); ?>
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">שם מלא <span>*</span></label>
          <input class="form-input inp" type="text" name="contact_name" placeholder="ישראל ישראלי" required />
        </div>
        <div class="form-group">
          <label class="form-label">טלפון <span>*</span></label>
          <input class="form-input inp" type="tel" name="contact_phone" placeholder="05X-XXX-XXXX" required />
        </div>
        <div class="form-group full">
          <label class="form-label">אימייל <span>*</span></label>
          <input class="form-input inp" type="email" name="contact_email" placeholder="your@email.com" required />
        </div>
        <div class="form-group full">
          <label class="form-label">נושא הפנייה</label>
          <select class="form-select inp" name="contact_subject">
            <option>שאלה לפני רכישה</option>
            <option>מעקב הזמנה</option>
            <option>החזרה / החלפה</option>
            <option>בעיה טכנית</option>
            <option>אחריות</option>
            <option>אחר</option>
          </select>
        </div>
        <div class="form-group full">
          <label class="form-label">תוכן ההודעה <span>*</span></label>
          <textarea class="form-textarea inp" name="contact_message" placeholder="ספר לנו כיצד נוכל לעזור..." required></textarea>
        </div>
      </div>
      <button type="submit" class="submit-btn">📨 שלח הודעה</button>
      <div class="form-note">🔒 הפרטים שלך מוגנים ולא יועברו לצד שלישי</div>
    </form>
    <?php endif; ?>
  </div>

  <div class="contact-side">
    <div class="side-box">
      <div class="side-box-title">שעות פעילות</div>
      <div class="hours-row"><span>ראשון</span><span>08:00–18:00</span></div>
      <div class="hours-row"><span>שני</span><span>08:00–18:00</span></div>
      <div class="hours-row"><span>שלישי</span><span>08:00–18:00</span></div>
      <div class="hours-row"><span>רביעי</span><span>08:00–18:00</span></div>
      <div class="hours-row"><span>חמישי</span><span>08:00–18:00</span></div>
      <div class="hours-row"><span>שישי</span><span>08:00–13:00</span></div>
      <div class="hours-row"><span>שבת</span><span style="color:#e53935">סגור</span></div>
    </div>

    <div class="side-box">
      <div class="side-box-title">שאלות נפוצות</div>
      <div class="faq-mini">
        <div class="faq-mini-item">
          <div class="faq-mini-q">כמה זמן לוקח המשלוח?</div>
          <div class="faq-mini-a">הזמנות שהתקבלו עד 14:00 מסופקות למחרת. בפריפריה עד 48 שעות.</div>
        </div>
        <div class="faq-mini-item">
          <div class="faq-mini-q">איך מחזירים מוצר?</div>
          <div class="faq-mini-a">שולחים אימייל עם מספר הזמנה ואנחנו מסדרים את כל הבירוקרטיה.</div>
        </div>
        <div class="faq-mini-item">
          <div class="faq-mini-q">האם יש איסוף עצמי?</div>
          <div class="faq-mini-a">כן, ניתן לאסוף מהמחסן בתיאום מראש בטלפון.</div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
