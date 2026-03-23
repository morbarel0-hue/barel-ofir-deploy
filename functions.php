<?php
/**
 * barel-ofir Child Theme Functions
 * Parent: WoodMart | Site: https://barelofir.co.il
 */

// ── ENQUEUE STYLES ──────────────────────────────────────
add_action('wp_enqueue_scripts', 'barel_enqueue_styles', 100);
function barel_enqueue_styles() {
    wp_enqueue_style('barel-fonts',
        'https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800;900&family=Rubik:wght@500;700;900&display=swap',
        [], null
    );
    wp_enqueue_style('barel-main',
        get_stylesheet_directory_uri() . '/assets/css/barel-main.css',
        [], '1.0.3'
    );
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('barel-woo',
            get_stylesheet_directory_uri() . '/assets/css/barel-woo.css',
            ['barel-main'], '1.0.3'
        );
    }
}

// ── ENQUEUE SCRIPTS ─────────────────────────────────────
add_action('wp_enqueue_scripts', 'barel_enqueue_scripts', 100);
function barel_enqueue_scripts() {
    wp_enqueue_script('barel-main',
        get_stylesheet_directory_uri() . '/assets/js/barel-main.js',
        ['jquery'], '1.0.3', true
    );
    wp_localize_script('barel-main', 'barel_params', [
        'ajax_url'    => admin_url('admin-ajax.php'),
        'cart_url'    => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
        'account_url' => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/'),
    ]);
}

// ── THEME SETUP ─────────────────────────────────────────
add_action('after_setup_theme', 'barel_setup');
function barel_setup() {
    load_child_theme_textdomain('barel-ofir', get_stylesheet_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','script','style']);
    register_nav_menus([
        'primary'  => 'תפריט ראשי',
        'cat-nav'  => 'ניווט קטגוריות',
        'footer-1' => 'פוטר - קטגוריות',
        'footer-2' => 'פוטר - שירות לקוחות',
        'footer-3' => 'פוטר - אודות',
    ]);
}

// ── CUSTOM SEARCH FORM ──────────────────────────────────
add_filter('get_search_form', 'barel_search_form');
function barel_search_form($form) {
    $action = esc_url(home_url('/'));
    $q = get_search_query();
    return '<form role="search" method="get" class="barel-search-bar" action="' . $action . '">
        <button type="submit" aria-label="חיפוש">🔍 חיפוש</button>
        <input type="search" name="s" placeholder="חפש מוצר, מותג, מקט..." value="' . esc_attr($q) . '" autocomplete="off" />
        <input type="hidden" name="post_type" value="product" />
    </form>';
}

// ── CART FRAGMENT ────────────────────────────────────────
add_filter('woocommerce_add_to_cart_fragments', 'barel_cart_fragment');
function barel_cart_fragment($fragments) {
    if (!function_exists('WC') || !WC()->cart) return $fragments;
    $count = WC()->cart->get_cart_contents_count();
    $fragments['.barel-cart-count'] = '<span class="barel-cart-count">' . $count . '</span>';
    return $fragments;
}

// ── CATEGORY NAV HELPER ─────────────────────────────────
function barel_render_cat_nav() {
    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
    $is_shop  = function_exists('is_shop') && is_shop();
    echo '<nav class="barel-cat-nav" aria-label="קטגוריות ראשיות"><div class="barel-cat-nav-inner">';
    echo '<a href="' . esc_url($shop_url) . '" class="barel-cat-link' . ($is_shop ? ' active' : '') . '">כל הכלים</a>';
    $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0,
                       'number' => 9, 'orderby' => 'count', 'order' => 'DESC']);
    if (!is_wp_error($cats)) {
        foreach ($cats as $cat) {
            if ($cat->slug === 'uncategorized') continue;
            $active = (function_exists('is_product_category') && is_product_category($cat->slug)) ? ' active' : '';
            echo '<a href="' . esc_url(get_term_link($cat)) . '" class="barel-cat-link' . $active . '">' . esc_html($cat->name) . '</a>';
        }
    }
    echo '<a href="' . esc_url(add_query_arg('orderby', 'date', $shop_url)) . '" class="barel-cat-link" style="color:#f5a623;">🔥 מבצעים</a>';
    echo '</div></nav>';
}

// ── SCHEMA.ORG ORGANIZATION ─────────────────────────────
add_action('wp_head', 'barel_schema_org', 5);
function barel_schema_org() {
    if (is_product()) return; // product schema handled separately
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'HardwareStore',
        'name'        => 'בר-אל אופיר בע"מ',
        'description' => 'חנות כלי עבודה מקצועיים - מברגות, מקדחות, ציוד בנייה ועוד',
        'url'         => home_url(),
        'address'     => ['@type' => 'PostalAddress', 'addressCountry' => 'IL'],
        'priceRange'  => 'ILS',
        'openingHours'=> 'Su-Th 08:00-18:00',
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => home_url('/?s={search_term_string}&post_type=product'),
            'query-input' => 'required name=search_term_string',
        ],
    ];
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

// ── SCHEMA.ORG PRODUCT ──────────────────────────────────
add_action('wp_head', 'barel_product_schema', 6);
function barel_product_schema() {
    if (!is_product()) return;
    global $product;
    if (!$product || !($product instanceof WC_Product)) return;
    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Product',
        'name'     => $product->get_name(),
        'offers'   => [
            '@type'         => 'Offer',
            'price'         => $product->get_price(),
            'priceCurrency' => 'ILS',
            'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'url'           => get_permalink(),
        ],
    ];
    if ($product->get_review_count() > 0) {
        $schema['aggregateRating'] = [
            '@type'       => 'AggregateRating',
            'ratingValue' => $product->get_average_rating(),
            'reviewCount' => $product->get_review_count(),
        ];
    }
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

// ── CATEGORY PAGE SCHEMA ────────────────────────────────
add_action('wp_head', 'barel_category_schema', 7);
function barel_category_schema() {
    if (!is_product_category()) return;
    $cat = get_queried_object();
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'CollectionPage',
        'name'        => $cat->name,
        'description' => $cat->description,
        'url'         => get_term_link($cat),
    ];
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

// ── REGISTER PAGE TEMPLATES ─────────────────────────────
add_filter('theme_page_templates', 'barel_register_templates');
function barel_register_templates($templates) {
    $templates['page-homepage.php']       = 'דף הבית - עיצוב מלא';
    $templates['page-contact-custom.php'] = 'צור קשר - עיצוב מלא';
    $templates['page-about-custom.php']   = 'אודות - עיצוב מלא';
    return $templates;
}

// ── WOOCOMMERCE TWEAKS ──────────────────────────────────
// Show WooCommerce notices
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action('woocommerce_before_main_content', 'barel_woo_breadcrumb', 20);
function barel_woo_breadcrumb() {
    echo '<div class="barel-breadcrumb-wrap">';
    woocommerce_breadcrumb(['wrap_before' => '<nav class="barel-breadcrumb">', 'wrap_after' => '</nav>', 'delimiter' => '<span>›</span>']);
    echo '</div>';
}
