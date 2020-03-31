<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="zoo-woo-share">
<span class="control-share"><?php echo esc_html__('Share', 'fona'); ?>:</span>
        <ul class="social-icons">
            <li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>"
                                    class="post_share_facebook icon-around" onclick="javascript:window.open(this.href,
                          '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;"
                                    title="<?php echo esc_html__('Share to facebook', 'fona') ?>"><i
                            class="cs-font clever-icon-facebook"></i> </a></li>
            <li class="twitter"><a href="https://twitter.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
                          '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;"
                                   title="<?php echo esc_html__('Share to twitter', 'fona') ?>"
                                   class="product_share_twitter icon-around"><i class="cs-font clever-icon-twitter"></i></a></li>
            <li class="pinterest"><a
                        href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if (function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo get_the_title(); ?>"
                        class="product_share_email icon-around"
                        title="<?php echo esc_html__('Share to pinterest', 'fona') ?>"><i
                            class="cs-font clever-icon-pinterest"></i></a></li>
            <li class="mail"><a
                        href="mailto:?subject=<?php the_title(); ?>&body=<?php echo strip_tags(get_the_excerpt()); ?> <?php the_permalink(); ?>"
                        class="product_share_email icon-around"
                        title="<?php echo esc_html__('Sent to mail', 'fona') ?>"><i class="cs-font clever-icon-email-envelope"></i></a>
            </li>
        </ul>
</div>