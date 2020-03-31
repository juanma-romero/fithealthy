<?php
/**
 * Style Panel
 *
 * @uses    object    $wp_customize     WP_Customize_Manager
 * @uses    object    $this             Zoo_Customizer
 *
 * @package    zoo_Theme\Core\Backend\Customizer
 */
$zoo_prefix = 'zoo_';
$zoo_style_prefix = 'zoo_style_';
$zoo_customize->add_panel('style', array(
    'title' => esc_html__('Style', 'fona'),
    'description' => esc_html__('Control your theme color, background, typography...', 'fona'),
    'priority' => 85
));
/*Section General*/
$zoo_customize->add_section($zoo_style_prefix . 'general', array(
    'title' => esc_html__('General', 'fona'),
    'panel' => 'style'
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'site_font_awesome',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Font Icon', 'fona') . '</div>',
    'priority' => 5,
));
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'switch',
    'settings' => $zoo_prefix . 'enable_font_awesome',
    'label'     => esc_html__( 'Enable page loader Font Awesome', 'fona' ),
    'section'   => $zoo_style_prefix .'general',
    'default'   => 'off',
    'choices'     => array(
        'on'  => esc_html__( 'On', 'fona' ),
        'off' => esc_html__( 'Off', 'fona' ),
    ),
    'priority' => 5
) );
/*Color for general*/
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'site_color_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Color', 'fona') . '</div>',
    'priority' => 10,
));

// Primary color
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'color_accent',
    'label' => esc_html__('Accent Color', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => '',
    'priority' => 10,
));

// Secondary color
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'color_primary',
    'label' => esc_html__('Primary Color', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => '',
    'priority' => 10,
    'transport'   => 'auto',
));
// Secondary color
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'color_secondary',
    'label' => esc_html__('Secondary Color', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => '',
    'priority' => 10,
));
// Border color
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'color_border',
    'label' => esc_html__('Border Color', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'priority' => 10,
    'default' => ''
));
// Border color
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'color_bg_block',
    'label' => esc_html__('Background block', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'priority' => 10,
    'default' => ''
));
/* Options heading - Site background */
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => $zoo_prefix . 'site_bg_heading',
    'label' => esc_html__('', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Site Background', 'fona') . '</div>',
    'priority' => 23,
));
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'color',
    'settings' => $zoo_prefix . 'site_background_color',
    'label' => esc_html__('Default Background Color', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => '',
    'priority' => 24,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'image',
    'settings' => $zoo_prefix . 'site_background_image',
    'label' => esc_html__('Default Background Image', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => '',
    'priority' => 25,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'select',
    'settings' => $zoo_prefix . 'site_background_size',
    'label' => esc_html__('Background Size', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => 'cover',
    'choices' => array(
        'auto' => esc_html__('Auto', 'fona'),
        'cover' => esc_html__('Cover', 'fona'),
        'contain' => esc_html__('Contain', 'fona'),
        'initial' => esc_html__('Initial', 'fona')
    ),
    'priority' => 26,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'select',
    'settings' => $zoo_prefix . 'site_background_repeat',
    'label' => esc_html__('Background Repeat', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => 'no-repeat',
    'choices' => array(
        'no-repeat' => esc_html__('No Repeat', 'fona'),
        'repeat' => esc_html__('Repeat', 'fona'),
        'repeat-x' => esc_html__('Repeat X', 'fona'),
        'repeat-y' => esc_html__('Repeat Y', 'fona')
    ),
    'priority' => 27,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'select',
    'settings' => $zoo_prefix . 'site_background_position',
    'label' => esc_html__('Background Position', 'fona'),
    'section' => $zoo_style_prefix . 'general',
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
    'priority' => 28,
));

$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'select',
    'settings' => $zoo_prefix . 'site_background_attachment',
    'label' => esc_html__('Background Attachment', 'fona'),
    'section' => $zoo_style_prefix . 'general',
    'default' => 'inherit',
    'choices' => array(
        'inherit' => esc_html__('Inherit', 'fona'),
        'scroll' => esc_html__('Scroll', 'fona'),
        'fixed' => esc_html__('Fixed', 'fona'),
        'local' => esc_html__('Local', 'fona')
    ),
    'priority' => 29,
));

require ZOO_THEME_DIR . 'lib/options/style-options/header.php';
require ZOO_THEME_DIR . 'lib/options/style-options/body.php';
require ZOO_THEME_DIR . 'lib/options/style-options/blog.php';
require ZOO_THEME_DIR . 'lib/options/style-options/woocommerce.php';
require ZOO_THEME_DIR . 'lib/options/style-options/footer.php';
require ZOO_THEME_DIR . 'lib/options/style-options/extend.php';
