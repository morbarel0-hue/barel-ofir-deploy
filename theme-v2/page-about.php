<?php
/**
 * Template Name: About Page
 * About page template matching barel-about.html design
 */
get_header();
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
?>

<section class="about-hero">
  <div class="about-hero-inner">
    <div class="about-hero-text">
      <div class="about-hero-tag">✦ הסיפור שלנו</div>
      <h1 class="about-hero-title">מעל 15 שנה של<br/><span>מקצועיות ואמינות</span></h1>
      <p class="about-hero-desc">בר-אל אופיר בע״מ היא חנות כלי עבודה מקצועיים שהוקמה מתוך אהבה לאיכות ומחויבות לשירות. אנחנו מספקים לאלפי לקוחות – קבלנים, חשמלאים, אינסטלטורים ואנשי DIY – את הכלים הטובים ביותר.</p>
      <div class="about-hero-ctas">
        <a href="<?php echo esc_url($shop_url); ?>" class="btn-primary">🔧 לכל המוצרים</a>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-outline">צור קשר →</a>
      </div>
    </div>
    <div class="about-hero-stats">
      <div class="hero-stat-box">
        <div class="hero-stat-num">15<span>+</span></div>
        <div class="hero-stat-label">שנות ניסיון</div>
      </div>
      <div class="hero-stat-box">
        <div class="hero-stat-num">10<span>K+</span></div>
        <div class="hero-stat-label">מוצרים במלאי</div>
      </div>
      <div class="hero-stat-box">
        <div class="hero-stat-num">5<span>K+</span></div>
        <div class="hero-stat-label">לקוחות מרוצים</div>
      </div>
      <div class="hero-stat-box">
        <div class="hero-stat-num">98<span>%</span></div>
        <div class="hero-stat-label">שביעות רצון</div>
      </div>
    </div>
  </div>
</section>

<section class="story-section">
  <div class="story-img">🏭</div>
  <div>
    <div class="story-label">הסיפור שלנו</div>
    <h2 class="story-title">מחסן קטן לחנות מקוונת מובילה</h2>
    <p class="story-text">בר-אל אופיר בע״מ נוסדה לפני למעלה מ-15 שנה על ידי בעל מקצוע שהאמין שכלי עבודה איכותיים צריכים להיות נגישים לכולם – לא רק לחברות הגדולות.</p>
    <p class="story-text">התחלנו עם מחסן קטן וקטלוג של כמה מאות מוצרים. היום אנחנו מציעים מעל 10,000 מוצרים ממותגים מובילים בעולם, עם משלוח לכל פינה בישראל.</p>
    <p class="story-text">הסוד שלנו? פשוט. אנחנו מתייחסים לכל לקוח כאל שותף. שאלה טכנית? ייעוץ לפני רכישה? בעיה עם מוצר? אנחנו כאן.</p>
  </div>
</section>

<section class="values-section">
  <div class="values-inner">
    <div class="section-center">
      <div class="section-tag">הערכים שלנו</div>
      <div class="section-title-lg">למה <span>בוחרים</span> בנו?</div>
      <div class="section-sub">הערכים שמובילים אותנו בכל החלטה ובכל שירות</div>
    </div>
    <div class="values-grid">
      <div class="value-card">
        <div class="value-icon">🏆</div>
        <div class="value-title">איכות ללא פשרות</div>
        <div class="value-text">אנחנו בוחרים רק מותגים שעמדו במבחן הזמן. כל מוצר עובר בדיקת איכות לפני שנכנס למלאי שלנו.</div>
      </div>
      <div class="value-card">
        <div class="value-icon">💰</div>
        <div class="value-title">מחיר הוגן תמיד</div>
        <div class="value-text">אנחנו עובדים ישירות עם היצרנים ומוכרים ללא מתווכים מיותרים. החיסכון עובר אליך.</div>
      </div>
      <div class="value-card">
        <div class="value-icon">🧑‍🔧</div>
        <div class="value-title">שירות מקצועי</div>
        <div class="value-text">הצוות שלנו מורכב מבעלי מקצוע מנוסים. אנחנו לא רק מוכרים – אנחנו מייעצים ומלווים.</div>
      </div>
      <div class="value-card">
        <div class="value-icon">🚚</div>
        <div class="value-title">אמינות ומהירות</div>
        <div class="value-text">הזמנה שהתקבלה עד 14:00 יוצאת עדיין היום. אנחנו לא מבטיחים מה שלא נוכל לקיים.</div>
      </div>
    </div>
  </div>
</section>

<section class="timeline-section">
  <div class="timeline-title">המסע שלנו</div>
  <div class="timeline-sub">מאיפה התחלנו ולאן הגענו</div>
  <div class="timeline">
    <div class="timeline-item">
      <div class="timeline-dot">🏁</div>
      <div class="timeline-content">
        <div class="timeline-year">2009</div>
        <div class="timeline-event">הקמת בר-אל אופיר בע״מ</div>
        <div class="timeline-desc">פתחנו מחסן קטן עם 300 מוצרים ושירות לקוחות אישי לכל לקוח.</div>
      </div>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">📦</div>
      <div class="timeline-content">
        <div class="timeline-year">2013</div>
        <div class="timeline-event">הרחבת המלאי ל-2,000 מוצרים</div>
        <div class="timeline-desc">חתמנו על הסכמי הפצה ישירים עם DeWalt ו-Bosch ישראל.</div>
      </div>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">💻</div>
      <div class="timeline-content">
        <div class="timeline-year">2017</div>
        <div class="timeline-event">השקת החנות המקוונת</div>
        <div class="timeline-desc">פתחנו את האתר הראשון שלנו ועברנו לשרת לקוחות מכל הארץ.</div>
      </div>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">🚀</div>
      <div class="timeline-content">
        <div class="timeline-year">2021</div>
        <div class="timeline-event">10,000 מוצרים ו-5,000 לקוחות</div>
        <div class="timeline-desc">הגענו לאבן דרך משמעותית – עם מלאי של 10,000 מוצרים ולקוחות נאמנים מכל הארץ.</div>
      </div>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">⭐</div>
      <div class="timeline-content">
        <div class="timeline-year">2025</div>
        <div class="timeline-event">אתר חדש, שירות טוב יותר</div>
        <div class="timeline-desc">השקנו את האתר החדש שלנו עם ממשק משתמש משופר ומערכת לוגיסטיקה מהירה יותר.</div>
      </div>
    </div>
  </div>
</section>

<section class="team-section">
  <div class="team-inner">
    <div class="section-center" style="text-align:center;margin-bottom:0">
      <div class="section-tag" style="background:#c0001a;color:#fff">הצוות שלנו</div>
      <div class="section-title-lg" style="color:#111">האנשים <span>מאחורי</span> הקלעים</div>
    </div>
    <div class="team-grid">
      <div class="team-card">
        <div class="team-avatar">👨‍💼</div>
        <div class="team-name">אופיר בר-אל</div>
        <div class="team-role">מייסד ומנכ"ל</div>
        <div class="team-desc">15+ שנות ניסיון בתחום כלי העבודה. חשמלאי מוסמך לשעבר.</div>
      </div>
      <div class="team-card">
        <div class="team-avatar">👨‍🔧</div>
        <div class="team-name">יוסי כהן</div>
        <div class="team-role">מנהל מלאי ולוגיסטיקה</div>
        <div class="team-desc">מוודא שכל הזמנה מגיעה בזמן ובמצב מושלם.</div>
      </div>
      <div class="team-card">
        <div class="team-avatar">👩‍💻</div>
        <div class="team-name">שרה לוי</div>
        <div class="team-role">שירות לקוחות</div>
        <div class="team-desc">כאן לענות על כל שאלה ולפתור כל בעיה – תוך שעות.</div>
      </div>
      <div class="team-card">
        <div class="team-avatar">👨‍🏫</div>
        <div class="team-name">דוד מזרחי</div>
        <div class="team-role">יועץ מקצועי</div>
        <div class="team-desc">קבלן שיפוצים ותיק עם ידע אנציקלופדי בכלי עבודה.</div>
      </div>
    </div>
  </div>
</section>

<div class="brands-section">
  <div class="brands-inner">
    <div class="brands-title">המותגים שאנחנו נושאים</div>
    <div class="brands-row">
      <div class="brand-item">DeWalt</div>
      <div class="brand-item">Bosch</div>
      <div class="brand-item">Makita</div>
      <div class="brand-item">Stanley</div>
      <div class="brand-item">Kress</div>
      <div class="brand-item">Worx</div>
      <div class="brand-item">Signet</div>
      <div class="brand-item">Hunter Tools</div>
    </div>
  </div>
</div>

<div class="cta-banner">
  <div class="cta-inner">
    <h2>מוכן לקנות <span>בחכמה?</span></h2>
    <p>אלפי כלי עבודה מקצועיים ממתינים לך – במחירים הטובים ביותר</p>
    <div class="cta-btns">
      <a href="<?php echo esc_url($shop_url); ?>" class="btn-primary">🔧 לכל המוצרים</a>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-outline">ייעוץ חינם →</a>
    </div>
  </div>
</div>

<?php get_footer(); ?>
