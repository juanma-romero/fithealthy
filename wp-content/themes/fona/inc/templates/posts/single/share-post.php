<?php
/**
 * Block share for post
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
?>
<div class="wrap-share-post pull-right">
    <?php
    if (is_plugin_active('clever-vc-addon/clever-vc-addon.php')) {
        ?>
        <span class="share-control"><i class="cs-font  clever-icon-share-2"></i></span>
        <ul class="share-links social-icons">
            <li class="facebook border-icon social-icon"><a
                        href="http://www.facebook.com/sharer.php?u=<?php esc_url(the_permalink()); ?>"
                        class="post_share_facebook" onclick="javascript:window.open(this.href,
                  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;"><i
                            class="cs-font clever-icon-facebook"></i></a></li>
            <li class="twitter border-icon social-icon"><a
                        href="https://twitter.com/share?url=<?php esc_url(the_permalink()); ?>" onclick="javascript:window.open(this.href,
                  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;"
                        class="product_share_twitter"><i class="cs-font clever-icon-twitter"></i></a></li>
            <li class="googleplus border-icon social-icon"><a
                        href="https://plus.google.com/share?url=<?php esc_url(the_permalink()); ?>" onclick="javascript:window.open(this.href,
                  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i
                            class="cs-font clever-icon-googleplus"></i></a></li>
            <li class="pinterest border-icon social-icon"><a
                        href="http://pinterest.com/pin/create/button/?url=<?php esc_url(the_permalink()); ?>&media=<?php if (function_exists('the_post_thumbnail')) echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>&description=<?php echo esc_url(get_the_title()); ?>"><i
                            class="cs-font clever-icon-pinterest"></i></a></li>
            <li class="mail border-icon social-icon"><a
                        href="mailto:?subject=<?php the_title();?>&body=<?php echo strip_tags(get_the_excerpt()); the_permalink(); ?>"
                        class="product_share_email"><i class="cs-font clever-icon-email-envelope"></i></a></li>
        </ul>
    <?php } ?>
</div>
