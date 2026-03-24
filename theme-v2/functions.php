<?php
/**
 * בר-אל אופיר v2 — functions.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   1. THEME SETUP
   ========================================================= */
function barel_setup() {
    load_theme_textdomain( 'barel-v2', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'woocommerce', [
        'thumbnail_image_width' => 600,
        'gallery_thumbnail_image_width' => 100,
        'single_image_width'    => 800,
    ] );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    register_nav_menus( [
        'primary'   => 'תפריט ראשי',
        'cat-nav'   => 'תפריט קטגוריות',
        'footer-1'  => 'פוטר — קישורים 1',
        'footer-2'  => 'פוטר — קישורים 2',
        'footer-3'  => 'פוטר — קישורים 3',
    ] );
}
add_action( 'after_setup_theme', 'barel_setup' );

/* =========================================================
   2. ENQUEUE ASSETS
   ========================================================= */
function barel_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'barel-fonts',
        'https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700;800;900&family=Heebo:wght@300;400;500;600;700&display=swap',
        [],
        null
    );

    // Main CSS
    wp_enqueue_style(
        'barel-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [ 'barel-fonts' ],
        '2.0.0'
    );

    // WooCommerce styles
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_style( 'woocommerce-general' );
        wp_enqueue_style( 'woocommerce-layout' );
        wp_enqueue_style( 'woocommerce-smallscreen' );
    }

    // Main JS
    wp_enqueue_script(
        'barel-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [ 'jquery' ],
        '2.0.0',
        true
    );

    // Localize for AJAX
    wp_localize_script( 'barel-main', 'barelAjax', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'barel_nonce' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'barel_enqueue_assets' );

/* =========================================================
   3. SIDEBARS
   ========================================================= */
function barel_widgets_init() {
    register_sidebar( [
        'name'          => 'ספריית חנות',
        'id'            => 'shop-sidebar',
        'description'   => 'ווידג\'טים לספריית החנות',
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );

    register_sidebar( [
        'name'          => 'פוטר — ווידג\'טים',
        'id'            => 'footer-widgets',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'barel_widgets_init' );

/* =========================================================
   4. CUSTOM SEARCH FORM
   ========================================================= */
function barel_search_form( $form ) {
    $action = esc_url( home_url( '/' ) );
    $value  = get_search_query();
    $form   = '<form role="search" method="get" class="barel-search-form" action="' . $action . '">
        <input type="search" class="search-field" placeholder="חיפוש מוצרים..." value="' . esc_attr( $value ) . '" name="s" />
        <button type="submit" class="search-submit" aria-label="חיפוש">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
    </form>';
    return $form;
}
add_filter( 'get_search_form', 'barel_search_form' );

/* =========================================================
   5. CART FRAGMENT AJAX
   ========================================================= */
function barel_cart_fragment( $fragments ) {
    ob_start();
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    ?>
    <span class="cart-count" data-count="<?php echo esc_attr( $count ); ?>"><?php echo esc_html( $count ); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'barel_cart_fragment' );

/* =========================================================
   6. SCHEMA.ORG — ORGANIZATION
   ========================================================= */
function barel_schema_organization() {
    $schema = [
        '@context'  => 'https://schema.org',
        '@type'     => 'HardwareStore',
        'name'      => 'בר-אל אופיר אספקה טכנית בע"מ',
        'url'       => home_url(),
        'logo'      => get_template_directory_uri() . '/assets/images/logo.png',
        'telephone' => '+972-52-422-2910',
        'address'   => [
            '@type'           => 'PostalAddress',
            'addressCountry'  => 'IL',
            'addressLocality' => 'ישראל',
        ],
        'sameAs' => [
            'https://wa.me/972524222910',
        ],
    ];
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'barel_schema_organization' );

/* =========================================================
   7. SCHEMA.ORG — PRODUCT PAGE
   ========================================================= */
function barel_schema_product() {
    if ( ! is_singular( 'product' ) ) return;
    global $product;
    if ( ! $product ) $product = wc_get_product( get_the_ID() );
    if ( ! $product ) return;

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => $product->get_name(),
        'description' => wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ),
        'sku'         => $product->get_sku(),
        'image'       => wp_get_attachment_url( $product->get_image_id() ),
        'brand'       => [
            '@type' => 'Brand',
            'name'  => get_post_meta( get_the_ID(), '_brand', true ) ?: 'בר-אל אופיר',
        ],
        'offers' => [
            '@type'         => 'Offer',
            'price'         => $product->get_price(),
            'priceCurrency' => get_woocommerce_currency(),
            'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'url'           => get_permalink(),
            'seller'        => [
                '@type' => 'Organization',
                'name'  => 'בר-אל אופיר',
            ],
        ],
    ];

    if ( $product->get_rating_count() > 0 ) {
        $schema['aggregateRating'] = [
            '@type'       => 'AggregateRating',
            'ratingValue' => $product->get_average_rating(),
            'reviewCount' => $product->get_rating_count(),
        ];
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'barel_schema_product' );

/* =========================================================
   8. SCHEMA.ORG — CATEGORY / COLLECTION PAGE
   ========================================================= */
function barel_schema_collection() {
    if ( ! is_product_category() ) return;
    $term = get_queried_object();
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'CollectionPage',
        'name'        => $term->name,
        'description' => $term->description ?: 'מוצרים בקטגוריה ' . $term->name,
        'url'         => get_term_link( $term ),
    ];
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'barel_schema_collection' );

/* =========================================================
   9. LLMS.TXT META LINK
   ========================================================= */
function barel_llms_meta() {
    echo '<link rel="ai-content-declaration" href="' . esc_url( home_url( '/llms.txt' ) ) . '" />' . "\n";
}
add_action( 'wp_head', 'barel_llms_meta' );

/* =========================================================
   10. WOOCOMMERCE — CUSTOM BREADCRUMB
   ========================================================= */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_main_content', 'barel_breadcrumb_wrapper', 5 );

function barel_breadcrumb_wrapper() {
    echo '<div class="barel-breadcrumb-wrap">';
    barel_render_breadcrumb();
    echo '</div>';
}

function barel_render_breadcrumb() {
    $args = [
        'delimiter'   => '<span class="bc-sep">›</span>',
        'wrap_before' => '<nav class="barel-breadcrumb" aria-label="breadcrumb"><ol>',
        'wrap_after'  => '</ol></nav>',
        'before'      => '<li>',
        'after'       => '</li>',
        'home'        => 'ראשי',
    ];
    woocommerce_breadcrumb( $args );
}

/* =========================================================
   11. PRODUCTS PER PAGE
   ========================================================= */
add_filter( 'loop_shop_per_page', function() { return 24; }, 20 );

/* =========================================================
   12. PRODUCT THUMBNAIL OVERRIDE
   ========================================================= */
function barel_loop_product_thumbnail() {
    echo woocommerce_get_product_thumbnail( 'woocommerce_thumbnail' );
}
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'barel_loop_product_thumbnail', 10 );

/* =========================================================
   13. HELPER: barel_is_hebrew()
   ========================================================= */
function barel_is_hebrew( $string = '' ) {
    return preg_match( '/[\x{0590}-\x{05FF}]/u', $string );
}

/* =========================================================
   14. HELPER: barel_get_top_cats()
   ========================================================= */
function barel_get_top_cats( $limit = 8 ) {
    $args = [
        'taxonomy'   => 'product_cat',
        'parent'     => 0,
        'number'     => $limit,
        'orderby'    => 'count',
        'order'      => 'DESC',
        'hide_empty' => true,
        'exclude'    => [ get_option( 'default_product_cat' ) ],
    ];
    return get_terms( $args );
}

/* =========================================================
   15. HELPER: barel_render_cat_nav()
   ========================================================= */
function barel_render_cat_nav() {
    $cats = barel_get_top_cats( 12 );
    if ( empty( $cats ) || is_wp_error( $cats ) ) return;

    echo '<nav class="cat-nav" aria-label="קטגוריות">';
    echo '<ul class="cat-nav__list">';

    foreach ( $cats as $cat ) {
        $url   = get_term_link( $cat );
        $name  = esc_html( $cat->name );
        $count = absint( $cat->count );
        $active = ( is_product_category( $cat->slug ) ) ? ' class="active"' : '';
        echo '<li' . $active . '><a href="' . esc_url( $url ) . '">' . $name . '</a></li>';
    }

    echo '</ul>';
    echo '</nav>';
}

/* =========================================================
   16. SEO DESCRIPTION AFTER SHOP LOOP
   ========================================================= */
function barel_shop_seo_text() {
    if ( is_product_category() ) {
        $term = get_queried_object();
        if ( $term && ! empty( $term->description ) ) {
            echo '<div class="shop-seo-text"><div class="container">' . wpautop( wp_kses_post( $term->description ) ) . '</div></div>';
        }
    }
}
add_action( 'woocommerce_after_main_content', 'barel_shop_seo_text', 5 );

/* =========================================================
   17. REMOVE WOODMART HOOKS (CLEAN SLATE)
   ========================================================= */
function barel_remove_woodmart_hooks() {
    if ( function_exists( 'woodmart_setup' ) ) {
        remove_action( 'woocommerce_before_main_content', 'woodmart_before_main_content', 10 );
        remove_action( 'woocommerce_after_main_content', 'woodmart_after_main_content', 10 );
        remove_action( 'woocommerce_sidebar', 'woodmart_get_sidebar', 10 );
    }
}
add_action( 'after_setup_theme', 'barel_remove_woodmart_hooks', 99 );

/* =========================================================
   18. WOOCOMMERCE WRAPPER
   ========================================================= */
function barel_woocommerce_wrapper_before() {
    echo '<main id="main-content" class="site-main woo-main"><div class="container">';
}
function barel_woocommerce_wrapper_after() {
    echo '</div></main>';
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'barel_woocommerce_wrapper_before', 10 );
add_action( 'woocommerce_after_main_content', 'barel_woocommerce_wrapper_after', 10 );

/* =========================================================
   19. CUSTOM WOOCOMMERCE SIDEBAR
   ========================================================= */
function barel_woocommerce_sidebar() {
    if ( is_active_sidebar( 'shop-sidebar' ) ) {
        echo '<aside class="shop-sidebar"><div class="sidebar-inner">';
        dynamic_sidebar( 'shop-sidebar' );
        echo '</div></aside>';
    }
}
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_sidebar', 'barel_woocommerce_sidebar', 10 );

/* =========================================================
   20. BODY CLASS
   ========================================================= */
add_filter( 'body_class', function( $classes ) {
    $classes[] = 'barel-theme';
    if ( is_rtl() ) $classes[] = 'rtl';
    return $classes;
} );

/* =========================================================
   21. DOCUMENT TITLE SEPARATOR
   ========================================================= */
add_filter( 'document_title_separator', function() { return '|'; } );

/* =========================================================
   22. EXCERPT LENGTH
   ========================================================= */
add_filter( 'excerpt_length', function() { return 20; } );

/* =========================================================
   23. WP HEAD CLEANUP
   ========================================================= */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
