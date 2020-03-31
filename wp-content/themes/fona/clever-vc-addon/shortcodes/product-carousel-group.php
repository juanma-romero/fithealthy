<?php
/**
 * Product carousel group template.
 */
$varid = mt_rand();
$zoo_class = 'shortcode-product-carousel-group carousel-group woocommerce ';
$zoo_class .= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($atts['css'], ' '), 'CleverProductCarouselGroup', $atts);
$zoo_woo_attr = array(
    'post_type' => 'product',
    'posts_per_page' => $atts['posts_per_page'],
);
if ($atts['cats'] != 'all') {
    $zoo_woo_attr['product_cat'] = $atts['cats'];
}
$meta_query = WC()->query->get_meta_query();
if ($atts['show'] == 'featured') {
    $meta_query[] = array(
        array(
            'taxonomy' => 'product_visibility',
            'field' => 'name',
            'terms' => 'featured',
            'operator' => 'IN'
        ),
    );
    $zoo_woo_attr['tax_query'] = $meta_query;
} elseif ($atts['show'] == 'onsale') {

    $product_ids_on_sale = wc_get_product_ids_on_sale();

    $zoo_woo_attr['post__in'] = $product_ids_on_sale;

    $zoo_woo_attr['meta_query'] = $meta_query;

} elseif ($atts['show'] == 'best-selling') {

    $zoo_woo_attr['meta_key'] = 'total_sales';

    $zoo_woo_attr['meta_query'] = $meta_query;

} elseif ($atts['show'] == 'latest') {

    $zoo_woo_attr['orderby'] = 'date';

    $zoo_woo_attr['order'] = 'DESC';

} elseif ($atts['show'] == 'toprate') {

    add_filter('posts_clauses', array('WC_Shortcodes', 'order_by_rating_post_clauses'));

} elseif ($atts['show'] == 'price') {

    $zoo_woo_attr['orderby'] = "meta_value_num {$wpdb->posts}.ID";
    $zoo_woo_attr['order'] = 'ASC';
    $zoo_woo_attr['meta_key'] = '_price';

} elseif ($atts['show'] == 'price-desc') {
    $zoo_woo_attr['orderby'] = "meta_value_num {$wpdb->posts}.ID";
    $zoo_woo_attr['order'] = 'DESC';
    $zoo_woo_attr['meta_key'] = '_price';

}
$product_query = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $zoo_woo_attr));
$product_query->query($zoo_woo_attr);
remove_filter('posts_clauses', array('WC_Shortcodes', 'order_by_rating_post_clauses'));
$zoo_data_config = '{"columns":"' . $atts['columns'] . '"}';
wp_enqueue_style('slick');
wp_enqueue_script('slick');
?>
<div id="zoo-pcb-<?php echo esc_attr($varid) ?>" class="<?php echo esc_attr($zoo_class) ?>"
     data-config='<?php echo esc_attr($zoo_data_config); ?>'>
    <?php
    if ($atts['title'] != '') {
        ?>
        <h4 class="title-shortcode"><?php echo esc_html($atts['title']) ?></h4>
        <?php
    }
    ?>
    <ul class="products wrap-carousel-products">
    <?php
    $i = 0;
    $zoo_total_product = $product_query->post_count;
    $rows = $atts['rows'];
    while ($product_query->have_posts()) {
        if ($i % $rows == 0) {
            ?>
            <div class="wrap-group-product">
            <?php
        }
        $product_query->the_post();
        global $product;
        echo cvca_get_shortcode_view('woocommerce/product-carousel', $atts);
        $i++;
        if ($i % $rows == 0 || $i == $zoo_total_product) {
            ?>
            </div>
            <?php
        }
    }
    ?>
    </ul>
</div>
<?php
wp_reset_postdata();
?>