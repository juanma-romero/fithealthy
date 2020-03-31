<?php
/**
 * Shop Panel
 *
 * @uses    object    $this          CleverTheme
 * @uses    object    $this    Clever_Customizer
 *
 * @package    Clever_Theme\Core\Backend\Customizer
 */

if (class_exists('WooCommerce')) {
    $zoo_customize->add_panel('woocommerce', array(
        'title' => esc_html__('WooCommerce', 'fona'),
        'description' => esc_html__('WooCommerce theme options.', 'fona'),
        'priority' => 84
    ));

    /* ----------------------------------------------------------
                        Section - Category Page
    ---------------------------------------------------------- */
    $zoo_customize->add_section('shop-archive', array(
        'title' => esc_html__('Shop Page', 'fona'),
        'panel' => 'woocommerce',
        'description' => esc_html__('The settings for archive shop, eg: archive, shop, category...', 'fona'),
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'custom',
        'settings' => 'zoo_slider_cover_heading',
        'label' => esc_html__('', 'fona'),
        'section' => 'shop-archive',
        'default' => '<h3 class="zoo-options-heading">' . esc_html__('Cover shop page', 'fona') . '</h3>',
        'priority' => 5
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'text',
        'settings' => 'zoo_slider_cover',
        'label' => esc_html__('Slider shortcode', 'fona'),
        'section' => 'shop-archive',
        'default' => '',
        'description' => esc_html__('Enter shortcode of rev slider for shop page', 'fona'),
        'priority' => 7
    ));
    /* Options heading - Category Box */
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'custom',
        'settings' => 'zoo_shop_page_heading',
        'label' => esc_html__('', 'fona'),
        'section' => 'shop-archive',
        'default' => '<h3 class="zoo-options-heading">' . esc_html__('Shop page layout', 'fona') . '</h3>',
        'priority' => 10
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_catalog_mod',
        'label' => esc_html__('Enable Catalog Mode', 'fona'),
        'section' => 'shop-archive',
        'default' => '0',
        'description' => esc_html__('If check, catalog mod will active, all button cart, icon cart will be hide, ', 'fona'),
        'priority' => 11
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'radio-image',
        'settings' => 'zoo_shop_sidebar_option',
        'label' => esc_html__('Shop sidebar option', 'fona'),
        'section' => 'shop-archive',
        'default' => 'left-sidebar',
        'choices' => array(
            'top-sidebar' => esc_url(ZOO_THEME_URI. 'lib/assets/icons/top-sidebar.png'),
            'no-sidebar' => esc_url(ZOO_THEME_URI. 'lib/assets/icons/no-sidebar.png'),
            'left-sidebar' => esc_url(ZOO_THEME_URI. 'lib/assets/icons/left-sidebar.png'),
            'right-sidebar' => esc_url(ZOO_THEME_URI. 'lib/assets/icons/right-sidebar.png'),
        ),
        'priority' => 12
    ));
    $zoo_customize->add_field( 'zoo_customizer', array(
        'type'     => 'select',
        'settings' => 'zoo_shop_sidebar',
        'label'    => esc_html__( 'Shop Sidebar', 'fona' ),
        'section'  => 'shop-archive',
        'choices'  => zoo_get_sidebar_options(),
        'priority' => 13
    ) );
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'text',
        'settings' => 'zoo_products_number_items',
        'label' => esc_html__('Products per Page', 'fona'),
        'section' => 'shop-archive',
        'default' => '9',
        'priority' => 15
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'slider',
        'settings' => 'zoo_products_item_min_width',
        'label' => esc_html__('Item min width (px)', 'fona'),
        'section' => 'shop-archive',
        'default' => '270',
        'choices' => array(
            'min' => '100',
            'max' => '500',
            'step' => '10',
        ),
        'priority' => 16
    ));

    $zoo_customize->add_field('zoo_customizer', array(
        'type'     => 'select',
        'settings' => 'zoo_products_pagination',
        'label'    => esc_html__( 'Shop Pagination type', 'fona' ),
        'section'  => 'shop-archive',
        'default'  => 'numeric',
        'choices'  => array(
            'numeric'  => esc_html__('Numeric','fona'),
            'simple'  => esc_html__('Simple','fona'),
            'ajaxload'  => esc_html__('Ajax load more','fona'),
            'infinity'  => esc_html__('Infinity scroll','fona'),
        ),
    ));

    /* Options heading - Category Box */
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'custom',
        'settings' => 'zoo_products_item_heading',
        'label' => esc_html__('', 'fona'),
        'section' => 'shop-archive',
        'default' => '<h3 class="zoo-options-heading">' . esc_html__('Product Item', 'fona') . '</h3>',
        'priority' => 20
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type'     => 'select',
        'settings' => 'zoo_product_style',
        'label'    => esc_html__( 'Product style', 'fona' ),
        'section'  => 'shop-archive',
        'default'  => 'default',
        'choices'  => array(
            'default'  => esc_html__('Default','fona'),
            'style-2'  => esc_html__('Style 2','fona'),
            'style-3'  => esc_html__('Style 3','fona'),
            'style-4'  => esc_html__('Style 4','fona'),
            'style-5'  => esc_html__('Style 5','fona'),
            'style-6'  => esc_html__('Style 6','fona'),
        ),
        'priority' => 20
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_aternative_images',
        'label' => esc_html__('Aternative images', 'fona'),
        'section' => 'shop-archive',
        'default' => '0',
        'description' => esc_html__('Show alternative product images on mouse hover (in category view and in product sliders)', 'fona'),
        'priority' => 20
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
        'settings' => 'zoo_product_sale_label',
        'label' => esc_html__('Show Sale Label', 'fona'),
        'section' => 'shop-archive',
        'default' => '1',
        'priority' => 22
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'select',
        'settings' => 'zoo_sale_type',
        'label' => esc_html__('Sale label type', 'fona'),
        'section' => 'shop-archive',
        'default' => 'number',
        'choices' => array(
            'number' => esc_html__('Number', 'fona'),
            'text' => esc_html__('Text', 'fona'),
        ),
        'priority' => 23
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_product_rating',
        'label' => esc_html__('Hide Rating', 'fona'),
        'description' => esc_html__('Rating of product will be hide', 'fona'),
        'section' => 'shop-archive',
        'default' => '1',
        'priority' => 24
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_product_stock_label',
        'label' => esc_html__('Hide Stock Label', 'fona'),
        'description' => esc_html__('Stock label will be hide', 'fona'),
        'section' => 'shop-archive',
        'default' => '0',
        'priority' => 25
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_product_disable_qv',
        'label' => esc_html__('Disable quick view', 'fona'),
        'description' => esc_html__('Quick view and all function require will disable', 'fona'),
        'section' => 'shop-archive',
        'default' => '0',
        'priority' => 26
    ));
    /* ----------------------------------------------------------
                        Section - Product Page
    ---------------------------------------------------------- */
    $zoo_customize->add_section('shop-single', array(
        'title' => esc_html__('Single Product Page', 'fona'),
        'panel' => 'woocommerce',
        'description' => esc_html__('The settings for single product', 'fona'),
    ));

    /* Options heading - Layout */
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'custom',
        'settings' => 'zoo_single_layout_heading',
        'label' => esc_html__('', 'fona'),
        'section' => 'shop-single',
        'default' => '<div class="zoo-options-heading">' . esc_html__('Layout', 'fona') . '</div>',
        'priority' => 5
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
        'type' => 'checkbox',
        'settings' => 'zoo_single_product_zoom',
        'label' => esc_html__('Enable Product Zoom', 'fona'),
        'section' => 'shop-single',
        'default' => '1',
        'description' => esc_html__('If check, zoom feature will active', 'fona'),
        'priority' => 9
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_single_link_product',
        'label' => esc_html__('Show Next and previous Product', 'fona'),
        'section' => 'shop-single',
        'default' => '1',
        'priority' => 10
    ));

    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_single_share',
        'label' => esc_html__('Show Social Share', 'fona'),
        'section' => 'shop-single',
        'default' => '1',
        'priority' => 11
    ));
    /* Options heading - Related Product */
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'custom',
        'settings' => 'zoo_single_related_product_heading',
        'label' => esc_html__('', 'fona'),
        'section' => 'shop-single',
        'default' => '<div class="zoo-options-heading">' . esc_html__('Related Product', 'fona') . '</div>',
        'priority' => 15
    ));

    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_single_related_product',
        'label' => esc_html__('Show Related product', 'fona'),
        'section' => 'shop-single',
        'default' => '1',
        'priority' => 16
    ));

    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'checkbox',
        'settings' => 'zoo_single_related_product_slider',
        'label' => esc_html__('Enable slider for Related products', 'fona'),
        'section' => 'shop-single',
        'default' => '1',
        'priority' => 17
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'number',
        'settings' => 'zoo_single_related_product_number',
        'label' => esc_html__('Number items', 'fona'),
        'section' => 'shop-single',
        'default' => '4',
        'priority' => 18
    ));
    $zoo_customize->add_field('zoo_customizer', array(
        'type' => 'slider',
        'settings' => 'zoo_single_related_cols',
        'label' => esc_html__('Columns', 'fona'),
        'section' => 'shop-single',
        'default' => '4',
        'choices' => array(
            'min' => '1',
            'max' => '6',
            'step' => '1',
        ),
        'priority' => 19,
        'active_callback'  => array(
            array(
                'setting'  => 'zoo_single_related_product_slider',
                'operator' => '==',
                'value'    => '1',
            )),
    ));
}
