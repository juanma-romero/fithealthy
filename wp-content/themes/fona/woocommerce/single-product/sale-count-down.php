<?php
/**
 * Sale Count down template
 * Display count down end sale
 * @since Zoo Theme 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post, $product;

if ($product->is_on_sale()) :
    $zoo_date_sale = get_post_meta(get_the_ID(), '_sale_price_dates_to', true);
    if ($zoo_date_sale > time()) {
        wp_enqueue_script('countdown');
        ?>
        <div class="wrap-zoo-countdown">
            <h4 class="label-countdown-block"><?php esc_html_e('Deals Ends In','fona')?></h4>
            <div class="zoo-countdown">
                <div class="countdown-block" data-countdown="countdown"
                     data-date="<?php echo date('m', $zoo_date_sale) . '-' . date('d', $zoo_date_sale) . '-' . date('Y', $zoo_date_sale) . '-' . date('H', $zoo_date_sale) . '-' . date('i', $zoo_date_sale) . '-' . date('s', $zoo_date_sale); ?>">
                </div>
            </div>
        </div>
        <?php
    }
endif;