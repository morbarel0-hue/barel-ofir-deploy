<?php
defined('ABSPATH') || exit;

add_action('after_setup_theme', 'barel_setup');
function barel_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('custom-logo', ['height' => 80, 'width' => 200, 'flex-height' => true, 'flex-width' => true]);
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','script','style']);
}

add_action('wp_enqueue_scripts', 'barel_enqueue');
function barel_enqueue() {
    wp_enqueue_style('barel-fonts',
        'https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800;900&family=Rubik:wght@500;700;900&display=swap',
        [], null);
    wp_enqueue_style('barel-main', get_template_directory_uri() . '/assets/css/main.css', ['barel-fonts'], '2.1.3');
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('barel-woo', get_template_directory_uri() . '/assets/css/woo.css', ['barel-main'], '2.1.3');
    }
    wp_enqueue_script('barel-main', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], '2.0.5', true);
    wp_enqueue_script('barel-search', get_template_directory_uri() . '/assets/js/barel-search.js', ['barel-main'], '2.0.5', true);
    wp_enqueue_script('barel-cart', get_template_directory_uri() . '/assets/js/barel-cart.js', ['jquery'], '2.0.6', true);
    if (function_exists('WC')) {
        wp_enqueue_script('wc-add-to-cart');
        wp_enqueue_script('woocommerce');
        wp_enqueue_script('wc-cart-fragments');
    }
    if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) {
        wp_enqueue_script('barel-infinite', get_template_directory_uri() . '/assets/js/infinite-scroll.js', ['jquery'], '2.0.5', true);
        global $wp_query;
        wp_localize_script('barel-infinite', 'BarelInfinite', [
            'ajaxUrl'  => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('barel_infinite'),
            'maxPages' => (int)$wp_query->max_num_pages,
            'currPage' => max(1, get_query_var('paged')),
        ]);
    }
    wp_localize_script('barel-main', 'BarelData', [
        'ajaxUrl'    => admin_url('admin-ajax.php'),
        'nonce'      => wp_create_nonce('barel_nonce'),
        'homeUrl'    => home_url('/'),
        'currency'   => get_woocommerce_currency_symbol(),
        'cartUrl'    => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
        'accountUrl' => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/'),
    ]);
}

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', function() { echo '<main class="barel-woo-main">'; }, 10);
add_action('woocommerce_after_main_content', function() { echo '</main>'; }, 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

add_filter('get_search_form', 'barel_search_form');
function barel_search_form($form) {
    $q = get_search_query();
    return '<form role="search" method="get" class="search-bar" action="' . esc_url(home_url('/')) . '">' .
      '<input type="hidden" name="post_type" value="product" />' .
      '<input type="search" name="s" id="searchInput" placeholder="חפש מוצר, מותג, מקט..." value="' . esc_attr($q) . '" autocomplete="off" />' .
      '<button type="submit" id="searchSubmit">🔍 חיפוש</button>' .
      '<div id="searchDropdown" class="search-dropdown" aria-live="polite"></div>' .
      '</form>';
}

add_action('wp_ajax_barel_search', 'barel_ajax_search');
add_action('wp_ajax_nopriv_barel_search', 'barel_ajax_search');
function barel_ajax_search() {
    check_ajax_referer('barel_nonce', 'nonce');
    $q = sanitize_text_field(wp_unslash($_GET['q'] ?? ''));
    if (strlen($q) < 2) { wp_send_json_success([]); }
    $qr = new WP_Query(['post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 8, 's' => $q]);
    $results = [];
    if ($qr->have_posts()) {
        while ($qr->have_posts()) {
            $qr->the_post();
            $p = wc_get_product(get_the_ID());
            if (!$p) continue;
            $results[] = ['id' => get_the_ID(), 'name' => get_the_title(), 'url' => get_permalink(), 'img' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'), 'price' => strip_tags($p->get_price_html()), 'sku' => $p->get_sku()];
        }
        wp_reset_postdata();
    }
    $cats = get_terms(['taxonomy' => 'product_cat', 'name__like' => $q, 'number' => 3, 'hide_empty' => true]);
    $cr = [];
    if (!is_wp_error($cats)) { foreach ($cats as $c) { $cr[] = ['name' => $c->name, 'url' => get_term_link($c), 'count' => $c->count]; } }
    wp_send_json_success(['products' => $results, 'categories' => $cr]);
}
add_action('wp_ajax_barel_add_to_cart', 'barel_ajax_add_to_cart');
add_action('wp_ajax_nopriv_barel_add_to_cart', 'barel_ajax_add_to_cart');
function barel_ajax_add_to_cart() {
    check_ajax_referer('barel_nonce', 'nonce');
    $pid = absint($_POST['product_id'] ?? 0);
    $qty = max(1, absint($_POST['quantity'] ?? 1));
    if (!$pid) { wp_send_json_error('Invalid product'); }
    $ok = WC()->cart->add_to_cart($pid, $qty);
    if ($ok) { wp_send_json_success(['count' => WC()->cart->get_cart_contents_count(), 'message' => 'המוצר נוסף לעגלה!']); }
    else { wp_send_json_error('Could not add to cart'); }
}
add_filter('woocommerce_add_to_cart_fragments', 'barel_cart_fragment');
function barel_cart_fragment($f) {
    if (!function_exists('WC') || !WC()->cart) return $f;
    $count = WC()->cart->get_cart_contents_count();
    $f['.cart-n'] = '<span class="cart-n">' . $count . '</span>';
    $f['.barel-cart-b'] = '<span class="barel-cart-b">' . $count . '</span>';
    $f['.barel-cart-count'] = '<span class="barel-cart-count">' . $count . '</span>';
    return $f;
}

add_filter('woocommerce_loop_add_to_cart_args', function($args) {
    $args['class'] = (isset($args['class']) ? $args['class'] . ' ' : '') . 'ajax_add_to_cart';
    return $args;
});
function barel_get_delivery_date($business_days = 7) {
    $date = new DateTime('now', new DateTimeZone('Asia/Jerusalem'));
    $added = 0;
    while ($added < $business_days) {
        $date->modify('+1 day');
        $dow = (int)$date->format('N');
        if ($dow === 6 || $dow === 7) continue;
        $added++;
    }
    $days_he   = ['ראשון','שני','שלישי','רביעי','חמישי','שישי','שבת'];
    $months_he = ['','ינואר','פברואר','מרץ','אפריל','מאי','יוני','יולי','אוגוסט','ספטמבר','אוקטובר','נובמבר','דצמבר'];
    return 'יום ' . $days_he[(int)$date->format('w')] . ', ' . $date->format('j') . ' ב' . $months_he[(int)$date->format('n')];
}
function barel_render_cat_nav() {
    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
    $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'number' => 10, 'orderby' => 'count', 'order' => 'DESC']);
    $is_sp = function_exists('is_shop') && is_shop();
    echo '<nav class="cat-nav" aria-label="קטגוריות ראשיות"><div class="cat-nav-inner">';
    echo '<div class="nav-item"><a href="' . esc_url($shop_url) . '" class="cat-link' . ($is_sp && !is_product_category() ? ' active' : '') . '"><span class="cat-icon">🔧</span> כל הכלים</a></div>';
    if (!is_wp_error($cats)) {
        foreach ($cats as $cat) {
            if ($cat->slug === 'uncategorized') continue;
            $children = get_terms(['taxonomy' => 'product_cat', 'parent' => $cat->term_id, 'hide_empty' => true]);
            $active   = (function_exists('is_product_category') && is_product_category($cat->slug)) ? ' active' : '';
            $has_kids = !is_wp_error($children) && count($children) > 0;
            echo '<div class="nav-item"><a href="' . esc_url(get_term_link($cat)) . '" class="cat-link' . $active . '">' . esc_html($cat->name) . ($has_kids ? ' <span class="arrow">▾</span>' : '') . '</a>';
            if ($has_kids) {
                echo '<div class="cat-dropdown">';
                foreach ($children as $child) {
                    echo '<a href="' . esc_url(get_term_link($child)) . '" class="cat-dd-item">'
                       . esc_html($child->name)
                       . '<span class="cnt">' . (int)$child->count . '</span></a>';
                }
                echo '<a href="' . esc_url(get_term_link($cat)) . '" class="cat-dd-see-all">← לכל ' . esc_html($cat->name) . '</a>';
                echo '</div>';
            }
            echo '</div>';
        }
    }
    echo '<div class="nav-item"><a href="' . esc_url(add_query_arg('orderby', 'date', $shop_url)) . '" class="cat-link sale">🔥 מבצעים</a></div>';
    echo '</div></nav>';
}
function barel_render_product_card($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) return;
    $is_sale  = $product->is_on_sale();
    $price    = $product->get_price();
    $reg      = $product->get_regular_price();
    $sale     = $product->get_sale_price();
    $img_url  = get_the_post_thumbnail_url($product_id, 'woocommerce_thumbnail');
    $rating   = $product->get_average_rating();
    $rev      = $product->get_review_count();
    $brand    = get_post_meta($product_id, '_brand', true);
    $discount = ($is_sale && $reg > 0 && $sale > 0) ? round((1 - $sale / $reg) * 100) : 0;
    $link     = get_permalink($product_id);
    echo '<div class="prod-card" data-product-id="' . $product_id . '">';
    echo '<a href="' . esc_url($link) . '" class="prod-img-link">';
    if ($img_url) { echo '<div class="prod-img"><img src="' . esc_url($img_url) . '" alt="' . esc_attr($product->get_name()) . '" loading="lazy" /></div>'; }
    else { echo '<div class="prod-img" style="min-height:180px;display:flex;align-items:center;justify-content:center;font-size:48px">🔧</div>'; }
    echo '</a>';
    if ($discount) echo '<span class="badge b-sale">-' . $discount . '%</span>';
    elseif ($product->is_featured()) echo '<span class="badge b-new">חדש</span>';
    echo '<button class="prod-wishlist" data-id="' . $product_id . '" aria-label="מועדפים">&#9825;</button>';
    echo '<div class="prod-body">';
    if ($brand) echo '<div class="prod-brand">' . esc_html($brand) . '</div>';
    echo '<div class="prod-name"><a href="' . esc_url($link) . '">' . esc_html($product->get_name()) . '</a></div>';
    if ($rating > 0) { echo '<div class="prod-stars">' . str_repeat('★', round($rating)) . str_repeat('☆', 5 - round($rating)) . ' <span>(' . $rev . ')</span></div>'; }
    echo '</div><div class="prod-footer"><div>';
    echo '<div class="price-main">' . wc_price($price) . '</div>';
    if ($is_sale && $reg) echo '<div class="price-old">' . wc_price($reg) . '</div>';
    echo '</div>';
    if ($product->is_in_stock()) { echo '<button class="prod-atc" data-product-id="' . $product_id . '" data-nonce="' . wp_create_nonce('barel_nonce') . '">+ עגלה</button>'; }
    else { echo '<span class="prod-oos">אזל</span>'; }
    echo '</div></div>';
}
add_action('wp_head', 'barel_schema_org', 5);
function barel_schema_org() {
    if (is_product() || is_product_category()) return;
    echo '<script type="application/ld+json">' . json_encode(['@context' => 'https://schema.org', '@type' => 'HardwareStore', 'name' => 'בר-אל אופיר בע"מ', 'url' => home_url(), 'telephone' => '+972524222910', 'openingHours' => 'Su-Th 08:00-18:00'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}
add_action('wp_head', 'barel_product_schema', 6);
function barel_product_schema() {
    if (!is_product()) return;
    global $product;
    if (!$product instanceof WC_Product) $product = wc_get_product(get_the_ID());
    if (!$product) return;
    $s = ['@context' => 'https://schema.org', '@type' => 'Product', 'name' => $product->get_name(), 'sku' => $product->get_sku(), 'offers' => ['@type' => 'Offer', 'price' => $product->get_price(), 'priceCurrency' => get_woocommerce_currency(), 'availability' => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock', 'url' => get_permalink()]];
    if ($product->get_review_count() > 0) { $s['aggregateRating'] = ['@type' => 'AggregateRating', 'ratingValue' => $product->get_average_rating(), 'reviewCount' => $product->get_review_count()]; }
    echo '<script type="application/ld+json">' . json_encode($s, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}
add_filter('loop_shop_per_page', function() { return 24; });
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_action('wp_ajax_barel_toggle_wishlist', 'barel_toggle_wishlist');
add_action('wp_ajax_nopriv_barel_toggle_wishlist', 'barel_toggle_wishlist');
function barel_toggle_wishlist() {
    check_ajax_referer('barel_nonce', 'nonce');
    $pid = absint($_POST['product_id'] ?? 0);
    $wl  = WC()->session ? (WC()->session->get('barel_wishlist') ?: []) : [];
    if (in_array($pid, $wl)) { $wl = array_diff($wl, [$pid]); $added = false; }
    else { $wl[] = $pid; $added = true; }
    if (WC()->session) WC()->session->set('barel_wishlist', $wl);
    wp_send_json_success(['added' => $added, 'count' => count($wl)]);
}
// Category style helper
function barel_cat_style($name, $slug) {
    $n = mb_strtolower($name);
    if (strpos($n,'חשמל')!==false||strpos($slug,'hashmal')!==false)
        return ['grad'=>'linear-gradient(135deg,#ff6b35,#f7931e)','icon'=>'⚡'];
    if (strpos($n,'ידני')!==false||strpos($slug,'yadani')!==false)
        return ['grad'=>'linear-gradient(135deg,#c0001a,#8f0013)','icon'=>'🔧'];
    if (strpos($n,'גינ')!==false||strpos($slug,'ginun')!==false||strpos($slug,'gina')!==false)
        return ['grad'=>'linear-gradient(135deg,#1a7a3a,#2da84f)','icon'=>'🌿'];
    if (strpos($n,'אינסטל')!==false||strpos($n,'וולט')!==false||strpos($slug,'volt')!==false)
        return ['grad'=>'linear-gradient(135deg,#1565c0,#1976d2)','icon'=>'💧'];
    if (strpos($n,'בנ')!==false||strpos($n,'בניה')!==false)
        return ['grad'=>'linear-gradient(135deg,#5d4037,#795548)','icon'=>'🏗️'];
    if (strpos($n,'צבע')!==false||strpos($slug,'tseva')!==false)
        return ['grad'=>'linear-gradient(135deg,#7b1fa2,#9c27b0)','icon'=>'🎨'];
    if (strpos($n,'אביזר')!==false||strpos($slug,'avizar')!==false)
        return ['grad'=>'linear-gradient(135deg,#37474f,#546e7a)','icon'=>'🔩'];
    if (strpos($n,'לגינה')!==false||strpos($slug,'lagina')!==false)
        return ['grad'=>'linear-gradient(135deg,#1a7a3a,#2da84f)','icon'=>'🌿'];
    return ['grad'=>'linear-gradient(135deg,#c0001a,#e8001f)','icon'=>'🛠️'];
}

// checkout page section order
add_action('woocommerce_checkout_before_order_review_heading', function() {
    echo '<style>
    .woocommerce-checkout form.checkout > * { width: 100% !important; float: none !important; }
    .woocommerce-checkout .col2-set { order: 1; }
    .woocommerce-checkout #order_review_heading { order: 2; }
    .woocommerce-checkout #order_review { order: 3; }
    </style>';
});

// buy now button (for standard WooCommerce product forms)
add_action('woocommerce_after_add_to_cart_button', function() {
    global $product;
    if (!$product) return;
    $product_id = $product->get_id();
    $checkout_url = add_query_arg([
        'add-to-cart' => $product_id,
        'quantity'    => 1,
    ], wc_get_checkout_url());
    echo '<a href="' . esc_url($checkout_url) . '" class="barel-buy-now">⚡ קנה עכשיו</a>';
});

add_action('wp_footer', function() { ?>
<script>
(function() {
  var ham = document.getElementById('mobHam');
  var drawer = document.getElementById('mobDrawer');
  var overlay = document.getElementById('mobOverlay');
  var close = document.getElementById('mobClose');
  function openDrawer() { drawer.classList.add('open'); overlay.classList.add('show'); document.body.style.overflow = 'hidden'; }
  function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('show'); document.body.style.overflow = ''; }
  if(ham) ham.addEventListener('click', openDrawer);
  if(close) close.addEventListener('click', closeDrawer);
  if(overlay) overlay.addEventListener('click', closeDrawer);
  document.querySelectorAll('.mob-menu-item .mob-menu-link').forEach(function(link) {
    link.addEventListener('click', function() {
      var item = this.closest('.mob-menu-item');
      var wasOpen = item.classList.contains('open');
      document.querySelectorAll('.mob-menu-item').forEach(function(i) { i.classList.remove('open'); });
      if (!wasOpen) item.classList.add('open');
    });
  });
})();
</script>
<?php }, 99);

add_action('wp_footer', function() {
    ?>
    <script>
    if (typeof wc_add_to_cart_params === 'undefined') {
        var wc_add_to_cart_params = {};
    }
    wc_add_to_cart_params.ajax_url = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
    wc_add_to_cart_params.wc_ajax_url = '<?php echo esc_url(WC_AJAX::get_endpoint('%%endpoint%%')); ?>';
    </script>
    <?php
});
