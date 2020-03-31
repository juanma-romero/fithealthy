<?php
/**
 * List layout for post
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$class = 'zoo-blog-item layout-item list-layout-item col-xs-12';
if (get_post_thumbnail_id() != '') {
    $class .= ' post-has-thumbnail';
} else {
    $class .= ' post-without-thumbnail';
}
?>
<article <?php echo post_class($class) ?>>
    <div class="zoo-post-inner">
        <?php
        if (is_sticky()) {
            ?>
            <span class="sticky-post-label"><?php echo esc_html__('Featured', 'fona') ?></span>
            <?php
        }
        $zoo_quote_content = get_post_meta(get_the_ID(), '_format_quote_source_content', true);
        if (!has_post_format('quote') || $zoo_quote_content == '') {
            the_title(sprintf('<h3 class="entry-title title-post"><a href="%s" rel="' . esc_html__('bookmark', 'fona') . '">', esc_url(get_permalink())), '</a></h3>');
            ?>
            <span class="date-post">
            <?php echo esc_html(get_the_date()); ?>
            </span>
            <?php
        }
        get_template_part('inc/templates/posts/archive/media');
        if (!has_post_format('quote') || $zoo_quote_content == '') {
            ?>
            <div class="wrap-main-post">
                <?php if (get_theme_mod('zoo_blog_show_excerpt', 1) == 1) { ?>
                    <div class="entry-content">
                        <?php
                        the_excerpt();
                        ?>
                    </div>
                <?php } ?>
                <?php if (get_the_title() == '' || get_theme_mod('zoo_blog_show_readmore', true)) { ?>
                    <div class="wrap-readmore">
                        <a href="<?php echo esc_url(the_permalink()); ?>"
                           class="readmore"><?php echo esc_html__('Continue Reading', 'fona'); ?> <i
                                    class="cs-font clever-icon-next-arrow-1"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</article>