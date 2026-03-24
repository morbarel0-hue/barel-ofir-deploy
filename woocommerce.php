<?php
/**
 * WooCommerce Template Wrapper
 * This wraps all WooCommerce pages with barel-ofir header/footer
 */
get_header();
?>
<main id="barel-main" class="barel-main barel-woo-main">
  <div class="barel-woo-container">
    <?php woocommerce_content(); ?>
  </div>
</main>
<?php get_footer(); ?>
