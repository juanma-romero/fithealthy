<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
wp_enqueue_script('isotope');
wp_enqueue_script('lazyload-master');
$zoo_wrap=zoo_woo_layout();
$zoo_wrap.=zoo_woo_catalog_mod()||get_theme_mod('zoo_product_cart_button', '0') == 1?' cart-disable':'';
?>
<ul class="products <?php echo esc_attr($zoo_wrap)?>"  data-width="<?php echo esc_attr(get_theme_mod('zoo_products_item_min_width',270));?>" data-highlight-featured="<?php echo esc_attr(zoo_highlight_featured());?>">
