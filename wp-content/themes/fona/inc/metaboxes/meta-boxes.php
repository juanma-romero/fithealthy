<?php
/**
 * Meta box for theme
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
add_filter('rwmb_meta_boxes', 'zoo_add_meta_box_options');
function zoo_add_meta_box_options()
{
    $prefix = "zoo_";
    $meta_boxes = array();
    //All page
    $meta_boxes[] = array(
        'id' => $prefix.'layout_single_heading',
        'title' => esc_html__('Layout Single Product', 'fona'),
        'pages' => array('product'),
        'context' => 'advanced',
        'fields' => array(
            array(
                'name' => esc_html__('Layout Options', 'fona'),
                'id' => $prefix."single_gallery_layout",
                'type' => 'select',
                'options' => array(
                    'inherit' => 'Inherit',
                    'vertical-gallery' =>esc_html__('Vertical Gallery','fona'),
                    'vertical-gallery-center-thumb' =>esc_html__('Vertical Gallery Center Thumb','fona'),
                    'horizontal-gallery' =>esc_html__('Horizontal Gallery','fona'),
                    'carousel' =>esc_html__('Carousel','fona'),
                    'center' =>esc_html__('Center','fona'),
                    'sticky' =>esc_html__('Sticky','fona'),
                    'sticky-right-content' =>esc_html__('Sticky Right Content','fona'),
                    'sticky-accordion' =>esc_html__('Sticky Accordion','fona'),
                    'images-center' =>esc_html__('Images Center','fona'),
                ),
                'std' => 'inherit',
                'desc' => esc_html__('Choose Options Sidebar.', 'fona')
            ),
        ));
    $meta_boxes[] = array(
        'id' => $prefix.'single_product_video_heading',
        'title' => esc_html__('Product Video', 'fona'),
        'pages' => array('product'),
        'context' => 'side',
        'fields' => array(
            array(
                'id' => $prefix."single_product_video",
                'type' => 'oembed',
                'desc' => esc_html__('Enter your embed video url.', 'fona')
            ),
        ));
    $meta_boxes[] = array(
        'id' => 'title_meta_box',
        'title' => esc_html__('Layout Options', 'fona'),
        'pages' => array('page','post'),
        'context' => 'advanced',
        'fields' => array(
            array(
                'name' => esc_html__('Logo page', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."logo_stt",
                'type' => 'heading'
            ),
            array(
                'name' => esc_html__('Logo for page', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."logo_page",
                'type' => 'image_advanced',
                'max_file_uploads' => 1
            ),
            array(
                'name' => esc_html__('Sticky Logo for page', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."sticky_logo_page",
                'type' => 'image_advanced',
                'max_file_uploads' => 1
            ),
            array(
                'name' => esc_html__('Logo padding top', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."logo_padding_top",
                'type' => 'number'
            ), array(
                'name' => esc_html__('Logo padding bottom', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."logo_padding_bottom",
                'type' => 'number'
            ),
            array(
                'name' => esc_html__('Hide site Tag line.', 'fona'),
                'id' => $prefix."hide_tag_line",
                'type' => 'checkbox',
            ),
            array(
                'name' => esc_html__('Title & Breadcrumbs Options', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."heading_title",
                'type' => 'heading'
            ),
            array(
                'name' => esc_html__('Disable Title', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."disable_title",
                'std' => '0',
                'type' => 'checkbox'
            ),
            array(
                'name' => esc_html__('Disable Breadcrumbs', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."disable_breadcrumbs",
                'std' => '0',
                'type' => 'checkbox'
            ),
            array(
                'name' => esc_html__('Page Layout', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."body_heading",
                'type' => 'heading'
            ),
            array(
                'name' => esc_html__('Page Layout', 'fona'),
                'id' => $prefix."page_layout",
                'type' => 'select',
                'options' => array(
                    'inherit' =>esc_html__('Inherit','fona'),
                    'boxes' =>esc_html__('Boxes','fona'),
                    'full-width' =>esc_html__('Full with','fona'),
                ),
                'std' => 'inherit',
                'desc' => esc_html__('Choose page Layout.', 'fona')
            ),
            array(
                'name' => esc_html__('Page Max Width', 'fona'),
                'desc' => esc_html__('Accept only number. If not set, it will follow customize config.', 'fona'),
                'id' => $prefix."site_width",
                'type' => 'number'
            ),
            array(
                'name' => esc_html__('Header Options', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."heading_header",
                'type' => 'heading'
            ),
            array(
                'name' => esc_html__('Disable top header.', 'fona'),
                'id' => $prefix."disable_top_header",
                'type' => 'checkbox',
            ),
            array(
                'name' => esc_html__('Enable header sticky.', 'fona'),
                'id' => $prefix."header_sticky",
                'type' => 'checkbox',
            ),
            array(
                'name' => esc_html__('Header Layout', 'fona'),
                'id' => $prefix."header_layout",
                'type' => 'image_select',
                'options' => array(
                    'inherit' => esc_url(get_template_directory_uri() . '/lib/assets/icons/inherit.png'),
                    'menu-right' => esc_url(get_template_directory_uri() . '/lib/assets/icons/menu-right.png'),
                    'menu-center' => esc_url(get_template_directory_uri() . '/lib/assets/icons/menu-center.png'),
                    'stack-center' => esc_url(get_template_directory_uri() . '/assets/images/stack-center.png'),
                    'stack-center-2' => esc_url(get_template_directory_uri() . '/assets/images/stack-center-2.png'),
                    'stack-center-3' => esc_url(get_template_directory_uri() . '/assets/images/stack-center-3.png'),
                    'logo-center' => esc_url(get_template_directory_uri() . '/lib/assets/icons/logo-center.png'),
                    'menu-bottom' => esc_url(get_template_directory_uri() . '/lib/assets/icons/logo-center.png'),
                ),
                'std' => 'inherit',
                'desc' => esc_html__('Choose Options Header Layout. If set Inherit, it follow option of customize', 'fona')
            ),
            array(
                'name' => esc_html__('Enable Header Transparency', 'fona'),
                'id' => $prefix."enable_header_transparent",
                'type' => 'checkbox',
                'std' => '0',
                'desc' => esc_html__('If check, header will be use transparent style.', 'fona')
            ),
            array(
                'name' => esc_html__('Enable Header inner background', 'fona'),
                'id' => $prefix."enable_header_inner_bg",
                'type' => 'checkbox',
                'std' => '0',
                'desc' => esc_html__('Background for inner main header will set. With with Header transparent style.', 'fona')
            ),
            array(
                'name' => esc_html__('100% Header Width', 'fona'),
                'id' => $prefix."enable_header_fullwidth",
                'type' => 'checkbox',
                'std' => '0',
                'desc' => esc_html__('Check this box to set the header to 100% of the browser width. Uncheck to follow the site width.', 'fona')
            ),
            array(
                'name' => esc_html__('Footer Options', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."heading_footer",
                'type' => 'heading',
                'class'=>'clear',
            ),
            array(
                'name' => esc_html__('Enable Footer sticky', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."stick_footer",
                'type' => 'checkbox',
                'desc' => esc_html__('Footer always on bottom.', 'fona')
            ),
            array(
                'name' => esc_html__('Disable top footer', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."top_footer",
                'type' => 'checkbox'
            ),
            array(
                'name' => esc_html__('Disable main footer', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."disable_main_footer",
                'type' => 'checkbox'
            ),
            array(
                'name' => esc_html__('Footer Layout', 'fona'),
                'id' => $prefix."footer_layout",
                'type' => 'image_select',
                'options' => array(
                    'inherit' =>esc_url(get_template_directory_uri() . '/lib/assets/icons/inherit.png'),
                    'default' => esc_url(get_template_directory_uri() . '/assets/images/footer-style1.png'),
                    'center' => esc_url(get_template_directory_uri() . '/assets/images/footer-center.png'),
                    'style-2' => esc_url(get_template_directory_uri() . '/assets/images/footer-style2.png'),
                ),
                'std' => 'inherit',
                'desc' => esc_html__('Choose Footer Layout.', 'fona')
            ),
        )
    );
    $meta_boxes[] = array(
        'id' => 'post_meta_box',
        'title' => esc_html__('Post Meta', 'fona'),
        'pages' => array('testimonial'),
        'context' => 'normal',
        'fields' => array(
            array(
                'name' => esc_html__('Author avatar', 'fona'),
                'desc' => esc_html__('Author avatar display in frontend', 'fona'),
                'id' => $prefix."author_img",
                'type' => 'image_advanced',
                'max_file_uploads' => 1
            ),
            array(
                'name' => esc_html__('Author name', 'fona'),
                'desc' => esc_html__('Author name display in frontend', 'fona'),
                'id' => $prefix."author",
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Author description', 'fona'),
                'desc' => esc_html__('Author description display in frontend', 'fona'),
                'id' => $prefix."author_des",
                'type' => 'text',
            ),
        ));

    $meta_boxes[] = array(
        'id' => 'zoo_heading_color',
        'title' => esc_html__('Style Options', 'fona'),
        'pages' => array('page'),
        'context' => 'advanced',
        'fields' => array(
            array(
                'name' => esc_html__('Page Font', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."heading_page_font",
                'type' => 'heading',
            ),
            array(
                'name' => esc_html__('Font', 'fona'),
                'id' => $prefix."page_font",
                'desc' => esc_html__('Select custom font you want use.', 'fona'),
                'type' => 'select',
                'options' => array(
                    'default' => 'Default',
                    'San_Francisco_Pro' => 'San Francisco Pro',
                    'FunctionPro' => 'FunctionPro'
                ),
            ),
            array(
                'name' => esc_html__('Page Color & Background', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."heading_page_color",
                'type' => 'heading',
            ),
            array(
                'name' => esc_html__('Page Accent Color', 'fona'),
                'id' => $prefix."accent_color",
                'type' => 'color',
                'std' => '',
            ),
            array(
                'name' => esc_html__('Page background', 'fona'),
                'desc' => esc_html__('Background Image for page', 'fona'),
                'id' => $prefix."page_bg",
                'type' => 'image_advanced',
                'max_file_uploads' => 1
            ),
            array(
                'name' => esc_html__('Page Background Color', 'fona'),
                'id' => $prefix."page_bg_color",
                'type' => 'color',
                'std' => '',
            ),
            array(
                'name' => esc_html__('Header Color & Background', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."heading_header_color",
                'type' => 'heading',
            ),
            array(
                'name' => esc_html__('Active Custom color & background header', 'fona'),
                'id' => $prefix."enable_header_color",
                'type' => 'checkbox',
                'std' => '0',
                'desc' => esc_html__('If check, all value custom color & background will be accept', 'fona')
            ),
            array(
                'name' => esc_html__('Top Header Background', 'fona'),
                'desc' => esc_html__('Background of top header', 'fona'),
                'id' => $prefix."top_header_bg",
                'type' => 'color',
                'std' => '#252525',
            ),
            array(
                'name' => esc_html__('Top Header Background Opacity', 'fona'),
                'desc' => esc_html__('Controls the opacity for the top header. Opacity only works with ranges between 0 (transparent) and 1 (opaque). Ex: 0.4', 'fona'),
                'id' => $prefix."top_header_bg_opc",
                'type' => 'slider',
                'std' => '1',
                'js_options' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.1,
                ),
            ),
            array(
                'name' => esc_html__('Top Header Color', 'fona'),
                'desc' => esc_html__('Color of text in top header include link', 'fona'),
                'id' => $prefix."top_header_color",
                'type' => 'color',
                'std' => '#252525',
            ),
            array(
                'name' => esc_html__('Top Header Color Hover', 'fona'),
                'desc' => esc_html__('Color of link when hover', 'fona'),
                'id' => $prefix."top_header_color_hover",
                'type' => 'color',
                'std' => '#252525',
            ),            array(
                'name' => esc_html__('Header Color', 'fona'),
                'desc' => esc_html__('Color of text in header', 'fona'),
                'id' => $prefix."header_color",
                'type' => 'color',
                'std' => '#252525',
            ),
            array(
                'name' => esc_html__('Header Color Hover', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."header_color_hover",
                'type' => 'color',
                'std' => '#252525',
            ),
            array(
                'name' => esc_html__('Header Background', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."custom_bg_header",
                'type' => 'color',
                'std' => '#fff',
            ),
            array(
                'name' => esc_html__('Header Background Opacity', 'fona'),
                'desc' => esc_html__('Controls the opacity for the header. Opacity only works with ranges between 0 (transparent) and 1 (opaque). Ex: 0.4', 'fona'),
                'id' => $prefix."custom_bg_header_opc",
                'type' => 'slider',
                'std' => '1',
                'js_options' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.1,
                ),
            ),
            array(
                'name' => esc_html__('Header Menu Background', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."custom_bg_header_menu",
                'type' => 'color',
                'std' => '#fff',
            ),
            array(
                'name' => esc_html__('Header Menu Background Opacity', 'fona'),
                'desc' => esc_html__('Controls the opacity for the header menu. Opacity only works with ranges between 0 (transparent) and 1 (opaque). Ex: 0.4', 'fona'),
                'id' => $prefix."custom_bg_header_menu_opc",
                'type' => 'slider',
                'std' => '1',
                'js_options' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.1,
                ),
            ),
            array(
                'name' => esc_html__('Header Menu Color', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."custom_color_header_menu",
                'type' => 'color',
                'std' => '#fff',
            ),array(
                'name' => esc_html__('Header Menu Color Hover', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."custom_color_header_menu_hover",
                'type' => 'color',
                'std' => '#fff',
            ),
            array(
                'name' => esc_html__('Header sticky Background', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."bg_sticky_header",
                'type' => 'color',
                'std' => '#fff',
            ),
            array(
                'name' => esc_html__('Header Sticky Background Opacity', 'fona'),
                'desc' => esc_html__('Controls the opacity for the header. Opacity only works with ranges between 0 (transparent) and 1 (opaque). Ex: 0.4', 'fona'),
                'id' => $prefix."bg_sticky_header_opc",
                'type' => 'slider',
                'std' => '1',
                'js_options' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.1,
                ),
            ),
            array(
                'name' => esc_html__('Header Sticky Color', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."custom_color_header_sticky",
                'type' => 'color',
                'std' => '#252525',
            ),array(
                'name' => esc_html__('Header Sticky Color Hover', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."custom_color_hover_header_sticky",
                'type' => 'color',
                'std' => '#252525',
            ),
            array(
                'name' => esc_html__('Header Border Color', 'fona'),
                'id' => $prefix."header_border_color",
                'type' => 'color',
                'std' => '#f5f5f5',
            ),
            array(
                'name' => esc_html__('Header Border Color', 'fona'),
                'desc' => esc_html__('Controls the opacity for the header. Opacity only works with ranges between 0 (transparent) and 1 (opaque). Ex: 0.4', 'fona'),
                'id' => $prefix."header_border_color_opc",
                'type' => 'slider',
                'std' => '1',
                'js_options' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.1,
                ),
            ),
            array(
                'name' => esc_html__('Footer Color', 'fona'),
                'desc' => esc_html__('', 'fona'),
                'id' => $prefix."heading_footer_color",
                'type' => 'heading',
                'class'=>'clear',
            ),
            array(
                'name' => esc_html__('Active Custom color & background footer', 'fona'),
                'id' => $prefix."enable_footer_color",
                'type' => 'checkbox',
                'std' => '0',
                'desc' => esc_html__('If check, all value custom color & background will be accept', 'fona')
            ),
            array(
                'name' => esc_html__('Footer Background', 'fona'),
                'id' => $prefix."footer_bg_color",
                'type' => 'color',
                'std' => '#f5f5f5',
            ),array(
                'name' => esc_html__('Footer Background Image', 'fona'),
                'id' => $prefix."footer_bg_img",
                'type' => 'image_advanced',
            ),
            array(
                'name' => esc_html__('Footer Background Opacity', 'fona'),
                'desc' => esc_html__('Controls the opacity for the footer. Opacity only works with ranges between 0 (transparent) and 1 (opaque). Ex: 0.4', 'fona'),
                'id' => $prefix."footer_bg_color_opc",
                'type' => 'slider',
                'std' => '1',
                'js_options' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.1,
                ),
            ),
            array(
                'name' => esc_html__('Footer Title Color', 'fona'),
                'id' => $prefix."footer_title_color",
                'type' => 'color',
                'std' => '',
            ),
            array(
                'name' => esc_html__('Footer Color', 'fona'),
                'id' => $prefix."footer_color",
                'type' => 'color',
                'std' => '#f5f5f5',
            ),
            array(
                'name' => esc_html__('Footer Link Color', 'fona'),
                'id' => $prefix."footer_link_color",
                'type' => 'color',
                'std' => '',
            ),
            array(
                'name' => esc_html__('Footer Link Color Hover', 'fona'),
                'id' => $prefix."footer_link_color_hover",
                'type' => 'color',
                'std' => '',
            ),
            array(
                'name' => esc_html__('Footer Bottom Border Color', 'fona'),
                'id' => $prefix."footer_bt_border_color",
                'type' => 'color',
                'std' => '#f5f5f5',
            ),
            array(
                'name' => esc_html__('Footer Bottom Border Opacity', 'fona'),
                'desc' => esc_html__('Controls the opacity for the footer. Opacity only works with ranges between 0 (transparent) and 1 (opaque). Ex: 0.4', 'fona'),
                'id' => $prefix."footer_bt_border_color_opc",
                'type' => 'slider',
                'std' => '1',
                'js_options' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.1,
                ),
            ),array(
                'name' => esc_html__('Footer Bottom Background Color', 'fona'),
                'id' => $prefix."footer_bt_bg_color",
                'type' => 'color',
                'std' => '#f5f5f5',
            ),
            array(
                'name' => esc_html__('Footer Bottom Background Opacity', 'fona'),
                'desc' => esc_html__('Controls the opacity for the footer. Opacity only works with ranges between 0 (transparent) and 1 (opaque). Ex: 0.4', 'fona'),
                'id' => $prefix."footer_bt_bg_color_opc",
                'type' => 'slider',
                'std' => '1',
                'js_options' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.1,
                ),
            ),
        ));
    return $meta_boxes;
}