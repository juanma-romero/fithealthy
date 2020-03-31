<?php
/**
 * Sale Count down template
 * Display count down end sale
 * @since ione 1.0.5
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post, $product;

if ($product->is_on_sale()) :
$rit_date_sale = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
if($rit_date_sale > time()) {
    wp_enqueue_script('countdown');
    ?>
    <div class="zoo-countdown">
        <div class="countdown-block" data-countdown="countdown"
             data-date="<?php echo date('m', $rit_date_sale) . '-' . date('d', $rit_date_sale) . '-' . date('Y', $rit_date_sale) . '-' . date('H', $rit_date_sale) . '-' . date('i', $rit_date_sale) . '-' . date('s', $rit_date_sale); ?>">
        </div>
    </div>
    <?php
}
endif;