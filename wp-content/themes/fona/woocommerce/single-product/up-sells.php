<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
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
if (get_theme_mod('zoo_single_upsell', '1') == '1') {
    if ($upsells) :
        $zoo_class = '';
        $zoo_json_config = $zoo_list_wrap = '';
        if (get_theme_mod('zoo_single_upsell_slider', '1') == 1) {
            $zoo_class = 'zoo-carousel';
            $zoo_json_config = '{"item":"' . get_theme_mod('zoo_single_upsell_cols', '4') . '","wrap":"ul.products","navigation":"true"}';
            $zoo_list_wrap = 'carousel';
        }
        ?>
            <div class="up-sells container <?php echo esc_attr($zoo_class) ?>" <?php if ($zoo_class != '')
                {
                ?>data-config='<?php echo esc_attr($zoo_json_config) ?>'<?php }
                ?>>
                <h2 class="title-single-block"><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ) ?></h2>
                <ul class="products grid <?php echo esc_attr($zoo_list_wrap); ?>"<?php if (get_theme_mod('zoo_single_upsell_slider', '1') != 1) {?> data-width="<?php echo esc_attr(get_theme_mod('zoo_products_item_min_width',270));?>"<?php }?>>
                <?php foreach ($upsells as $upsell) :
                    $post_object = get_post($upsell->get_id());
                    setup_postdata($GLOBALS['post'] =& $post_object);
                    wc_get_template_part('content', 'product');
                    endforeach; ?>

                    </ul>
            </div>
    <?php endif;
}
wp_reset_postdata();
