<?php
/**
 * The main template file
 *
 * @package Hub_Marketeria
 */

get_header(); ?>

<div class="main-content">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php _e('No content found.', 'hub-marketeria'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
