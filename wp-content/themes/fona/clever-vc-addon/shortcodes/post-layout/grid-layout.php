<?php
/**
 * Grid layout for post
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$class = 'zoo-blog-item layout-item grid-layout-item ';
switch ($atts['columns']) {
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
<article <?php echo post_class($class) ?>>
    <?php if ($atts['preset'] == 'default'||$atts['preset'] == 'style-3'): ?>
        <div class="zoo-post-inner">
            <?php
            echo cvca_get_shortcode_view('post-layout/media-block', $atts);
            if ($atts['post_info'] == 'yes') {
                echo cvca_get_shortcode_view('post-layout/post-info', $atts);
            }
            the_title(sprintf('<h3 class="title-post"><a href="%s" rel="' . esc_html__('bookmark', 'fona') . '">', esc_url(get_permalink())), '</a></h3>'); ?>
            <?php if ($atts['output_type'] != 'no') { ?>
                <div class="entry-content">
                    <?php
                    if ($atts['output_type'] == 'excerpt') {
                        echo cvca_get_excerpt($atts['excerpt_length']);
                    } else {
                        the_content();
                    }
                    ?>
                </div>
            <?php }
            if (get_the_title() == '' || $atts['view_more'] == 'yes') {
                ?>
                <a href="<?php echo esc_url(the_permalink()); ?>"
                   class="readmore"><?php echo esc_html__('Continue Reading', 'fona'); ?></a>
            <?php } ?>
        </div>
    <?php else:
        ?>
        <div class="zoo-post-inner"><?php
            the_title(sprintf('<h3 class="title-post"><a href="%s" rel="' . esc_html__('bookmark', 'fona') . '">', esc_url(get_permalink())), '</a></h3>'); ?>
            <?php
            if ($atts['post_info'] == 'yes') {
                echo cvca_get_shortcode_view('post-layout/post-info', $atts);
            }
            if ($atts['output_type'] != 'no') { ?>
                <div class="entry-content">
                    <?php
                    if ($atts['output_type'] == 'excerpt') {
                        echo cvca_get_excerpt($atts['excerpt_length']);
                    } else {
                        the_content();
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
        <?php
        if (get_the_title() == '' || $atts['view_more'] == 'yes') {
            ?>
            <a href="<?php echo esc_url(the_permalink()); ?>"
               class="readmore"><?php echo esc_html__('Continue Reading', 'fona'); ?></a>
        <?php } ?>
    <?php endif; ?>
</article>