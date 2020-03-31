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

    /**
     * woocommerce_before_shop_loop_item_title hook.
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */
    if ( has_post_thumbnail() ) { ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
                <?php better_amp_the_post_thumbnail( 'better-amp-normal' ); ?>
            </a>
        </div>
    <?php }

    /**
     * woocommerce_shop_loop_item_title hook.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     *
     */
    wc_get_template_part('/woocommerce/theme-custom/stock','label');
    ?>
</div>
<div class="wrap-product-info">
    <h3 class="product-name">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        <?php
        /**
         * woocommerce_after_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action('woocommerce_after_shop_loop_item');
        ?>
    </h3>
    <div class="wrap-after-shop-title">
        <?php
        do_action('zoo_woo_loop_rating');
        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title'); ?>
    </div>
    <div class="wrap-product-button">
        <div class="ef-cart"><?php do_action('zoo_loop_add_to_cart'); ?></div>
    </div>
</div>
