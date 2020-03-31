<?php

namespace Spocket\Backend;

/**
 * Responsible for registering and enqueueing assets on the Backend
 */
class Assets {

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
	 * Defines a list of strings used in the interface, localized and passed
	 * to JavaScript.
	 *
	 * @return array
	 */
	public function l10nList() {
		return array(
			'test' => __(
				'Test',
				'spocket'
			),
		);
	}

	/**
	 * Enqueues the plugin script.
	 *
	 * @param string $hook The current admin page.
	 * @return void
	 */
	public function enqueueScript( $hook) {
		if ('toplevel_page_spocket' !== $hook) {
			return;
		}

		wp_enqueue_script(
			'spocket',
			"{$this->plugin->getAssetsURL()}js/admin.js",
			array(),
			$this->plugin->getVersion()
		);

		$scriptData = array(
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonces' => array(
				'getRequirementsStatus' => wp_create_nonce('spocket-get-requirements-status-nonce'),
				'getSpocketStatus' => wp_create_nonce('spocket-get-status-nonce'),
				'disconnectSpocketNonce' => wp_create_nonce('spocket-disconnect-nonce'),
				'saveShopUrlNonce' => wp_create_nonce('spocket-save-shop-url-nonce'),
				'directSignup' => wp_create_nonce('spocket-direct-signup-nonce'),
				'removeStoreAuthorizationKeyFromRequest' => wp_create_nonce('spocket-remove-store-authorization-key-nonce'),
			),
			'l10n' => $this->l10nList(),
			'assetsSrcUrl' => $this->plugin->getAssetsSrcURL(),
			'assetsUrl' => $this->plugin->getAssetsURL(),
			'storeUrl' => get_site_url(),
			'spocketShopUrl' => get_option('spocket_shop_url', ''),
			'spocketAdminUrl' => get_admin_url(null, 'admin.php?page=spocket'),
			'spocketAuthToken' => get_option('spocket_auth_token', ''),
			'spocketUserId' => get_option('spocket_user_id', '')
		);

		wp_localize_script(
			'spocket',
			'SpocketData',
			$scriptData
		);
	}

	/**
	 * Enqueue all styles needed on the Backend.
	 *
	 * @param string $hook The current admin page.
	 * @return void
	 */
	public function enqueueStyles( $hook) {
		if ('toplevel_page_spocket'!== $hook) {
			return;
		}

		if (\getenv('IS_DEV') === 'true') {
			// Styles are live-reloaded with webpack JS
			return;
		}

		\wp_enqueue_style(
			'spocket',
			"{$this->plugin->getAssetsURL()}css/admin.css",
			array(),
			$this->plugin->getVersion()
		);
	}

	public function enqueueTopLevelMenuStyle() {
		\wp_enqueue_style(
			'spocket',
			"{$this->plugin->getAssetsURL()}css/toplevel-menu.css",
			array(),
			$this->plugin->getVersion()
		);
	}

	/**
	 * Registeres and enqueues assets.
	 *
	 * @return void
	 */
	public function run() {
		add_action('admin_enqueue_scripts', array($this, 'enqueueScript'));
		add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueueTopLevelMenuStyle'));
	}
}
