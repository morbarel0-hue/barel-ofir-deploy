<?php
/**
 * front-page.php — Homepage
 */

get_header();

$top_cats = barel_get_top_cats( 8 );
?>

<!-- ===================================================
     HERO SECTION
     =================================================== -->
<section class="hero" aria-label="הירו — כלי עבודה מקצועיים">
    <div class="hero__bg-effects" aria-hidden="true">
        <div class="hero__gradient-blob hero__gradient-blob--1"></div>
        <div class="hero__gradient-blob hero__gradient-blob--2"></div>
    </div>
    <div class="container hero__inner">
        <div class="hero__content">
            <div class="hero__badge">המובילים בישראל בכלי עבודה מקצועיים</div>
            <h1 class="hero__title">
                כלי עבודה מקצועיים.<br>
                <span class="hero__title-accent">מחיר שמגיע לך.</span>
            </h1>
            <p class="hero__subtitle">
                DeWalt, Bosch, Makita, Stanley, Hilti, Milwaukee ועוד —<br>
                אספקה מקצועית ישירות אליך, במחיר ישיר מהיצרן.
            </p>
            <div class="hero__ctas">
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary btn--lg">
                    לכל המוצרים
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                <a href="https://wa.me/972524222910" class="btn btn--ghost btn--lg" target="_blank" rel="noopener noreferrer">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.117.549 4.107 1.513 5.834L.057 23.5l5.826-1.527A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818c-1.848 0-3.563-.5-5.038-1.37l-.361-.213-3.455.906.921-3.368-.234-.375A9.818 9.818 0 0 1 2.182 12C2.182 6.57 6.57 2.182 12 2.182S21.818 6.57 21.818 12 17.43 21.818 12 21.818z"/></svg>
                    דברו איתנו
                </a>
            </div>
            <div class="hero__trust-badges">
                <div class="trust-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM1 10h22M7 15v3M17 15v3"/></svg>
                    תשלום מאובטח
                </div>
                <div class="trust-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    משלוח מהיר
                </div>
                <div class="trust-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    מוצרים מקוריים
                </div>
                <div class="trust-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    החזרה 30 יום
                </div>
            </div>
        </div>
        <div class="hero__visual" aria-hidden="true">
            <div class="hero__image-wrap">
                <div class="hero__image-ring hero__image-ring--outer"></div>
                <div class="hero__image-ring hero__image-ring--inner"></div>
                <div class="hero__image-center">
                    <svg width="120" height="120" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="48" fill="#1a1a1a" stroke="#c0001a" stroke-width="1.5"/>
                        <path d="M30 65L45 35L55 55L65 40L70 65" stroke="#c0001a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M25 70H75" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="65" cy="38" r="5" fill="#c0001a"/>
                        <path d="M58 28l4 4-4 4-4-4z" fill="#ffffff" opacity="0.6"/>
                        <path d="M38 72v-8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v8" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================================================
     CATEGORIES SECTION
     =================================================== -->
<section class="section section--cats" aria-label="קטגוריות מוצרים">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title">קנה לפי קטגוריה</h2>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="section__link">כל הקטגוריות &rsaquo;</a>
        </div>
        <?php if ( ! empty( $top_cats ) && ! is_wp_error( $top_cats ) ) : ?>
        <div class="cats-grid">
            <?php foreach ( $top_cats as $cat ) :
                $thumb_id  = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                $thumb_url = $thumb_id ? wp_get_attachment_url( $thumb_id ) : '';
            ?>
            <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="cat-card">
                <div class="cat-card__img-wrap">
                    <?php if ( $thumb_url ) : ?>
                        <img src="<?php echo esc_url( $thumb_url ); ?>"
                             alt="<?php echo esc_attr( $cat->name ); ?>"
                             loading="lazy" width="240" height="200">
                    <?php else : ?>
                        <div class="cat-card__img-placeholder">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div class="cat-card__overlay"></div>
                </div>
                <div class="cat-card__body">
                    <span class="cat-card__name"><?php echo esc_html( $cat->name ); ?></span>
                    <span class="cat-card__count"><?php echo absint( $cat->count ); ?> מוצרים</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ===================================================
     FEATURED PRODUCTS
     =================================================== -->
<section class="section section--featured" aria-label="מוצרים מובחרים">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title">מוצרים מובחרים</h2>
            <a href="<?php echo esc_url( add_query_arg( 'filter', 'featured', wc_get_page_permalink( 'shop' ) ) ); ?>" class="section__link">לכל המוצרים &rsaquo;</a>
        </div>
        <?php echo do_shortcode( '[featured_products per_page="8" columns="4" orderby="date" order="DESC"]' ); ?>
    </div>
</section>

<!-- ===================================================
     NEW ARRIVALS
     =================================================== -->
<section class="section section--new" aria-label="חדש בחנות">
    <div class="container">
        <div class="section__header">
            <div class="section__title-group">
                <span class="section__tag">חדש</span>
                <h2 class="section__title">הגיע לחנות</h2>
            </div>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="section__link">עוד מוצרים &rsaquo;</a>
        </div>
        <?php echo do_shortcode( '[recent_products per_page="4" columns="4" orderby="date" order="DESC"]' ); ?>
    </div>
</section>

<!-- ===================================================
     BRANDS BAR
     =================================================== -->
<section class="section section--brands" aria-label="מותגים">
    <div class="container">
        <h2 class="section__title section__title--center">המותגים שאנחנו מייצגים</h2>
        <div class="brands-bar">
            <?php
            $brands = [
                [ 'name' => 'DeWalt',    'slug' => 'dewalt'    ],
                [ 'name' => 'Bosch',     'slug' => 'bosch'     ],
                [ 'name' => 'Makita',    'slug' => 'makita'    ],
                [ 'name' => 'Stanley',   'slug' => 'stanley'   ],
                [ 'name' => 'Hilti',     'slug' => 'hilti'     ],
                [ 'name' => 'Milwaukee', 'slug' => 'milwaukee' ],
                [ 'name' => 'Festool',   'slug' => 'festool'   ],
                [ 'name' => 'Metabo',    'slug' => 'metabo'    ],
            ];
            foreach ( $brands as $brand ) :
                $term = get_term_by( 'slug', $brand['slug'], 'product_cat' );
                $url  = $term ? get_term_link( $term ) : '#';
            ?>
            <a href="<?php echo esc_url( $url ); ?>" class="brand-chip" aria-label="<?php echo esc_attr( $brand['name'] ); ?>">
                <span class="brand-chip__name"><?php echo esc_html( $brand['name'] ); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===================================================
     WHY US
     =================================================== -->
<section class="section section--why" aria-label="למה לקנות מאיתנו">
    <div class="container">
        <h2 class="section__title section__title--center">למה בר-אל אופיר?</h2>
        <div class="why-grid">
            <div class="why-card">
                <div class="why-card__icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </div>
                <h3 class="why-card__title">משלוח מהיר</h3>
                <p class="why-card__text">משלוח עד 3 ימי עסקים לכל הארץ. איסוף עצמי גם אפשרי.</p>
            </div>
            <div class="why-card">
                <div class="why-card__icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="11" width="22" height="11" rx="2" ry="2"/><path d="M1 15h22M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                </div>
                <h3 class="why-card__title">תשלום מאובטח</h3>
                <p class="why-card__text">הצפנת SSL מלאה, קרדיט/דביט/PayPal. בטוח ומהיר.</p>
            </div>
            <div class="why-card">
                <div class="why-card__icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="why-card__title">מוצרים מקוריים</h3>
                <p class="why-card__text">100% מוצרים אותנטיים מיובאים ישירות מהיצרן. עם אחריות.</p>
            </div>
            <div class="why-card">
                <div class="why-card__icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="why-card__title">שירות מקצועי</h3>
                <p class="why-card__text">צוות מומחים זמין לייעוץ אישי ומקצועי בבחירת הכלי הנכון.</p>
            </div>
            <div class="why-card">
                <div class="why-card__icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
                </div>
                <h3 class="why-card__title">החזרה 30 יום</h3>
                <p class="why-card__text">לא מרוצה? מחזירים עד 30 יום ללא שאלות, מלא הכסף בחזרה.</p>
            </div>
            <div class="why-card">
                <div class="why-card__icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3 class="why-card__title">מחירים הוגנים</h3>
                <p class="why-card__text">מחירים תחרותיים ושקופים. לא מחירון — מחיר שמגיע לך.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===================================================
     SALE PRODUCTS
     =================================================== -->
<section class="section section--sale" aria-label="מוצרים במבצע">
    <div class="container">
        <div class="section__header">
            <div class="section__title-group">
                <span class="section__tag section__tag--sale">מבצע</span>
                <h2 class="section__title">מוצרים במבצע</h2>
            </div>
            <a href="<?php echo esc_url( add_query_arg( 'orderby', 'price', wc_get_page_permalink( 'shop' ) ) ); ?>" class="section__link">לכל המבצעים &rsaquo;</a>
        </div>
        <?php echo do_shortcode( '[sale_products per_page="4" columns="4" orderby="date" order="DESC"]' ); ?>
    </div>
</section>

<?php get_footer(); ?>
