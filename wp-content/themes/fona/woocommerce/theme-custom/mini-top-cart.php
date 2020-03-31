<?php
/**
 * Mini Ajax Cart block at header
 * Template of Zoo Theme
 * Ver: 1.0
 */
if (class_exists('WooCommerce')) {
        ?>
        <div id="mini-top-cart">
            <?php
            if (is_plugin_active('yith-woocommerce-wishlist/init.php')) {
                $wishlist_url = YITH_WCWL()->get_wishlist_url();
                ?>
                <div class="wishlist-url">
                    <a href="<?php echo esc_url($wishlist_url) ?>" rel="nofollow"
                       title="<?php echo apply_filters('yith-wcwl-browse-wishlist-label', '') ?>">
                        <i class="cs-font clever-icon-heart-o"></i>
                    </a>
                </div>
                <?php
            }
        if (!zoo_woo_catalog_mod()) {
            ?>
            <div class="wrap-icon-cart">
                <a class="top-cart-icon" href="<?php echo wc_get_cart_url(); ?>"
                   title="<?php echo esc_html__('View your shopping cart', 'fona') ?>"><i
                            class="cs-font clever-icon-cart-14"></i></a>
                <span class="top-cart-total">
                <?php echo sprintf(_n('<span>%d</span> <label>item</label>', '<span>%d</span> <label>items</label>', esc_html(WC()->cart->get_cart_contents_count()), 'fona'), esc_html(WC()->cart->get_cart_contents_count())); ?>
            </span>
            </div>
        <?php }?>
        </div>
    <?php
} ?>