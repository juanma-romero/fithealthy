<?php
/**
 * The template for displaying image attachments
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */

get_header(); ?>
<main id="main" class="wrap-site-main single-main-post">
    <div class="container">

        <?php
        // Start the loop.
        while (have_posts()) : the_post();
            ?>
            <article id="attachment-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="header-post">
                    <?php the_title('<h1 class="title-detail">', '</h1>'); ?>
                </div><!-- .entry-header -->
                <div class="post-content">

                    <div class="entry-attachment">
                        <?php
                        echo wp_get_attachment_image(get_the_ID(), 'full');
                        ?>

                        <?php if (has_excerpt()) : ?>
                            <div class="entry-caption">
                                <?php the_excerpt(); ?>
                            </div><!-- .entry-caption -->
                        <?php endif; ?>
                    </div><!-- .entry-attachment -->

                    <?php
                    the_content();
                    get_template_part('inc/templates/inpost', 'pagination');
                    ?>
                    <?php edit_post_link(__('Edit', 'fona'), '<span class="edit-link">', '</span>'); ?>
                </div>
                <nav id="image-navigation" class="navigation image-navigation">
                    <div class="nav-links">
                        <div class="nav-previous"><?php previous_image_link(false, __('Previous Image', 'fona')); ?></div>
                        <div class="nav-next"><?php next_image_link(false, __('Next Image', 'fona')); ?></div>
                    </div><!-- .nav-links -->
                </nav><!-- .image-navigation -->
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        endwhile;
        ?>
    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>
