<?php
/**
 * Template Order step
 * @since: zoo-theme 1.0
 */
?>
<div id="order-step">
    <?php if (is_cart()) {
        esc_html_e('Shopping Cart', 'fona');
    } elseif (is_checkout() && !is_wc_endpoint_url('order-received')) {
        esc_html_e('Check Out Detail', 'fona');;
    } elseif (is_wc_endpoint_url('order-received')) {
        esc_html_e('Order Complete', 'fona');
    }
    ?>
</div>
