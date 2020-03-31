<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$zoo_single_layout= zoo_woo_gallery_layout_single();
?>
<div class="wrap-after-product-des">
<div class="wrap-price">
	<p class="price">
		<?php
		if($zoo_single_layout=='carousel'||$zoo_single_layout=='sticky')
			do_action('zoo_woocommerce_show_product_sale_flash');
		echo $product->get_price_html(); ?></p>
</div>
    <div class="wrap-meta-content">
        <?php

        if (!$product->is_in_stock()) {
            ?>
            <span class="out-stock-label stock"><?php esc_html_e('Out of Stock', 'fona'); ?></span>
            <?php
        } else {
            if (get_option('woocommerce_notify_low_stock_amount') > $product->get_stock_quantity() && $product->get_stock_quantity()) {
                ?>
                <span class="low-stock-label stock"><?php esc_html_e('Low Stock', 'fona'); ?></span>
                <?php
            }else{
                ?>
                <span class="stock in-stock"><?php echo sprintf(__( '%s in stock', 'woocommerce' ),$product->get_stock_quantity()); ?></span>
            <?php
            }
        }
        do_action('zoo_woo_single_meta');
        ?>
    </div>
</div>