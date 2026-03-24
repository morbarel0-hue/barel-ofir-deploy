<?php
/**
 * Custom Single Product Template — matches barel-product.html
 */
if (!defined('ABSPATH')) exit;
get_header();
while (have_posts()) : the_post();
global $product;
$product = wc_get_product(get_the_ID());
if (!$product) { get_footer(); return; }

$title       = $product->get_name();
$price_html  = $product->get_price_html();
$regular_price = $product->get_regular_price();
$sale_price  = $product->get_sale_price();
$on_sale     = $product->is_on_sale();
$in_stock    = $product->is_in_stock();
$sku         = $product->get_sku();
$brand       = get_post_meta(get_the_ID(), 'brand', true) ?: '';
$avg_rating  = $product->get_average_rating();
$review_count = $product->get_review_count();

// Gallery images
$attachment_ids = $product->get_gallery_image_ids();
$main_image_id  = $product->get_image_id();
$main_image_url = $main_image_id ? wp_get_attachment_image_url($main_image_id, 'woocommerce_single') : wc_placeholder_img_src('woocommerce_single');

// Discount %
$discount = '';
if ($on_sale && $regular_price && $sale_price) {
    $discount = round((($regular_price - $sale_price) / $regular_price) * 100) . '%';
}

// Breadcrumb
$term = null;
$cats = get_the_terms(get_the_ID(), 'product_cat');
if ($cats && !is_wp_error($cats)) {
    $term = $cats[0];
}
?>

<!-- BREADCRUMB -->
<div class="breadcrumb">
  <div class="breadcrumb-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>">בית</a>
    <span>›</span>
    <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>">חנות</a>
    <?php if ($term): ?>
      <span>›</span>
      <?php $ancs = get_ancestors($term->term_id, 'product_cat');
      foreach (array_reverse($ancs) as $ai): $an = get_term($ai, 'product_cat'); ?>
        <a href="<?php echo esc_url(get_term_link($an)); ?>"><?php echo esc_html($an->name); ?></a>
        <span>›</span>
      <?php endforeach; ?>
      <a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
      <span>›</span>
    <?php endif; ?>
    <strong><?php echo esc_html($title); ?></strong>
  </div>
</div>

<!-- PRODUCT MAIN -->
<div class="product-main sp-product-main" itemscope itemtype="https://schema.org/Product">

  <!-- GALLERY -->
  <div class="sp-gallery">
    <div class="gallery-main" id="spMainImg">
      <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr($title); ?>" itemprop="image" />
      <?php if ($on_sale && $discount): ?>
        <div class="gallery-badge">-<?php echo esc_html($discount); ?></div>
      <?php endif; ?>
      <?php if (!$in_stock): ?>
        <div class="gallery-badge" style="background:#666;">אזל מהמלאי</div>
      <?php endif; ?>
    </div>
    <?php if (!empty($attachment_ids)): ?>
    <div class="gallery-thumbs">
      <div class="thumb active" onclick="spSetImg(this,'<?php echo esc_url($main_image_url); ?>')">
        <img src="<?php echo esc_url(wp_get_attachment_image_url($main_image_id, 'thumbnail')); ?>" alt="" />
      </div>
      <?php foreach ($attachment_ids as $aid):
        $turl = wp_get_attachment_image_url($aid, 'thumbnail');
        $full = wp_get_attachment_image_url($aid, 'woocommerce_single');
      ?>
      <div class="thumb" onclick="spSetImg(this,'<?php echo esc_url($full); ?>')">
        <img src="<?php echo esc_url($turl); ?>" alt="" />
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

  <!-- PRODUCT INFO -->
  <div class="sp-info" itemprop="name">
    <?php if ($brand): ?>
      <div class="prod-brand-tag"><?php echo esc_html($brand); ?></div>
    <?php endif; ?>
    <h1 class="prod-title" itemprop="name"><?php echo esc_html($title); ?></h1>

    <?php if ($avg_rating > 0 || $review_count >= 0): ?>
    <div class="prod-rating">
      <span class="stars"><?php echo wc_get_rating_html($avg_rating, $review_count); ?></span>
      <?php if ($review_count > 0): ?>
        <span class="rating-num"><?php echo number_format($avg_rating, 1); ?></span>
        <span class="rating-count">(<?php echo intval($review_count); ?> ביקורות)</span>
      <?php endif; ?>
      <?php if ($in_stock): ?>
        <span class="in-stock">✓ במלאי</span>
      <?php else: ?>
        <span class="in-stock" style="background:#ffe8e8;color:#c0001a;">✗ אזל</span>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="price-section" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
      <?php if ($on_sale && $sale_price): ?>
        <div>
          <span class="price-now">₪<?php echo number_format((float)$sale_price, 2); ?></span>
          <span class="price-was">₪<?php echo number_format((float)$regular_price, 2); ?></span>
          <?php if ($discount): ?>
            <span class="price-discount">-<?php echo esc_html($discount); ?></span>
          <?php endif; ?>
        </div>
        <div class="price-save-msg">חסכת ₪<?php echo number_format($regular_price - $sale_price, 2); ?> בהזמנה זו!</div>
      <?php else: ?>
        <span class="price-now">₪<?php echo number_format((float)$product->get_price(), 2); ?></span>
      <?php endif; ?>
      <meta itemprop="price" content="<?php echo esc_attr($product->get_price()); ?>" />
      <meta itemprop="priceCurrency" content="ILS" />
    </div>

    <?php if ($sku): ?>
      <div style="font-size:12px;color:#888;margin-bottom:12px;">מק״ט: <?php echo esc_html($sku); ?></div>
    <?php endif; ?>

    <!-- Add to Cart -->
    <div class="sp-atc-wrap">
      <?php woocommerce_template_single_add_to_cart(); ?>
    </div>

    <!-- Trust Mini Badges -->
    <div class="trust-mini">
      <div class="trust-mini-item"><span class="trust-mini-icon">🚚</span> משלוח מהיר לכל הארץ</div>
      <div class="trust-mini-item"><span class="trust-mini-icon">🔄</span> החזרה תוך 30 יום</div>
      <div class="trust-mini-item"><span class="trust-mini-icon">🛡️</span> תשלום מאובטח 100%</div>
      <div class="trust-mini-item"><span class="trust-mini-icon">🏆</span> אחריות יצרן מלאה</div>
    </div>

    <!-- Share Row -->
    <div class="share-row">
      <span>שתף:</span>
      <a href="https://wa.me/?text=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="share-btn">💬</a>
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="share-btn">📘</a>
    </div>
  </div>

</div><!-- .product-main -->

<!-- PRODUCT TABS -->
<div class="product-tabs">
  <div class="tabs-nav" role="tablist">
    <button class="tab-btn active" onclick="spTab(this,'desc')" role="tab">תיאור מוצר</button>
    <?php $attrs = $product->get_attributes();
    if (!empty($attrs)): ?>
      <button class="tab-btn" onclick="spTab(this,'specs')" role="tab">מפרט טכני</button>
    <?php endif; ?>
    <?php if ($review_count > 0 || comments_open()): ?>
      <button class="tab-btn" onclick="spTab(this,'reviews')" role="tab">ביקורות (<?php echo $review_count; ?>)</button>
    <?php endif; ?>
  </div>

  <div class="tab-content active" id="sp-tab-desc">
    <?php the_content(); ?>
  </div>

  <?php if (!empty($attrs)): ?>
  <div class="tab-content" id="sp-tab-specs">
    <table class="specs-table">
      <?php foreach ($attrs as $attr):
        $name = wc_attribute_label($attr->get_name());
        $values = $attr->is_taxonomy()
          ? implode(', ', wc_get_product_terms($product->get_id(), $attr->get_name(), ['fields' => 'names']))
          : implode(', ', $attr->get_options());
      ?>
        <tr>
          <td><?php echo esc_html($name); ?></td>
          <td><?php echo esc_html($values); ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if ($sku): ?>
        <tr><td>מק"ט</td><td><?php echo esc_html($sku); ?></td></tr>
      <?php endif; ?>
    </table>
  </div>
  <?php endif; ?>

  <?php if ($review_count > 0 || comments_open()): ?>
  <div class="tab-content" id="sp-tab-reviews">
    <?php comments_template(); ?>
  </div>
  <?php endif; ?>
</div>

<!-- RELATED PRODUCTS -->
<?php
$related_ids = wc_get_related_products($product->get_id(), 4);
if (!empty($related_ids)): ?>
<div class="related-section">
  <div class="sec-head">
    <div class="sec-title">מוצרים קשורים</div>
    <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="see-all">לכל המוצרים →</a>
  </div>
  <div class="products-grid related-grid">
    <?php foreach ($related_ids as $rid): barel_render_product_card($rid); endforeach; ?>
  </div>
</div>
<?php endif; ?>

<script>
function spSetImg(el, url) {
  document.getElementById('spMainImg').querySelector('img').src = url;
  document.querySelectorAll('.thumb').forEach(function(t){ t.classList.remove('active'); });
  el.classList.add('active');
}
function spTab(el, tab) {
  document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active'); });
  document.querySelectorAll('.tab-content').forEach(function(c){ c.classList.remove('active'); });
  el.classList.add('active');
  var tc = document.getElementById('sp-tab-' + tab);
  if (tc) tc.classList.add('active');
}
</script>

<?php endwhile; get_footer(); ?>
