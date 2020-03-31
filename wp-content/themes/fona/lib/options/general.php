<?php
/**
 * General Panel
 *
 * @uses    object    $this          CleverTheme
 * @uses    object    $this    Clever_Customizer
 *
 * @package    Clever_Theme\Core\Backend\Customizer
 */

$zoo_customize->add_section( 'general', array(
    'title'    => esc_html__( 'General', 'fona' ),
    'priority' => 1
) );

/* Options heading - Site layout */
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_site_layout_heading',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'general',
    'default'   => '<div class="zoo-options-heading">' . esc_html__( 'Site layout', 'fona' ) . '</div>',
    'priority' => 5
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'radio-buttonset',
    'settings' => 'zoo_site_layout',
    'label'    => esc_html__( 'Available Layout', 'fona' ),
    'section'  => 'general',
    'default'  => 'full',
    'choices'  => array(
        'full'  => esc_html__( 'Full Width', 'fona' ),
        'boxed' => esc_html__( 'Boxed', 'fona' )
    ),
    'priority' => 6
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'number',
    'settings' => 'zoo_site_width',
    'label'    => esc_html__( 'Site max width', 'fona' ),
    'section'  => 'general',
    'default'  => '1200',
    'description' => esc_html__( 'Max width content block of site. Leave it blank or 0 if set content block is full width.', 'fona' ),
    'priority' => 6
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings'  => 'zoo_site_layout_box_shadow',
    'label'     => esc_html__( 'Add Drop Shadow to Content box', 'fona' ),
    'section'   => 'general',
    'default'   => '1',
    'priority' => 7
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings'  => 'zoo_disable_breadcrumbs',
    'label'     => esc_html__( 'If check, breadcrumbs will hide.', 'fona' ),
    'section'   => 'general',
    'default'   => '0',
    'priority' => 7
) );
/* Options heading - Page loader */
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_site_page_loader_heading',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'general',
    'default'   => '<div class="zoo-options-heading">' . esc_html__( 'Page loader', 'fona' ) . '</div>',
    'priority' => 10
) );

$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'switch',
    'settings'  => 'zoo_site_page_loader',
    'label'     => esc_html__( 'Enable page loader effect', 'fona' ),
    'section'   => 'general',
    'default'   => '0',
    'choices'     => array(
        'on'  => esc_html__( 'On', 'fona' ),
        'off' => esc_html__( 'Off', 'fona' ),
    ),
    'priority' => 11
) );
