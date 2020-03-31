<?php
/**
 * The template for displaying product content related within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-related.php.
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

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
$zoo_class = 'col-xs-12 ';
switch (get_theme_mod('zoo_single_related_cols', 4)) {
    case 1:
        $zoo_class .= 'col-sm-12';
        break;
    case 2:
        $zoo_class .= 'col-sm-6';
        break;
    case 3:
        $zoo_class .= 'col-sm-4';
        break;
    case 4:
        $zoo_class .= 'col-sm-3';
        break;
    case 5:
        $zoo_class .= 'col-sm-1-5';
        break;
    default:
        $zoo_class .= 'col-sm-2';
};
$zoo_product_style =zoo_product_style();
?>
<li <?php post_class($zoo_class.' '.$zoo_product_style); ?>>
    <?php wc_get_template_part('/woocommerce/product-style/'.$zoo_product_style);?>
</li>
