<?php
/**
 * Woocommerce functions
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
/*Default woocomerce*/
//Remove link close woo 2.5
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
//Custom number product display
add_filter('loop_shop_per_page', 'zoo_loop_shop_per_page');
function zoo_loop_shop_per_page(){
    return get_theme_mod('zoo_products_number_items', '9');
}

/* ==============  WooCommerce - Ajax add to cart ============== */
/* Ajax Url ==========================================================================================================*/
add_action('wp_enqueue_scripts', 'zoo_framework_ajax_url_render', 1000);
// Enqueue scripts for theme.
if (!function_exists('zoo_framework_ajax_url_render')) {
    function zoo_framework_ajax_url_render()
    {
        // Load custom style
        wp_add_inline_script('fona', zoo_framework_ajax_url());
    }
}
if (!function_exists('zoo_framework_ajax_url')) {
    function zoo_framework_ajax_url()
    {
        $ajaxurl = 'var ajaxurl = "' . esc_url(admin_url('admin-ajax.php')) . '";';
        return $ajaxurl;
    }
}
//Update topcart when addtocart(Ajax cart)
add_filter('woocommerce_add_to_cart_fragments', 'zoo_top_cart');
if (!function_exists("zoo_top_cart")) {
    function zoo_top_cart($fragments)
    {
        ob_start();
        get_template_part('woocommerce/theme-custom/topheadcart');
        $fragments['#top-cart'] = ob_get_clean();
        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'zoo_total_cart');
if (!function_exists("zoo_total_cart")) {
    function zoo_total_cart($fragments)
    {
        ob_start();
        echo '<span class="top-cart-total">' . sprintf(_n('<span>%d</span> <label>item</label>', '<span>%d</span> <label>items</label>', esc_html(WC()->cart->get_cart_contents_count()), 'fona'), esc_html(WC()->cart->get_cart_contents_count())) . '</span>';
        $fragments['.top-cart-total'] = ob_get_clean();
        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'zoo_add_to_cart_message');
if (!function_exists("zoo_add_to_cart_message")) {
    function zoo_add_to_cart_message($fragments)
    {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        if (get_option('woocommerce_cart_redirect_after_add') != 'yes' && $product_id != '') {
            $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
            $fragments['zoo_add_to_cart_message'] = '<div id="zoo-add-to-cart-message">' . wc_add_to_cart_message($product_id, $quantity, true) . '</div>';
        }
        return $fragments;
    }
}
/* ======  WooCommerce - Ajax remover cart ====== */
add_action('wp_ajax_cart_remove_product', 'zoo_woo_remove_product');
add_action('wp_ajax_nopriv_cart_remove_product', 'zoo_woo_remove_product');
if (!function_exists('zoo_woo_remove_product')) {
    function zoo_woo_remove_product()
    {
        $product_key = $_POST['product_key'];
        $cart = WC()->instance()->cart;
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $product_key) {
                $removed = WC()->cart->remove_cart_item($cart_item_key);
            }
        }
        if ($removed) {
            $output['status'] = '1';
            $output['cart_count'] = $cart->get_cart_contents_count();
            $output['cart_subtotal'] = $cart->get_cart_subtotal();
            ob_start();
            zoo_free_shipping_cart_notice_zones();
            $output['free_shipping_cart_notice'] = ob_get_clean();
        } else {
            $output['status'] = '00';
        }
        echo json_encode($output);
        exit;
    }
}
/* ======  WooCommerce - Ajax restore cart item====== */
add_action('wp_ajax_restore_cart_item', 'zoo_woo_restore_cart_item');
add_action('wp_ajax_nopriv_restore_cart_item', 'zoo_woo_restore_cart_item');
if (!function_exists('zoo_woo_restore_cart_item')) {
    function zoo_woo_restore_cart_item()
    {
        $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
        $cart = WC()->instance()->cart;
        $restore = WC()->cart->restore_cart_item($cart_item_key);

        if ($restore) {
            $output['status'] = '1';
            $output['cart_count'] = $cart->get_cart_contents_count();
            $output['cart_subtotal'] = $cart->get_cart_subtotal();
            ob_start();
            zoo_free_shipping_cart_notice_zones();
            $output['free_shipping_cart_notice'] = ob_get_clean();
        } else {
            $output['status'] = '00';
        }
        echo json_encode($output);
        exit;
    }
}
/*-------Quick view ajax--------*/
add_action('wp_ajax_zoo_quickview', 'zoo_quickview');
add_action('wp_ajax_nopriv_zoo_quickview', 'zoo_quickview');
/* The Quickview Ajax Output */
if (!function_exists('zoo_quickview')) {
    function zoo_quickview()
    {
        global $post, $product, $woocommerce;
        wp_enqueue_script('wc-add-to-cart-variation');
        $product_id = $_POST['product_id'];

        $product = wc_get_product($product_id);

        $post = $product->post;

        setup_postdata($post);

        ob_start();

        wc_get_template_part('theme-custom/quick', 'view');

        $output = ob_get_contents();

        ob_end_clean();

        wp_reset_postdata();

        echo ent2ncr($output);

        exit;
    }
}
/*End Default woocomerce*/
/*-------Shop page functions--------*/
//Add lazy img for product
if (!function_exists('woocommerce_template_loop_product_thumbnail')) {
    function woocommerce_template_loop_product_thumbnail()
    {
        $zoo_img = get_post_thumbnail_id(get_the_ID());
        $zoo_attachments = get_attached_file($zoo_img);
        if (has_post_thumbnail() && $zoo_attachments) :
            $zoo_item = wp_get_attachment_image_src($zoo_img, 'shop_catalog');
            $zoo_img_url = $zoo_item[0];
            $zoo_width = $zoo_item[1];
            $zoo_height = $zoo_item[2];
            $resolution = $zoo_width / $zoo_height;
            $zoo_img_title = get_the_title($zoo_img);
            $zoo_img_srcset = wp_get_attachment_image_srcset($zoo_img);
            ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"
               style="height:<?php echo esc_attr($zoo_height) ?>px;width:<?php echo esc_attr($zoo_width) ?>px"
               data-resolution="<?php echo esc_attr($resolution) ?>"
               class="wrap-img<?php if (zoo_aternative_images()) echo esc_attr(' has-2imgs'); ?>">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/placeholder.png'; ?>"
                     height="<?php echo esc_attr($zoo_height) ?>" width="<?php echo esc_attr($zoo_width) ?>"
                     class="lazy-img wp-post-image" data-original="<?php echo esc_attr($zoo_img_url) ?>"
                     alt="<?php echo esc_attr($zoo_img_title); ?>"
                     sizes="<?php echo wp_get_attachment_image_sizes($zoo_img) ?>"
                     data-srcset="<?php echo esc_attr($zoo_img_srcset) ?>"/>
                <?php
                echo zoo_aternative_images();
                ?>
            </a>
        <?php
        endif;
    }
}
//Aternative images
if (!function_exists('zoo_aternative_images')) {
    function zoo_aternative_images()
    {
        if (get_theme_mod('zoo_aternative_images', '0') != '0') {
            $id = get_the_ID();
            $gallery = get_post_meta($id, '_product_image_gallery', true);
            if (!empty($gallery)) {
                $gallery = explode(',', $gallery);
                $first_image_id = $gallery[0];
                $zoo_item = wp_get_attachment_image_src($first_image_id, 'shop_catalog');
                $zoo_img_url = $zoo_item[0];
                $zoo_width = $zoo_item[1];
                $zoo_height = $zoo_item[2];
                $zoo_img_title = get_the_title($first_image_id);
                $zoo_img_srcset = wp_get_attachment_image_srcset($first_image_id);
                return '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png"
                     height="' . esc_attr($zoo_height) . '" width="' . esc_attr($zoo_width) . '"
                     class="lazy-img sec-img hover-image" data-original="' . esc_attr($zoo_img_url) . '"
                     alt="' . esc_attr($zoo_img_title) . '"
                     sizes="' . wp_get_attachment_image_sizes($first_image_id) . '"
                     data-srcset="' . esc_attr($zoo_img_srcset) . '"/>';
            }
            return false;
        }
    }
}
//Hight Light Featured Product
if (!function_exists('zoo_highlight_featured')) {
    function zoo_highlight_featured()
    {
        $zoo_highlight_featured = get_theme_mod('zoo_highlight_featured', '1');
        if (isset($_GET['zoo_highlight_featured'])) {
            $zoo_highlight_featured = $_GET['zoo_highlight_featured'];
        }
        return $zoo_highlight_featured;
    }
}
//Move breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action('zoo_woocommerce_breadcrumb', 'woocommerce_breadcrumb', 10);
//Catalog Mod
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('zoo_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10);
if (!function_exists('zoo_woo_catalog_mod')) {
    function zoo_woo_catalog_mod()
    {
        $zoo_catalog_status = get_theme_mod('zoo_catalog_mod', '') == '1' ? true : false;
        if (isset($_GET['catalog_mod'])):
            $zoo_catalog_status = true;
        endif;
        if ($zoo_catalog_status) {
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            remove_action('zoo_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10);
        }
        return $zoo_catalog_status;
    }
}
//Woocommerce Sidebar
if (!function_exists('zoo_woo_sidebar')) {
    function zoo_woo_sidebar()
    {
        $zoo_woo_sidebar = get_theme_mod('zoo_shop_sidebar_option', 'no-sidebar');
        if (isset($_GET['sidebar'])):
            if ($_GET['sidebar'] == 'left') {
                $zoo_woo_sidebar = 'left-sidebar';
            } else if ($_GET['sidebar'] == 'no') {
                $zoo_woo_sidebar = 'no-sidebar';
            } else {
                $zoo_woo_sidebar = 'right-sidebar';
            }
        endif;
        return $zoo_woo_sidebar;
    }
}
if (!function_exists('zoo_woo_sidebar_status')) {
    function zoo_woo_sidebar_status()
    {
        $zoo_sb_status = '';
        if (isset($_COOKIE['sidebar-status'])) {
            $zoo_sb_status = ($_COOKIE['sidebar-status'] == 'true' ? ' disable-sidebar' : '');
        }
        return $zoo_sb_status;
    }

}
//Layout options
if (!function_exists('zoo_woo_layout')) {
    function zoo_woo_layout()
    {
        $zoo_layout = get_theme_mod('zoo_products_layout', 'grid');
        if (isset($_GET['product-layout'])):
            $zoo_layout = $_GET['product-layout'];
        endif;
        if (isset($_COOKIE['product-layout'])):
            $zoo_layout = $_COOKIE['product-layout'];
        endif;
        return $zoo_layout;
    }
}
/*Product item options*/
//Disable cart
if (get_theme_mod('zoo_product_cart_button', '0') == 1) {
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
    remove_action('zoo_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10);
}
//Sale label status
if (get_theme_mod('zoo_product_sale_label', '1') != 1) {
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
}
//Remove Rating
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
if (get_theme_mod('zoo_product_rating', '1') != 1) {
    add_action('zoo_woo_loop_rating', 'woocommerce_template_loop_rating', 5);
}
//Hide Quick view
if (!function_exists('zoo_woo_enable_quickview')) {
    function zoo_woo_enable_quickview()
    {
        $zoo_qv_status = true;
        if (get_theme_mod('zoo_product_disable_qv', '0') == 1) {
            $zoo_qv_status = false;
        }
        return $zoo_qv_status;
    }

}
//Sale countdown
add_action('woocommerce_before_shop_loop_item_title', 'zoo_sale_countdown', 10);
if (!function_exists('zoo_sale_countdown')) {
    function zoo_sale_countdown()
    {
        return wc_get_template_part('loop/sale-count', 'down');
    }

}
//Hide Stock label
if (!function_exists('zoo_woo_enable_stocklabel')) {
    function zoo_woo_enable_stocklabel()
    {
        $zoo_status = true;
        if (get_theme_mod('zoo_product_stock_label', '0') == 1) {
            $zoo_status = false;
        }
        return $zoo_status;
    }

}
/*-------End Shop page functions--------*/
/*-------Single Woocommerce functions-------*/
//Single product navigation
if (!function_exists('zoo_woo_single_nav')) {
    function zoo_woo_single_nav()
    {
        $zoo_status = false;
        if (get_theme_mod('zoo_single_link_product', '1') == 1) {
            $zoo_status = true;
        }
        return $zoo_status;
    }
}
//Disable Zoom
if (!function_exists('zoo_woo_enable_zoom')) {
    function zoo_woo_enable_zoom()
    {
        $zoo_status = false;
        if (get_theme_mod('zoo_single_product_zoom', '1') == 1) {
            $zoo_status = true;
        }
        return $zoo_status;
    }
}
//Single Product share
if (!function_exists('zoo_woo_enable_share')) {
    function zoo_woo_enable_share()
    {
        $zoo_status = false;
        if (get_theme_mod('zoo_single_share', '1') == 1) {
            $zoo_status = true;
        }
        return $zoo_status;
    }
}
//Product Detail Layout
if (!function_exists('zoo_woo_gallery_layout_single')) {
    function zoo_woo_gallery_layout_single($productId = '')
    {
        if ($productId != '') {
            $zoo_layout_single = get_post_meta($productId, 'zoo_single_gallery_layout', true);
        } else {
            $zoo_layout_single = get_post_meta(get_the_ID(), 'zoo_single_gallery_layout', true);
        }
        if ($zoo_layout_single == 'inherit' || $zoo_layout_single == '') {
            $zoo_layout_single = get_theme_mod('zoo_single_gallery_layout', 'vertical-gallery');
        }
        return $zoo_layout_single;
    }
}
//Woocommerce Sidebar
if (!function_exists('zoo_woo_single_sidebar')) {
    function zoo_woo_single_sidebar()
    {
        $zoo_woo_sidebar = get_theme_mod('zoo_single_product_sidebar_option', '');
        if (isset($_GET['sidebar'])):
            if ($_GET['sidebar'] == 'left') {
                $zoo_woo_sidebar = 'left-sidebar';
            } else if ($_GET['sidebar'] == 'no') {
                $zoo_woo_sidebar = 'no-sidebar';
            } else {
                $zoo_woo_sidebar = 'right-sidebar';
            }
        endif;
        return $zoo_woo_sidebar;
    }
}

//Change location of single product hook (remove if not use it)
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('zoo_woo_single_meta', 'woocommerce_template_single_meta', 10);
//Move price location
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
//Add breadcrumb to before single product title
add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 0);

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
add_action('zoo_woocommerce_show_product_sale_flash', 'woocommerce_show_product_sale_flash', 5);
//Notice
remove_action('woocommerce_before_shop_loop', 'wc_print_notices', 10);
add_action('zoo_woo_print_notices', 'wc_print_notices', 10);
//Cart page
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('zoo_woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 5);
//Theme support lightbox
add_action('woocommerce_output_product_data_tabs', 'woocommerce_output_product_data_tabs', 10);
add_action('after_setup_theme', 'zoo_support_lb');
if (!function_exists('zoo_support_lb')) {
    function zoo_support_lb()
    {
        add_theme_support('wc-product-gallery-lightbox');
    }
}
//Number related products display
if (!function_exists('zoo_woo_related_products_limit')) {
    function zoo_woo_related_products_limit($args)
    {
        $args['posts_per_page'] = get_theme_mod('zoo_single_related_product_number', '4');
        return $args;
    }
}
add_filter('woocommerce_output_related_products_args', 'zoo_woo_related_products_limit');
//Upsell product display
if (!function_exists('zoo_woo_output_upsells')) {
    function zoo_woo_output_upsells()
    {
        $zoo_args = get_theme_mod('zoo_single_upsell_number', '4');
        woocommerce_upsell_display($zoo_args, $zoo_args);
    }
}
add_filter('woocommerce_layered_nav_count', 'zoo_nav_count_change', 1, 1);
function zoo_nav_count_change($html)
{
    $html = str_replace('<span class="count">(', '<span  class="count">', $html);
    $html = str_replace(')</span>', '</span>', $html);
    return $html;
}

add_filter('wp_list_categories', 'zoo_cat_count_span');
function zoo_cat_count_span($links)
{
    $links = str_replace('<span class="count">(', '<span  class="count">', $links);
    $links = str_replace(')</span>', '</span>', $links);
    return $links;
}

//Single product video
if (!function_exists('zoo_oembed_dataparse')) {
    function zoo_oembed_dataparse($return, $data, $url)
    {
        if (false === strpos($return, 'youtube.com'))
            return $return;
        $id = explode('watch?v=', $url);
        $add_id = str_replace('allowfullscreen>', 'allowfullscreen id="yt-' . $id[1] . '">', $return);
        $add_id = str_replace('?feature=oembed', '?enablejsapi=1', $add_id);
        return $add_id;
    }
}
add_filter('oembed_dataparse', 'zoo_oembed_dataparse', 10, 3);
add_action('zoo_single_product_video', 'zoo_product_video', 10);
if (!function_exists('zoo_product_video')) {
    function zoo_product_video()
    {
        $zoo_product_video = get_post_meta(get_the_ID(), 'zoo_single_product_video', true);
        if ($zoo_product_video != '') {

            $zoo_product_video_url = parse_url($zoo_product_video);
            if ($zoo_product_video_url['host'] == 'vimeo.com')
                wp_enqueue_script('vimeoapi', 'https://player.vimeo.com/api/player.js', true);
            if ($zoo_product_video_url['host'] == 'youtube.com' || $zoo_product_video_url['host'] == 'www.youtube.com')
                wp_enqueue_script('youtube-api', 'https://www.youtube.com/player_api', true);
            switch ($zoo_product_video_url['host']) {
                case 'vimeo.com':
                    $zoo_embed_class = 'vimeo-embed';
                    break;
                case 'youtube.com':
                    $zoo_embed_class = 'youtube-embed';
                    break;
                case 'www.youtube.com':
                    $zoo_embed_class = 'youtube-embed';
                    break;
                default:
                    $zoo_embed_class = '';
            }
            $zoo_pv_html = '<div class="wrap-product-video ' . $zoo_embed_class . '"><a href=' . $zoo_product_video . ' title="' . get_the_title() . '" class="video-lb-control"><i class="cs-font clever-icon-play"></i> ' . esc_html__("Watch Video", "fona") . '</a>';
            $zoo_pv_html .= '<div class="mask-product-video"><i class="cs-font clever-icon-close-1"></i></div>' . wp_oembed_get($zoo_product_video) . '</div>';
            echo ent2ncr($zoo_pv_html);
            wp_enqueue_script('zoo-product-embed');
        } else {
            return;
        }

    }
}
//Shop Product style
if (!function_exists('zoo_product_style')) {
    function zoo_product_style()
    {
        $zoo_product_style = get_theme_mod('zoo_product_style', 'default');
        if (isset($_GET['style'])) {
            $zoo_product_style = $_GET['style'];
        }
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        return $zoo_product_style;
    }
}
//Sale count down
add_action('woocommerce_single_product_summary', 'zoo_sale_coundown', 10);
if (!function_exists('zoo_sale_coundown')) {
    function zoo_sale_coundown()
    {
        return get_template_part('/woocommerce/single-product/sale-count', 'down');
    }
}
//Cart free shipping notice
if (!function_exists('zoo_free_shipping_cart_notice_zones')) {
    function zoo_free_shipping_cart_notice_zones()
    {
        if (get_theme_mod('zoo_cart_notice', true)) {
            global $woocommerce;
            // Get Free Shipping Methods for Rest of the World Zone & populate array $min_amounts
            $default_zone = new WC_Shipping_Zone(0);
            $default_methods = $default_zone->get_shipping_methods();

            foreach ($default_methods as $key => $value) {
                if ($value->id === "free_shipping") {
                    if ($value->min_amount > 0) $min_amounts[] = $value->min_amount;
                }
            }
            // Get Free Shipping Methods for all other ZONES & populate array $min_amounts
            $delivery_zones = WC_Shipping_Zones::get_zones();

            foreach ($delivery_zones as $key => $delivery_zone) {
                foreach ($delivery_zone['shipping_methods'] as $key => $value) {
                    if ($value->id === "free_shipping") {
                        if ($value->min_amount > 0) $min_amounts[] = $value->min_amount;
                    }
                }
            }
            // Find lowest min_amount
            if (isset($min_amounts)) {
                if (is_array($min_amounts) && $min_amounts) {
                    $min_amount = min($min_amounts);
                    // Get Cart Subtotal inc. Tax excl. Shipping
                    $current = WC()->cart->subtotal;

                    // If Subtotal < Min Amount Echo Notice
                    // and add "Continue Shopping" button
                    if ($current > 0) {
                        $percent = round(($current / $min_amount) * 100, 2);
                        $percent >= 100 ? $percent = '100' : '';
                        $parse_class = '';
                        if ($percent < 40) {
                            $parse_class = 'first-parse';
                        } elseif ($percent >= 40 && $percent < 80) {
                            $parse_class = 'second-parse';
                        } else {
                            $parse_class = 'final-parse';
                        }
                        $parse_class .= ' free-shipping-required-notice';
                        if ($current < $min_amount) {
                            $added_text = '<div class="shipping-heading-notice">' . esc_html__('Get ', 'fona') . '<b>' . esc_html__('Free Shipping', 'fona') . '</b>' . esc_html__(' if you order ', 'fona') . wc_price($min_amount - $current) . esc_html__(' more!', 'fona') . '</div>';
                            $return_to = apply_filters('woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect(wc_get_raw_referer(), false) : wc_get_page_permalink('shop'));
                            $notice = sprintf('%s<a href="%s" class="button wc-forward">%s</a>', $added_text, esc_url($return_to), esc_html__('Continue Shopping', 'woocommerce'));
                        } else {
                            $notice = '<div class="shipping-heading-notice">' . esc_html__('Congratulations! You\'ve got free shipping!', 'fona') . '</div>';
                        }
                        $html = '<div class="' . esc_attr($parse_class) . '">';
                        $html .= '<div class="zoo-loading-bar"><div class="load-percent" style="width:' . esc_attr($percent) . '%">';
                        $html .= esc_html($percent) . '%';
                        $html .= '</div></div>';
                        $html .= $notice;
                        $html .= '</div>';
                        echo $html;
                    }

                }
            }
        }
    }
}
add_action('zoo_free_shipping_cart_notice', 'zoo_free_shipping_cart_notice_zones');

//Vendor hook WCMp
if (class_exists('WCMp')) {
    add_filter('wcmp_sold_by_text_after_products_shop_page', '__return_false');
    function zoo_WCMp_vendor_name()
    {
        global $post;
        if ('Enable' === get_wcmp_vendor_settings('sold_by_catalog', 'general')) {
            $vendor = get_wcmp_product_vendors($post->ID);
            if ($vendor) {
                $sold_by_text = apply_filters('wcmp_sold_by_text', __('Sold By', 'fona'), $post->ID);
                echo '<a class="zoo-by-vendor-name-link" href="' . $vendor->permalink . '">' . $sold_by_text . ' ' . $vendor->user_data->display_name . '</a>';
            }
        }
    }

    if (zoo_product_style() == 'style-3' || zoo_product_style() == 'style-5' || zoo_product_style() == 'style-6') {
        add_action('woocommerce_after_shop_loop_item', 'zoo_WCMp_vendor_name', 5);
    } else {
        add_action('woocommerce_before_shop_loop_item', 'zoo_WCMp_vendor_name', 5);
    }


    // Add link Register form vendor
    if (!function_exists('clever_register_vendor_url')) {
        function clever_register_vendor_url()
        {
            echo '<p class="vendor-register"><a href="' . esc_url(get_permalink(wcmp_vendor_registration_page_id())) . '"> Create a Vendor account. </a></p>';
        }
    }
    add_action('woocommerce_register_vendor_form', 'clever_register_vendor_url', 10);

    // Get vendor user
    if (!function_exists('get_vendor_user')) {
        function get_vendor_user()
        {
            global $WCMp;
            $ob_vendors = get_wcmp_vendors();
            $vendors = array();
            foreach ($ob_vendors as $key => $value) {
                $id = $value->user_data->data->ID;
                $name = $value->user_data->data->user_login;
                $vendors[]['id'] = $id;
                $vendors[]['name'] = $name;
            }
            return $vendors;
        }
    }
    if (!function_exists('zoo_get_vendor_id')) {
        function zoo_get_vendor_id()
        {
            global $WCMp, $vendor, $wp;
            $vendor_store = get_wcmp_vendor_by_store_url(home_url($wp->request));
            $check_vendor_store = $vendor_store ? $vendor_store->taxonomy : '';
            $vendor_id = false;
            if ($check_vendor_store == 'dc_vendor_shop') {
                $vendor_id = $vendor->id;
            }
            return $vendor_id;
        }
    }
    if (!function_exists('zoo_get_vendor_info')) {
        function zoo_get_vendor_info()
        {
            global $WCMp, $vendor, $wp;
            $vendor_archive_info = array();
            $vendor_archive_info['vendor_id'] = $vendor_archive_info['display_name'] = $vendor_archive_info['profile'] = '';
            $vendor_archive_info['banner'] = $vendor_archive_info['description'] = $vendor_store = $check_vendor_store = '';

            $vendor_store = get_wcmp_vendor_by_store_url(home_url($wp->request));
            $check_vendor_store = $vendor_store ? $vendor_store->taxonomy : '';

            if ($check_vendor_store == 'dc_vendor_shop') {
                $image = $vendor->get_image();
                $address = '';
                if ($vendor->city) {
                    $address = $vendor->city . ', ';
                }
                if ($vendor->state) {
                    $address .= $vendor->state . ', ';
                }
                if ($vendor->country) {
                    $address .= $vendor->country;
                }
                $vendor_archive_info['vendor_id'] = $vendor->id;
                $vendor_archive_info['display_name'] = $vendor->user_data->data->display_name;
                $vendor_archive_info['profile'] = $image;
                $vendor_archive_info['banner'] = $vendor->get_image('banner');
                $vendor_archive_info['description'] = stripslashes($vendor->description);
                $vendor_archive_info['mobile'] = $vendor->phone;
                $vendor_archive_info['location'] = $address;
                $vendor_archive_info['email'] = $vendor->user_data->user_email;

                $vendor_archive_info['address_1'] = get_user_meta($vendor->id, '_vendor_address_1', true);
                $vendor_archive_info['address_2'] = get_user_meta($vendor->id, '_vendor_address_2', true);
                $vendor_archive_info['social']['fb'] = get_user_meta($vendor->id, '_vendor_fb_profile', true);
                $vendor_archive_info['social']['tw'] = get_user_meta($vendor->id, '_vendor_twitter_profile', true);
                $vendor_archive_info['social']['ld'] = get_user_meta($vendor->id, '_vendor_linkdin_profile', true);
                $vendor_archive_info['social']['gp'] = get_user_meta($vendor->id, '_vendor_google_plus_profile', true);
                $vendor_archive_info['social']['yt'] = get_user_meta($vendor->id, '_vendor_youtube', true);
                $vendor_archive_info['social']['it'] = get_user_meta($vendor->id, '_vendor_instagram', true);
            }
            return $vendor_archive_info;
        }
    }
}

if (!function_exists('check_vendor')) {
    function check_vendor()
    {
        global $WCMp, $vendor, $wp;
        $check_vendor = false;
        if (class_exists('WCMp')) {
            $vendor_store = get_wcmp_vendor_by_store_url(home_url($wp->request));
            $check_vendor_store = $vendor_store ? $vendor_store->taxonomy : '';
            if ($check_vendor_store == 'dc_vendor_shop') {
                $check_vendor = true;
            }
        }
        return $check_vendor;
    }

}
//GDPR Hook
remove_action('register_form', array('GDPR', 'consent_checkboxes'));