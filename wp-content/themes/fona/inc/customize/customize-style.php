<?php
/**
 * Import customize style
 *
 * @return Css inline at header.
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
// Render css customize
add_action('wp_enqueue_scripts', 'zoo_enqueue_render', 1000);
// Enqueue scripts for theme.
function zoo_enqueue_render()
{
    //Load font
    $zoo_fonts = array();
    $zoo_fonts[] = get_theme_mod('zoo_typo_body_font', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_heading_font', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_main_menu', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_sub_menu', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_footer_title', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_blog_archive_title', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_title_sidebar', '');
    if (class_exists('WooCommerce')) {
        $zoo_fonts[] = get_theme_mod('zoo_typo_woo_shop_title', '');
        $zoo_fonts[] = get_theme_mod('zoo_typo_woo_single_title', '');
        $zoo_fonts[] = get_theme_mod('zoo_typo_woo_price', '');
    }
    if (!empty(array_filter($zoo_fonts))) {
        $zoo_gg_fonts = array();
        foreach ($zoo_fonts as $font) {
            if ($font) {
                if (!in_array('San Francisco Pro', $font) && !in_array('FunctionPro', $font)) {
                    $zoo_gg_fonts[] = $font;
                }
            }
        }
        $zoo_gg_fonts = zoo_import_fonts($zoo_gg_fonts);
        wp_enqueue_style('zoo-font', $zoo_gg_fonts, false, '');
    }
    // Load custom style
    wp_add_inline_style('fona', zoo_customize_style());
    if (get_theme_mod('zoo_custom_js') != '') {
        wp_add_inline_script('fona', zoo_customize_js());
    }
}

if (!function_exists('zoo_customize_js')) {
    function zoo_customize_js()
    {
        $zoo_script = '';
        if (get_theme_mod('zoo_custom_js') != '') {
            $zoo_script = get_theme_mod('zoo_custom_js');
        }
        return $zoo_script;
    }
}
function zoo_customize_style()
{
    /* ----------------------------------------------------------
                                Typography
                        All typography must add here
    ---------------------------------------------------------- */
    $zoo_fonts = array();
    $zoo_fonts[] = get_theme_mod('zoo_typo_body_font', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_heading_font', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_main_menu', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_sub_menu', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_footer_title', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_blog_archive_title', '');
    $zoo_fonts[] = get_theme_mod('zoo_typo_title_sidebar', '');

    $body_font = get_theme_mod('zoo_typo_body_font', array('font-family' => 'San Francisco Pro', 'variant' => 400, 'font-size' => '16px'));
    $heading_font = get_theme_mod('zoo_typo_heading_font', array('font-family' => 'San Francisco Pro', 'variant' => '600'));
    $navigation_font = get_theme_mod('zoo_typo_main_menu', array('font-family' => 'San Francisco Pro', 'variant' => '600', 'font-size' => '14px'));
    $sub_nav_font = get_theme_mod('zoo_typo_sub_menu', array('font-family' => 'San Francisco Pro', 'variant' => '400', 'font-size' => '16px'));
    $footer_title = get_theme_mod('zoo_typo_footer_title', array('font-family' => 'San Francisco Pro', 'variant' => '600', 'font-size' => '16px'));
    $archive_title = get_theme_mod('zoo_typo_blog_archive_title', array('font-family' => 'San Francisco Pro', 'variant' => '500', 'font-size' => '30px'));
    $sidebar_title = get_theme_mod('zoo_typo_title_sidebar', array('font-family' => 'San Francisco Pro', 'variant' => '500', 'font-size' => '21px'));

    if (class_exists('WooCommerce')) {
        $woo_title = get_theme_mod('zoo_typo_woo_shop_title', array('font-family' => 'San Francisco Pro', 'variant' => '400', 'font-size' => '16px'));
        $woo_single_title = get_theme_mod('zoo_typo_woo_single_title', array('font-family' => 'San Francisco Pro', 'variant' => '500', 'font-size' => '34px'));
        $woo_price = get_theme_mod('zoo_typo_woo_price', array('font-family' => 'San Francisco Pro', 'variant' => '500', 'font-size' => '16px'));
        $zoo_fonts[] = get_theme_mod('zoo_typo_woo_shop_title', '');
        $zoo_fonts[] = get_theme_mod('zoo_typo_woo_single_title', '');
        $zoo_fonts[] = get_theme_mod('zoo_typo_woo_price', '');
    }
    $css = '';
    $zoo_local_font = array();
    foreach ($zoo_fonts as $font) {
        if ($font) {
            if (in_array('San Francisco Pro', $font)) {
                $zoo_local_font[] = 'San Francisco Pro';
            } elseif (in_array('FunctionPro', $font)) {
                $zoo_local_font[] = 'FunctionPro';
            }
        }
    }
    if(is_page() && get_post_meta(get_the_ID(),'zoo_page_font',true)!=''){
        if(get_post_meta(get_the_ID(),'zoo_page_font',true)=='FunctionPro'){
            $zoo_local_font = array();
            $body_font = get_theme_mod('zoo_typo_body_font', array('font-family' => 'FunctionPro', 'variant' => 400, 'font-size' => '16px'));
            $heading_font = get_theme_mod('zoo_typo_heading_font', array('font-family' => 'FunctionPro', 'variant' => '600'));
            $navigation_font = get_theme_mod('zoo_typo_main_menu', array('font-family' => 'FunctionPro', 'variant' => '600', 'font-size' => '14px'));
            $sub_nav_font = get_theme_mod('zoo_typo_sub_menu', array('font-family' => 'FunctionPro', 'variant' => '400', 'font-size' => '16px'));
            $footer_title = get_theme_mod('zoo_typo_footer_title', array('font-family' => 'FunctionPro', 'variant' => '600', 'font-size' => '16px'));
            $archive_title = get_theme_mod('zoo_typo_blog_archive_title', array('font-family' => 'FunctionPro', 'variant' => '600', 'font-size' => '30px'));
            $sidebar_title = get_theme_mod('zoo_typo_title_sidebar', array('font-family' => 'FunctionPro', 'variant' => '500', 'font-size' => '21px'));
            $woo_title = get_theme_mod('zoo_typo_woo_shop_title', array('font-family' => 'FunctionPro', 'variant' => '400', 'font-size' => '16px'));
            $woo_single_title = get_theme_mod('zoo_typo_woo_single_title', array('font-family' => 'FunctionPro', 'variant' => '600', 'font-size' => '34px'));
            $woo_price = get_theme_mod('zoo_typo_woo_price', array('font-family' => 'FunctionPro', 'variant' => '600', 'font-size' => '16px'));
            $zoo_local_font[] = 'FunctionPro';
        }elseif(get_post_meta(get_the_ID(),'zoo_page_font',true)=='San_Francisco_Pro'){
            $zoo_local_font = array();
            $zoo_local_font[] = 'San Francisco Pro';
            $body_font = get_theme_mod('zoo_typo_body_font', array('font-family' => 'San Francisco Pro', 'variant' => 400, 'font-size' => '16px'));
            $heading_font = get_theme_mod('zoo_typo_heading_font', array('font-family' => 'San Francisco Pro', 'variant' => '600'));
            $navigation_font = get_theme_mod('zoo_typo_main_menu', array('font-family' => 'San Francisco Pro', 'variant' => '600', 'font-size' => '14px'));
            $sub_nav_font = get_theme_mod('zoo_typo_sub_menu', array('font-family' => 'San Francisco Pro', 'variant' => '400', 'font-size' => '16px'));
            $footer_title = get_theme_mod('zoo_typo_footer_title', array('font-family' => 'San Francisco Pro', 'variant' => '600', 'font-size' => '16px'));
            $archive_title = get_theme_mod('zoo_typo_blog_archive_title', array('font-family' => 'San Francisco Pro', 'variant' => '500', 'font-size' => '30px'));
            $sidebar_title = get_theme_mod('zoo_typo_title_sidebar', array('font-family' => 'San Francisco Pro', 'variant' => '500', 'font-size' => '21px'));
            $woo_title = get_theme_mod('zoo_typo_woo_shop_title', array('font-family' => 'San Francisco Pro', 'variant' => '400', 'font-size' => '16px'));
            $woo_single_title = get_theme_mod('zoo_typo_woo_single_title', array('font-family' => 'San Francisco Pro', 'variant' => '500', 'font-size' => '34px'));
            $woo_price = get_theme_mod('zoo_typo_woo_price', array('font-family' => 'San Francisco Pro', 'variant' => '600', 'font-size' => '16px'));

        }
    }
    if (empty(array_filter($zoo_fonts)) || !empty($zoo_local_font)) {
        if (in_array('San Francisco Pro', $zoo_local_font)||empty(array_filter($zoo_fonts))) {
            $css .= '@font-face {
    font-family: \'San Francisco Pro\';
    font-style: normal;
    font-weight: 400;
    src: url(' . get_template_directory_uri() . '/assets/fonts/SF-Pro-Text-Regular.otf) format("truetype");
    }
    
    @font-face {
        font-family: \'San Francisco Pro\';
        font-style: normal;
        font-weight: 500;
        src: url(' . get_template_directory_uri() . '/assets/fonts/SF-Pro-Text-Medium.otf) format("truetype");
    }
    
    @font-face {
        font-family: \'San Francisco Pro\';
        font-style: normal;
        font-weight: 600;
        src: url(' . get_template_directory_uri() . '/assets/fonts/SF-Pro-Text-Semibold.otf) format("truetype");
    }
    ';
        }
        if (in_array('FunctionPro', $zoo_local_font)) {
            $css .= '@font-face {
    font-family: \'FunctionPro\';
    font-style: normal;
    font-weight: 400;
    src: url(' . get_template_directory_uri() . '/assets/fonts/FunctionPro/FunctionPro-Book.ttf) format("truetype");
    }
    
    @font-face {
        font-family: \'FunctionPro\';
        font-style: normal;
        font-weight: 500;
        src: url(' . get_template_directory_uri() . '/assets/fonts/FunctionPro/FunctionPro-Medium.ttf) format("truetype");
    }
    
    @font-face {
        font-family: \'FunctionPro\';
        font-style: normal;
        font-weight: 600;
        src: url(' . get_template_directory_uri() . '/assets/fonts/FunctionPro/FunctionPro-Bold.ttf) format("truetype");
    }
    ';
        }
    }
    /* ----------------------------------------------------------
                           Load Font
    ---------------------------------------------------------- */
    $css .= "html{";
    if (isset($body_font['font-size'])) {
        $css .= "font-size: {$body_font['font-size']};";
    }
    $css .= "}";
    /*Site width*/
    $css .= '@media(min-width:1200px){.container{max-width:' . zoo_site_width() . ';width:100%}';
    if (get_theme_mod('zoo_site_width', '1200') > 1200) {
        $css .= '.woocommerce .horizontal-gallery.zoo-single-product .wrap-right-single-product,.woocommerce .zoo-single-product.vertical-gallery .wrap-right-single-product, .woocommerce .zoo-single-product.vertical-gallery .wrap-right-single-product{
        padding-left:8.3%;}';
    }
    $css .= '}';
    /*Logo Padding*/
    $zoo_logo_padding_top = get_theme_mod('zoo_logo_padding_top', '40');
    $zoo_logo_padding_bottom = get_theme_mod('zoo_logo_padding_bottom', '40');
    if (is_page() && get_post_meta(get_the_ID(), 'zoo_logo_page', true) != '') {
        $zoo_logo_padding_top = get_post_meta(get_the_ID(), 'zoo_logo_padding_top', true) != '' ? get_post_meta(get_the_ID(), 'zoo_logo_padding_top', true) : $zoo_logo_padding_top;
        $zoo_logo_padding_bottom = get_post_meta(get_the_ID(), 'zoo_logo_padding_bottom', true) != '' ? get_post_meta(get_the_ID(), 'zoo_logo_padding_bottom', true) : $zoo_logo_padding_bottom;
    }
    $css .= " #site-branding{padding-top:" . $zoo_logo_padding_top . "px;padding-bottom:" . $zoo_logo_padding_bottom . "px;}";
    if (get_theme_mod('zoo_logo_height', '') != '') {
        $css .= "#logo img{height:" . get_theme_mod('zoo_logo_height', '') . "px}";
    }
    /*Site bg*/
    $zoo_bg = get_theme_mod('zoo_site_background_color', 'transparent');
    $zoo_bg_img = get_theme_mod('zoo_site_background_image', '');
    if (is_single() || is_page()) {
        if (get_post_meta(get_the_ID(), 'zoo_page_bg_color', true) != '') {
            $zoo_bg = get_post_meta(get_the_ID(), 'zoo_page_bg_color', true);
        }
        if (get_post_meta(get_the_ID(), 'zoo_page_bg', true) != '') {
            $zoo_bg_img = get_post_meta(get_the_ID(), 'zoo_page_bg', true);
            $zoo_bg_img = wp_get_attachment_url($zoo_bg_img);
        }
    }
    $zoo_bg = 'background:' . $zoo_bg;
    if ($zoo_bg_img != '') {
        $zoo_bg .= ' url("' . $zoo_bg_img . '") ' . get_theme_mod('zoo_site_background_position', 'bottom center') . '/' . get_theme_mod('zoo_site_background_size', 'contain') . ';';
        $zoo_bg .= ' background-repeat:' . get_theme_mod('zoo_site_background_repeat', 'no-repeat') . ';';
        $zoo_bg .= ' background-attachment:' . get_theme_mod('zoo_site_background_attachment', 'inherit') . ';';
    }
    $css .= 'body, body.boxes-page{' . $zoo_bg . '}';
    /*Typography generate Css*/
    $css .= zoo_generate_font('body', $body_font);
//    if (isset($body_font['font-family'])) {
//        $css .= 'body, div.asl_r .results .item .asl_content h3, div.asl_r .results .item .asl_content h3 a{font-family:' . $body_font['font-family'] . ' !important}';
//    }

    /* Heading font */
    $css .= zoo_generate_font("h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6", $heading_font);
    $css .= zoo_generate_font_size('h1, .h1', get_theme_mod('zoo_typo_heading_size_h1', '34'));
    $css .= zoo_generate_font_size('h2, .h2', get_theme_mod('zoo_typo_heading_size_h2', '30'));
    $css .= zoo_generate_font_size('h3, .h3', get_theme_mod('zoo_typo_heading_size_h3', '24'));
    $css .= zoo_generate_font_size('h4, .h4', get_theme_mod('zoo_typo_heading_size_h4', '21'));
    $css .= zoo_generate_font_size('h5, .h5', get_theme_mod('zoo_typo_heading_size_h5', '18'));
    $css .= zoo_generate_font_size('h6, .h6', get_theme_mod('zoo_typo_heading_size_h6', '16'));
    /*Primary font*/
    /*End Typography generate Css*/
    /*Color*/
    $css .= zoo_generate_color("body", get_theme_mod('zoo_color_body', ''));
    $css .= zoo_generate_color("h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6", get_theme_mod('zoo_color_heading', ''));
    $css .= zoo_generate_color("a", get_theme_mod('zoo_color_link', ''));
    $css .= zoo_generate_color("a:hover, a:focus, a:active", get_theme_mod('zoo_color_link_hover', ''));
    /*Accent color*/
    //Accent color
    $accent_color = zoo_preset();
    if (is_page()) {
        $css .= zoo_generate_color('.products .product .product-name a:hover, .zoo-blog-item .title-post:hover', $accent_color);
        $css .= zoo_generate_color('.primary-nav nav > ul > li li:hover> a', $accent_color);
    }
    //Accent color
    $accent_class = '.wrap-text-field.gdpr-consent > p a, #user_consents_privacy-policy_field a, .woocommerce .login.form label a:not(.btn):not(.added_to_cart), .woocommerce .register.form label a:not(.btn):not(.added_to_cart), .cvca-products-wrap.cat-align-right .cvca-ajax-load.cvca-list-product-category a:hover, .cvca-products-wrap.cat-align-right .cvca-ajax-load.cvca-list-product-category a.active, .login-form-popup .wrap-login-form > p a.register, .zoo-single-post-nav-item a:hover, .products .product.style-2 .wrap-product-button .button:hover i, .products .product.style-2 .wrap-product-button .btn:hover i, .products .product.style-2 .wrap-product-button .added_to_cart:hover i, .products .product.style-2 .wrap-product-button .zoo-custom-wishlist-block:hover i,#icon-header .search a:hover, .search-popup .header-search-block .close-search:hover, #menu-mobile-trigger.active,
.zoo-icon-field .wrap-icon-item i, .zoo-wrap-pagination.simple a:hover,
.layout-control-block li a.active, .layout-control-block li a.disable-sidebar,
.primary-nav nav > ul li:hover > a, .primary-nav nav > ul li:hover:after, .primary-nav nav > ul li.current-menu-item > a, .primary-nav nav > ul li.current_page_item > a,
#zoo-header.header-transparent .is-sticky .cmm-container .cmm.cmm-theme-tomo > li:hover > a, #zoo-header.header-transparent .is-sticky .cmm-container .cmm.cmm-theme-tomo > li:hover > .cmm-nav-link, #zoo-header.header-transparent .is-sticky .menu-center-layout #icon-header .search a:hover, #zoo-header.header-transparent .is-sticky .menu-center-layout #icon-header .top-wl-url a:hover, #zoo-header.header-transparent .is-sticky .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon:hover, #zoo-header.header-transparent .is-sticky .canvas-sidebar-trigger:hover,
.widget-acc-info > a, .wrap-center-layout .zoo-widget-social-icon li:hover i, .zoo-blog-item .post-info a:hover, .zoo-blog-item .readmore,
.zoo-carousel-btn:hover, .post-content a, .comment-body a, .calendar_wrap table a, .tags-link-wrap a, .btn.btn-white, .cvca-shortcode-banner.style-4 .banner-content a.banner-media-link:hover,
.single-page .cvca-demo-box.inline.textstyle .cvca-header-demo-box > i, .default.carousel-testimonial .cvca-testimonial-item .cvca-testimonial-author, .style-1.carousel-testimonial .cvca-testimonial-item .cvca-testimonial-author,
.btn.btn-border-accent, a:hover, #icon-header .search a:hover, .menu-right-layout #icon-header .search a.search-trigger:hover, .menu-right-layout #icon-header .top-wl-url a:hover, .menu-right-layout #icon-header .top-cart-icon:hover, .menu-right-layout #icon-header .my-acc-url a:hover,
.search-popup .header-search-block .close-search:hover, .menu-center-layout #icon-header .search a:hover, .menu-center-layout #icon-header .top-wl-url a:hover, .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon:hover,
.stack-center-layout:not(.style-3) .header-search-block button:hover, .stack-center-layout.style-2 .zoo-widget-social-icon li:hover, .menu-top #top-menu #icon-header li.top-wl-url a:hover, .stack-center-layout #icon-header .top-cart-icon:hover,
#menu-mobile-trigger.active, .sidebar a:hover, .tagcloud a, .zoo-icon-field .wrap-icon-item i, .zoo-posts-widget .title-post:hover, .zoo-wrap-pagination.simple a:hover, .header-post.post-has-thumbnail a:hover,
.zoo-single-post-nav-item a:hover, .layout-control-block li a.active, .layout-control-block li a.disable-sidebar, .amount ins, ul.products li.product .button:hover, ul.products li.product .added_to_cart:hover, .woocommerce ul.products li.product .price ins,
.product-category .woocommerce-loop-category__title:hover, .zoo-woo-page .zoo-custom-wishlist-btn.yith-wcwl-wishlistexistsbrowse a, .zoo-woo-page .zoo-custom-wishlist-btn.yith-wcwl-wishlistaddedbrowse a, .zoo-woo-page .zoo-custom-wishlist-btn:hover a, .products .zoo-custom-wishlist-btn.yith-wcwl-wishlistexistsbrowse a, .products .zoo-custom-wishlist-btn.yith-wcwl-wishlistaddedbrowse a, .products .zoo-custom-wishlist-btn:hover a,
.products .product .add_to_wishlist:hover, .products .product .product-name .zoo-custom-wishlist-btn.yith-wcwl-wishlistaddedbrowse a, .products .product .product-name .zoo-custom-wishlist-btn.yith-wcwl-wishlistexistsbrowse a, .products .product .product-name .zoo-custom-wishlist-btn a:hover,
.products .product .product-name a:hover:not(.button), .products .product:not(.default) .wrap-product-button .button:hover i, .products .product:not(.default) .wrap-product-button .btn:hover i, .products .product:not(.default) .wrap-product-button .added_to_cart:hover i, .products .product:not(.default) .wrap-product-button .zoo-custom-wishlist-block:hover i,
.cart.variations_form .reset_variations:hover, .wrap-site-main .zoo-woo-sidebar .prdctfltr_reset:hover, .wrap-site-main .prdctfltr_wc.prdctfltr_square .prdctfltr_filter label.prdctfltr_active > span::before, 
.wrap-icon-cart:hover i, .bottom-cart .total .amount, .zoo-mini-cart .mini_cart_item .right-mini-cart-item .amount, .zoo-mini-cart .mini_cart_item .product-name a:hover,.zoo-mini-cart .mini_cart_item .right-mini-cart-item .remove:hover,
 .zoo-single-product-nav .product-title:hover, .wrap-extend-content a:hover, .woocommerce .zoo-single-product .wrap-thumbs-gal .zoo-carousel-btn:hover, .woocommerce .zoo-single-product .wrap-single-carousel .zoo-carousel-btn:hover,
.woocommerce div.product .entry-summary form.cart .group_table td.label ins, .single-product .zoo-woo-lightbox:hover, .woocommerce .zoo-single-product .entry-summary .zoo-custom-wishlist-block.yith-wcwl-add-to-wishlist .zoo-custom-wishlist-btn a:hover,
.woocommerce .zoo-single-product .product_meta a:hover, .wrap-right-single-product .zoo-custom-wishlist-block:hover, .wrap-right-single-product .control-share:hover, .woocommerce table.shop_table tbody .product-price, .woocommerce table.shop_table tbody .product-subtotal,
.woocommerce table.shop_table tbody .product-quantity .quantity .qty-nav:hover, .woocommerce table.shop_table tbody .product-remove a.remove:hover, .woocommerce-cart ul.shop_table .amount, .woocommerce-checkout ul.shop_table .amount,
.woocommerce-cart .shipping-cal .shipping-calculator-button:hover, .woocommerce-checkout .shipping-cal .shipping-calculator-button:hover, .woocommerce-checkout .woocommerce-info a,
 .woocommerce-MyAccount-content a, .cmm-container .cmm.cmm-theme-tomo li > .cmm-content-container .cmm-content-wrapper ul.menu > li > a:hover';

    //Accent background
    $accent_bg_class = '.menu-bottom #bottom-header, .tnp-widget form .tnp-submit:hover, .bottom-cart .buttons .button.wc-forward:hover, #commentform #submit, .shadow-hover:hover, .zoo-widget-social-icon i:hover, #sb_instagram #sbi_load .sbi_follow_btn:hover, .main-content .navigation.pagination .nav-links .page-numbers:hover, .wrap-pagination .pagination span:hover, .social-icons li a:hover, .page-numbers li .page-numbers:hover, .cvca-team-member .member-social li:hover, .wpcf7-form-control.wpcf7-submit:hover,
.shadow-active, .cvca-pagination .cvca_pagination-item:hover, .cvca-pagination .cvca_pagination-item.current,.shadow-active-light,#sb_instagram #sbi_load .sbi_follow_btn,.tnp-widget form .tnp-submit,
.zoo-blog-item.masonry-layout-item.post_format-post-format-quote .zoo-post-inner:before, .main-content .navigation.pagination .nav-links .page-numbers.current, .main-content .navigation.pagination .nav-links .page-numbers:hover,
.wrap-pagination .pagination span:hover, .wrap-pagination .pagination > span, .bottom-post .share-control, .tags-link-wrap a:hover, .social-icons li a:hover, .page-numbers li .page-numbers.current, .page-numbers li .page-numbers:hover,
.wrap-head-team-member:after, .wpcf7-form-control.wpcf7-submit:hover, .cvca-shortcode-banner .wrap-banner-link .banner-media-link:before, .cvca-shortcode-banner .banner-content .banner-media-link:before, .btn.btn-light:hover,
.cvca-products-wrap.bottomnav .products .cvca-carousel-btn, .btn.btn-slider, .btn.btn-border-accent:hover, .btn.btn-accent, .share-links .social-icon:hover a, .btn-primary, .btn:hover, input[type="submit"]:hover, button:not(.vc_general):not(.pswp__button):hover, .button:hover,
.wrap-text-field .line:after, .tagcloud a:hover, .zoo_download_block .text-download, .wrap-header-post-info div.cat-post-label a:hover, .single-quote, .wrap-img:before, .wrap-img:after, .added_to_cart, .products .wrap-product-img:before, .products .wrap-product-img:after,
.products.grid .default .quick-view:hover, .products .product.style-5 .button:hover, .products .product.style-5 .added_to_cart:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li .page-numbers.current, .woocommerce nav.woocommerce-pagination ul.page-numbers li a.page-numbers:hover,
.wrap-site-main .pf_rngstyle_html5 .irs-slider, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .wrap-icon-cart .top-cart-total, .bottom-cart .buttons .button.checkout:hover, .wrap-extend-content a:hover i,
.tooltipster-base, .woocommerce div.product .entry-summary form.cart .group_table td .button:hover, .images .wrap-single-image:before, .images .wrap-single-image:after, .woocommerce .zoo-single-product .entry-summary .cart .button:hover,.woocommerce .zoo-single-product .zoo-woo-tabs .zoo-tabs li:hover, div.pp_woocommerce .pp_content_container .pp_loaderIcon:before, div.pp_woocommerce .pp_content_container .pp_loaderIcon:after,
.woocommerce-cart .woocommerce .wc-proceed-to-checkout .checkout-button.button:hover, .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .checkout-button.button:hover, .wrap-cart-empty .return-to-shop .button.wc-backward,
.woocommerce .wrap-coupon input.button:hover, .woocommerce-checkout #payment.woocommerce-checkout-payment #place_order:hover, .woocommerce .login.form input.button:hover, .woocommerce .register.form input.button:hover,
.wrap-product-img .zoo-countdown, .wrap-left-single-product:before, .wrap-left-single-product:after';
    $desk_top_accent_class = '
    .cmm-container .cmm.cmm-theme-tomo > li:hover > a, .cmm-container .cmm.cmm-theme-tomo > li.current-menu-item > a, .cmm-container .cmm.cmm-theme-tomo > li.current-menu-ancestor > a,
    .cmm-container .cmm.cmm-theme-tomo > li.cmm-current-menu-item > a, .cmm-container .cmm.cmm-theme-tomo > li:hover > a, .cmm-container .cmm.cmm-theme-tomo > li.current-menu-item > a, .cmm-container .cmm.cmm-theme-tomo > li.current-menu-ancestor > a, #zoo-header.header-transparent:hover .primary-nav nav > ul > li:hover > a, #zoo-header.header-transparent:hover .primary-nav nav > ul > li.menu-item-has-children:hover::after, #zoo-header.header-transparent:hover .cmm-container .cmm.cmm-theme-tomo > li:hover > a, #zoo-header.header-transparent:hover .cmm-container .cmm.cmm-theme-tomo > li:hover > .cmm-nav-link, #zoo-header.header-transparent:hover .menu-center-layout #icon-header .search a:hover, #zoo-header.header-transparent:hover .menu-center-layout #icon-header .top-wl-url a:hover, #zoo-header.header-transparent:hover .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon:hover, #zoo-header.header-transparent:hover .canvas-sidebar-trigger:hover, #zoo-header.header-transparent .is-sticky .primary-nav nav > ul > li:hover > a, #zoo-header.header-transparent .is-sticky .primary-nav nav > ul > li.menu-item-has-children:hover::after, #zoo-header.header-transparent .is-sticky .cmm-container .cmm.cmm-theme-tomo > li:hover > a, #zoo-header.header-transparent .is-sticky .cmm-container .cmm.cmm-theme-tomo > li:hover > .cmm-nav-link, #zoo-header.header-transparent .is-sticky .menu-center-layout #icon-header .search a:hover, #zoo-header.header-transparent .is-sticky .menu-center-layout #icon-header .top-wl-url a:hover, #zoo-header.header-transparent .is-sticky .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon:hover, #zoo-header.header-transparent .is-sticky .canvas-sidebar-trigger:hover';
    //Accent Border
    $accent_border_class = '.cvca-shortcode-banner.style-4 .banner-content a.banner-media-link:hover,.btn.btn-border-accent, blockquote, .blockquote, select:focus, .text-field:focus, input[type="text"]:focus, input[type="search"]:focus, input[type="password"]:focus, textarea:focus, input[type="email"]:focus, input[type="tel"]:focus,
.zoo-wrap-pagination.simple a:hover, .wrap-header-post-info div.cat-post-label a:hover, .product-list-color-swatch li.catalog-swatch-item:hover, .product-list-color-swatch li.catalog-swatch-item.selected,
.zoo-mini-cart:before, .zoo-mini-cart:after,  .variations #pa_color.swatch li.selected, .variations #pa_color.swatch li:hover,
.single-product .zoo-woo-lightbox:hover';
    //Accent shadow class
    $accent_opc_class = '.woocommerce-mini-cart-item.loading .remove::after, .shadow-active, .cvca-pagination .cvca_pagination-item:hover, .cvca-pagination .cvca_pagination-item.current, .shadow-hover:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li span:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li a:hover, .wrap-site-main .pf_rngstyle_html5 .irs-slider:hover, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover, .woocommerce .zoo-single-product .entry-summary .cart .button:hover, .woocommerce .zoo-single-product .zoo-woo-tabs .zoo-tabs li:hover, .woocommerce #review_form input#submit:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover ,
.shadow-hover:hover, .zoo-widget-social-icon i:hover, #sb_instagram #sbi_load .sbi_follow_btn:hover, .tnp-widget form .tnp-submit:hover, .main-content .navigation.pagination .nav-links .page-numbers:hover, .wrap-pagination .pagination span:hover, .social-icons li a:hover, .page-numbers li .page-numbers:hover, .wrap-head-team-member .member-social li:hover, .wpcf7-form-control.wpcf7-submit:hover,
.cvca-shortcode-banner .wrap-banner-link .banner-media-link:hover, .btn.btn-slider,
.cvca-shortcode-banner .wrap-banner-link .banner-media-link:hover,
.shadow-hover:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li span:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li a:hover, .wrap-site-main .pf_rngstyle_html5 .irs-slider:hover, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover, .woocommerce .zoo-single-product .entry-summary .cart .button:hover, .woocommerce .zoo-single-product .zoo-woo-tabs .zoo-tabs li:hover, .woocommerce #review_form input#submit:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover';
    if ($accent_color != '') {
        $css .= zoo_generate_color($accent_class, $accent_color);
        $css .= $accent_bg_class . '{background:' . $accent_color . '}';
        $css .= $accent_border_class . '{border-color:' . $accent_color . '}';
        $css .= $accent_opc_class . '{box-shadow: 5px 5px 10px ' . zoo_hex2rgba($accent_color, 0.3) . '}';
        $css .= '@media(min-width:981px){' . zoo_generate_color($desk_top_accent_class, $accent_color) . '}';
    }

    /*Header css*/
    if (get_header_image() != '') {
        $css .= '#zoo-header{background: url("' . get_header_image() . '") center center/cover no-repeat}';
    }
    /*Top Header css*/
    $zoo_top_header_bg = get_theme_mod('zoo_header_top_bg_color', '');
    $zoo_top_header_color = get_theme_mod('zoo_header_top_color', '');
    $zoo_top_header_link = get_theme_mod('zoo_header_top_link_color', '');
    $zoo_top_header_link_hover = get_theme_mod('zoo_header_top_link_color_hover', '');
    $zoo_header_color = get_theme_mod('zoo_header_main_color', '');
    $zoo_header_link_color = get_theme_mod('zoo_header_main_link_color', '');
    $zoo_header_link_color_hv = get_theme_mod('zoo_header_main_link_color_hover', '');
    $zoo_header_bg = get_theme_mod('zoo_header_main_background_color', '');
    $zoo_header_border = get_theme_mod('zoo_header_border_color', '');
    if (is_page() && get_post_meta(get_the_ID(), 'zoo_enable_header_color', true) == 1) {
        $zoo_top_header_bg = zoo_hex2rgba(get_post_meta(get_the_ID(), 'zoo_top_header_bg', true), get_post_meta(get_the_ID(), 'zoo_top_header_bg_opc', true));
        $zoo_top_header_link = $zoo_top_header_color = get_post_meta(get_the_ID(), 'zoo_top_header_color', true);
        $zoo_top_header_link_hover = get_post_meta(get_the_ID(), 'zoo_top_header_color_hover', true);
        $css .= zoo_generate_color('#top-header .zoo-icon-field .wrap-icon-item i', $zoo_top_header_link);
        $zoo_header_link_color = $zoo_header_color = get_post_meta(get_the_ID(), 'zoo_header_color', true);
        $zoo_header_link_color_hv = get_post_meta(get_the_ID(), 'zoo_header_color_hover', true);
        $zoo_header_bg = zoo_hex2rgba(get_post_meta(get_the_ID(), 'zoo_custom_bg_header', true), get_post_meta(get_the_ID(), 'zoo_custom_bg_header_opc', true));
        $css .= '.sticky-wrapper:hover .wrap-header-block,
.sticky-wrapper:hover #main-header, 
.sticky-wrapper:hover .wrap-header-block.menu-center-layout, 
.two-lines-1 .sticky-wrapper:hover #main-navigation, 
.header-two-lines-2 .sticky-wrapper:hover #main-navigation, .is-sticky .wrap-header-block,.is-sticky #main-header, .is-sticky .wrap-header-block.menu-center-layout, .two-lines-1 .is-sticky #main-navigation, .header-two-lines-2 .is-sticky  #main-navigation{background:' . zoo_hex2rgba(get_post_meta(get_the_ID(), 'zoo_bg_sticky_header', true), get_post_meta(get_the_ID(), 'zoo_bg_sticky_header_opc', true)) . '}';
        $css .= '.is-sticky > .sticker{box-shadow: none}';
        $zoo_header_border = zoo_hex2rgba(get_post_meta(get_the_ID(), 'zoo_header_border_color', true), get_post_meta(get_the_ID(), 'zoo_header_border_color_opc', true));
    } else {
        if (get_theme_mod('zoo_header_main_bg_sticky', '') != '') {
            $css .= '.sticky-wrapper:hover .wrap-header-block,
.sticky-wrapper:hover #main-header, 
.sticky-wrapper:hover .wrap-header-block.menu-center-layout, 
.two-lines-1 .sticky-wrapper:hover #main-navigation, 
.header-two-lines-2 .sticky-wrapper:hover #main-navigation, .is-sticky .wrap-header-block, .two-lines-1 .is-sticky #main-navigation, .header-two-lines-2 .is-sticky  #main-navigation{background:' . get_theme_mod('zoo_header_main_bg_sticky', '') . '}';
        }
    }
    if ($zoo_top_header_bg != '') {
        $css .= '#top-header, .two-lines-2 #top-header, .top-head-widget.widget_nav_menu .menu-item ul{background:' . $zoo_top_header_bg . ';}';
    }
    if ($zoo_header_border != '') {
        $css .= '.stack-center-layout.style-1 .wrap-logo,.header-two-lines-2 #main-navigation{border-bottom-color:' . $zoo_header_border . '}';
    }
    $css .= zoo_generate_color('#top-header', $zoo_top_header_color);
    $css .= zoo_generate_color('#top-header a, #top-header #icon-header .search-trigger', $zoo_top_header_link);
    $css .= zoo_generate_color('#top-header a:hover', $zoo_top_header_link_hover);
    /*End Top Header css*/
    /*Main Header*/
    if ($zoo_header_bg != '') {
        $css .= '.wrap-header-block.stack-center-layout, #main-header, .wrap-header-block.menu-center-layout{background:' . $zoo_header_bg . ';}';
    }
    $css .= zoo_generate_color('#main-header', $zoo_header_color);
    $css .= zoo_generate_color('#menu-mobile-trigger.mobile-menu-icon, .menu-center-layout #icon-header .search a, .menu-center-layout #icon-header .top-wl-url a, .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon, .wrap-header-block a:not(.cmm-nav-link)', $zoo_header_link_color);
    $css .= zoo_generate_color('#menu-mobile-trigger.mobile-menu-icon:hover, .menu-center-layout #icon-header .search a:hover, .menu-center-layout #icon-header .top-wl-url a:hover, .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon:hover, #main-header a:hover', $zoo_header_link_color_hv);
    /*End Header css*/
    /*Main Menu*/
    $zoo_main_menu_bg = get_theme_mod('zoo_header_menu_bg', '');
    $zoo_main_menu_color = '';
    $zoo_main_menu_color_hv = get_theme_mod('zoo_main_menu_color_hover', '');
    if (is_page() && get_post_meta(get_the_ID(), 'zoo_enable_header_color', true) == 1) {
        $zoo_main_menu_bg = zoo_hex2rgba(get_post_meta(get_the_ID(), 'zoo_custom_bg_header_menu', true), get_post_meta(get_the_ID(), 'zoo_custom_bg_header_menu_opc', true));
        $zoo_main_menu_color = get_post_meta(get_the_ID(), 'zoo_custom_color_header_menu', true);
        $zoo_main_menu_color_hv = get_post_meta(get_the_ID(), 'zoo_custom_color_header_menu_hover', true);
        $zoo_header_sticky_color = get_post_meta(get_the_ID(), 'zoo_custom_color_header_sticky', true);
        $zoo_header_sticky_color_hv = get_post_meta(get_the_ID(), 'zoo_custom_color_hover_header_sticky', true);
    }
    if ($zoo_main_menu_bg != '') {
        $css .= '.stack-center-layout #main-navigation, .primary-nav{background:' . $zoo_main_menu_bg . '}';
    }
    if ($zoo_main_menu_color == '') {
        $css .= zoo_generate_color('.primary-nav, .primary-nav>div>ul>li>a, .wrap-sidebar-menu-header, .menu-bottom .menu-mini-cart #mini-top-cart > div > a', get_theme_mod('zoo_header_menu_color', ''));
        $css .= zoo_generate_color('.is-sticky .menu-center-layout #icon-header .search a,.is-sticky  .menu-center-layout #icon-header .top-wl-url a,.is-sticky  .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon,.is-sticky  .wrap-header-block a:not(.cmm-nav-link), .is-sticky .primary-nav nav > ul > li > a, .is-sticky .primary-nav nav > ul > li::after', get_theme_mod('zoo_custom_color_header_sticky', ''));
        $css .= zoo_generate_color('.is-sticky .menu-center-layout #icon-header .search a:hover,.is-sticky  .menu-center-layout #icon-header .top-wl-url a:hover,.is-sticky .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon:hover,.is-sticky  .wrap-header-block a:not(.cmm-nav-link):hover, .is-sticky .primary-nav nav > ul > li:hover > a, .is-sticky .primary-nav nav > ul > li:hover:after', get_theme_mod('zoo_custom_color_header_sticky_hv', ''));
    } else {
        $css .= zoo_generate_color('.primary-nav, .primary-nav>div>ul>li>a, .wrap-sidebar-menu-header, .wrap-sidebar-menu-header', $zoo_main_menu_color);
        $css .= zoo_generate_color('#main-navigation .cmm-container .cmm > li > a, .primary-nav nav > ul > li > a,.primary-nav nav > ul > li:after', $zoo_main_menu_color);
        $css .= '@media(min-width: 981px) {';
        $css .= zoo_generate_color('#zoo-header.header-transparent .site-title > a, #zoo-header.header-transparent .primary-nav nav > ul > li > a, #zoo-header.header-transparent .site-description, #zoo-header.header-transparent .primary-nav nav > ul > li.menu-item-has-children::after, #zoo-header.header-transparent .cmm-container .cmm.cmm-theme-tomo > li > a, #zoo-header.header-transparent .cmm-container .cmm.cmm-theme-tomo > li > .cmm-nav-link, #zoo-header.header-transparent .menu-center-layout #icon-header .search a, #zoo-header.header-transparent .menu-center-layout #icon-header .top-wl-url a, #zoo-header.header-transparent .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon, #zoo-header.header-transparent .canvas-sidebar-trigger', $zoo_main_menu_color);
        $css .= '}';
        $css .= zoo_generate_color('#main-navigation .cmm-container .cmm > li:hover>a, .menu-bottom .menu-mini-cart #mini-top-cart > div > a:hover', $zoo_main_menu_color_hv);
        $css .= zoo_generate_color('#main-navigation .cmm-container .cmm li > .cmm-content-container .cmm-content-wrapper ul.menu > li > a:hover,#main-navigation .cmm-container .cmm li > .cmm-sub-container .sub-menu li > a:hover, #main-navigation .cmm-container .cmm li > .cmm-sub-container .cmm-sub-wrapper li > a:hover', $accent_color);
        $css .= zoo_generate_color('.is-sticky #menu-mobile-trigger.mobile-menu-icon,.sticky-wrapper:hover #menu-mobile-trigger.mobile-menu-icon,.sticky-wrapper:hover .menu-center-layout #icon-header .search a,
.sticky-wrapper:hover .menu-center-layout #icon-header .top-wl-url a,
.sticky-wrapper:hover .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon,
.sticky-wrapper:hover .wrap-header-block a:not(.cmm-nav-link),
.sticky-wrapper:hover #main-navigation .cmm-container .cmm > li > a, 
.sticky-wrapper:hover .primary-nav nav > ul > li > a, .is-sticky .primary-nav nav > ul > li::after, .is-sticky .menu-center-layout #icon-header .search a,.is-sticky  .menu-center-layout #icon-header .top-wl-url a,.is-sticky  .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon,.is-sticky  .wrap-header-block a:not(.cmm-nav-link),.is-sticky #main-navigation .cmm-container .cmm > li > a, .is-sticky .primary-nav nav > ul > li > a, .is-sticky .primary-nav nav > ul > li::after', $zoo_header_sticky_color);
        $css .= zoo_generate_color('.is-sticky #menu-mobile-trigger.mobile-menu-icon:hover,.sticky-wrapper:hover #menu-mobile-trigger.mobile-menu-icon:hover,.sticky-wrapper:hover .menu-center-layout #icon-header .search a:hover,
.sticky-wrapper:hover  .menu-center-layout #icon-header .top-wl-url a:hover,
.sticky-wrapper:hover .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon:hover,
.sticky-wrapper:hover  .wrap-header-block a:not(.cmm-nav-link):hover,
.sticky-wrapper:hover #main-navigation .cmm-container .cmm > li:hover > a, 
.sticky-wrapper:hover .primary-nav nav > ul > li:hover > a, 
.sticky-wrapper:hover .primary-nav nav > ul > li:hover:after,.is-sticky .menu-center-layout #icon-header .search a:hover,.is-sticky  .menu-center-layout #icon-header .top-wl-url a:hover,.is-sticky .menu-center-layout #icon-header .top-ajax-cart .top-cart-icon:hover,.is-sticky  .wrap-header-block a:not(.cmm-nav-link):hover,.is-sticky #main-navigation .cmm-container .cmm > li:hover > a, .is-sticky .primary-nav nav > ul > li:hover > a, .is-sticky .primary-nav nav > ul > li:hover:after', $zoo_header_sticky_color_hv);
    }
    /* Main Navigation font */
    $css .= zoo_generate_font('.primary-nav nav > ul > li > a', $navigation_font);
    $css .= zoo_generate_color('.primary-nav nav>ul>li:hover>a,.primary-nav nav>ul>li:hover:after,  #mini-top-cart .wrap-icon-cart:hover i', $zoo_main_menu_color_hv);
    if (get_theme_mod('zoo_main_menu_bg', '')) {
        $css .= '.primary-nav nav>ul>li{background:' . get_theme_mod('zoo_main_menu_bg', 'transparent') . ';}';
    }
    $css .= '.primary-nav nav>ul>li:hover{background:' . get_theme_mod('zoo_main_menu_bg_hover', 'transparent') . ';}';
    /*End Main Menu*/
    /*Sub Menu*/
    $css .= '.primary-nav nav>ul ul{background:' . get_theme_mod('zoo_sub_menu_block_bg', '#fff') . ';}';
    $css .= zoo_generate_font('.primary-nav nav > ul > li li a', $sub_nav_font);
    $css .= zoo_generate_color('.primary-nav nav>ul ul li:hover>a, .primary-nav nav>ul ul li:hover:after', get_theme_mod('zoo_sub_menu_color_hover', ''));
    if (get_theme_mod('zoo_sub_menu_bg', '') != '') {
        $css .= '.primary-nav nav>ul ul li{background:' . get_theme_mod('zoo_sub_menu_bg', '') . '}';
    }
    if (get_theme_mod('zoo_sub_menu_bg_hover', '') != '') {
        $css .= '.primary-nav nav>ul ul li:hover{background:' . get_theme_mod('zoo_sub_menu_bg_hover', '') . '}';
    }
    /*End Sub Menu*/
    /*Footer Options*/
    $css .= zoo_generate_font('.wrap-style-2-layout .footer-widget-title, .footer-widget-title', $footer_title);
    /* Footer bg**/
    $footer_bg = get_theme_mod('zoo_footer_bg_color', '');
    if ($footer_bg != '')
        $footer_bg = 'background:' . $footer_bg;
    $footer_bg_img = get_theme_mod('zoo_footer_bg_image', '');
    if ($footer_bg_img != '') {
        $footer_bg .= ' url("' . $footer_bg_img . '") ' . get_theme_mod('zoo_footer_bg_position', 'center center') . '/' . get_theme_mod('zoo_footer_bg_size', 'cover') . ';';
        $footer_bg .= ' background-repeat:' . get_theme_mod('zoo_footer_bg_repeat', 'no-repeat') . ';';
        $footer_bg .= ' background-attachment:' . get_theme_mod('zoo_footer_bg_attachment', 'inherit') . ';';
    }
    if (is_page()) {
        if (get_post_meta(get_the_ID(), 'zoo_enable_footer_color', true) == 1) {
            $footer_bg = zoo_hex2rgba(get_post_meta(get_the_ID(), 'zoo_footer_bg_color', true), get_post_meta(get_the_ID(), 'zoo_footer_bg_color_opc', true));
            $footer_bg_img = wp_get_attachment_image_url(get_post_meta(get_the_ID(), 'zoo_footer_bg_img', true), 'full');
            if ($footer_bg_img) {
                $footer_bg .= ' url("' . $footer_bg_img . '") ' . get_theme_mod('zoo_footer_bg_position', 'center center') . '/' . get_theme_mod('zoo_footer_bg_size', 'cover') . ';';
                $footer_bg .= ' background-repeat:' . get_theme_mod('zoo_footer_bg_repeat', 'no-repeat') . ';';
                $footer_bg .= ' background-attachment:' . get_theme_mod('zoo_footer_bg_attachment', 'inherit') . ';';
                $css .= '#main-footer{background:transparent}';
            }
            $css .= '#zoo-footer, #zoo-footer.wrap-default-layout{background:' . $footer_bg . '}';
        } else {
            if (get_post_meta(get_the_ID(), 'zoo_footer_layout', 'true') == 'inherit') {
                $css .= '#zoo-footer, #zoo-footer.wrap-default-layout{' . $footer_bg . '}';
            }
        }
    } else {
        $css .= '#zoo-footer, #zoo-footer.wrap-default-layout{' . $footer_bg . '}';
    }
    $bt_footer_bg = get_theme_mod('zoo_bt_footer_bg', '');
    $bt_footer_color = get_theme_mod('zoo_bt_footer_color', '');
    $bt_footer_link_color = get_theme_mod('zoo_bt_footer_link_color', '');
    $bt_footer_link_color_hover = get_theme_mod('zoo_bt_footer_link_color_hover', '');
    if (is_page() && get_post_meta(get_the_ID(), 'zoo_enable_footer_color', true) == 1) {
        $css .= zoo_generate_color('#zoo-footer .footer-widget-title', get_post_meta(get_the_ID(), 'zoo_footer_title_color', true));
        $css .= zoo_generate_color('#top-footer, #main-footer, #main-footer .textwidget h2, #copyright', get_post_meta(get_the_ID(), 'zoo_footer_color', true));
        $css .= zoo_generate_color('#top-footer a, #main-footer a:not(.btn), #zoo-footer.wrap-default-layout #bottom-footer .zoo-widget-social-icon li, .wrap-style-2-layout .bottom-footer-block .widget_nav_menu li a', get_post_meta(get_the_ID(), 'zoo_footer_link_color', true));
        $css .= zoo_generate_color('#top-footer a:hover, #main-footer a:not(.btn):hover, .footer-widget .zoo-widget-social-icon a:hover, #zoo-footer.wrap-default-layout #bottom-footer .zoo-widget-social-icon li:hover i, .wrap-style-2-layout .bottom-footer-block .widget_nav_menu li a:hover', get_post_meta(get_the_ID(), 'zoo_footer_link_color_hover', true));
        $css .= ".wrap-main-footer{border-bottom:1px solid " . zoo_hex2rgba(get_post_meta(get_the_ID(), 'zoo_footer_bt_border_color', true), get_post_meta(get_the_ID(), 'zoo_footer_bt_border_color_opc', true)) . "}";
        $bt_footer_bg = zoo_hex2rgba(get_post_meta(get_the_ID(), 'zoo_footer_bt_bg_color', true), get_post_meta(get_the_ID(), 'zoo_footer_bt_bg_color_opc', true));
    } else {
        $css .= zoo_generate_color('#top-footer', get_theme_mod('zoo_top_footer_color', ''));
        $css .= zoo_generate_color('#top-footer a', get_theme_mod('zoo_top_footer_link_color', ''));
        $css .= zoo_generate_color('#top-footer a:hover', get_theme_mod('zoo_top_footer_link_color_hover', ''));
        if (get_theme_mod('zoo_top_footer_bg', '') != '') {
            $css .= '#top-footer{background:' . get_theme_mod('zoo_top_footer_bg', '') . '}';
        }
        $css .= zoo_generate_color('#main-footer', get_theme_mod('zoo_main_footer_color', ''));
        $css .= zoo_generate_color('#main-footer a', get_theme_mod('zoo_main_footer_link_color', ''));
        $css .= zoo_generate_color('#main-footer a:hover', get_theme_mod('zoo_main_footer_link_color_hover', ''));
        if (get_theme_mod('zoo_main_footer_bg', '') != '') {
            $css .= '#main-footer, .wrap-footer-2-layout .main-footer-block{background:' . get_theme_mod('zoo_main_footer_bg', '') . '}';
        }
        if (get_theme_mod('zoo_footer_border', '') != '') {
            $css .= "#main-footer{border-top:1px solid" . get_theme_mod('zoo_footer_border', '') . "}";
        }
    }
    $css .= zoo_generate_color('#zoo-footer.wrap-default-layout #bottom-footer, #bottom-footer', $bt_footer_color);
    $css .= zoo_generate_color('.wrap-style-2-layout .bottom-footer-block .widget_nav_menu li a, #zoo-footer.wrap-default-layout #bottom-footer a,#bottom-footer a, #bottom-footer .zoo-widget-social-icon li i', $bt_footer_link_color);
    $css .= zoo_generate_color('.wrap-style-2-layout .bottom-footer-block .widget_nav_menu li a:hover, #zoo-footer.wrap-default-layout #bottom-footer a:hover, #bottom-footer a:hover, #bottom-footer .zoo-widget-social-icon li:hover i', $bt_footer_link_color_hover);
    if ($bt_footer_bg != '') {
        $css .= "#bottom-footer, #zoo-footer.wrap-default-layout #bottom-footer{background:" . $bt_footer_bg . "}";
    }
    /*End Footer Options*/
    /*Archive page*/
    $css .= zoo_generate_font('.zoo-blog-item .title-post', $archive_title);
    $css .= zoo_generate_color('.zoo-blog-item .title-post:hover', get_theme_mod('zoo_blog_archive_title_hover', ''));
    $css .= zoo_generate_color('.zoo-blog-item .entry-content', get_theme_mod('zoo_blog_archive_text', ''));
    $css .= zoo_generate_color('.zoo-blog-item .post-info, .post-info span,  .zoo-blog-item .post-info > span', get_theme_mod('zoo_blog_archive_info', ''));
    $css .= zoo_generate_color('.post-label li a', get_theme_mod('zoo_blog_archive_link', ''));
    $css .= zoo_generate_color('.post-label li a:hover', get_theme_mod('zoo_blog_archive_link_hover', ''));
    $css .= zoo_generate_color('.post-label li a:hover', get_theme_mod('zoo_blog_archive_link_hover', ''));
    $lb_cat = get_theme_mod('zoo_blog_lb_cat_bg', '');
    if ($lb_cat != '') {
        $css .= '.post-label li.cat-post-label{background:' . $lb_cat . '}';
    }
    $lb_cat_hv = get_theme_mod('zoo_blog_lb_cat_bg_hv', '');
    if ($lb_cat_hv != '') {
        $css .= '.post-label li.cat-post-label:hover,.post-label li.cat-post-label:after{background:' . $lb_cat_hv . '}';
        $css .= '.post-label li.cat-post-label:after{box-shadow:  0 0 5px 5px ' . $lb_cat_hv . '}';
    }
    $css .= zoo_generate_color('.zoo-blog-item .readmore', get_theme_mod('zoo_blog_archive_rm', ''));
    $css .= zoo_generate_color('.zoo-blog-item .readmore:hover', get_theme_mod('zoo_blog_archive_rm_hover', ''));
    /*End Archive page*/
    /*Post Sidebar page*/
    $css .= zoo_generate_font('.zoo-posts-widget .post-widget-item .title-post, .post-related .zoo-blog-item .title-post', get_theme_mod('zoo_typo_blog_sidebar_title', ''));
    $css .= zoo_generate_color('.zoo-posts-widget .post-widget-item .title-post:hover, .post-related .zoo-blog-item .title-post:hover', get_theme_mod('zoo_blog_sidebar_title_hover', ''));
    $css .= zoo_generate_color('.zoo-posts-widget .date-post, .post-related .date-post', get_theme_mod('zoo_blog_sidebar_info_color', ''));
    /*Post Sidebar page*/
    /*Single post*/
    $css .= zoo_generate_font('.single .title-detail', get_theme_mod('zoo_typo_blog_single_title', ''));
    $css .= zoo_generate_color('.single .post-info > .date-post', get_theme_mod('zoo_blog_single_info', ''));
    $css .= zoo_generate_color('.single .post-info span  a, .single .logged-in-as a ', get_theme_mod('zoo_blog_single_link', ''));
    $css .= zoo_generate_color('.single .post-info a:hover, .single .logged-in-as a:hover ', get_theme_mod('zoo_blog_single_link_hover', ''));
    /*End Single post*/
    /*Sidebar*/
    $css .= zoo_generate_font('.sidebar .widget .widget-title', $sidebar_title);
    /*Shop page*/
    if (class_exists('WooCommerce')) {
        $css .= zoo_generate_font('.products .product .product-name a,.product_list_widget .product-title, .woocommerce table.shop_table tbody .product-name a', $woo_title);
        $css .= zoo_generate_font('.woocommerce div.product h1.product_title', $woo_single_title);
        $css .= zoo_generate_color('.woocommerce .products .product .product-name a:hover,.product_list_widget .product-title:hover, .woocommerce table.shop_table tbody .product-name a:hover, .zoo-mini-cart .mini_cart_item .product-name a:hover', get_theme_mod('zoo_woo_title_hover', ''));
        $css .= zoo_generate_color('.products .default .btn.quick-view, .products .quick-view', get_theme_mod('zoo_woo_qv_color', ''));
        $css .= zoo_generate_color('.woocommerce .star-rating span::before', get_theme_mod('zoo_woo_rate_color', ''));
        if (get_theme_mod('zoo_woo_qv_bg', '') != '') {
            $css .= '.products .default .btn.quick-view, .products .quick-view{background: ' . get_theme_mod('zoo_woo_qv_bg', '') . '}';
        }
        $css .= zoo_generate_color('.products .default .btn.quick-view:hover, .products .quick-view:hover', get_theme_mod('zoo_woo_qv_color_hover', ''));
        if (get_theme_mod('zoo_woo_qv_bg_hover', '') != '') {
            $css .= '.products .default .btn.quick-view:hover, .products .quick-view:hover{background: ' . get_theme_mod('zoo_woo_qv_bg_hover', '') . '}';
        }
        //Cart
        $css .= zoo_generate_color('.products .default .wrap-product-button .zoo-custom-wishlist-block, .products.grid .default .wrap-product-button .button, .woocommerce ul.products li.product .button, .woocommerce .zoo-single-product .entry-summary .cart .button', get_theme_mod('zoo_woo_cart_color', ''));
        if (get_theme_mod('zoo_woo_cart_bg', '') != '')
            $css .= '.products .default .wrap-product-button .zoo-custom-wishlist-block, .products.grid .default .wrap-product-button .button, .woocommerce ul.products li.product .button, .woocommerce .zoo-single-product .entry-summary .cart .button{background: ' . get_theme_mod('zoo_woo_cart_bg', '') . '}';
        $css .= zoo_generate_color('.products .default .wrap-product-button .zoo-custom-wishlist-block:hover, .products.grid .default .wrap-product-button .button:hover, .woocommerce ul.products li.product .button:hover, .woocommerce .zoo-single-product .entry-summary .cart .button:hover', get_theme_mod('zoo_woo_cart_color_hover', ''));
        if (get_theme_mod('zoo_woo_cart_bg_hover', '') != '')
            $css .= '.products .default .wrap-product-button .zoo-custom-wishlist-block:hover, .products.grid .default .wrap-product-button .button:hover, .woocommerce ul.products li.product .button:hover, .woocommerce .zoo-single-product .entry-summary .cart .button:hover{background: ' . get_theme_mod('zoo_woo_cart_bg_hover', '') . '}';
        //Sale label
        $css .= zoo_generate_color('.woocommerce ul.products li.product .onsale, .woocommerce .zoo-woo-page span.onsale, #zoo-quickview-lb.woocommerce span.onsale', get_theme_mod('zoo_woo_color_lb_sale', ''));
        if (get_theme_mod('zoo_woo_bg_lb_sale', '') != '')
            $css .= '.woocommerce ul.products li.product .onsale, .woocommerce .zoo-woo-page span.onsale, #zoo-quickview-lb.woocommerce span.onsale{background: ' . get_theme_mod('zoo_woo_bg_lb_sale', '') . '}';
        //Stock
        $css .= zoo_generate_color('.stock-label.low-stock-label', get_theme_mod('zoo_woo_lb_low_stock', ''));
        if (get_theme_mod('zoo_woo_lb_low_stock', '') != '')
            $css .= '.stock-label.low-stock-label{border-color:' . get_theme_mod('zoo_woo_lb_low_stock', '') . '}';
        $css .= zoo_generate_color('.stock-label.out-stock-label', get_theme_mod('zoo_woo_lb_out_stock', ''));
        if (get_theme_mod('zoo_woo_lb_out_stock', '') != '')
            $css .= '.stock-label.out-stock-label{border-color:' . get_theme_mod('zoo_woo_lb_out_stock', '') . '}';
        //Price
        $css .= zoo_generate_color('.amount, .woocommerce-cart ul.shop_table .amount, .woocommerce-checkout ul.shop_table .amount, amount, .zoo-mini-cart .mini_cart_item .right-mini-cart-item .amount, .woocommerce ul.products li.product .price', get_theme_mod('zoo_woo_price_color', ''));
        $css .= zoo_generate_font('.amount, .woocommerce-cart ul.shop_table .amount, .woocommerce-checkout ul.shop_table .amount, amount, .zoo-mini-cart .mini_cart_item .right-mini-cart-item .amount, .woocommerce ul.products li.product .price',$woo_price);
        $css .= zoo_generate_color('.woocommerce div.product p.price del, .woocommerce div.product span.price del, .woocommerce ul.products li.product .price del', get_theme_mod('zoo_woo_price_regular_color', ''));
        $css .= zoo_generate_color('.woocommerce div.product p.price ins, .woocommerce div.product span.price ins, .woocommerce ul.products li.product .price ins', get_theme_mod('zoo_woo_price_sale_color', ''));
        //Button for ajax cart and cart page
        $css .= zoo_generate_color('.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-checkout #payment.woocommerce-checkout-payment #place_order, .woocommerce .button.checkout, .woocommerce .wrap-coupon input.button, .woocommerce-cart .woocommerce .wc-proceed-to-checkout .checkout-button.button, .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .checkout-button.button', get_theme_mod('zoo_woo_pri_btn_color', ''));
        if (get_theme_mod('zoo_woo_pri_btn_bg', '') != '')
            $css .= '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-checkout #payment.woocommerce-checkout-payment #place_order, .woocommerce .button.checkout, .woocommerce .wrap-coupon input.button, .woocommerce-cart .woocommerce .wc-proceed-to-checkout .checkout-button.button, .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .checkout-button.button{background:' . get_theme_mod('zoo_woo_pri_btn_bg', '') . '}';
        $css .= zoo_generate_color('.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-checkout #payment.woocommerce-checkout-payment #place_order:hover,.woocommerce .button.checkout:hover, .woocommerce .wrap-coupon input.button:hover, .woocommerce-cart .woocommerce .wc-proceed-to-checkout .checkout-button.button:hover, .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .checkout-button.button:hover', get_theme_mod('zoo_woo_pri_btn_color_hover', ''));
        if (get_theme_mod('zoo_woo_pri_btn_bg_hover', '') != '')
            $css .= '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-checkout #payment.woocommerce-checkout-payment #place_order:hover,.woocommerce .button.checkout:hover, .woocommerce .wrap-coupon input.button:hover, .woocommerce-cart .woocommerce .wc-proceed-to-checkout .checkout-button.button:hover, .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .checkout-button.button:hover{background:' . get_theme_mod('zoo_woo_pri_btn_bg_hover', '') . '}';
        $css .= zoo_generate_color('.woocommerce-cart .woocommerce .wc-proceed-to-checkout .button:not(.checkout-button), .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .button:not(.checkout-button),.bottom-cart .buttons .button:not(.checkout)', get_theme_mod('zoo_woo_sec_btn_color', ''));
        $css .= zoo_generate_color('.woocommerce-cart .woocommerce .wc-proceed-to-checkout .button:hover:not(.checkout-button), .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .button:hover:not(.checkout-button),.bottom-cart .buttons .button:hover:not(.checkout)', get_theme_mod('zoo_woo_sec_btn_color_hover', ''));
        if (get_theme_mod('zoo_woo_sec_btn_bg', '') != '')
            $css .= '.woocommerce-checkout .woocommerce .login.global-login-form .button, .woocommerce-checkout .woocommerce .checkout_coupon .button, .woocommerce-cart .woocommerce .wc-proceed-to-checkout .button:not(.checkout-button), .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .button:not(.checkout-button),.bottom-cart .buttons .button:not(.checkout){background:' . get_theme_mod('zoo_woo_sec_btn_bg', '') . '}';
        if (get_theme_mod('zoo_woo_sec_btn_bg_hover', '') != '')
            $css .= '.woocommerce-checkout .woocommerce .login.global-login-form .button:hover, .woocommerce-checkout .woocommerce .checkout_coupon .button:hover, .woocommerce-cart .woocommerce .wc-proceed-to-checkout .button:hover:not(.checkout-button), .woocommerce-checkout .woocommerce .wc-proceed-to-checkout .button:hover:not(.checkout-button),.bottom-cart .buttons .button:hover:not(.checkout){background:' . get_theme_mod('zoo_woo_sec_btn_bg_hover', '') . '}';
    }
    /*End Shop page*/
    $css .= zoo_generate_color('.text-field, input[type="text"], input[type="search"], input[type="password"], textarea, input[type="email"], input[type="tel"]', get_theme_mod('zoo_form_style_color', ''));
    if (get_theme_mod('zoo_form_style_border', '') != '') {
        $css .= '.text-field, input[type="text"], input[type="search"], input[type="password"], textarea, input[type="email"], input[type="tel"]{border-color:' . get_theme_mod('zoo_form_style_border', '') . '}';
    }
    if (get_theme_mod('zoo_form_style_border_active', '') != '') {
        $css .= '.text-field:focus, input[type="text"]:focus, input[type="search"]:focus, input[type="password"]:focus, textarea:focus, input[type="email"]:focus, input[type="tel"]:focus{border-color:' . get_theme_mod('zoo_form_style_border_active', '') . '}';
    }
    if (get_theme_mod('zoo_form_style_bg', '') != '') {
        $css .= '.text-field, input[type="text"], input[type="search"], input[type="password"], textarea, input[type="email"], input[type="tel"]{background-color:' . get_theme_mod('zoo_form_style_bg', '') . '}';
    }
    $css .= zoo_generate_color('.btn, input[type="submit"], button:not(.vc_general), .button', get_theme_mod('zoo_btn_style_color', ''));
    $css .= zoo_generate_color('.btn:hover, input[type="submit"]:hover, button:hover:not(.vc_general), .button:hover', get_theme_mod('zoo_btn_style_color_hover', ''));
    if (get_theme_mod('zoo_btn_style_bg', '') != "")
        $css .= '.btn, input[type="submit"], button:not(.vc_general), .button{background:' . get_theme_mod('zoo_btn_style_bg', '') . '}';
    if (get_theme_mod('zoo_btn_style_bg_hover', '') != "")
        $css .= '.btn:hover, input[type="submit"]:hover, button:hover:not(.vc_general), .button:hover{background:' . get_theme_mod('zoo_btn_style_bg_hover', '') . '}';

    //Primary color
    $pri_color = get_theme_mod('zoo_color_primary', '');
    $pri_class = ".zoo-single-post-nav-item a, .post-author .author-name,.tags-link-wrap h5,.title-block span, #reply-title";
    $css .= zoo_generate_color($pri_class, $pri_color);

    $zoo_border_color = get_theme_mod('zoo_color_border', '');
    $border_class = '.canvas-widget, .sidebar .widget, .header-post, .zoo-single-post-nav, .wpcf7-form-control-wrap .wpcf7-form-control,
blockquote, .blockquote, tbody th, tbody td, thead th, thead td, .stack-center-layout.style-1 #main-navigation > .container > nav,
.wrap-list-cat-search, #mobile-nav li, #mobile-nav > div > ul ul, .search-wrap .ipt, .wrap-comments > li, li.comment,
.wrap-comments > li > ul.children, li.comment > ul.children, #top-product-page, .wrap-site-main .zoo-woo-sidebar .prdctfltr_filter,
.woocommerce.widget, .bottom-cart .total, .zoo-mini-cart .mini_cart_item, .woocommerce div.product .entry-summary form.cart .group_table td ,
.woocommerce .zoo-single-product .quantity input, .woocommerce .zoo-single-product .quantity .qty-nav.increase,
.woocommerce #reviews #comments ol.commentlist .comment, .woocommerce table.shop_table thead th, .woocommerce-checkout-review-order-table .wrap-cart-subtotal li,
.woocommerce-cart .title-block-page, .woocommerce-checkout .title-block-page, .woocommerce-cart .shop_table > li, .woocommerce-checkout .shop_table > li,
.woocommerce-cart .shipping-cal .shipping-calculator-form select, .woocommerce-checkout .shipping-cal .shipping-calculator-form select,
.woocommerce .wrap-coupon, .woocommerce .wrap-coupon input.input-text, .woocommerce-checkout input[type="text"], .woocommerce-checkout input[type="search"], .woocommerce-checkout input[type="password"], .woocommerce-checkout textarea, .woocommerce-checkout input[type="email"], .woocommerce-checkout input[type="tel"],
.woocommerce-checkout .woocommerce-info, .woocommerce-checkout .woocommerce .login.global-login-form, .woocommerce-checkout .woocommerce .checkout_coupon ,
.woocommerce-checkout #payment.woocommerce-checkout-payment .wc_payment_methods, .woocommerce-checkout #payment.woocommerce-checkout-payment .wc_payment_method,
.woocommerce-checkout .select2-container .select2-choice, .woocommerce form .form-row .select2-container--default .select2-selection--single,
.woocommerce .wrap-header-order, .woocommerce .woocommerce-MyAccount-navigation ul, .woocommerce .woocommerce-order-details .woocommerce-order-details__title
';
    if ($zoo_border_color != '') {
        $css .= $border_class . '{border-color:' . $zoo_border_color . '}';
    }
    $bg_block = get_theme_mod('zoo_color_bg_block', '');
    $bg_block_class = '.woocommerce nav.woocommerce-pagination ul.page-numbers li span, .woocommerce nav.woocommerce-pagination ul.page-numbers li a,
.wrap-site-main .prdctfltr_checkboxes .prdctfltr_count,  .wrap-site-main .pf_rngstyle_html5 .irs-line, .woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
.woocommerce.widget .count, .woocommerce-checkout-review-order-table .wrap-cart-subtotal, .woocommerce .wrap-coupon,
.woocommerce-checkout .woocommerce .login.global-login-form, .woocommerce-checkout .woocommerce .checkout_coupon,
.woocommerce-shipping-fields #ship-to-different-address input, .woocommerce-account-fields .create-account input.input-checkbox,
.woocommerce-account .woocommerce-Addresses .edit,.widget-acc-info,  .zoo-widget-social-icon i,
 .main-content .navigation.pagination .nav-links .page-numbers, .wrap-pagination .pagination span,
 .social-icons li a, .page-numbers li .page-numbers, .comment-reply-link, .comment-edit-link';
    if ($bg_block != '') {
        if ($zoo_border_color != '') {
            $css .= $bg_block_class . '{background-color:' . $bg_block . '}';
        }
    }
    if (get_theme_mod('zoo_shop_disable_mobile_cart_btn', true)) {
        $css .= '@media(max-width:769px){.wrap-product-button{display:none !important; visibility:hidden !important}}';
    }
    if (get_theme_mod('zoo_custom_css') != '') {
        $css .= get_theme_mod('zoo_custom_css');
    }
    return $css;
}