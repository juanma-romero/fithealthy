<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$col = 12;
$zoo_block_layout = get_theme_mod('zoo_blog_layout', 'list');
$main_class = 'main-content ';
if (zoo_get_sidebar() != 'none') {
    $col = $col - 4;
    $main_class .= 'has-left-sidebar pull-right';
}
if (zoo_get_sidebar('right') != 'none') {
    $col = $col - 4;
    $main_class .= ' has-right-sidebar pull-left';
}
$main_class .= ' col-xs-12 col-sm-' . $col . ' ' . $zoo_block_layout . '-layout';
get_header(); ?>
    <main id="main" class="wrap-site-main index-page">
        <div class="container">
            <div class="row">
                <?php get_sidebar(); ?>
                <div class="<?php echo esc_attr($main_class) ?>">
                    <div class="row">
                        <?php if (have_posts()) :
                            while (have_posts()) : the_post();
                                get_template_part('inc/templates/posts/archive/' . $zoo_block_layout, 'layout');
                            endwhile;
                        else :
                            get_template_part('content', 'none');
                        endif; ?>
                    </div>
                    <?php get_template_part('inc/templates/posts/post', 'pagination'); ?>
                </div>
                <?php get_sidebar('right'); ?>
            </div>
        </div>
    </main>
<?php
get_footer();