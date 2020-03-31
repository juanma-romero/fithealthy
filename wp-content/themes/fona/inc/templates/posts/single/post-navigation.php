<?php
/**
 * Post navigation of single post
 *
 * @package     Zoo fona
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 *
 **/
$zoo_next_post = get_next_post();
$zoo_prev_post = get_previous_post();
if (get_theme_mod('zoo_blog_single_nav', '1') == 1) {
    ?>
    <div class="zoo-single-post-nav">
        <div class="next-post zoo-single-post-nav-item">
            <?php if (!empty($zoo_next_post)): ?>
                <a href="<?php echo get_permalink($zoo_next_post->ID); ?>"
                   title="<?php echo esc_attr($zoo_next_post->post_title); ?>">
                    <i class="cs-font clever-icon-prev-arrow-1"></i>
                    <div class="wrap-text">
                        <span><?php echo esc_html__('Next Post', 'fona'); ?></span>
                        <h4><?php echo esc_html($zoo_next_post->post_title); ?></h4>
                    </div>
                </a>
            <?php endif; ?>
        </div>
        <div class="prev-post zoo-single-post-nav-item pull-right">
            <?php if (!empty($zoo_prev_post)): ?>
                <a href="<?php echo get_permalink($zoo_prev_post->ID); ?>"
                   title="<?php echo esc_attr($zoo_prev_post->post_title); ?>">
                    <div class="wrap-text">
                        <span><?php echo esc_html__('Previous Post', 'fona'); ?></span>
                        <h4><?php echo esc_html($zoo_prev_post->post_title); ?></h4>
                    </div>
                    <i class="cs-font clever-icon-next-arrow-1"></i></a>
            <?php endif; ?>
        </div>
    </div>
<?php } ?>