<?php
/**
 * index.php — Default fallback template
 */

get_header();

if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
    woocommerce_content();
} else {
    ?>
    <main id="main-content" class="site-main">
        <div class="container">
            <?php if ( have_posts() ) : ?>
                <div class="posts-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="post-card__thumb">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                </a>
                            <?php endif; ?>
                            <div class="post-card__body">
                                <time class="post-card__date" datetime="<?php echo get_the_date( 'c' ); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                                <h2 class="post-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="post-card__excerpt"><?php the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="btn btn--outline btn--sm">קרא עוד &rsaquo;</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <div class="pagination">
                    <?php the_posts_pagination( [ 'mid_size' => 2, 'prev_text' => '&rsaquo;', 'next_text' => '&lsaquo;' ] ); ?>
                </div>
            <?php else : ?>
                <div class="no-results">
                    <h1>אין תוצאות</h1>
                    <p>לא נמצאו פוסטים. נסו לחפש משהו אחר.</p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php
}

get_footer();
