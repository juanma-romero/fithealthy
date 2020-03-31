<?php
/**
 * Sticky Gallery Layout
 * For Single Product
 * @since zoo-theme 1.0.3
 */
wp_enqueue_script('sticky-kit');
$zoo_single_layout = zoo_woo_gallery_layout_single();
?>
<div class="wrap-product-sticky">
    <div class="wrap-left-single-product">
        <?php
        /**
         * woocommerce_before_single_product_summary hook.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action('woocommerce_before_single_product_summary');
        $zoo_product_video= get_post_meta(get_the_ID(),'zoo_single_product_video',true);
        if($zoo_product_video):
            ?>
            <div class="wrap-extend-content">
                <?php do_action('zoo_single_product_video'); ?>
            </div>
        <?php endif;?>
    </div>
    <div class="summary entry-summary wrap-right-single-product">
        <div class="content-right-single-product">
            <?php
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
            if($zoo_single_layout == 'sticky-right-content'||$zoo_single_layout == 'sticky-accordion'){
                do_action('woocommerce_output_product_data_tabs');
            }
            ?>
        </div>
    </div>
</div>