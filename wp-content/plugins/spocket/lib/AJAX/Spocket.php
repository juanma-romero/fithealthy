<?php

namespace Spocket\AJAX;

use \Spocket\Common\Spocket as CommonSpocket;

/**
 * Handles AJAX requests related to Spocket
 */
class Spocket {

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
	 * Gets requirements status.
	 *
	 * @return void
	 */
	public function getSpocketStatus() {
		check_ajax_referer('spocket-get-status-nonce', 'nonce');
		$spocketStatus = CommonSpocket::getSpocketStatus();
		wp_send_json_success(array(
			'spocketStatus' => $spocketStatus,
		));
	}

	/**
	 * Disconnects the store from Spocket.
	 *
	 * @return void
	 */
	public function disconnectSpocket() {
		check_ajax_referer('spocket-disconnect-nonce', 'nonce');
		$disconnected = CommonSpocket::disconnectSpocket();
		wp_send_json_success(array(
			'disconnected' => $disconnected,
		));
	}

	/**
	 * Save shop url.
	 *
	 * @return void
	 */
	public function saveShopUrl() {
		check_ajax_referer('spocket-save-shop-url-nonce', 'nonce');

		$spocketStatus = CommonSpocket::saveShopUrl();
	}

	/**
	 * Finishes the direct signup process.
	 *
	 * @return void
	 */
	public function finishDirectSignup() {
		check_ajax_referer('spocket-direct-signup-nonce', 'nonce');

		if (isset($_POST['storeAuthorizationKey'])) {
			$storeAuthorizationKey          = filter_var($_POST['storeAuthorizationKey'], FILTER_SANITIZE_STRING);
			$isStoreAuthorizationKeyCreated = CommonSpocket::finishDirectSignup($storeAuthorizationKey);

			if ($isStoreAuthorizationKeyCreated) {
				return wp_send_json_success(array(
					'direct_signup_status'  => 'created',
				));
			}
		}
		wp_send_json_error(array(
			'direct_signup_status'  => 'failed',
			'message' => 'Please provide your store authorization key'
		));
	}

	public function removeStoreAuthorizationKeyFromRequest() {
		check_ajax_referer('spocket-remove-store-authorization-key-nonce', 'nonce');
		update_option('spocket_store_authorization_key', '', false);

		if (get_option('spocket_store_authorization_key') === '') {
			return wp_send_json_success(array(
				'status'  => 'removed',
			));
		}
	}

	/**
	 * Registeres and enqueues assets.
	 *
	 * @return void
	 */
	public function run() {
		add_action('wp_ajax_spocket_status', array($this, 'getSpocketStatus'));
		add_action('wp_ajax_spocket_disconnect', array($this, 'disconnectSpocket'));
		add_action('wp_ajax_spocket_save_shop_url', array($this, 'saveShopUrl'));
		add_action('wp_ajax_spocket_direct_signup', array($this, 'finishDirectSignup'));
		add_action(
			'wp_ajax_spocket_remove_store_authorization_key_from_request',
			array($this, 'removeStoreAuthorizationKeyFromRequest')
		);
	}
}
