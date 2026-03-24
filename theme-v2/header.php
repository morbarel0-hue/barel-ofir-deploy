<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ===== TOPBAR ===== -->
<div class="topbar" role="banner">
    <div class="topbar__inner container">
        <ul class="topbar__list">
            <li><span class="topbar__icon">🚚</span> משלוח מהיר לכל הארץ</li>
            <li><span class="topbar__icon">🔒</span> תשלום מאובטח SSL</li>
            <li>
                <a href="tel:0524222910" class="topbar__phone">
                    <span class="topbar__icon">📞</span> 052-422-2910
                </a>
            </li>
            <li><span class="topbar__icon">↩️</span> החזרה תוך 30 יום</li>
        </ul>
    </div>
</div>

<!-- ===== HEADER ===== -->
<header class="site-header" id="site-header" role="banner">
    <div class="header__inner container">

        <!-- LOGO -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo" aria-label="<?php bloginfo( 'name' ); ?> — עמוד הבית">
            <?php
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                echo '<span class="header__logo-text">בר-אל אופיר</span>';
            }
            ?>
        </a>

        <!-- SEARCH -->
        <div class="header__search">
            <?php get_search_form(); ?>
        </div>

        <!-- ACTIONS -->
        <div class="header__actions">
            <!-- Phone -->
            <a href="tel:0524222910" class="header__action header__action--phone" aria-label="התקשר אלינו">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.95-.95a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                <span class="header__action-label">052-422-2910</span>
            </a>

            <!-- Account -->
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="header__action header__action--account" aria-label="חשבון שלי">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span class="header__action-label">חשבון</span>
            </a>

            <!-- Cart -->
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header__action header__action--cart" aria-label="עגלת קניות">
                <span class="cart-icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="cart-count"><?php echo WC()->cart ? absint( WC()->cart->get_cart_contents_count() ) : 0; ?></span>
                </span>
                <span class="header__action-label">עגלה</span>
            </a>

            <!-- Mobile Hamburger -->
            <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="פתח תפריט" aria-expanded="false" aria-controls="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

    </div><!-- /.header__inner -->
</header><!-- /.site-header -->

<!-- ===== CATEGORY NAV ===== -->
<div class="cat-nav-wrap">
    <div class="container">
        <?php barel_render_cat_nav(); ?>
    </div>
</div>

<!-- ===== MOBILE MENU ===== -->
<div class="mobile-menu" id="mobile-menu" role="dialog" aria-label="תפריט ניווט" aria-hidden="true">
    <div class="mobile-menu__header">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-menu__logo">
            <?php bloginfo( 'name' ); ?>
        </a>
        <button class="mobile-menu__close" id="mobile-menu-close" aria-label="סגור תפריט">✕</button>
    </div>
    <div class="mobile-menu__search">
        <?php get_search_form(); ?>
    </div>
    <nav class="mobile-menu__nav" aria-label="תפריט ניווט ראשי">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'menu_class'     => 'mobile-nav__list',
            'container'      => false,
            'fallback_cb'    => function() {
                $cats = barel_get_top_cats( 12 );
                if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
                    echo '<ul class="mobile-nav__list">';
                    foreach ( $cats as $cat ) {
                        echo '<li><a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
                    }
                    echo '</ul>';
                }
            },
        ] );
        ?>
    </nav>
    <div class="mobile-menu__contact">
        <a href="tel:0524222910" class="mobile-contact-btn">📞 052-422-2910</a>
        <a href="https://wa.me/972524222910" class="mobile-contact-btn mobile-contact-btn--wa" target="_blank" rel="noopener noreferrer">💬 WhatsApp</a>
    </div>
</div>
<div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

<div id="page" class="site">
<div id="content" class="site-content">
