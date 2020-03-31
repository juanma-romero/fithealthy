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
?>
<article <?php echo post_class($class) ?>>
    <div class="zoo-post-inner">
        <?php
        the_title(sprintf('<h3 class="entry-title title-post"><a href="%s" rel="' . esc_html__('bookmark', 'fona') . '">', esc_url(get_permalink())), '</a></h3>');
        ?>
        <span class="date-post"><?php echo esc_html(get_the_date()); ?></span>
        <?php
        echo cvca_get_shortcode_view('post-layout/media-block', $atts); ?>
        <div class="wrap-main-post">
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
            if ($atts['view_more'] == 'yes') {
                ?>
                <a href="<?php echo esc_url(the_permalink()); ?>"
                   class="readmore"><?php echo esc_html__('Continue Reading', 'fona'); ?></a>
            <?php } ?>
        </div>
    </div>
</article>