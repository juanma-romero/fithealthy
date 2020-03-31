<?php
/**
 * Style Panel of Header
 *
 * @uses    object    $wp_customize     WP_Customize_Manager
 * @uses    object    $this             Zoo_Customizer
 *
 * @package    zoo_Theme
 *
 */

/* ----------------------------------------------------------
					Section - Header
---------------------------------------------------------- */
$zoo_customize->add_section($zoo_style_prefix . 'header', array(
    'title' => esc_html__('Header', 'fona'),
    'panel' => 'style'
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'colors_type_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Top Header', 'fona') . '</div>',
    'priority' => 10
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_top_color',
    'label' => esc_html__('Color', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 11
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_top_link_color',
    'label' => esc_html__('Link color', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 12
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_top_link_color_hover',
    'label' => esc_html__('Link color hover', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 13
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_top_bg_color',
    'label' => esc_html__('Background', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 14
));

/* Options heading - Header main */
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'header_main_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Main Header', 'fona') . '</div>',
    'priority' => 15
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_main_color',
    'label' => esc_html__('Color', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 16
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_main_link_color',
    'label' => esc_html__('Link color', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 17
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_main_link_color_hover',
    'label' => esc_html__('Link color hover', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 18
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_main_background_color',
    'label' => esc_html__('Background', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 19
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_main_bg_sticky',
    'label' => esc_html__('Background Sticky', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 19
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_sticky_color',
    'label' => esc_html__('Sticky Color', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 19
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_sticky_color_hv',
    'label' => esc_html__('Sticky Color Hover', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 19
));

/* Options heading - Header Main Menu */
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'header_menu_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Header Navigation', 'fona') . '</div>',
    'priority' => 20
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' =>  $zoo_prefix . 'header_menu_color',
    'label' => esc_html__('Color', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 20
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'header_menu_bg',
    'label' => esc_html__('Background', 'fona'),
    'description' => esc_html__('Background of menu bar', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 20
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'header_menu_typo_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Main Menu', 'fona') . '</div>',
    'priority' => 21
));
// Navigation font
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'typography',
    'settings' =>  $zoo_prefix . 'typo_main_menu',
    'label' => esc_html__('', 'fona'),
    'description' => esc_html__('Typography options for site navigation ', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => array(
        'font-family' => 'Poppins',
        'variant' => '600',
        'subsets' => array(),
        'text-transform' => 'none',
        'font-size' => '15px',
        'line-height' => '1.5',
        'letter-spacing' => '0',
        'color'          => '#252525',
    ),
    'priority' => 22
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'main_menu_color_hover',
    'label' => esc_html__('Color Hover', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 23
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'main_menu_bg',
    'label' => esc_html__('Background', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'description' => esc_html__('Background for main menu item', 'fona'),
    'default' => '',
    'priority' => 24
));$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'main_menu_bg_hover',
    'label' => esc_html__('Background hover', 'fona'),
    'description' => esc_html__('Background for main menu item when hover', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 24
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'header_menu_color_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '<div class="zoo-options-heading-block">' . esc_html__('Sub Menu', 'fona') . '</div>',
    'priority' => 25
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'typography',
    'settings' =>  $zoo_prefix . 'typo_sub_menu',
    'label' => esc_html__('', 'fona'),
    'description' => esc_html__('Typography options for sub menu of site navigation ', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => array(
        'font-family' => 'Poppins',
        'variant' => '600',
        'subsets' => array(),
        'text-transform' => 'none',
        'font-size' => '15px',
        'line-height' => '1.5',
        'letter-spacing' => '0',
        'color'          => '#252525',
    ),
    'priority' => 25
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'sub_menu_color_hover',
    'label' => esc_html__('Color hover', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 26
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' =>  $zoo_prefix . 'sub_menu_block_bg',
    'label' => esc_html__('Background block', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'description' => esc_html__('Background for sub menu', 'fona'),
    'default' => '',
    'priority' => 27
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' =>  $zoo_prefix . 'sub_menu_bg',
    'label' => esc_html__('Background', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'description' => esc_html__('Background for sub menu item', 'fona'),
    'default' => '',
    'priority' => 27
));$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' =>  $zoo_prefix . 'sub_menu_bg_hover',
    'label' => esc_html__('Background hover', 'fona'),
    'description' => esc_html__('Background for sub menu item when hover', 'fona'),
    'section' => $zoo_style_prefix . 'header',
    'default' => '',
    'priority' => 27
));
