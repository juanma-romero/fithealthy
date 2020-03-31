<?php
/**
 * The template for displaying search results pages.
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
wp_deregister_style('cvca-style');
get_header();
?>
    <main id="main" class="wrap-site-main archive-page block-page">
        <div class="container">
            <div class="row">
                <?php get_sidebar(); ?>
                <div class="<?php echo esc_attr($main_class) ?>">
                    <header class="page-header">
                        <h2 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'fona'), get_search_query()); ?></h2>
                    </header>

                    <?php if (have_posts()) : while (have_posts()) : the_post();
                        ?>
                        <div class="row"><?php
                            get_template_part('inc/templates/posts/archive/' . $zoo_block_layout, 'layout');
                            ?>
                        </div>
                    <?php
                    endwhile;
                    else :
                        get_template_part('content', 'none');
                    endif; ?>
                    <?php get_template_part('inc/templates/posts/post', 'pagination'); ?>
                </div>
                <?php get_sidebar('right'); ?>
            </div>
        </div>
    </main> <!-- #main -->
<?php
get_footer();
