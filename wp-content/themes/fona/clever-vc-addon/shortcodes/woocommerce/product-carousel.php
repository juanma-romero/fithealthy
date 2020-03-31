<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $post;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php post_class(); ?>>
    <div class="wrap-product-img">
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');

        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        the_post_thumbnail('thumbnail');

        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         *
         */
        if ($atts['show_stock'] == '1') {
            if (!$product->is_in_stock()) {
                ?>
                <span class="out-stock-label stock-label"><?php esc_html_e('Out of Stock', 'fona'); ?></span>
                <?php
            } else {
                if (get_option('woocommerce_notify_low_stock_amount') > $product->get_stock_quantity() && $product->get_stock_quantity()) {
                    ?>
                    <span class="low-stock-label stock-label"><?php esc_html_e('Low Stock', 'fona'); ?></span>
                    <?php
                }
            }
        }
        if ($atts['show_qv'] == '1') {
            wp_enqueue_style('slick');
            wp_enqueue_script('slick');
            wp_enqueue_script('zoomove');
            wp_enqueue_script('wc-add-to-cart-variation');
            ?>
            <a data-product_id="<?php echo esc_attr(get_the_id()); ?>" class="btn quick-view"
               href="<?php the_permalink(); ?>">
                <?php echo esc_html__('Quick View', 'fona'); ?>
            </a>
        <?php }
        ?>
    </div>
    <div class="wrap-product-info">
        <div class="wrap-after-shop-title">
            <?php
            do_action('zoo_woo_loop_rating');
            /**
             * woocommerce_after_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            if (is_plugin_active('yith-woocommerce-wishlist/init.php')) {
                echo do_shortcode('[yith_wcwl_add_to_wishlist]');
            } ?>
        </div>
        <h3 class="product-name"><a href="<?php the_permalink(); ?>"
                                    title="<?php the_title(); ?>"><?php the_title(); ?></a>
            <?php
            /**
             * woocommerce_after_shop_loop_item hook.
             *
             * @hooked woocommerce_template_loop_product_link_close - 5
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action('woocommerce_after_shop_loop_item');
            ?>
        </h3>
        <?php
        if (shortcode_exists('zoo_cw_shop_swatch')) {
            echo do_shortcode('[zoo_cw_shop_swatch]');
        }
        ?>
    </div>
</li>
