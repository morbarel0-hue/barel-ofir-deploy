<?php get_header(); global $product;
while(have_posts()): the_post();
$product=$prod=wc_get_product(get_the_ID()); if(!$product)continue;
$pid=$product->get_id(); $name=$product->get_name();
$price=$product->get_price(); $reg=$product->get_regular_price();
$sale=$product->get_sale_price(); $is_sale=$product->is_on_sale();
$is_stock=$product->is_in_stock(); $sku=$product->get_sku();
$rating=$product->get_average_rating(); $rev_count=$product->get_review_count();
$brand=get_post_meta($pid,'_brand',true);
$gal_ids=$product->get_gallery_image_ids();
$main_img=get_the_post_thumbnail_url($pid,'woocommerce_single');
$cat_terms=get_the_terms($pid,'product_cat');
$cat_name=($cat_terms&&!is_wp_error($cat_terms))?$cat_terms[0]->name:'';
$cat_link=($cat_terms&&!is_wp_error($cat_terms))?get_term_link($cat_terms[0]):'';
$discount=($is_sale&&$reg>0&&$sale>0)?round((1-$sale/$reg)*100):0;
$delivery=barel_get_delivery_date(7); ?>
<div class="breadcrumb"><div class="breadcrumb-inner">
<a href="<?php echo esc_url(home_url('/')); ?>">בית</a><span>&rsaquo;</span>
<?php if($cat_link): ?><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a><span>&rsaquo;</span><?php endif; ?>
<strong><?php echo esc_html($name); ?></strong>
</div></div>
<div class="product-wrap"><div class="product-main">
<div class="gallery"><div class="gallery-main" id="galleryMain">
<?php if($main_img): ?><img src="<?php echo esc_url($main_img); ?>" alt="<?php echo esc_attr($name); ?>" id="mainProductImg" /><?php else: ?><div style="font-size:80px;display:flex;align-items:center;justify-content:center;height:100%">&#128295;</div><?php endif; ?>
<?php if($discount): ?><div class="gallery-badge">-<?php echo $discount; ?>% הנחה</div><?php endif; ?>
</div>
<?php if(count($gal_ids)): ?><div class="gallery-thumbs">
<?php if($main_img): ?><div class="thumb active" onclick="setMainImg(this,'<?php echo esc_js($main_img); ?>')"><img src="<?php echo esc_url($main_img); ?>" alt="" /></div><?php endif; ?>
<?php foreach($gal_ids as $gi): $gu=wp_get_attachment_image_url($gi,'woocommerce_thumbnail'); ?>
<div class="thumb" onclick="setMainImg(this,'<?php echo esc_js($gu); ?>')"><img src="<?php echo esc_url($gu); ?>" alt="" /></div>
<?php endforeach; ?></div><?php endif; ?>
</div>
<div class="product-info">
<?php if($brand): ?><div class="prod-brand-tag"><?php echo esc_html($brand); ?></div><?php endif; ?>
<h1 class="prod-title"><?php echo esc_html($name); ?></h1>
<?php if($rating>0): ?><div class="prod-rating"><span class="stars"><?php echo str_repeat('&#9733;',round($rating)).str_repeat('&#9734;',5-round($rating)); ?></span> <span class="rating-num"><?php echo number_format($rating,1); ?></span></div><?php endif; ?>
<?php $short=$product->get_short_description(); if($short): ?><div class="prod-short-desc"><?php echo wp_kses_post($short); ?></div><?php endif; ?>
<div class="prod-price-wrap">
<div class="prod-price"><?php echo wc_price($price); ?></div>
<?php if($is_sale&&$reg): ?><div class="prod-price-old"><?php echo wc_price($reg); ?></div><div class="prod-discount">-<?php echo $discount; ?>%</div><?php endif; ?>
</div>
<div class="prod-meta">
<?php if($sku): ?><div class="prod-meta-item"><span>מקט:</span> <?php echo esc_html($sku); ?></div><?php endif; ?>
<?php if($cat_name): ?><div class="prod-meta-item"><span>קטגוריה:</span> <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></div><?php endif; ?>
<?php echo $is_stock?'<div class="prod-meta-item prod-instock">&#9989; במלאי</div>':'<div class="prod-meta-item prod-outstock">&#10060; אזל</div>'; ?>
</div>
<?php if($is_stock): ?>
<div class="prod-atc-wrap">
<div class="qty-wrap"><button class="qty-btn" onclick="changeQty(-1)">&#8722;</button><input type="number" id="productQty" class="qty-input" value="1" min="1" max="<?php echo $product->get_stock_quantity()?:99; ?>" /><button class="qty-btn" onclick="changeQty(1)">+</button></div>
<button class="atc-btn" id="addToCartBtn" data-product-id="<?php echo $pid; ?>" data-nonce="<?php echo wp_create_nonce('barel_nonce'); ?>">&#128722; הוסף לעגלה</button>
</div>
<div class="atc-feedback" id="atcFeedback" style="display:none;"></div>
<?php
$checkout_url = add_query_arg(['add-to-cart' => $pid, 'quantity' => 1], wc_get_checkout_url());
echo '<a href="' . esc_url($checkout_url) . '" class="barel-buy-now">⚡ קנה עכשיו</a>';
?>
<?php else: ?><div class="prod-oos-msg">המוצר אינו זמין כרגע</div><?php endif; ?>
<div class="product-trust">
  <div class="product-trust-item">
    <span class="product-trust-icon">🚚</span>
    <div>
      <div class="product-trust-title">משלוח מהיר</div>
      <div class="product-trust-sub">עד 7 ימי עסקים</div>
    </div>
  </div>
  <div class="product-trust-item">
    <span class="product-trust-icon">↩️</span>
    <div>
      <div class="product-trust-title">החזרה</div>
      <div class="product-trust-sub">תוך 30 יום</div>
    </div>
  </div>
  <div class="product-trust-item">
    <span class="product-trust-icon">🔒</span>
    <div>
      <div class="product-trust-title">תשלום מאובטח</div>
      <div class="product-trust-sub">SSL מוגן</div>
    </div>
  </div>
  <div class="product-trust-item">
    <span class="product-trust-icon">🏆</span>
    <div>
      <div class="product-trust-title">+30 שנות ניסיון</div>
      <div class="product-trust-sub">פעילים מאז 1995</div>
    </div>
  </div>
</div>
</div></div>
<div class="product-tabs">
<div class="tabs-header"><button class="tab-btn active" onclick="showTab('desc',this)">תיאור מוצר</button><button class="tab-btn" onclick="showTab('specs',this)">מפרט טכני</button><?php if($rev_count>0): ?><button class="tab-btn" onclick="showTab('reviews',this)">חוות דעת (<?php echo $rev_count; ?>)</button><?php endif; ?></div>
<div class="tab-panel active" id="tab-desc"><?php $d=$product->get_description();if($d): ?><div class="product-description"><?php echo wp_kses_post($d); ?></div><?php else: ?><p>תיאור המוצר יתעדכן בקרוב.</p><?php endif; ?></div>
<div class="tab-panel" id="tab-specs" style="display:none;"><?php $attrs=$product->get_attributes();if($attrs): ?><table class="specs-table"><?php foreach($attrs as $a){ echo '<tr><th>'.esc_html(wc_attribute_label($a->get_name())).'</th><td>'.esc_html(implode(', ',$a->get_options())).'</td></tr>'; } ?></table><?php else: ?><p>מפרט אינו זמין.</p><?php endif; ?></div>
<?php if($rev_count>0): ?><div class="tab-panel" id="tab-reviews" style="display:none;"><?php comments_template(); ?></div><?php endif; ?>
</div>
<?php $related=wc_get_related_products($pid,4);if($related): ?>
<section class="related-products"><h2 class="related-title">מוצרים קשורים</h2><div class="products-grid"><?php foreach($related as $rp){barel_render_product_card($rp);} ?></div></section>
<?php endif; ?></div>
<script>
function setMainImg(t,u){document.querySelectorAll('.thumb').forEach(function(x){x.classList.remove('active');});t.classList.add('active');var i=document.getElementById('mainProductImg');if(i)i.src=u;}
function changeQty(d){var i=document.getElementById('productQty');if(!i)return;var v=parseInt(i.value)+d;i.value=Math.max(parseInt(i.min)||1,Math.min(parseInt(i.max)||999,v));}
function showTab(n,b){document.querySelectorAll('.tab-panel').forEach(function(p){p.style.display='none';});document.querySelectorAll('.tab-btn').forEach(function(x){x.classList.remove('active');});var p=document.getElementById('tab-'+n);if(p)p.style.display='block';b.classList.add('active');}
document.addEventListener('DOMContentLoaded',function(){
var btn=document.getElementById('addToCartBtn'); if(!btn) return;
btn.addEventListener('click',function(){
  var pid=btn.dataset.productId,nonce=btn.dataset.nonce;
  var qty=document.getElementById('productQty');qty=qty?qty.value:1;
  var fb=document.getElementById('atcFeedback');
  btn.disabled=true; btn.textContent='מוסיף...';
  jQuery.post(BarelData.ajaxUrl,{action:'barel_add_to_cart',product_id:pid,quantity:qty,nonce:nonce},function(r){
    btn.disabled=false; btn.textContent='הוסף לעגלה';
    if(r.success){
      document.querySelectorAll('.cart-n,.barel-cart-b,.barel-cart-count,.cart-count').forEach(function(e){e.textContent=r.data.count;});
      if(fb){fb.textContent=r.data.message;fb.style.display='block';setTimeout(function(){fb.style.display='none';},3000);}
    }
  });
});});
</script>
<?php endwhile; get_footer(); ?>
