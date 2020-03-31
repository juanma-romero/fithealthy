<?php
/**
 * Stock Label template
 * For Product Item
 * @since zoo-theme 1.0.4
 */
global $product;
if (zoo_woo_enable_stocklabel()) {
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