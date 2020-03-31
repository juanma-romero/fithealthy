<?php
/**
 * Ajax Cart block at header
 * Template of Zoo Theme
 * Ver: 1.0
 */
?>
<div id="top-cart">
    <div class="wrap-icon-cart">
        <a class="top-cart-icon" href="<?php echo wc_get_cart_url(); ?>"
           title="<?php echo esc_html__('View your shopping cart', 'fona') ?>"><i
                class="cs-font clever-icon-cart-14"></i></a>
         <span class="top-cart-total">
        <?php echo sprintf(_n('<span>%d</span> <label>item</label>', '<span>%d</span> <label>items</label>', esc_html(WC()->cart->get_cart_contents_count()), 'fona'), esc_html(WC()->cart->get_cart_contents_count())); ?>
    </span>
        <span
            class="total-cart"><?php echo wp_kses(WC()->cart->get_cart_total(), array('label' => array('class' => array()))); ?></span>
    </div>
    <div class="wrap-mini-cart">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <div class="mask-close"></div>
</div>