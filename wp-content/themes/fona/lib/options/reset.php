<?php
/**
 * Reset Options Panel
 *
 * @uses    object    $wp_customize     WP_Customize_Manager
 * @uses    object    $this             Zoo_Customizer
 *
 * @package    Zoo_Theme\Core\Backend\Customizer
 */

/* ----------------------------------------------------------
					Section - Reset Options
---------------------------------------------------------- */
$this->add_section( 'reset', array(
	'title' => esc_html__( 'Reset', 'fona' ),
	'priority' => 999999999999,
) );

$this->add_field( 'zoo_customizer', array(
	'type'     		=> 'custom',
	'settings' 		=> 'zoo_reset_info',
	'label'    		=> '',
	'section'  		=> 'reset',
	'default'  		=> '<p>' . esc_html__( 'Click the reset button to reset all options to default values.', 'fona' ) . '</p>',
) );

$this->add_field( 'zoo_reset_customizer_button', array(
    'type'        => 'custom',
    'settings' 	  => 'custom_title_advanced_reset',
    'label'       => '',
	'section'     => 'reset',
    'default'     => sprintf( '<div id="zoo-customize-reset-field"><button name="zoo-customizer-reset" id="zoo-customize-reset-btn" class="button-primary button">%s</button></div>', esc_html__( 'Reset cusomtize options', 'fona' ) ),
) );
