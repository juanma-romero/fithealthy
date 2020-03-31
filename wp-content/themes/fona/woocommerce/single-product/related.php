<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */
if (!defined('ABSPATH')) {
    exit;
}
global $product;
wp_enqueue_script('tippy');
if (get_theme_mod('zoo_single_related_product', '1') == '1' && $related_products):
    ?>
    <?php
    if ($related_products) :
        $zoo_class = '';
        $zoo_json_config = $zoo_list_wrap = '';
        if (get_theme_mod('zoo_single_related_product_slider', '1') == 1) {
            $zoo_class = 'zoo-carousel';
            $zoo_json_config = '{"item":"' . get_theme_mod('zoo_single_related_cols', '4') . '","wrap":"ul.products","navigation":"true"}';
            $zoo_list_wrap = 'carousel';
        }
        $zoo_list_wrap .= zoo_woo_catalog_mod() || get_theme_mod('zoo_product_cart_button', '0') == 1 ? ' cart-disable' : '';
        ?>
        <div class="related container <?php echo esc_attr($zoo_class) ?>" <?php if ($zoo_class != '')
        {
        ?>data-config='<?php echo esc_attr($zoo_json_config) ?>'<?php }
        ?>>
            <h2 class="title-single-block"><?php esc_html_e('Related products', 'woocommerce'); ?></h2>
            <ul class="products grid row <?php echo esc_attr($zoo_list_wrap); ?>">

                <?php
                foreach ($related_products as $related_product) : ?>

                    <?php
                    $post_object = get_post($related_product->get_id());

                    setup_postdata($GLOBALS['post'] =& $post_object);

                    wc_get_template_part('content', 'product-related'); ?>

                <?php endforeach; ?>

            </ul>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>
<?php endif; ?>