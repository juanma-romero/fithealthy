<?php
/**
 * Changes the styling of the customizer
 * based on the settings set using the kirki/config filter.
 * For documentation please see
 * https://github.com/aristath/kirki/wiki/Styling-the-Customizer
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// @codingStandardsIgnoreFile

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Kirki_Modules_Customizer_Styling {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 */
	protected function __construct() {
		add_action( 'customize_controls_print_styles', array( $this, 'custom_css' ), 99 );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add custom CSS rules to the head, applying our custom styles.
	 *
	 * @access public
	 */
	public function custom_css() {

		$config = apply_filters( 'kirki/config', array() );
		if ( ! isset( $config['color_accent'] ) && ! isset( $config['color_back'] ) ) {
			return;
		}
		$back     = isset( $config['color_back'] ) ? $config['color_back'] : false;

		$text_on_back              = '';
		$border_on_back            = '';
		$back_on_back              = '';
		$hover_on_back             = '';
		$arrows_on_back            = '';
		$text_on_accent            = '';
		$border_on_accent          = '';
		$accent_disabled_obj       = '';
		$accent_disabled           = '';
		$text_on_accent_disabled   = '';
		$border_on_accent_disabled = '';

		if ( $back ) {
			$back_obj       = ariColor::newColor( $back );
			$text_on_back   = ( 60 > $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness + 60 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness - 60 )->toCSS( $back_obj->mode );
			$border_on_back = ( 80 < $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness - 13 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness + 13 )->toCSS( $back_obj->mode );
			$back_on_back   = ( 90 < $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness - 6 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness + 11 )->toCSS( $back_obj->mode );
			$hover_on_back  = ( 90 < $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness - 3 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness + 3 )->toCSS( $back_obj->mode );
			$arrows_on_back = ( 50 > $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness + 30 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness - 30 )->toCSS( $back_obj->mode );
		}
		$accent     = ( isset( $config['color_accent'] ) ) ? $config['color_accent'] : false;
		if ( $accent ) {
			$accent_obj                = ariColor::newColor( $accent );
			$text_on_accent            = ( 60 > $accent_obj->lightness ) ? $accent_obj->getNew( 'lightness', $accent_obj->lightness + 60 )->toCSS( $accent_obj->mode ) : $accent_obj->getNew( 'lightness', $accent_obj->lightness - 60 )->toCSS( $accent_obj->mode );
			$border_on_accent          = ( 50 < $accent_obj->lightness ) ? $accent_obj->getNew( 'lightness', $accent_obj->lightness - 4 )->toCSS( $accent_obj->mode ) : $accent_obj->getNew( 'lightness', $accent_obj->lightness + 4 )->toCSS( $accent_obj->mode );
			$accent_disabled_obj       = ( 35 < $accent_obj->lightness ) ? $accent_obj->getNew( 'lightness', $accent_obj->lightness - 30 ) : $accent_obj->getNew( 'lightness', $accent_obj->lightness + 30 );
			$accent_disabled           = $accent_disabled_obj->toCSS( $accent_disabled_obj->mode );
			$text_on_accent_disabled   = ( 60 > $accent_disabled_obj->lightness ) ? $accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness + 60 )->toCSS( $accent_disabled_obj->mode ) : $accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness - 60 )->toCSS( $accent_disabled_obj->mode );
			$border_on_accent_disabled = ( 50 < $accent_disabled_obj->lightness ) ? $accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness - 4 )->toCSS( $accent_disabled_obj->mode ) : $accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness + 4 )->toCSS( $accent_disabled_obj->mode );
		}
	}
}
