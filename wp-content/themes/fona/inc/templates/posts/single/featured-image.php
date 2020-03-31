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
$zoo_wrap_class = '';
switch (get_post_meta(get_the_ID(), 'zoo_post_single_thumb_fullwidth', true)) {
    case 'no':
        $zoo_wrap_class = 'container';
        break;
    case 'yes':
        $zoo_wrap_class = 'full-width';
        break;
    default:
        if (get_theme_mod('zoo_blog_post_thumb_fullwidth', '1') == 1) {
            $zoo_wrap_class = 'full-width';
        } else {
            $zoo_wrap_class = 'container';
        }
        break;
}
if (has_post_thumbnail()) :
    wp_enqueue_script('parally');
    ?>
    <div class="post-image single-image <?php  echo esc_attr($zoo_wrap_class); ?>">
        <?php
        the_post_thumbnail('full-thumb'); ?>
    </div>
<?php endif; ?>