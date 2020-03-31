<?php
/**
 * Style Panel of Extend style
 * All style of input and button add at here
 *
 * @uses    object    $wp_customize     WP_Customize_Manager
 * @uses    object    $this             Zoo_Customizer
 *
 * @package    zoo_Theme
 */
$zoo_customize->add_section($zoo_style_prefix . 'form', array(
    'title' => esc_html__('Form field and button', 'fona'),
    'panel' => 'style'
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'form_style_heading',
    'section' => $zoo_style_prefix . 'form',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Form field', 'fona') . '</div>',
    'priority' => 10,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'form_style_color',
    'label' => esc_html__('Color', 'fona'),
    'description' => esc_html__('Color of form field', 'fona'),
    'section' => $zoo_style_prefix . 'form',
    'default' => '',
    'priority' => 11
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'form_style_border',
    'label' => esc_html__('Border color', 'fona'),
    'description' => esc_html__('Border color of form field', 'fona'),
    'section' => $zoo_style_prefix . 'form',
    'default' => '',
    'priority' => 11
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'form_style_border_active',
    'label' => esc_html__('Border color active', 'fona'),
    'description' => esc_html__('Border color of form field when active or focus', 'fona'),
    'section' => $zoo_style_prefix . 'form',
    'default' => '',
    'priority' => 11
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'form_style_bg',
    'label' => esc_html__('Background', 'fona'),
    'description' => esc_html__('Background color of form field.', 'fona'),
    'section' => $zoo_style_prefix . 'form',
    'default' => '',
    'priority' => 11
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'btn_style_heading',
    'section' => $zoo_style_prefix . 'form',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Button', 'fona') . '</div>',
    'priority' => 15,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'btn_style_color',
    'label' => esc_html__('Color', 'fona'),
    'section' => $zoo_style_prefix . 'form',
    'default' => '',
    'priority' => 16
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'btn_style_color_hover',
    'label' => esc_html__('Color hover', 'fona'),
    'section' => $zoo_style_prefix . 'form',
    'default' => '',
    'priority' => 16
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'btn_style_bg',
    'label' => esc_html__('Background', 'fona'),
    'section' => $zoo_style_prefix . 'form',
    'default' => '',
    'priority' => 16
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'btn_style_bg_hover',
    'label' => esc_html__('Background hover', 'fona'),
    'section' => $zoo_style_prefix . 'form',
    'default' => '',
    'priority' => 16
));
