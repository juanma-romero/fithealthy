<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action('woocommerce_before_cart');
get_template_part('woocommerce/theme-custom/order', 'step');
?>
<form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post" class="woocommerce-cart-form">
    <div class="row">
        <div class="col-xs-12 col-sm-7">
            <?php do_action('woocommerce_before_cart_table'); ?>
            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <thead>
                <tr>
                    <th class="product-name" colspan="2"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                    <th class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                    <th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                    <th class="product-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
                    <th class="product-remove">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php do_action('woocommerce_before_cart_contents'); ?>

                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                        ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                            <td class="product-name" colspan="2"
                                data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                <div class="wrap-cart-product-name">
                                    <div class="wrap-cart-thumb">
                                        <?php
                                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                        if ( ! $product_permalink ) {
                                            echo $thumbnail; // PHPCS: XSS ok.
                                        } else {
                                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                        } ?>
                                    </div>
                                    <div class="wrap-cart-item-name">
                                        <?php
                                        if ( ! $product_permalink ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }

                                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                        // Meta data.
                                        echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                        // Backorder notification.
                                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                        }
                                        ?>
                                        <div class="mobile-content">
                                            <?php
                                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                            echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                __('Remove this item', 'woocommerce'),
                                                esc_attr($product_id),
                                                esc_attr($_product->get_sku()),
                                                __('Remove', 'fona')
                                            ), $cart_item_key);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                <?php
                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);

                                ?>
                            </td>

                            <td class="product-quantity"
                                data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                <?php
                                if ($_product->is_sold_individually()) {
                                    $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                } else {
                                    $product_quantity = woocommerce_quantity_input(array(
                                        'input_name' => "cart[{$cart_item_key}][qty]",
                                        'input_value' => $cart_item['quantity'],
                                        'max_value' => $_product->get_max_purchase_quantity(),
                                        'min_value' => '0',
                                        'product_name' => $_product->get_name(),
                                    ), $_product, false);
                                }

                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                ?>
                            </td>

                            <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                                <?php
                                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                ?>
                            </td>
                            <td class="product-remove">
                                <?php
                                // @codingStandardsIgnoreLine
                                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="cs-font clever-icon-close"></i></a>',
                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                    __( 'Remove this item', 'woocommerce' ),
                                    esc_attr( $product_id ),
                                    esc_attr( $_product->get_sku() )
                                ), $cart_item_key );
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                do_action('woocommerce_cart_contents');
                ?>
                <?php do_action('woocommerce_after_cart_contents'); ?>
                </tbody>
            </table>
            <div class="bottom-table-cart">
                <a class="btn back-shop" title="<?php echo esc_attr__('Continue Shopping', 'fona') ?>"
                   href="<?php echo get_permalink(wc_get_page_id('shop')) ?>">
                    <?php echo esc_html__('Continue Shopping', 'fona') ?>
                </a>
                <button type="submit" class="btn btn-update-cart" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
                <?php do_action('woocommerce_cart_actions'); ?>
                <?php wp_nonce_field('woocommerce-cart'); ?>
            </div>
            <?php do_action('woocommerce_after_cart_table'); ?>
        </div>
        <div class="col-sm-5 col-xs-12 cart-collaterals">
            <?php do_action('woocommerce_cart_collaterals'); ?>
        </div>
    </div>
    <?php do_action('zoo_woocommerce_cart_collaterals'); ?>
</form>
<?php do_action('woocommerce_after_cart'); ?>
