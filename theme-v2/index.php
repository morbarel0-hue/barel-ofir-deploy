<?php get_header(); ?>
<div class="container" style="max-width:1280px;margin:40px auto;padding:0 20px">
  <?php if (have_posts()): ?>
    <div class="products-grid">
      <?php while (have_posts()): the_post(); ?>
        <?php barel_render_product_card(get_the_ID()); ?>
      <?php endwhile; ?>
    </div>
    <?php the_posts_pagination(); ?>
  <?php else: ?>
    <div style="text-align:center;padding:80px 20px">
      <div style="font-size:60px">🔍</div>
      <h2>לא נמצא תוכן</h2>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary" style="display:inline-block;margin-top:20px">לדף הבית</a>
    </div>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
