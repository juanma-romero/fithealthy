<?php
/**
 * Media block for post
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$zoo_quote_content = get_post_meta(get_the_ID(), '_format_quote_source_content', true);
if (has_post_format('quote')&&$zoo_quote_content != '') {
        ?>
        <div class="quote-block single-quote">
            <h3 class="quote-content"><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo get_the_title() ?>"><?php echo esc_html($zoo_quote_content); ?></a></h3>
            <h5 class="quote-author"><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo get_the_title() ?>"><?php echo esc_html(get_post_meta(get_the_ID(), '_format_quote_source_name', true)); ?></a></h5>
        </div>
    <?php
} elseif (has_post_thumbnail()) {
    $zoo_block_layout = get_theme_mod('zoo_blog_layout', 'list');
    if ($zoo_block_layout == 'list')
        $zoo_img_size = 'full';
    else
        $zoo_img_size = 'medium'
    ?>
    <div class="wrap-media">
        <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo get_the_title() ?>">
            <?php
            the_post_thumbnail($zoo_img_size);
            ?>
        </a>
    </div>
<?php }