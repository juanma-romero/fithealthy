<?php
/**
 * Style of product item
 * For Product Item
 * @since zoo-theme 1.0.4
 */
global $product;
?>
<div class="wrap-product-img">
    <?php
    /**
     * woocommerce_before_shop_loop_item hook.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');
    $thumbnail = '';
    if (isset($atts['thumbnail'])) {
        $thumbnail = $atts['thumbnail'];
    }
    if ($thumbnail == '1') {
        do_action('woocommerce_show_product_loop_sale_flash');
        $zoo_img = get_post_thumbnail_id(get_the_ID());
        $zoo_attachments = get_attached_file($zoo_img);
        if (has_post_thumbnail() && $zoo_attachments) :
            $zoo_item = wp_get_attachment_image_src($zoo_img, 'thumbnail');
            $zoo_img_url = $zoo_item[0];
            $zoo_width = $zoo_item[1];
            $zoo_height = $zoo_item[2];
            $resolution = $zoo_width / $zoo_height;
            $zoo_img_title = get_the_title($zoo_img);
            $zoo_img_srcset = wp_get_attachment_image_srcset($zoo_img);
            ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"
               data-resolution="<?php echo esc_attr($resolution) ?>" class="wrap-img">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/placeholder.png'; ?>"
                     height="<?php echo esc_attr($zoo_height) ?>" width="<?php echo esc_attr($zoo_width) ?>"
                     class="lazy-img wp-post-image" data-original="<?php echo esc_attr($zoo_img_url) ?>"
                     alt="<?php echo esc_attr($zoo_img_title); ?>"
                     data-srcset="<?php echo esc_attr($zoo_img_srcset) ?>"/>
            </a>
            <?php
        endif;
    } else {
        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action('woocommerce_before_shop_loop_item_title');
    }
    /**
     * woocommerce_shop_loop_item_title hook.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     *
     */
    if ($atts['show_stock'] == '1') {
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
    ?>
    <div class="wrap-product-button">
        <?php
        do_action('zoo_loop_add_to_cart');
        if ($atts['show_qv'] == '1') {
            wp_enqueue_style('slick');
            wp_enqueue_script('slick');
            wp_enqueue_script('zoomove');
            wp_enqueue_script('wc-add-to-cart-variation');
            ?>
            <a data-product_id="<?php echo esc_attr(get_the_id()); ?>" class="btn quick-view"
               href="#" title="<?php echo esc_attr__('Quick View', 'fona'); ?>">
                <i class="cs-font clever-icon-quickview-2"></i>
            </a>
        <?php }
        if (is_plugin_active('yith-woocommerce-wishlist/init.php')) {
            echo do_shortcode('[yith_wcwl_add_to_wishlist]');
        }
        ?>
    </div>
</div>
<div class="wrap-product-info">
    <h3 class="product-name"><a href="<?php the_permalink(); ?>"
                                title="<?php the_title(); ?>"><?php the_title(); ?></a>
    </h3>
    <div class="wrap-after-shop-title">
        <?php
        if ($atts['show_rating'] == 1)
            do_action('zoo_woo_loop_rating');
        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title'); ?>
    </div>
    <?php
    /**
     * woocommerce_after_shop_loop_item hook.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>
    <?php
    if (shortcode_exists('zoo_cw_shop_swatch')) {
        echo do_shortcode('[zoo_cw_shop_swatch]');
    }
    ?>
</div>