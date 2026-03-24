<?php
/**
 * single.php — Single post fallback
 */

get_header();
?>
<main id="main-content" class="site-main single-main">
    <div class="container container--narrow">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>
                <header class="single-post__header">
                    <div class="single-post__meta">
                        <time datetime="<?php echo get_the_date( 'c' ); ?>" class="single-post__date">
                            <?php echo get_the_date(); ?>
                        </time>
                        <?php
                        $cats = get_the_category();
                        if ( $cats ) {
                            echo '<span class="single-post__cat">' . esc_html( $cats[0]->name ) . '</span>';
                        }
                        ?>
                    </div>
                    <h1 class="single-post__title"><?php the_title(); ?></h1>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="single-post__thumb">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                    <?php endif; ?>
                </header>
                <div class="single-post__body entry-content">
                    <?php the_content(); ?>
                </div>
                <footer class="single-post__footer">
                    <div class="post-nav">
                        <?php
                        $prev = get_previous_post();
                        $next = get_next_post();
                        if ( $prev ) {
                            echo '<a href="' . get_permalink( $prev ) . '" class="post-nav__link post-nav__link--prev">&rsaquo; ' . esc_html( get_the_title( $prev ) ) . '</a>';
                        }
                        if ( $next ) {
                            echo '<a href="' . get_permalink( $next ) . '" class="post-nav__link post-nav__link--next">' . esc_html( get_the_title( $next ) ) . ' &lsaquo;</a>';
                        }
                        ?>
                    </div>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>
