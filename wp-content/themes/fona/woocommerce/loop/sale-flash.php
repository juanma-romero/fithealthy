<?php
/**
 * Product loop sale flash
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post, $product;
if ($product->is_on_sale()) :
    if (get_theme_mod('zoo_sale_type', 'number') == 'text') {
        echo apply_filters('woocommerce_sale_flash', '<span class="onsale">' . __('Sale!', 'woocommerce') . '</span>', $post, $product);
    } else {
        if (!$product->is_type('grouped')) {
            $sale = '';
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            if ($product->has_child()) {
                $variation_prices = $product->get_variation_prices();
                $variation_id = array();
                $percent = 0;
                foreach ($variation_prices['price'] as $id => $value) {
                    $new_percent = round((($variation_prices['regular_price'][$id] - $value) / $variation_prices['regular_price'][$id]) * 100);
                    if ($new_percent > $percent) {
                        $percent = $new_percent;
                    }
                }
                $regular_price = $product->get_variation_regular_price('max', true);
            } else {
                $percent = round((($regular_price - $sale_price) / $regular_price) * 100);
            }
            if ($regular_price != '') {
                echo apply_filters('woocommerce_sale_flash', '<span class="onsale">-' . $percent . '%</span>', $post, $product);
            }
        }
    }
endif;