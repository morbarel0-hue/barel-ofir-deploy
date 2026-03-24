<?php
/**
 * woocommerce.php — WooCommerce template wrapper
 */

get_header();
?>
<div class="container" style="padding-block: 40px;">
<?php woocommerce_content(); ?>
</div>
<?php
get_footer();
