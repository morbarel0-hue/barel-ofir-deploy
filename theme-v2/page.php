<?php
/**
 * Barel Ofir - Page Template
 * Used for WooCommerce cart, checkout, my-account pages
 */
get_header();
?>
<div class="barel-woo-main">
<?php
while (have_posts()) :
    the_post();
    the_content();
endwhile;
?>
</div>
<?php get_footer(); ?>
