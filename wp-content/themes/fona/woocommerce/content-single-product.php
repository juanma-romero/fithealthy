<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$zoo_single_layout = zoo_woo_gallery_layout_single();
$zoo_class = $zoo_single_layout . ' zoo-single-product';
wp_enqueue_style('slick');
wp_enqueue_style('slick-theme');
if (zoo_woo_enable_zoom()) {
    wp_enqueue_style('zoomove');
    wp_enqueue_script('zoomove');
    $zoo_class .= ' zoo-product-zoom';
}
$zoo_single_sidebar = zoo_woo_single_sidebar();
$zoo_class .= ' ' . $zoo_single_sidebar;
if ($zoo_single_layout == 'vertical-gallery-center-thumb') {
    $zoo_single_layout = 'vertical-gallery';
    $zoo_class .= ' vertical-gallery';
}
if ($zoo_single_layout == 'carousel') {
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
}
if ($zoo_single_layout == 'sticky-right-content'||$zoo_single_layout == 'sticky-accordion') {
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    $zoo_single_layout = 'sticky';
    $zoo_class .= ' sticky';
}
if ($zoo_single_layout == 'images-center') {
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
}
?>
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class($zoo_class, $product); ?>>
        <div class="wrap-top-single-product">
            <div class="container">
                <?php get_template_part('woocommerce/single-product/layout/' . $zoo_single_layout, 'layout'); ?>
            </div>
        </div>
        <div class="wrap-main-single-product">
            <?php
            /**
             * woocommerce_after_single_product_summary hook.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            do_action('woocommerce_after_single_product_summary');
            ?>
        </div>
    </div>
<?php

do_action('woocommerce_after_single_product');