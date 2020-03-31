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
$zoo_customize->add_section($zoo_style_prefix . 'footer', array(
    'title' => esc_html__('Footer', 'fona'),
    'panel' => 'style'
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'color_footer_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Footer', 'fona') . '</div>',
    'priority' => 10,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'typography',
    'settings' => $zoo_prefix . 'typo_footer_title',
    'label' => esc_html__('Typography for title', 'fona'),
    'description' => esc_html__('Typography for title widget', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => array(
        'font-family' => 'Poppins',
        'variant' => '500',
        'subsets' => array(),
        'text-transform' => 'uppercase',
        'font-size' => '15px',
        'line-height' => '1.5',
        'letter-spacing' => '0',
        'color' => '#fff',
    ),
    'priority' => 11,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'footer_border',
    'label' => esc_html__('Border', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 11
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'footer_bg_color',
    'label' => esc_html__('Background Color', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 12,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'image',
    'settings' => $zoo_prefix . 'footer_bg_image',
    'label' => esc_html__('Background Image', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 13
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'select',
    'settings' => $zoo_prefix . 'footer_bg_size',
    'label' => esc_html__('Background Size', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => 'cover',
    'choices' => array(
        'auto' => esc_html__('Auto', 'fona'),
        'cover' => esc_html__('Cover', 'fona'),
        'contain' => esc_html__('Contain', 'fona'),
        'initial' => esc_html__('Initial', 'fona')
    ),
    'priority' => 14
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'select',
    'settings' => $zoo_prefix . 'footer_bg_repeat',
    'label' => esc_html__('Background Repeat', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => 'no-repeat',
    'choices' => array(
        'no-repeat' => esc_html__('No Repeat', 'fona'),
        'repeat' => esc_html__('Repeat', 'fona'),
        'repeat-x' => esc_html__('Repeat X', 'fona'),
        'repeat-y' => esc_html__('Repeat Y', 'fona')
    ),
    'priority' => 14
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'select',
    'settings' => $zoo_prefix . 'footer_bg_position',
    'label' => esc_html__('Background Position', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => 'center center',
    'choices' => array(
        'left top' => esc_html__('Left Top', 'fona'),
        'left center' => esc_html__('Left Center', 'fona'),
        'left bottom' => esc_html__('Left Bottom', 'fona'),
        'right top' => esc_html__('Right Top', 'fona'),
        'right center' => esc_html__('Right Center', 'fona'),
        'right bottom' => esc_html__('Right Bottom', 'fona'),
        'center top' => esc_html__('Center Top', 'fona'),
        'center bottom' => esc_html__('Center Bottom', 'fona'),
        'center center' => esc_html__('Center Center', 'fona')
    ),
    'priority' => 14
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'select',
    'settings' => $zoo_prefix . 'footer_bg_attachment',
    'label' => esc_html__('Background Attachment', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => 'scroll',
    'choices' => array(
        'scroll' => esc_html__('Scroll', 'fona'),
        'fixed' => esc_html__('Fixed', 'fona')
    ),
    'priority' => 14
));
/*Top Footer*/
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'color_top_footer_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Top Footer', 'fona') . '</div>',
    'priority' => 15,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'top_footer_color',
    'label' => esc_html__('Color', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 16,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'top_footer_link_color',
    'label' => esc_html__('Link color', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 17,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'top_footer_link_color_hover',
    'label' => esc_html__('Link Color Hover', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 17,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'top_footer_bg',
    'label' => esc_html__('Background', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 18,
));
/*Main Footer*/
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'color_main_footer_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Main Footer', 'fona') . '</div>',
    'priority' => 20,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'main_footer_color',
    'label' => esc_html__('Color', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 21,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'main_footer_link_color',
    'label' => esc_html__('Link color', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 22
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'main_footer_link_color_hover',
    'label' => esc_html__('Link Color Hover', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 22
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'main_footer_bg',
    'label' => esc_html__('Background', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 23
));
/* Options heading - Bottom Footer */
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'bt_footer_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Bottom Footer', 'fona') . '</div>',
    'priority' => 25,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'bt_footer_color',
    'label' => esc_html__('Color', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 26
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'bt_footer_link_color',
    'label' => esc_html__('Link color', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 27
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'bt_footer_link_color_hover',
    'label' => esc_html__('Link Color Hover', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 27
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'bt_footer_bg',
    'label' => esc_html__('Background Color', 'fona'),
    'section' => $zoo_style_prefix . 'footer',
    'default' => '',
    'priority' => 27
));
