<?php
/**
 * Register custom theme mods from a theme
 *
 * @param  object $zoo_customize \Zoo_Customizer
 * @param  object $wp_customize \WP_Customize_Manager
 * @param  mixed $mods Theme mods - value of `get_theme_mods()`
 */
//Add filter font size
add_filter('zoo_body_font_size',function(){return 16;});
if(!function_exists('zoo_register_theme_mods')){
    function zoo_register_theme_mods($zoo_customize, $zoo_mods)
    {
        //$wp_customize->remove_control('colors');
        $zoo_prefix = 'zoo_';
        $zoo_style_prefix = 'zoo_style_';
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'typography',
            'settings' => $zoo_prefix . 'typo_primary_font',
            'label' => esc_html__('Primary Font', 'fona'),
            'description' => esc_html__('Apply for some special location.', 'fona'),
            'section' => $zoo_style_prefix . 'body',
            'default' => array(
                'font-family' => 'Poppins',
                'letter-spacing' => '0'
            ),
            'priority' => 11,
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'radio-image',
            'settings' => 'zoo_header_layout',
            'label' => esc_html__('Header layout', 'fona'),
            'description' => esc_html__('Choose header layout you want use for your site.', 'fona'),
            'section' => 'header',
            'default' => 'menu-center',
            'choices' => array(
                'menu-right' => esc_url(get_template_directory_uri() . '/lib/assets/icons/menu-right.png'),
                'menu-center' => esc_url(get_template_directory_uri() . '/lib/assets/icons/menu-center.png'),
                'stack-center' => esc_url(get_template_directory_uri() . '/assets/images/stack-center.png'),
                'stack-center-2' => esc_url(get_template_directory_uri() . '/assets/images/stack-center-2.png'),
                'stack-center-3' => esc_url(get_template_directory_uri() . '/assets/images/stack-center-3.png'),
                'logo-center' => esc_url(get_template_directory_uri() . '/lib/assets/icons/logo-center.png'),
                'menu-bottom' => esc_url(get_template_directory_uri() . '/lib/assets/icons/logo-center.png'),
            ),
            'priority' => 6
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'radio-image',
            'settings' => 'zoo_footer_layout',
            'label' => esc_html__('Footer Layout', 'fona'),
            'section' => 'footer',
            'default' => 'default',
            'choices' => array(
                'default' => esc_url(get_template_directory_uri() . '/assets/images/footer-style1.png'),
                'center' => esc_url(get_template_directory_uri() . '/assets/images/footer-center.png'),
                'style-2' => esc_url(get_template_directory_uri() . '/assets/images/footer-style2.png'),
            ),
            'priority' => 6
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'switch',
            'settings' => $zoo_prefix . 'blog_show_readmore',
            'label' => esc_html__('Show Read more', 'fona'),
            'section' => 'blog-archive',
            'priority' => 9,
            'default' => true,
            'choices' => array(
                true => esc_html__('On', 'fona'),
                false => esc_html__('Off', 'fona'),
            ),
        ));
        /*Woocommerce page cover*/
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'text',
            'settings' => $zoo_prefix . 'shop_cover_text',
            'label' => esc_html__('Cover shop page title', 'fona'),
            'description' => esc_html__('Title of cover shop page', 'fona'),
            'section' => 'shop-archive',
            'default' => '',
            'priority' => 8,
        ));$zoo_customize->add_field('zoo_customizer', array(
            'type' => 'image',
            'settings' => $zoo_prefix . 'shop_cover_img_bg',
            'label' => esc_html__('Image Background', 'fona'),
            'description' => esc_html__('Image background of cover shop page', 'fona'),
            'section' => 'shop-archive',
            'default' => '',
            'priority' => 8,
        ));$zoo_customize->add_field('zoo_customizer', array(
            'type' => 'color',
            'settings' => $zoo_prefix . 'shop_cover_color_bg',
            'label' => esc_html__('Color Background', 'fona'),
            'description' => esc_html__('Background color of cover shop page', 'fona'),
            'section' => 'shop-archive',
            'default' => '',
            'priority' => 8,
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'slider',
            'settings' => $zoo_prefix . 'shop_cover_padding_top',
            'label' => esc_html__('Cover Padding Top', 'fona'),
            'description' => esc_html__('White space from top heading of cover page to top. It\'s work on case Slider shortcode blank', 'fona'),
            'section' => 'shop-archive',
            'default' => 0,
            'choices' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1
            ),
            'priority' => 8,
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'slider',
            'settings' => $zoo_prefix . 'shop_cover_padding_bottom',
            'label' => esc_html__('Cover Padding Bottom', 'fona'),
            'description' => esc_html__('White space from bottom heading of cover page to bottom. It\'s work on case Slider shortcode blank', 'fona'),
            'section' => 'shop-archive',
            'default' => 0,
            'choices' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1
            ),
            'priority' => 8,
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'slider',
            'settings' => $zoo_prefix . 'shop_columns',
            'label' => esc_html__('Products per row', 'fona'),
            'description' => esc_html__('Default number product columns display on shop page', 'fona'),
            'section' => 'shop-archive',
            'default' => 4,
            'choices' => array(
                'min' => 2,
                'max' => 5,
                'step' => 1
            ),
            'priority' => 10,
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'switch',
            'settings' => $zoo_prefix . 'shop_disable_mobile_cart_btn',
            'label' => esc_html__('Disable cart button on mobile', 'fona'),
            'description' => esc_html__('Disable cart buttom at shop page on mobile', 'fona'),
            'section' => 'shop-archive',
            'default' => true,
            'choices' => array(
                true => esc_html__('On', 'fona'),
                false => esc_html__('Off', 'fona'),
            ),
            'priority' => 22,
        ));
        /*End Woocommerce page cover*/
        /*Woocommerce Up sell*/
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'custom',
            'settings' => 'zoo_single_upsell_heading',
            'label' => esc_html__('', 'fona'),
            'section' => 'shop-single',
            'default' => '<div class="zoo-options-heading">' . esc_html__('Up sell Product', 'fona') . '</div>',
            'priority' => 20
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'checkbox',
            'settings' => 'zoo_single_upsell',
            'label' => esc_html__('Show Up sell product', 'fona'),
            'section' => 'shop-single',
            'default' => '1',
            'priority' => 21
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'checkbox',
            'settings' => 'zoo_single_upsell_slider',
            'label' => esc_html__('Enable slider for Up sell products', 'fona'),
            'section' => 'shop-single',
            'default' => '1',
            'priority' => 22
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'number',
            'settings' => 'zoo_single_upsell_number',
            'label' => esc_html__('Number items', 'fona'),
            'section' => 'shop-single',
            'default' => '4',
            'priority' => 23
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'slider',
            'settings' => 'zoo_single_upsell_cols',
            'label' => esc_html__('Columns', 'fona'),
            'section' => 'shop-single',
            'default' => '4',
            'choices' => array(
                'min' => '1',
                'max' => '6',
                'step' => '1',
            ),
            'priority' => 24,
            'active_callback' => array(
                array(
                    'setting' => 'zoo_single_upsell_slider',
                    'operator' => '==',
                    'value' => '1',
                )),
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'checkbox',
            'settings' => 'zoo_product_cart_button',
            'label' => esc_html__('Disable cart button', 'fona'),
            'section' => 'shop-archive',
            'default' => '0',
            'priority' => 21
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'checkbox',
            'settings' => 'zoo_highlight_featured',
            'label' => esc_html__('Highlight product related', 'fona'),
            'description' => esc_html__('If check product related will bigger more than another product.', 'fona'),
            'section' => 'shop-archive',
            'default' => '1',
            'priority' => 14
        ));
        $zoo_customize->add_section('cart', array(
            'title' => esc_html__('Cart Page', 'fona'),
            'panel' => 'woocommerce',
            'description' => esc_html__('The settings for cart and checkout page', 'fona'),
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'switch',
            'settings' => $zoo_prefix . 'cart_notice',
            'label' => esc_html__('Enable cart free shipping notice', 'fona'),
            'section' => 'cart',
            'default' => true,
            'choices' => array(
                true => esc_html__('On', 'fona'),
                false => esc_html__('Off', 'fona'),
            ),
            'priority' => 5,
        ));
        /*End Woocommerce Up sell*/
        $zoo_customize->add_section($zoo_style_prefix . 'sidebar', array(
            'title' => esc_html__('Sidebar', 'fona'),
            'panel' => 'style',
            'priority' => 10,
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'typography',
            'settings' => $zoo_prefix . 'typo_title_sidebar',
            'label' => esc_html__('Sidebar title Font', 'fona'),
            'description' => esc_html__('Apply for title sidebar.', 'fona'),
            'section' => $zoo_style_prefix . 'sidebar',
            'default' => array(
                'font-family' => ' ',
                'variant' => ' ',
                'subsets' => array(),
                'font-size' => '15',
                'line-height' => '1',
                'letter-spacing' => '0',
                'color' => '#252525'
            ),
            'priority' => 11,
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'color',
            'settings' => $zoo_prefix . 'blog_archive_link',
            'label' => esc_html__('Post label categories color', 'fona'),
            'section' => $zoo_style_prefix . 'blog',
            'default' => '',
            'priority' => 13
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'color',
            'settings' => $zoo_prefix . 'blog_archive_link_hover',
            'label' => esc_html__('Post label categories color hover', 'fona'),
            'section' => $zoo_style_prefix . 'blog',
            'default' => '',
            'priority' => 13
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'select',
            'settings' => 'zoo_single_gallery_layout',
            'label' => esc_html__('Shop Gallery Layout', 'fona'),
            'section' => 'shop-single',
            'default' => 'vertical-gallery',
            'choices' => array(
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
            'priority' => 6
        ));
        $zoo_customize->add_field('zoo_customizer', array(
            'type' => 'switch',
            'settings' => $zoo_prefix . 'login_icon',
            'label' => esc_html__('Enable Login Icon', 'fona'),
            'section' => 'header',
            'priority' => 9,
            'default' => 1,
            'choices' => array(
                1 => esc_html__('On', 'fona'),
                0 => esc_html__('Off', 'fona'),
            ),
        ));
    }
}
add_action('zoo_before_customize_register', 'zoo_register_theme_mods', 15, 4);
if(!function_exists('zoo_add_my_custom_font')) {
    function zoo_add_my_custom_font($standard_fonts)
    {
        $fonts['San_Francisco_Pro'] = array(
            'label' => 'San Francisco Pro',
            'variants' => array('400','500','600'),
            'stack' => 'San Francisco Pro',
        );
        $fonts['FunctionPro'] = array(
            'label' => 'FunctionPro',
            'variants' => array('400','500','600'),
            'stack' => 'FunctionPro',
        );
        return $fonts;
    }
}
add_filter( 'kirki/fonts/standard_fonts', 'zoo_add_my_custom_font' );