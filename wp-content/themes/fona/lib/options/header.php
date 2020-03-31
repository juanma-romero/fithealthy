<?php
/**
 * Header Panel
 *
 * @uses    object    $this          CleverTheme
 * @uses    object    $this    zoo_Customizer
 *
 * @package    zoo_Theme\Core\Backend\Customizer
 */

/* ----------------------------------------------------------
					Section - Site Identity
---------------------------------------------------------- */
$zoo_customize->add_field( 'zoo_customizer',  array(
    'type'        => 'image',
    'settings'    => 'zoo_site_featured_imaged',
    'label'       => esc_html__( 'Site Featured Image', 'fona' ),
    'description' => esc_html__( 'It\'s default image show up when you share site.', 'fona' ),
    'section'     => 'title_tagline',
    'transport'   => $transport,
) );

$zoo_customize->add_field( 'zoo_customizer',  array(
    'type'        => 'image',
    'settings'    => 'zoo_site_logo_sticky',
    'label'       => esc_html__( 'Site Logo - Sticky', 'fona' ),
    'description' => esc_html__( 'An alternative logo image used on headers sticky.', 'fona' ),
    'section'     => 'title_tagline',
    'transport'   => $transport,
) );

$zoo_customize->add_field( 'zoo_customizer',  array(
    'type'     => 'number',
    'settings' => 'zoo_logo_height',
    'label'    => esc_html__( 'Logo Height', 'fona' ),
    'description' => esc_html__( 'Height of logo. If it blank, logo will use keep original size of logo image', 'fona' ),
    'section'  => 'title_tagline',
    'default'  => '',
) );$zoo_customize->add_field( 'zoo_customizer',  array(
    'type'     => 'slider',
    'settings' => 'zoo_logo_padding_top',
    'label'    => esc_html__( 'Logo Padding Top', 'fona' ),
    'section'  => 'title_tagline',
    'default'  => 0,
    'choices'  => array(
        'min'  => 0,
        'max'  => 100,
        'step' => 1
    ),
) );
$zoo_customize->add_field( 'zoo_customizer',  array(
    'type'     => 'slider',
    'settings' => 'zoo_logo_padding_bottom',
    'label'    => esc_html__( 'Logo Padding Bottom', 'fona' ),
    'section'  => 'title_tagline',
    'default'  => 0,
    'choices'  => array(
        'min'  => 0,
        'max'  => 100,
        'step' => 1
    ),
) );

$zoo_customize->add_section( 'header', array(
    'title'    => esc_html__( 'Header', 'fona' ),
    'priority' => 80
) );
/* ----------------------------------------------------------
					Section - Header Presets
---------------------------------------------------------- */
/* Options heading - Header */
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_header_options_notice',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'header',
    'default'   => '<div class="zoo-notice"><i class="fa  fa-info" aria-hidden="true"></i>' . esc_html__( 'On Page/post some options of customize will override by options of that page/post.', 'fona' ) . '</div>',
    'priority' => 5
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_header_layout_heading',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'header',
    'default'   => '<div class="zoo-options-heading">' . esc_html__( 'Header Layout', 'fona' ) . '</div>',
    'priority' => 5
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'radio-image',
    'settings' => 'zoo_header_layout',
    'label'    => esc_html__( 'Header layout', 'fona' ),
    'description'=> esc_html__( 'Choose header layout you want use for your site.', 'fona' ),
    'section'  => 'header',
    'default'  => 'menu-right',
    'choices'  => array(
        'menu-right' => esc_url(get_template_directory_uri() . '/lib/assets/icons/menu-right.png'),
        'menu-center' => esc_url(get_template_directory_uri() . '/lib/assets/icons/menu-center.png'),
        'stack-center' => esc_url(get_template_directory_uri() . '/lib/assets/icons/stack-center.png'),
        'stack-center-2' => esc_url(get_template_directory_uri() . '/lib/assets/icons/stack-center-2.png'),
        'logo-center' => esc_url(get_template_directory_uri() . '/lib/assets/icons/logo-center.png'),
    ),
    'priority' => 6
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_header_options_heading',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'header',
    'default'   => '<div class="zoo-options-heading">' . esc_html__( 'Header Options', 'fona' ) . '</div>',
    'priority' => 7
) );

$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'switch',
    'settings'  => 'zoo_enable_top_header',
    'label'     => esc_html__( 'Enable top header', 'fona' ),
    'section'   => 'header',
    'default'   => '1',
    'choices' => array(
        '1'  => esc_attr__( 'Yes', 'fona' ),
        '0' => esc_attr__( 'No', 'fona' )
    ),
    'priority' => 8
) );$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'switch',
    'settings'  => 'zoo_enable_header_transparent',
    'label'     => esc_html__( 'Enable header transparent', 'fona' ),
    'description'=> esc_html__( 'Header will has position is absolute, and visible on top.', 'fona' ),
    'section'   => 'header',
    'default'   => '0',
    'choices' => array(
        '1'  => esc_attr__( 'Yes', 'fona' ),
        '0' => esc_attr__( 'No', 'fona' )
    ),
    'priority' => 9
) );

$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'switch',
    'settings'  => 'zoo_header_sticky',
    'label'     => esc_html__( 'Use sticky header', 'fona' ),
    'description'=> esc_html__( 'Header will always visible on top.', 'fona' ),
    'section'   => 'header',
    'default'   => '1',
    'choices' => array(
        '1'  => esc_attr__( 'Yes', 'fona' ),
        '0' => esc_attr__( 'No', 'fona' )
    ),
    'priority' => 10
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'switch',
    'settings'  => 'zoo_enable_header_fullwidth',
    'label'     => esc_html__( '100% Header width', 'fona' ),
    'description'=> esc_html__( 'Header will full width.', 'fona' ),
    'section'   => 'header',
    'default'   => '0',
    'choices' => array(
        '1'  => esc_attr__( 'Yes', 'fona' ),
        '0' => esc_attr__( 'No', 'fona' )
    ),
    'priority' => 11
) );
