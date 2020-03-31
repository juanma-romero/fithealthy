<?php

namespace Spocket\Common;

/**
 * Handles requirements checks
 */
class Requirements {

	/**
	 * Checks if cURL is activated on php installation.
	 *
	 * @return array cURL requirements check results
	 */
	public static function checkCurl() {
		if (!in_array('curl', get_loaded_extensions())) {
			return array(
				'title'  => __('PHP cURL', 'spocket'),
				'pass'   => false,
				'reason' => __('PHP cURL seems to be disabled or not installed on your server.', 'spocket'),
				'solution' => __('Please activate cURL to use the spocket plugin. <br>')
			);
		}

		return array(
			'title' => __('PHP cURL', 'spocket'),
			'pass' => true,
		);
	}

	/**
	 * Checks if the connection is SSL.
	 *
	 * @return array SSL requirements check results
	 */
	public static function checkSSLConnection() {
		if (!getenv('IS_DEV') && ( !isset($_SERVER['HTTPS']) || empty($_SERVER['HTTPS']) || 'on' !== $_SERVER['HTTPS'] )) {
			return array(
				'title' => __('SSL Connection', 'spocket'),
				'pass' => false,
				'reason' => __('You are not using a SSL connection', 'spocket'),
				'solution' => __(
					'Please set up a HTTPS certificate to use Spocket.<br>'
				),
			);
		}

		return array(
			'title' => __('SSL Connection', 'spocket'),
			'pass' => true,
		);
	}

	/**
	 * Checks Store name.
	 * checks if the store has a name to use on spocket.
	 *
	 * @return array Store name requirements check results
	 */
	public static function getStoreNameRequirementsStatus() {

		if (get_option('blogname') === '') {
			return array(
				'title' => __('Store name', 'spocket'),
				'pass' => false,
				'reason' => __('Seems like your store does not have a name.', 'spocket'),
				'solution' => __(
					'Please set a name for your store. <br> You can set one in <b>Settings > General > Site Title<b>',
					'spocket'
				),
			);
		}

		return array(
			'title' => __('Store name', 'spocket'),
			'pass' => true,
		);
	}

	/**
	 * Checks Current User requirements.
	 *
	 * @return array Current User requirements check results
	 */
	public static function getUserRequirementsStatus() {
		$currentUser = wp_get_current_user();
		if ($currentUser->get('user_email') === '') {
			return array(
				'title' => __('Current User', 'spocket'),
				'pass' => false,
				'reason' => __('Your user does not have an e-mail account.', 'spocket'),
				'solution' => __(
					'Please you need to assign an e-mail to your user.',
					'spocket'
				),
			);
		}

		return array(
			'title' => __('Current User', 'spocket'),
			'pass' => true,
		);
	}

	/**
	 * Checks WooCommerce requirements.
	 *
	 * @return array WooCommerce requirements check results
	 */
	public static function getWooCommerceRequirementsStatus() {
		if (!function_exists('wc')) {
			return array(
				'title' => __('WooCommerce', 'spocket'),
				'pass' => false,
				'reason' => __('WooCommerce plugin is not activated', 'spocket'),
				'solution' => __(
					'Please install and activate the WooCommerce plugin',
					'spocket'
				),
			);
		}

		if (!version_compare(wc()->version, '2.6', '>=')) {
			return array(
				'title' => __('WooCommerce', 'spocket'),
				'pass' => false,
				'reason' => __(
					'WooCommerce plugin is out of date, version >= 2.6 is required',
					'spocket'
				),
				'solution' => __(
					'Please update your WooCommerce plugin',
					'spocket'
				),
			);
		}

		return array(
			'title' => __('WooCommerce', 'spocket'),
			'pass' => true,
		);
	}

	/**
	 * Checks WordPress requirements.
	 *
	 * @return array WordPress requirements check results
	 */
	public static function getWordPressRequirementsStatus() {
		if (!version_compare(get_bloginfo('version'), '4.4', '>=')) {
			return array(
				'title' => __('WordPress', 'spocket'),
				'pass' => false,
				'reason' => __(
					'WordPress is out of date, version >= 4.4 is required',
					'spocket'
				),
				'solution' => __(
					'Please update your WordPress installation',
					'spocket'
				),
			);
		}

		return array(
			'title' => __('WordPress', 'spocket'),
			'pass' => true,
		);
	}

	/**
	 * Checks permalinks requirements.
	 *
	 * @return array Permalinks requirements check results
	 */
	public static function getPermalinksRequirementsStatus() {
		if (get_option('permalink_structure', '') === '') {
			return array(
				'title' => __('Permalinks', 'spocket'),
				'pass' => false,
				'reason' => __(
					'Permalinks set to "Plain"',
					'spocket'
				),
				'solution' => __(
					'Set permalinks to anything other than "Plain" in <b>Settings > Permalinks</b>',
					'spocket'
				),
			);
		}

		return array(
			'title' => __('Permalinks', 'spocket'),
			'pass' => true,
		);
	}

	/**
	 * Retrieves collective requirements status.
	 *
	 * @return array Requirements check results
	 */
	public static function getRequirementsStatus() {
		$requirementsStatus = array(
			'woocommerce' => self::getWooCommerceRequirementsStatus(),
			'wordpress'   => self::getWordPressRequirementsStatus(),
			'permalinks'  => self::getPermalinksRequirementsStatus(),
			'user'        => self::getUserRequirementsStatus(),
			'store_name'  => self::getStoreNameRequirementsStatus(),
			'check_ssl'   => self::checkSSLConnection(),
			'check_curl'  => self::checkCurl(),
		);
		return $requirementsStatus;
	}

	private static function getApiURL() {
		$plugin = new \Spocket\Plugin();
		return $plugin->getApiURL();
	}
}
