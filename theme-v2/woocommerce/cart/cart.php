<?php defined('ABSPATH') || exit;
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
woocommerce_output_all_notices(); ?>

<div class="breadcrumb"><div class="breadcrumb-inner"><a href="<?php echo esc_url(home_url('/')); ?>">בית</a><span>›</span><strong>עגלת קניות</strong></div></div>

<div class="page-title">
  <h1>עגלת קניות</h1>
  <p><?php echo WC()->cart->get_cart_contents_count(); ?> פריטים בעגלה שלך</p>
</div>

<div class="checkout-steps">
  <div class="step active"><div class="step-num">1</div><span>עגלה</span></div>
  <div class="step-line active"></div>
  <div class="step"><div class="step-num">2</div><span>פרטים</span></div>
  <div class="step-line"></div>
  <div class="step"><div class="step-num">3</div><span>תשלום</span></div>
  <div class="step-line"></div>
  <div class="step"><div class="step-num">4</div><span>אישור</span></div>
</div>

<div class="cart-layout">
  <div class="cart-main">
    <form class="cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
      <div class="cart-table">
        <div class="cart-table-head">
          <span>מוצר</span>
          <span>מחיר</span>
          <span>כמות</span>
          <span>סה"כ</span>
          <span></span>
        </div>
        <?php foreach(WC()->cart->get_cart() as $cik=>$ci):
          $prod=apply_filters('woocommerce_cart_item_product',$ci['data'],$ci,$cik);
          $pid=apply_filters('woocommerce_cart_item_product_id',$ci['product_id'],$ci,$cik);
          if(!$prod||!$prod->exists()||$ci['quantity']===0) continue;
          $link=apply_filters('woocommerce_cart_item_permalink',$prod->is_visible()?get_permalink($pid):'',$ci,$cik);
          $iu=get_the_post_thumbnail_url($pid,'woocommerce_thumbnail');
          $brand=get_post_meta($pid,'_brand',true); ?>
          <div class="cart-item">
            <div class="cart-item-info">
              <div class="cart-item-img"><?php if($iu): ?><a href="<?php echo esc_url($link); ?>"><img src="<?php echo esc_url($iu); ?>" alt="" /></a><?php else: ?><span style="font-size:40px">📦</span><?php endif; ?></div>
              <div>
                <?php if($brand): ?><div class="cart-item-brand"><?php echo esc_html($brand); ?></div><?php endif; ?>
                <div class="cart-item-name"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($prod->get_name()); ?></a></div>
                <?php if($prod->get_sku()): ?><div class="cart-item-sku"><?php echo esc_html($prod->get_sku()); ?></div><?php endif; ?>
              </div>
            </div>
            <div class="cart-item-price"><?php echo wc_price($prod->get_price()); ?></div>
            <div class="cart-item-qty"><?php echo woocommerce_quantity_input(['input_name'=>"cart[$cik][qty]",'input_value'=>$ci['quantity'],'max_value'=>$prod->get_max_purchase_quantity(),'min_value'=>'0','product_name'=>$prod->get_name()],$prod,false); ?></div>
            <div class="cart-item-total"><?php echo WC()->cart->get_product_subtotal($prod,$ci['quantity']); ?></div>
            <div class="cart-item-remove"><?php echo apply_filters('woocommerce_cart_item_remove_link',sprintf('<a href="%s" class="remove-btn" data-product_id="%s">✕</a>',esc_url(wc_get_cart_remove_url($cik)),esc_attr($pid)),$cik); ?></div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="cart-actions">
        <?php if(wc_coupons_enabled()): ?>
        <div class="cart-coupon">
          <input type="text" name="coupon_code" class="inp" id="coupon_code" placeholder="קוד קופון..." />
          <button type="submit" class="cpn-btn" name="apply_coupon" value="החל">החל</button>
        </div>
        <?php endif; ?>
        <button type="submit" class="update-cart-btn" name="update_cart" value="1">🔄 עדכן עגלה</button>
      </div>
      <?php wp_nonce_field('woocommerce-cart','woocommerce-cart-nonce'); ?>
    </form>
  </div>

  <div class="cart-sidebar">
    <div class="order-summary">
      <h3>סיכום הזמנה</h3>
      <?php woocommerce_cart_totals(); ?>
      <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-btn">🔒 המשך לתשלום</a>
      <a href="<?php echo esc_url($shop_url); ?>" class="continue-shopping">← המשך קניות</a>
    </div>
    <div class="cart-trust">
      <div>🔒 תשלום מאובטח SSL</div>
      <div>🚚 משלוח מהיר לכל הארץ</div>
      <div>↩️ החזרה ב-30 יום</div>
      <div>💳 עד 12 תשלומים</div>
    </div>
  </div>
</div>
