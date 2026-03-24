<?php defined('ABSPATH') || exit; ?>
<div class="cart-page">
<div class="cart-empty">
<div class="cart-empty-icon">&#128722;</div>
<h2>העגלה שלך ריקה</h2>
<p>עדיין לא הוספת מוצרים לעגלה. בוא נמצא את מה שאתה מחפש!</p>
<?php $shop=function_exists('wc_get_page_permalink')?wc_get_page_permalink('shop'):home_url('/shop/'); ?>
<a href="<?php echo esc_url($shop); ?>" class="btn-primary">&#128722; לכל המוצרים</a>
</div></div>
