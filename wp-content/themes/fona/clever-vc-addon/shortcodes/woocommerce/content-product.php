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
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
if (isset($atts['style'])) {
    $product_style = $atts['style'];
} else {
    $product_style = 'default';
}
wp_enqueue_script('tippy');
?>
<li <?php post_class($product_style); ?>>
    <div class="wrap-product-item">
        <?php
        if(zoo_check_better_amp()){
            wc_get_template_part('/woocommerce/product-style/style','amp');
        }else
        echo cvca_get_shortcode_view('woocommerce/product-style/'.$product_style, $atts);

        ?>
    </div>
</li>
