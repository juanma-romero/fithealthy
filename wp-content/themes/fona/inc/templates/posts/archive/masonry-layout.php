<?php
/**
 * Masonry layout for post
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$class = 'zoo-blog-item layout-item masonry-layout-item ';
switch (get_theme_mod('zoo_blog_col', '3')) {
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
wp_enqueue_script('isotope');
$zoo_quote_content='';
if (has_post_format('quote')) $zoo_quote_content = get_post_meta(get_the_ID(), '_format_quote_source_content', true);
?>
<article <?php echo post_class($class) ?>>
    <?php if ($zoo_quote_content==''){ ?>
    <div class="zoo-post-inner">
        <?php
        if (is_sticky()) {
            ?>
            <span class="sticky-post-label"><?php echo esc_html__('Featured', 'fona') ?></span>
            <?php
        }
        get_template_part('inc/templates/posts/archive/media'); ?>
        <div class="wrap-short-content">
            <?php
            the_title(sprintf('<h3 class="title-post"><a href="%s" rel="' . esc_html__('bookmark', 'fona') . '">', esc_url(get_permalink())), '</a></h3>'); ?>
            <p class="date-post"><?php echo esc_html(get_the_date()); ?></p>
            <?php if (get_theme_mod('zoo_blog_show_excerpt', 1) == 1) { ?>
                <div class="entry-content">
                    <?php
                    the_excerpt();
                    ?>
                </div>
            <?php } ?>
            <?php if (get_the_title() == '' || get_theme_mod('zoo_blog_show_readmore', true)) { ?>
                <a href="<?php echo esc_url(the_permalink()); ?>"
                   class="readmore"><?php echo esc_html__('Continue Reading', 'fona'); ?>
                </a>
            <?php } ?>
        </div>
    </div>
    <?php }else{
        $zoo_thumb='';
        if (has_post_thumbnail()) {
            $zoo_thumb=get_the_post_thumbnail_url();
            }
        ?>
        <div class="zoo-post-inner" <?php if($zoo_thumb!=''){?>style="background-image:url(<?php echo esc_url($zoo_thumb);?>)"<?php }?>>
            <a class="title-post" href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo get_the_title() ?>">
                <?php
                if (is_sticky()) {
                    ?>
                    <span class="sticky-post-label"><?php echo esc_html__('Featured', 'fona') ?></span>
                    <?php
                }
                ?>
                <h3 class="quote-content">
                <?php
                echo esc_html($zoo_quote_content);
                ?>
                </h3>
                <h5 class="quote-author"><?php echo esc_html(get_post_meta(get_the_ID(), '_format_quote_source_name', true)); ?></h5>
            </a>
        </div>
    <?php } ?>
</article>