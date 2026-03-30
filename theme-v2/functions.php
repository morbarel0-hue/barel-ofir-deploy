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
    $q = sanitize_text_field(wp_unslash($_GET['q'] ?? ''));
    if (strlen($q) < 2) { wp_send_json(['products' => [], 'categories' => []]); return; }

    $results = ['products' => [], 'categories' => []];

    // מוצרים
    $products = wc_get_products(['s' => $q, 'limit' => 5, 'status' => 'publish']);
    foreach ($products as $product) {
        $img = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail');
        $brand = $product->get_attribute('pa_brand') ?: get_post_meta($product->get_id(), '_brand', true);
        $results['products'][] = [
            'id'    => $product->get_id(),
            'name'  => $product->get_name(),
            'price' => wc_price($product->get_price()),
            'url'   => get_permalink($product->get_id()),
            'img'   => $img ?: wc_placeholder_img_src(),
            'brand' => $brand,
        ];
    }

    // קטגוריות
    $cats = get_terms(['taxonomy' => 'product_cat', 'search' => $q, 'hide_empty' => true, 'number' => 4]);
    if (!is_wp_error($cats)) {
        foreach ($cats as $cat) {
            if ($cat->slug === 'uncategorized') continue;
            $results['categories'][] = ['name' => $cat->name, 'count' => $cat->count, 'url' => get_term_link($cat)];
        }
    }

    wp_send_json($results);
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
    // term IDs confirmed on server: חשמליים=124, ידניים=171, הטמבוריה=999
    $main_cats = [
        ['id' => 0,   'label' => 'כל הכלים',           'icon' => '🔧', 'class' => ''],
        ['id' => 124, 'label' => 'כלי עבודה חשמליים',  'icon' => '⚡', 'class' => ''],
        ['id' => 171, 'label' => 'כלי עבודה ידניים',   'icon' => '🔨', 'class' => ''],
        ['id' => 999, 'label' => 'הטמבוריה',            'icon' => '🏪', 'class' => ''],
    ];
    echo '<nav class="cat-nav" aria-label="קטגוריות ראשיות"><div class="cat-nav-inner">';
    foreach ($main_cats as $mc) {
        if ($mc['id'] === 0) {
            $url    = $shop_url;
            $active = (function_exists('is_shop') && is_shop() && !is_product_category()) ? ' active' : '';
            echo '<div class="nav-item"><a href="' . esc_url($url) . '" class="cat-link' . $active . '">'
               . '<span class="cat-icon">' . $mc['icon'] . '</span> ' . esc_html($mc['label'])
               . '</a></div>';
            continue;
        }
        $term = get_term($mc['id'], 'product_cat');
        if (!$term || is_wp_error($term)) continue;
        $url      = get_term_link($term);
        $active   = (function_exists('is_product_category') && is_product_category($term->term_id)) ? ' active' : '';
        $children = get_terms(['taxonomy' => 'product_cat', 'parent' => $term->term_id, 'hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC', 'number' => 12]);
        $has_kids = !is_wp_error($children) && count($children) > 0;
        echo '<div class="nav-item">';
        echo '<a href="' . esc_url($url) . '" class="cat-link' . $active . '">'
           . '<span class="cat-icon">' . $mc['icon'] . '</span> ' . esc_html($mc['label'])
           . ($has_kids ? ' <span class="arrow">▼</span>' : '')
           . '</a>';
        if ($has_kids) {
            echo '<div class="cat-dropdown">';
            foreach ($children as $child) {
                echo '<a href="' . esc_url(get_term_link($child)) . '" class="cat-dd-item">'
                   . '<span class="ic">›</span>'
                   . esc_html($child->name)
                   . '<span class="cnt">' . (int)$child->count . '</span>'
                   . '</a>';
            }
            echo '<a href="' . esc_url($url) . '" class="cat-dd-see-all">← לכל ' . esc_html($mc['label']) . '</a>';
            echo '</div>';
        }
        echo '</div>';
    }
    echo '<div class="nav-item"><a href="' . esc_url(add_query_arg('orderby', 'date', $shop_url)) . '" class="cat-link sale"><span class="cat-icon">🔥</span> מבצעים</a></div>';
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

/* ── ACCOUNT MENU: remove downloads tab ────────────────────────────── */
add_filter('woocommerce_account_menu_items', function($items) {
    unset($items['downloads']);
    return $items;
}, 10);

/* ── FILTERS: sticky sidebar desktop ───────────────────────────────── */
remove_action('woocommerce_before_shop_loop', 'barel_render_filters', 15);
add_action('woocommerce_before_shop_loop', 'barel_render_filters_wrapper', 5);

function barel_render_filters_wrapper() {
    if (!is_shop() && !is_product_category()) return;
    echo '<div class="barel-filters-sidebar">';
    barel_render_filters();
    echo '</div>';
}

add_action('wp_head', function() {
    if (!is_shop() && !is_product_category()) return;
    ?>
    <style>
    @media(min-width:769px) {
      .woocommerce-products-header { grid-column:1 / -1 !important; }
      .barel-filters-sidebar { grid-column:1 !important; grid-row:2 !important; }
      .woocommerce-ordering,
      .woocommerce-result-count { grid-column:2 !important; }
      .woocommerce ul.products { grid-column:2 !important; }
      .woocommerce-notices-wrapper { grid-column:1 / -1 !important; }
    }
    </style>
    <?php
});

function barel_render_filters() {
    if (!is_shop() && !is_product_category() && !is_product_tag()) return;

    // קבל מוצרים בקטגוריה הנוכחית בלבד
    $tax_query = [];
    if (is_product_category()) {
        $current_cat = get_queried_object();
        $tax_query[] = [
            'taxonomy'         => 'product_cat',
            'field'            => 'term_id',
            'terms'            => $current_cat->term_id,
            'include_children' => true,
        ];
    }

    $products_in_cat = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => $tax_query,
    ]);

    if (empty($products_in_cat)) return;

    // תכונות לסינון - רק אם יש ערכים רלוונטים
    $attributes_to_show = [
        'pa_brand'       => ['title' => '🏷️ מותג',       'min_count' => 1],
        'pa_סוג-הפעלה'  => ['title' => '⚡ סוג הפעלה',  'min_count' => 1],
        'pa_מידה'        => ['title' => '📐 מידה',        'min_count' => 2],
        'pa_size'        => ['title' => '📏 גודל',        'min_count' => 1],
        'pa_כמות'        => ['title' => '🔢 כמות',        'min_count' => 2],
        'pa_color'       => ['title' => '🎨 צבע',         'min_count' => 1],
        'pa_מל'          => ['title' => '🧴 נפח',         'min_count' => 2],
        'pa_גוף-בלבד'   => ['title' => '🔧 גוף בלבד',   'min_count' => 1],
    ];

    $current_filters = $_GET ?? [];

    // בנה נתוני תכונות רק מהמוצרים בקטגוריה
    $attr_data = [];
    foreach ($products_in_cat as $pid) {
        foreach ($attributes_to_show as $taxonomy => $config) {
            $terms = wc_get_product_terms($pid, $taxonomy, ['fields' => 'all']);
            foreach ($terms as $term) {
                if (!isset($attr_data[$taxonomy][$term->term_id])) {
                    $attr_data[$taxonomy][$term->term_id] = [
                        'name'  => $term->name,
                        'slug'  => $term->slug,
                        'count' => 0,
                    ];
                }
                $attr_data[$taxonomy][$term->term_id]['count']++;
            }
        }
    }

    // בדוק אם יש בכלל פילטרים להציג
    $has_any = false;
    foreach ($attr_data as $taxonomy => $terms) {
        if (count($terms) >= $attributes_to_show[$taxonomy]['min_count']) {
            $has_any = true;
            break;
        }
    }
    if (!$has_any) return;

    echo '<div class="barel-filters">';

    foreach ($attributes_to_show as $taxonomy => $config) {
        if (empty($attr_data[$taxonomy])) continue;

        // מינימום ערכים להצגה
        if (count($attr_data[$taxonomy]) < $config['min_count']) continue;

        // מיין לפי כמות
        uasort($attr_data[$taxonomy], fn($a,$b) => $b['count'] - $a['count']);

        $filter_key = 'filter_' . sanitize_key(str_replace('pa_', '', $taxonomy));
        $current_val = $current_filters[$filter_key] ?? '';

        echo '<div class="barel-filter-group">';
        echo '<div class="barel-filter-title">' . $config['title'] . '</div>';
        echo '<div class="barel-filter-options">';

        foreach ($attr_data[$taxonomy] as $tid => $term) {
            $active = ($current_val === $term['slug']) ? 'active' : '';
            $url = ($current_val === $term['slug'])
                ? remove_query_arg($filter_key)
                : add_query_arg($filter_key, $term['slug']);

            echo '<a href="' . esc_url($url) . '" class="barel-filter-chip ' . $active . '">';
            echo esc_html($term['name']);
            echo '<span class="barel-filter-cnt">' . $term['count'] . '</span>';
            echo '</a>';
        }

        echo '</div></div>';
    }

    // כפתור נקה פילטרים
    $filter_keys = array_map(
        fn($t) => 'filter_' . sanitize_key(str_replace('pa_', '', $t)),
        array_keys($attributes_to_show)
    );
    $active_filters = array_filter($filter_keys, fn($k) => !empty($_GET[$k]));

    if (!empty($active_filters)) {
        echo '<a href="' . esc_url(remove_query_arg($filter_keys)) . '" class="barel-filter-reset">✕ נקה פילטרים</a>';
    }

    echo '</div>';
}

// סנן מוצרים לפי כל הפילטרים הפעילים
add_action('woocommerce_product_query', function($q) {
    $attr_map = [
        'filter_brand'      => 'pa_brand',
        'filter_סוג-הפעלה' => 'pa_סוג-הפעלה',
        'filter_מידה'       => 'pa_מידה',
        'filter_size'       => 'pa_size',
        'filter_כמות'       => 'pa_כמות',
        'filter_color'      => 'pa_color',
        'filter_מל'         => 'pa_מל',
        'filter_גוף-בלבד'  => 'pa_גוף-בלבד',
    ];

    $tax_query = (array) $q->get('tax_query');
    $has_filter = false;

    foreach ($attr_map as $param => $taxonomy) {
        if (!empty($_GET[$param])) {
            $tax_query[] = [
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET[$param]),
            ];
            $has_filter = true;
        }
    }

    if ($has_filter) {
        $q->set('tax_query', $tax_query);
    }
});

/* ── SIDEBAR FILTERS (category-relevant) ───────────────────────────── */

function barel_get_relevant_filters() {
    $tax_query = [];
    if (is_product_category()) {
        $current_cat = get_queried_object();
        $tax_query[] = [
            'taxonomy'         => 'product_cat',
            'field'            => 'term_id',
            'terms'            => $current_cat->term_id,
            'include_children' => true,
        ];
    }

    $products_in_cat = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => $tax_query,
    ]);

    if (empty($products_in_cat)) return [];

    $all_attrs = wc_get_attribute_taxonomies();
    $filters = [];

    foreach ($all_attrs as $attr) {
        $taxonomy  = 'pa_' . $attr->attribute_name;
        $attr_terms = [];

        foreach ($products_in_cat as $pid) {
            $terms = wc_get_product_terms($pid, $taxonomy, ['fields' => 'all']);
            foreach ($terms as $term) {
                if (!isset($attr_terms[$term->term_id])) {
                    $attr_terms[$term->term_id] = [
                        'name'  => $term->name,
                        'slug'  => $term->slug,
                        'count' => 0,
                    ];
                }
                $attr_terms[$term->term_id]['count']++;
            }
        }

        if (count($attr_terms) >= 2) {
            uasort($attr_terms, fn($a,$b) => $b['count'] - $a['count']);
            $filters[$taxonomy] = [
                'label' => $attr->attribute_label,
                'terms' => $attr_terms,
                'key'   => 'filter_' . sanitize_key($attr->attribute_name),
            ];
        }
    }

    return $filters;
}

function barel_render_sidebar_filters() {
    $filters = barel_get_relevant_filters();
    if (empty($filters)) return;

    $current_filters = $_GET ?? [];

    echo '<div class="sidebar-filters">';

    foreach ($filters as $taxonomy => $filter) {
        $current_val = $current_filters[$filter['key']] ?? '';

        echo '<div class="sidebar-filter-group">';
        echo '<div class="sidebar-filter-title">' . esc_html($filter['label']) . '</div>';
        echo '<div class="sidebar-filter-options">';

        foreach ($filter['terms'] as $tid => $term) {
            $active = ($current_val === $term['slug']) ? 'active' : '';
            $url    = ($current_val === $term['slug'])
                ? remove_query_arg($filter['key'])
                : add_query_arg($filter['key'], $term['slug']);

            echo '<a href="' . esc_url($url) . '" class="sidebar-filter-chip ' . $active . '">';
            echo '<span class="sfc-name">' . esc_html($term['name']) . '</span>';
            echo '<span class="sfc-cnt">' . $term['count'] . '</span>';
            echo '</a>';
        }

        echo '</div></div>';
    }

    $all_keys    = array_column($filters, 'key');
    $active_any  = array_filter($all_keys, fn($k) => !empty($_GET[$k]));
    if (!empty($active_any)) {
        echo '<a href="' . esc_url(remove_query_arg($all_keys)) . '" class="sidebar-filter-reset">✕ נקה פילטרים</a>';
    }

    echo '</div>';
}

/* ── BRAND LOGO on single product ──────────────────────────────────── */
add_action('woocommerce_single_product_summary', 'barel_show_brand_logo', 3);

function barel_show_brand_logo() {
    global $product;
    $brands = wc_get_product_terms($product->get_id(), 'pa_brand', ['fields'=>'all']);
    if (empty($brands)) return;

    $brand   = $brands[0];
    $logo_id = get_term_meta($brand->term_id, 'brand_logo_id', true);

    echo '<div class="barel-brand-wrap">';
    if ($logo_id) {
        echo '<a href="'.esc_url(get_term_link($brand)).'" class="barel-brand-logo-link">';
        echo wp_get_attachment_image($logo_id, 'thumbnail', false, ['class'=>'barel-brand-logo']);
        echo '</a>';
    } else {
        echo '<a href="'.esc_url(get_term_link($brand)).'" class="barel-brand-name-link">';
        echo '<span class="barel-brand-name">'.esc_html($brand->name).'</span>';
        echo '</a>';
    }
    echo '</div>';
}

// ══ פילטר מותג רלוונטי לקטגוריה ══
add_action('woocommerce_before_shop_loop', 'barel_brand_filter', 15);

function barel_brand_filter() {
    if (!is_shop() && !is_product_category()) return;

    $tax_query = [];
    if (is_product_category()) {
        $cat = get_queried_object();
        $tax_query[] = [
            'taxonomy'         => 'product_cat',
            'field'            => 'term_id',
            'terms'            => $cat->term_id,
            'include_children' => true,
        ];
    }

    $product_ids = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => $tax_query,
    ]);

    if (empty($product_ids)) return;

    $brands = [];
    foreach ($product_ids as $pid) {
        $terms = wc_get_product_terms($pid, 'pa_brand', ['fields' => 'all']);
        foreach ($terms as $term) {
            if (!isset($brands[$term->term_id])) {
                $brands[$term->term_id] = ['name' => $term->name, 'slug' => $term->slug, 'count' => 0];
            }
            $brands[$term->term_id]['count']++;
        }
    }

    $power_types = [];
    foreach ($product_ids as $pid) {
        $terms = wc_get_product_terms($pid, 'pa_סוג-הפעלה', ['fields' => 'all']);
        foreach ($terms as $term) {
            if (!isset($power_types[$term->term_id])) {
                $power_types[$term->term_id] = ['name' => $term->name, 'slug' => $term->slug, 'count' => 0];
            }
            $power_types[$term->term_id]['count']++;
        }
    }

    if (empty($brands) && empty($power_types)) return;

    uasort($brands, fn($a,$b) => $b['count'] - $a['count']);

    $current_brand = $_GET['filter_brand'] ?? '';
    $current_power = $_GET['filter_power'] ?? '';
    $has_filter    = $current_brand || $current_power;

    echo '<div class="barel-filter-bar">';

    if (!empty($brands)) {
        echo '<div class="barel-filter-section">';
        echo '<div class="barel-filter-label">🏷️ מותג</div>';
        echo '<div class="barel-filter-chips">';
        foreach ($brands as $brand) {
            $active = $current_brand === $brand['slug'] ? 'active' : '';
            $url    = $current_brand === $brand['slug']
                ? remove_query_arg('filter_brand')
                : add_query_arg('filter_brand', $brand['slug']);
            echo '<a href="' . esc_url($url) . '" class="barel-chip ' . $active . '">';
            echo esc_html($brand['name']);
            echo '<span class="barel-chip-cnt">' . $brand['count'] . '</span>';
            echo '</a>';
        }
        echo '</div></div>';
    }

    if (!empty($power_types) && count($power_types) >= 2) {
        echo '<div class="barel-filter-section">';
        echo '<div class="barel-filter-label">⚡ סוג הפעלה</div>';
        echo '<div class="barel-filter-chips">';
        foreach ($power_types as $pt) {
            $active = $current_power === $pt['slug'] ? 'active' : '';
            $url    = $current_power === $pt['slug']
                ? remove_query_arg('filter_power')
                : add_query_arg('filter_power', $pt['slug']);
            echo '<a href="' . esc_url($url) . '" class="barel-chip ' . $active . '">';
            echo esc_html($pt['name']);
            echo '<span class="barel-chip-cnt">' . $pt['count'] . '</span>';
            echo '</a>';
        }
        echo '</div></div>';
    }

    if ($has_filter) {
        echo '<a href="' . esc_url(remove_query_arg(['filter_brand','filter_power'])) . '" class="barel-filter-reset">✕ נקה פילטרים</a>';
    }

    echo '</div>';
}

add_action('woocommerce_product_query', function($q) {
    $tax_query = (array) $q->get('tax_query');

    if (!empty($_GET['filter_brand'])) {
        $tax_query[] = [
            'taxonomy' => 'pa_brand',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['filter_brand']),
        ];
    }
    if (!empty($_GET['filter_power'])) {
        $tax_query[] = [
            'taxonomy' => 'pa_סוג-הפעלה',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['filter_power']),
        ];
    }

    if (!empty($_GET['filter_brand']) || !empty($_GET['filter_power'])) {
        $q->set('tax_query', $tax_query);
    }
});
