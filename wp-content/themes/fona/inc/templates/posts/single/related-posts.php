<?php
/**
 * Block Related for post
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
if (get_theme_mod('zoo_blog_single_related', '0') == 1) {
    $zoo_categories = get_the_category(get_the_ID());
    $zoo_category_ids = array();
    foreach ($zoo_categories as $zoo_category) $zoo_category_ids[] = $zoo_category->term_id;
    $args = array(
        'post_type' => 'post',
        'post__not_in' => array(get_the_ID()),
        'showposts' => get_theme_mod('zoo_blog_single_related_number_items', '3'),
        'ignore_sticky_posts' => -1
    );
    $zoo_related_query = new wp_query($args);
    if ($zoo_related_query->have_posts()) {
        $class = 'item-related zoo-blog-item layout-item grid-layout-item';
        switch (get_theme_mod('zoo_blog_single_related_number_items', '3')) {
            case '2':
                $class .= "col-xs-12 col-sm-6";
                break;
            case '3':
                $class .= "col-xs-12 col-sm-4";
                break;
            case '4':
                $class .= "col-xs-12 col-sm-3";
                break;
            case '5':
                $class .= "col-xs-12 col-sm-1-5";
                break;
            case '6':
                $class .= "col-xs-12 col-sm-2";
                break;
            default:
                $class .= "col-xs-12 col-sm-12";
                break;
        }
        if (get_post_thumbnail_id() != '') {
            $class .= ' post-has-thumbnail';
        } else {
            $class .= ' post-without-thumbnail';
        }
        ?>
        <div class="post-related">
            <h4 class="title-block"><?php esc_html_e('You Might Also Like', 'fona'); ?></h4>
            <div class="row">
                <?php while ($zoo_related_query->have_posts()) {
                    $zoo_related_query->the_post();

                    ?>
                    <article <?php echo post_class($class) ?>>
                        <div class="zoo-post-inner">
                            <?php get_template_part('inc/templates/posts/archive/media'); ?>
                            <?php
                            the_title(sprintf('<h3 class="title-post"><a href="%s" rel="' . esc_html__('bookmark', 'fona') . '">', esc_url(get_permalink())), '</a></h3>');
                            get_template_part('inc/templates/posts/archive/post', 'info');
                            ?>
                            <?php if (get_the_title() == '') { ?>
                                <a href="<?php echo esc_url(the_permalink()); ?>"
                                   class="readmore"><?php echo esc_html__('Continue Reading', 'fona'); ?></a>
                            <?php } ?>
                        </div>
                    </article>
                    <?php
                } ?>
            </div>
        </div>
    <?php }
    wp_reset_postdata();
}
?>