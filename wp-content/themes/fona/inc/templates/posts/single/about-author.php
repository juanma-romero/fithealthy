<?php
/**
 * The default template for Author for post
 *
 * Used for both single and author page.
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
if(get_the_author_meta('description')!='' && get_theme_mod('zoo_blog_post_author','')==1){?>
<div class="post-author">
    <div class="author-img">
        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" title="<?php echo esc_attr(get_the_author()) ?>">
            <?php echo wp_kses(get_avatar(get_the_author_meta('email'), '115'), array('img' => array('class' => array(), 'width' => array(), 'height' => array(), 'alt' => array(), 'src' => array()))); ?>
        </a>
    </div>
    <div class="author-content">
        <h5 class="author-name"><?php the_author_posts_link(); ?></h5>
        <p><?php the_author_meta('description'); ?></p>
        <ul class="wrap-author-social social-icons">
            <?php if (get_the_author_meta('facebook')) : ?>
                <li><a target="_blank" class="author-social"
                       href="http://facebook.com/<?php echo esc_url(the_author_meta('facebook')); ?>"><i
                        class="fa fa-facebook"></i></a></li><?php endif; ?>
            <?php if (get_the_author_meta('twitter')) : ?>
                <li><a target="_blank" class="author-social"
                       href="http://twitter.com/<?php echo esc_url(the_author_meta('twitter')); ?>"><i
                        class="fa fa-twitter"></i></a></li><?php endif; ?>
            <?php if (get_the_author_meta('google')) : ?>
                <li><a target="_blank" class="author-social"
                       href="http://plus.google.com/<?php echo esc_url(the_author_meta('google')); ?>?rel=author"><i
                        class="fa fa-google-plus"></i></a></li><?php endif; ?>
            <?php if (get_the_author_meta('pinterest')) : ?>
                <li><a target="_blank" class="author-social"
                       href="http://pinterest.com/<?php echo esc_url(the_author_meta('pinterest')); ?>"><i
                        class="fa fa-pinterest"></i></a></li><?php endif; ?>
            <?php if (get_the_author_meta('tumblr')) : ?>
                <li><a target="_blank" class="author-social"
                       href="http://<?php echo esc_url(the_author_meta('tumblr')); ?>.tumblr.com/"><i
                        class="fa fa-tumblr"></i></a></li><?php endif; ?>
            <?php if (get_the_author_meta('instagram')) : ?>
                <li><a target="_blank" class="author-social"
                       href="http://instagram.com/<?php echo esc_url(the_author_meta('instagram')); ?>"><i
                        class="fa fa-instagram"></i></a></li><?php endif; ?>
        </ul>
    </div>
</div>
<?php }