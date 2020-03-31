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
$zoo_imgsize=$atts['blog_img_size'];
if (has_post_thumbnail()) {
    ?>
    <div class="wrap-media">
        <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo get_the_title() ?>">
            <?php
            the_post_thumbnail($zoo_imgsize);
            ?>
        </a>
    </div>
<?php }