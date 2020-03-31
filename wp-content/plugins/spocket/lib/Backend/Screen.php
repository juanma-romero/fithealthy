<?php

namespace Spocket\Backend;

/**
 * Displays an admin interface for the plugin
 */
class Screen {

	/**
	 * The plugin instance.
	 *
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * Sets up initial instance properties
	 *
	 * @param \Spocket\Plugin $plugin This plugin's instance.
	 * @return void
	 */
	public function __construct( \Spocket\Plugin $plugin) {
		$this->plugin = $plugin;
	}

	/**
	 * Registers interface, to be displayed as a sub-menu of the Settings menu
	 * item.
	 *
	 * @return void
	 */
	public function addMenuPage() {
		add_menu_page(
			esc_html__('Spocket', 'spocket'),
			esc_html__('Spocket', 'spocket'),
			'manage_woocommerce',
			'spocket',
			array($this, 'displayInterface'),
			"{$this->plugin->getAssetsURL()}images/white-logo.png",
			57
		);
	}

	/**
	 * Displays an interface.
	 *
	 * @return void
	 */
	public function displayInterface() {
		do_action('spocket_before_interface', $this);
		echo '<div class="wrap js-spocket-admin-interface">';
		esc_html_e('Loading, please wait...', 'spocket');
		echo '</div>';
		do_action('spocket_after_interface', $this);
	}

	/**
	 * Registers filters and actions.
	 *
	 * @return void
	 */
	public function run() {
		add_action('admin_menu', array($this, 'addMenuPage'));
	}
}
