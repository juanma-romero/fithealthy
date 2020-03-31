<?php
/**
 * Plugin Name:   Kirki Toolkit
 * Plugin URI:    http://kirki.org
 * Description:   The ultimate WordPress Customizer Toolkit
 * Author:        Aristeides Stathopoulos
 * Author URI:    http://aristeides.com
 * Version:       3.0.16
 * Text Domain:   kirki
 *
 * GitHub Plugin URI: aristath/kirki
 * GitHub Plugin URI: https://github.com/aristath/kirki
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// No need to proceed if Kirki already exists.
if ( class_exists( 'Kirki' ) ) {
	return;
}

// Include the autoloader.
include_once get_template_directory() . '/lib/vendor/kirki/class-kirki-autoload.php';
new Kirki_Autoload();

if ( ! defined( 'KIRKI_PLUGIN_FILE' ) ) {
	define( 'KIRKI_PLUGIN_FILE', get_template_directory() . '/lib/vendor/kirki' );
}
// Define the KIRKI_VERSION constant.
if ( ! defined( 'KIRKI_VERSION' ) ) {
    define( 'KIRKI_VERSION', '3.0.10' );
}


// Make sure the path is properly set.
Kirki::$path = wp_normalize_path( get_template_directory() . '/lib/vendor/kirki' );
Kirki_Init::set_url();

if ( ! function_exists( 'Kirki' ) ) {
	/**
	 * Returns an instance of the Kirki object.
	 */
	function kirki() {
		$kirki = Kirki_Toolkit::get_instance();
		return $kirki;
	}
}

// Start Kirki.
global $kirki;
$kirki = kirki();

// Instantiate the modules.
$kirki->modules = new Kirki_Modules();

Kirki::$url = wp_normalize_path( get_template_directory() . '/lib/vendor/kirki' );

// Instantiate classes.
new Kirki_L10n();
new Kirki();
// Include deprecated functions & methods.
include_once wp_normalize_path( get_template_directory() . '/lib/vendor/kirki/core/deprecated.php' );

// Include the ariColor library.
include_once wp_normalize_path( get_template_directory() . '/lib/vendor/kirki/lib/class-aricolor.php' );

// Add an empty config for global fields.
Kirki::add_config( '' );