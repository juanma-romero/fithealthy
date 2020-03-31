<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
get_header();?>
    <main id="main" class="single-page">
        <div class="container">
            <?php while (have_posts()) : the_post();
                get_template_part('content', 'page');
                if (comments_open() || get_comments_number()) :
                    comments_template('', true);
                endif;
            endwhile; ?>
        </div>
    </main>
<?php
get_footer();