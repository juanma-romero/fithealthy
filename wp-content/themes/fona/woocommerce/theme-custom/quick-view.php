<?php
/*
 * Zoo Quick View Template
 */

?>
<div id="zoo-quickview-lb" class="animated fadeIn woocommerce">
    <div id="product-<?php the_ID();?>" class="wrap-top-single-product product zoo-single-product">
        <a href="#" class="close-btn close-quickview" title="<?php esc_attr__('Close','fona')?>"><i class="cs-font clever-icon-close"></i> </a>
        <div class="wrap-left-single-product">
            <?php
            do_action('zoo_woocommerce_show_product_sale_flash');
            ?>
            <div class="images">
                <?php
                /**
                 * woocommerce_before_single_product_summary hook.
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action('woocommerce_before_single_product_summary');

                ?></div>
        </div>
        <div class="summary entry-summary wrap-right-single-product">
            <?php
            zoo_woo_catalog_mod();
            /**
             * woocommerce_single_product_summary hook.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             */
            do_action('woocommerce_single_product_summary');
            if (is_plugin_active('yith-woocommerce-wishlist/init.php')) {
                echo do_shortcode('[yith_wcwl_add_to_wishlist]');
            }
            ?>
        </div><!-- .summary -->
    </div>
</div>