<?php
/**
 * Custom Css/Js Panel
 *
 * @uses    object    $wp_customize     WP_Customize_Manager
 * @uses    object    $this             Zoo_Customizer
 *
 * @package    Zoo_Theme\Core\Backend\Customizer
 */

/* ----------------------------------------------------------
					Section - Custom Css/Js
---------------------------------------------------------- */
$zoo_customize->add_section( 'custom', array(
	'title' => esc_html__( 'Additional JS', 'fona' ),
    'priority' => 200
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'        => 'code',
	'settings' => 'zoo_custom_js',
	'label'    => esc_html__( 'Custom Js', 'fona' ),
	'section'  => 'custom',
	'default'  => '',
    'priority'    => 10,
    'choices'     => array(
        'language' => 'javascript',
        'theme'    => 'dracula',
        'height'   => 350,
    ),
) );
