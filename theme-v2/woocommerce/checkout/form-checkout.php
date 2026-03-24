<?php defined('ABSPATH') || exit; if (!is_checkout()) return;
do_action('woocommerce_before_checkout_form', $checkout);
$delivery=barel_get_delivery_date(7); ?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>">
<div class="pg">
<div class="pg-left">
<div class="card"><div class="sec">&#128100; פרטים אישיים</div>
<?php $fields=$checkout->get_checkout_fields('billing'); ?>
<div class="g2">
<?php foreach(['billing_first_name','billing_last_name'] as $key): if(isset($fields[$key])) woocommerce_form_field($key,$fields[$key],$checkout->get_value($key)); endforeach; ?>
</div><div class="g2">
<?php foreach(['billing_email','billing_phone'] as $key): if(isset($fields[$key])) woocommerce_form_field($key,$fields[$key],$checkout->get_value($key)); endforeach; ?>
</div></div>
<div class="card"><div class="sec">&#128230; כתובת למשלוח</div>
<div class="g1">
<?php foreach(['billing_address_1','billing_address_2','billing_city','billing_state','billing_postcode'] as $key): if(isset($fields[$key])) woocommerce_form_field($key,$fields[$key],$checkout->get_value($key)); endforeach; ?>
</div>
<?php if(apply_filters('woocommerce_enable_order_notes_field','yes'===get_option('woocommerce_enable_order_comments','yes'))): ?>
<div class="f"><label class="lbl" for="order_comments">הערות להזמנה (אופציונלי)</label><textarea name="order_comments" id="order_comments" class="inp" rows="3" placeholder="הערות לשליח..."><?php echo esc_textarea($checkout->get_value('order_comments')); ?></textarea></div>
<?php endif; ?></div>
<div class="card"><div class="sec">&#128666; אופן משלוח</div><?php wc_cart_totals_shipping_html(); ?></div>
<div class="card"><div class="sec">&#128179; אמצעי תשלום</div><?php do_action('woocommerce_checkout_payment'); ?></div>
<?php if(wc_coupons_enabled()): ?>
<div class="card"><a class="cpn-link" onclick="document.getElementById('cpnWrap').style.display='flex';this.style.display='none'">&#127991;&#65039; יש לך קוד קופון?</a>
<div class="cpn-wrap" id="cpnWrap" style="display:none"><input type="text" class="inp" id="couponCode" placeholder="קוד קופון..." /><button type="button" class="cpn-btn" onclick="applyCoupon()">החל</button></div>
<div class="cpn-msg" id="cpnMsg"></div></div>
<?php endif; ?>
</div>
<div class="pg-right">
<div class="summary-card" id="order-review">
<div class="sum-title">סיכום הזמנה</div>
<div class="sum-items">
<?php foreach(WC()->cart->get_cart() as $ik=>$item):
  $prod=apply_filters('woocommerce_cart_item_product',$item['data'],$item,$ik);
  $pid=apply_filters('woocommerce_cart_item_product_id',$item['product_id'],$item,$ik);
  if(!$prod||!$prod->exists()||$item['quantity']===0) continue;
  $iu=get_the_post_thumbnail_url($pid,'thumbnail'); ?>
  <div class="sum-item">
    <div class="sum-item-img"><?php if($iu): ?><img src="<?php echo esc_url($iu); ?>" alt="" /><?php else: ?><span>&#128230;</span><?php endif; ?><span class="sum-item-qty"><?php echo $item['quantity']; ?></span></div>
    <div class="sum-item-details"><div class="sum-item-name"><?php echo esc_html($prod->get_name()); ?></div><?php if($prod->get_sku()): ?><div class="sum-item-sku">מקט: <?php echo esc_html($prod->get_sku()); ?></div><?php endif; ?></div>
    <div class="sum-item-price"><?php echo WC()->cart->get_product_subtotal($prod,$item['quantity']); ?></div>
  </div>
<?php endforeach; ?>
</div>
<div class="sum-totals">
<div class="sum-row"><span>סכום ביניים</span><span><?php wc_cart_totals_subtotal_html(); ?></span></div>
<?php foreach(WC()->cart->get_coupons() as $code=>$coupon): ?>
<div class="sum-row sum-coupon"><span>קופון: <?php echo esc_html($code); ?></span><span><?php wc_cart_totals_coupon_html($coupon); ?></span></div>
<?php endforeach; ?>
<div class="sum-row"><span>משלוח</span><span><?php wc_cart_totals_shipping_html(); ?></span></div>
<?php if(wc_tax_enabled()): ?><div class="sum-row"><span>מע"מ</span><span><?php wc_cart_totals_taxes_total_html(); ?></span></div><?php endif; ?>
<div class="sum-row sum-total"><span>סה"כ לתשלום</span><span><?php wc_cart_totals_order_total_html(); ?></span></div>
</div>
<div class="delivery-estimate">&#128666; משלוח מהיר: עד <?php echo esc_html($delivery); ?></div>
<div class="sum-trust"><div>&#128274; תשלום מאובטח</div><div>&#8617;&#65039; החזרה 30 יום</div><div>&#127942; אחריות יצרן</div></div>
<?php do_action('woocommerce_review_order_before_submit'); ?>
<button type="submit" class="place-order-btn" id="place_order" name="woocommerce_checkout_place_order" value="1">&#128274; אישור והשלמת הזמנה</button>
<?php do_action('woocommerce_review_order_after_submit'); ?>
<?php wp_nonce_field('woocommerce-process_checkout','woocommerce-process-checkout-nonce'); ?>
</div></div></div></form>
<script>
function applyCoupon(){var code=document.getElementById('couponCode').value.trim(),msg=document.getElementById('cpnMsg');if(!code)return;
jQuery.post(BarelData.ajaxUrl,{action:'woocommerce_apply_coupon',security:wc_checkout_params?.apply_coupon_nonce||'',coupon_code:code},function(r){
msg.textContent=r.success?'הקופון הוחל!':'קוד לא תקין';msg.style.color=r.success?'#1a7a3a':'#c0001a';if(r.success)location.reload();});}</script>
<?php do_action('woocommerce_after_checkout_form',$checkout); ?>
