<?php

namespace Spocket\ActivationCheck;

class Requirements {

	private static $object = null;

	/**
	 * The plugin instance.
	 *
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * The response instance.
	 *
	 * @var response
	 */
	private $response;

	/**
	 * Verify if WooCommerce is installed and activated.
	 *
	 * @return bool
	 */
	private function isWoocommerceActivated() {
		if (is_plugin_active('woocommerce/woocommerce.php')) {
			return true;
		}

		return false;
	}

	/**
	 * Disable plugin.
	 *
	 * @return void
	 */
	private function deactivateSpocketPlugin() {
		if (current_user_can('activate_plugins') && is_plugin_active(self::$object->plugin->getPluginBaseName())) {
			deactivate_plugins(plugin_basename(self::$object->plugin->getPluginBaseName()));
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}

	/**
	 * Sets up initial instance properties
	 *
	 * @param \Spocket\Plugin $plugin This plugin's instance.
	 * @return void
	 */
	public function __construct( \Spocket\Plugin $plugin) {
		self::$object = $this;
		$this->plugin = $plugin;
	}

	/**
	 * Disable the plugin if the request fails.
	 *
	 * @return void
	 */
	public static function disablePluginIfRequirementsFail() {
		if (!self::$object->isWoocommerceActivated()) {
			self::$object->deactivateSpocketPlugin();
			add_action(
				'admin_head',
				function() {
					self::notifyUser('Spocket Plugin', 'WooCoommerce needs to be installed and activated before you can activate spocket plugin.');
				}
			);
		}
	}

	/**
	 * Shows up a notice error message on WordPress Dashboard.
	 *
	 * @param string $title The message's title
	 * @param string $message the message itself
	 *
	 * @return void
	 */
	public static function notifyUser( $title, $message) {
		echo '<div class="error">
			    <p>' .
				 esc_html__($title)
			  . '</p>
			    <p>
		         <b>Error: </b>' . esc_html__($message)
			  . '</p>
		     </div>';
	}

	/**
	 * Runs the requirements.
	 *
	 * @return void
	 */
	public function run() {
		add_action('admin_init', array($this, 'disablePluginIfRequirementsFail'));
	}

}
