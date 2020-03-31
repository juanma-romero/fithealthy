<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */
defined( 'ABSPATH' ) || exit;
$wrap_cart_class = 'zoo-mini-cart';
if (get_theme_mod('cart_notice', true)) {
    $wrap_cart_class .= ' cart-notice-active';
}
?>
<div class="<?php echo esc_attr($wrap_cart_class) ?>"
     data-empty-cart="<?php _e('No products in the cart.', 'woocommerce'); ?>">
    <?php do_action('woocommerce_before_mini_cart'); ?>
    <div class="header-cart">
        <h3><?php esc_html_e('Shopping bag', 'fona'); ?></h3>
        <a href="#" class="close"><i class="cs-font clever-icon-close"></i> </a>
    </div>
    <ul class="cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
        <?php if (!WC()->cart->is_empty()) :
            do_action('woocommerce_before_mini_cart_contents');
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    <li class="woocommerce-mini-cart-item  <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
                        <?php if (!$_product->is_visible()) : ?>
                            <?php echo str_replace(array('http:', 'https:'), '', $thumbnail); ?>
                        <?php else : ?>
                            <a href="<?php echo esc_url($product_permalink); ?>" class="product-thumb">
                                <?php echo str_replace(array('http:', 'https:'), '', $thumbnail); ?>
                            </a>
                        <?php endif; ?>
                        <div class="right-mini-cart-item">
                            <?php
                            echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="cs-font clever-icon-close"></i></a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                __('Remove this item', 'woocommerce'),
                                esc_attr($product_id),
                                esc_attr($cart_item_key),
                                esc_attr($_product->get_sku())
                            ), $cart_item_key);
                            echo sprintf(
                                '<a href="javascript:;" class="revert-cart-item" title="%s" data-product_id="%s"  data-cart_item_key="%s" data-product_qty="%s"><i class="cs-font clever-icon-refresh"></i></a>',
                                esc_attr__('Restore this item', 'woocommerce'),
                                esc_attr($product_id),
                                esc_attr($cart_item_key),
                                esc_attr($cart_item['quantity'])
                            );
                            ?>
                            <?php if (!$_product->is_visible()) : ?>
                                <h3 class="product-name"><?php echo esc_html($product_name) ?></h3>
                            <?php else : ?>
                                <h3 class="product-name">
                                    <a href="<?php echo esc_url($product_permalink); ?>"
                                       title="<?php echo esc_attr($product_name) ?>">
                                        <?php echo esc_html($product_name) ?>
                                    </a>
                                </h3>
                            <?php endif; ?>
                            <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                            <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<div class="cart-detail">' . esc_html__('Qty: ', 'fona') . '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span></div>', $cart_item, $cart_item_key); ?>
                        </div>
                    </li>
                    <?php
                }
            }

            do_action('woocommerce_mini_cart_contents');
            ?>

        <?php else : ?>

            <li class="empty"><?php _e('No products in the cart.', 'woocommerce'); ?></li>

        <?php endif; ?>

    </ul>
    <div class="wrap-bottom-cart">
        <?php
        do_action('zoo_free_shipping_cart_notice');
        if (!WC()->cart->is_empty()) : ?>
            <div class="bottom-cart">
                <div class="total"><strong><?php _e('Subtotal', 'woocommerce'); ?>
                        :</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></div>

                <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>
                <div class="buttons">
                    <?php do_action('woocommerce_widget_shopping_cart_buttons'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php do_action('woocommerce_after_mini_cart'); ?>
</div>