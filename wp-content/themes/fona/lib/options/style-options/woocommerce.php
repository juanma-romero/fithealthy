<?php
/**
 * Style Panel of WooCommerce
 * All style of blog add at here
 *
 * @uses    object    $wp_customize     WP_Customize_Manager
 * @uses    object    $this             Zoo_Customizer
 *
 * @package    zoo_Theme
 */
$zoo_customize->add_section($zoo_style_prefix . 'woo', array(
    'title' => esc_html__('WooCommerce', 'fona'),
    'panel' => 'style'
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_color_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading">' . esc_html__('WooCommerce style', 'fona') . '</div>',
    'priority' => 10,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_rate_color',
    'label' => esc_html__('Rating color', 'fona'),
    'description' => esc_html__('Color of rating product', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 12
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_qv_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Button Quick View', 'fona') . '</div>',
    'priority' => 13,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_qv_color',
    'label' => esc_html__('Quick view text', 'fona'),
    'description' => esc_html__('Color of Quick view button', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 13
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_qv_color_hover',
    'label' => esc_html__('Quick view text hover', 'fona'),
    'description' => esc_html__('Color of button Quick view when hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 13
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_qv_bg',
    'label' => esc_html__('Quick view background', 'fona'),
    'description' => esc_html__('Background of button Quick view', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 14
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_qv_bg_hover',
    'label' => esc_html__('Quick view text hover', 'fona'),
    'description' => esc_html__('Background of button Quick view when hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 14
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_cart_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Button Cart', 'fona') . '</div>',
    'priority' => 15,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_cart_color',
    'label' => esc_html__('Cart text', 'fona'),
    'description' => esc_html__('Color of button cart ', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 15
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_cart_color_hover',
    'label' => esc_html__('Cart hover', 'fona'),
    'description' => esc_html__('Color of button cart when hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 15
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_cart_bg',
    'label' => esc_html__('Cart background', 'fona'),
    'description' => esc_html__('Background of button cart', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 16
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_cart_bg_hover',
    'label' => esc_html__('Cart background hover', 'fona'),
    'description' => esc_html__('Background of button cart when hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 16
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_lb_sale_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Sale label', 'fona') . '</div>',
    'priority' => 17,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_color_lb_sale',
    'label' => esc_html__('Sale label', 'fona'),
    'description' => esc_html__('Color of sale label', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 17
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_bg_lb_sale',
    'label' => esc_html__('Background Sale label', 'fona'),
    'description' => esc_html__('Background of sale label', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 17
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_lb_stock_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Stock label', 'fona') . '</div>',
    'priority' => 18,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_lb_low_stock',
    'label' => esc_html__('Low Stock label', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 18
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_lb_out_stock',
    'label' => esc_html__('Out Stock label', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 18
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_price_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Price', 'fona') . '</div>',
    'priority' => 20,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'typography',
    'settings' => $zoo_prefix . 'typo_woo_price',
    'label' => esc_html__('Typography for price', 'fona'),
    'description' => esc_html__('Typography for price product on shop page', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => array(
        'font-family' => ' ',
        'variant' => '500',
        'subsets' => array(),
        'text-transform' => 'none',
        'font-size' => ' ',
        'line-height' => ' ',
        'letter-spacing' => ' ',
    ),
    'priority' => 20,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_price_color',
    'label' => esc_html__('Price', 'fona'),
    'description' => esc_html__('Default color of price', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 20
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_price_regular_color',
    'label' => esc_html__('Regular price', 'fona'),
    'description' => esc_html__('Color regular price of product on sale', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 20
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_price_sale_color',
    'label' => esc_html__('Sale price', 'fona'),
    'description' => esc_html__('Color sale price of product on sale', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 20
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_shop_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Shop Product', 'fona') . '</div>',
    'priority' => 20,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'typography',
    'settings' => $zoo_prefix . 'typo_woo_shop_title',
    'label' => esc_html__('Typography for title', 'fona'),
    'description' => esc_html__('Typography for title product', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => array(
        'font-family' => ' ',
        'variant' => '400',
        'subsets' => array(),
        'text-transform' => 'none',
        'font-size' => ' ',
        'line-height' => ' ',
        'letter-spacing' => ' ',
        'color' => ' ',
    ),
    'priority' => 21,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_title_shop_hover',
    'label' => esc_html__('Title hover', 'fona'),
    'description' => esc_html__('Color of title product on shop page when hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 21
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_single_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Single Product', 'fona') . '</div>',
    'priority' => 25,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'typography',
    'settings' => $zoo_prefix . 'typo_woo_single_title',
    'label' => esc_html__('Typography for title', 'fona'),
    'description' => esc_html__('Typography for title product', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => array(
        'font-family' => ' ',
        'variant' => '600',
        'subsets' => array(),
        'text-transform' => 'none',
        'font-size' => ' ',
        'line-height' => ' ',
        'letter-spacing' => ' ',
        'color' => ' ',
    ),
    'priority' => 26,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_cart_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Cart and check out', 'fona') . '</div>',
    'priority' => 30,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_pri_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Primary button', 'fona') . '</div>',
    'priority' => 31,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_pri_btn_color',
    'label' => esc_html__('Color', 'fona'),
    'description' => esc_html__('Color checkout, place order button', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 31
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_pri_btn_color_hover',
    'label' => esc_html__('Color hover', 'fona'),
    'description' => esc_html__('Color checkout, place order button when hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 31
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_pri_btn_bg',
    'label' => esc_html__('Background', 'fona'),
    'description' => esc_html__('Background of checkout, place order button', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 31
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_pri_btn_bg_hover',
    'label' => esc_html__('Background hover', 'fona'),
    'description' => esc_html__('Background of checkout, place order button when hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 31
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'woo_sec_heading',
    'section' => $zoo_style_prefix . 'woo',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Second button', 'fona') . '</div>',
    'priority' => 32,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_sec_btn_color',
    'label' => esc_html__('Color', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 32
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_sec_btn_color_hover',
    'label' => esc_html__('Color hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 32
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_sec_btn_bg',
    'label' => esc_html__('Background', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 32
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'woo_sec_btn_bg_hover',
    'label' => esc_html__('Background hover', 'fona'),
    'section' => $zoo_style_prefix . 'woo',
    'default' => '',
    'priority' => 32
));
