<?php
/**
 * Clever Product Shortcode
 */
if (!isset($_POST['show'])) {
    echo '<input name="cvca-filter-page-baseurl" type="hidden" value="' . cvca_current_url() . '">';
}
$varid = mt_rand();
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($atts['css'], ' '), 'CleverProduct', $atts);
$css_class .= $atts['element_custom_class'];
if ($atts['products_type'] != 'carousel') {
    wp_enqueue_script('lazyload');
    wp_enqueue_script('isotope');
} else {
    wp_enqueue_style('slick');
    wp_enqueue_style('slick-theme');
    wp_enqueue_script('slick');
    switch ($atts['topnav']) {
        case 'top':
            $css_class .= ' topnav';
            break;
        case 'bottom':
            $css_class .= ' bottomnav';
            break;
        default:
            break;
    }
    if (isset($atts['topnav'])) {
        $css_class .= $atts['topnav'] == '1' ? ' topnav' : '';
    }
}
if(isset($atts['cat_align'])){
    $css_class .=' cat-align-'.$atts['cat_align'];
}
wp_enqueue_style('cvca-style');
wp_enqueue_script('cvca-script');
?>
<div class="woocommerce cvca-products-wrap cvca-products-wrap_<?php echo esc_attr($varid); ?> <?php echo esc_attr($css_class) ?>" <?php if ($atts['show_filter'] || $atts['loadmore']) { ?>
    data-args='<?php
    //shortcode agurgument
    if (!isset($_POST['show'])) {
        $init_atts = $atts;
        unset($init_atts['wc_attr']);
        echo json_encode($init_atts);
    } else {
        echo json_encode($_POST);
    }
    ?>'
    data-empty="<?php echo esc_attr__('No product found', 'fona'); ?>"
    data-categories="<?php echo esc_attr($atts['filter_categories']); ?>"
    data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"<?php } ?>>
    <?php
    echo cvca_get_shortcode_view('woocommerce/product-filter', $atts);
    $class = ''; ?>
    <div class="cvca-wrapper-products-shortcode">
        <?php
        $cvca_wrap_class = "cvca-wrap-products-sc";
        if ($atts['products_type'] == 'list') {
            $class .= 'list';
        } else {
            $class .= 'grid';
        }
        $class .= zoo_woo_catalog_mod() || get_theme_mod('zoo_product_cart_button', '0') == 1 ? ' cart-disable' : '';
        if ($atts['products_type'] == 'carousel') {
            $class .= ' ' . $atts['products_type'];
            $cvca_wrap_class .= ' cvca-carousel';
            $cvca_pag = $atts['show_pag'] != '' ? 'true' : 'false';
            $cvca_nav = $atts['show_nav'] != '' ? 'true' : 'false';
            $cvca_json_config = '{"item":"' . $atts['column'] . '","wrap":"ul.products","pagination":"' . $cvca_pag . '","navigation":"' . $cvca_nav . '"}';
        }
        if ($atts['show_rating'] != 1) {
            $cvca_wrap_class .= ' hide-rating';
        }
        $product_query = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $atts['wc_attr']));
        $product_query->query($atts['wc_attr']);
        remove_filter('posts_clauses', array('WC_Shortcodes', 'order_by_rating_post_clauses'));
        ?>
        <?php if (isset($atts['title']) && $atts['title'] != '') { ?>
            <h3 class="title-block-page"><span><?php echo esc_html($atts['title']) ?></span></h3>
        <?php } ?>
        <div class="<?php echo esc_attr($cvca_wrap_class) ?>"
             <?php if ($atts['products_type'] == 'carousel'){ ?>data-config='<?php echo esc_attr($cvca_json_config) ?>'<?php } ?>>
            <ul class="products <?php echo esc_attr($class) ?>" <?php if ($atts['products_type'] != 'carousel') { ?> data-highlight-featured="<?php echo esc_attr($atts['highlight-featured']) ?>" data-width="<?php echo esc_attr($atts['col_width']) ?>"<?php } ?>>
                <?php while ($product_query->have_posts()) {
                    $product_query->the_post();
                    global $product;
                    echo cvca_get_shortcode_view('woocommerce/content-product', $atts);
                }
                ?>
            </ul>
        </div>
        <?php if (zoo_check_better_amp()) { ?>
            <div class="amp-pagination">
                <?php
                echo paginate_links(apply_filters( 'woocommerce_pagination_args', array(
                    'base' => esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false)))),
                    'format' => '',
                    'add_args' => false,
                    'current' => max(1, get_query_var('paged')),
                    'total' => $product_query->max_num_pages,
                    'prev_next' => true,
                    'prev_text' => '<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;'.better_amp_translation_get( 'prev' ),
                    'next_text' => better_amp_translation_get( 'next' ).'&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>',
                    'type' => 'plain',
                    'end_size' => 1,
                    'mid_size' => 1
                )));?>
            </div>
        <?php }
        elseif (!isset($_POST['ajax'])){
            if ($atts['loadmore'] && $product_query->max_num_pages > $atts['wc_attr']['paged']):?>
                <div class="wrap-ajax-loadmore">
                    <a class="cvca_ajax_load_more_button btn" href="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"
                       title="<?php esc_attr_e('Load more', 'fona') ?>"
                       data-empty="<?php esc_attr_e('No more Load', 'fona') ?>"
                       data-maxpage='<?php echo esc_attr($product_query->max_num_pages); ?>'
                    ><?php esc_html_e('Load more products', 'fona'); ?></a></div>
                <?php
                wp_enqueue_script('cvca-ajax-product');
            endif; ?>
        <?php } ?>
    </div>
    <?php
    wp_reset_postdata();
    ?>
</div>