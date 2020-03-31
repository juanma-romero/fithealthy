<?php

namespace Spocket\Common;

/**
 * Handles Spocket related functionality
 */
class Spocket {

	 /**
	 * The plugin instance.
	 *
	 * @var Plugin
	 */
	private $plugin;

	private static $object = null;

	private function getSpocketConsumerSecret() {
		global $wpdb;

		$wpUser    = wp_get_current_user();
		$tableName = $wpdb->prefix . 'woocommerce_api_keys';

		return $wpdb->get_row($wpdb->prepare(
			'SELECT consumer_secret
             FROM `%1$s`
             WHERE description LIKE %s AND user_id = "%3$s"', $tableName, $wpdb->esc_like('%spocket%'), $wpUser->id));
	}

	private function getProductCategory( $category_id) {
		global $wpdb; 

		$tableName = $wpdb->prefix . 'terms';
		return $wpdb->get_row($wpdb->prepare('select * from `%1$s` where term_id = "%2$s"', $tableName, $category_id));
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
	 * Checks whether Spocket is integrated with the store.
	 *
	 * @return array Spocket status results
	 */
	public static function getSpocketStatus() {
		return array(
			'connected' => get_option('spocket_connected', false),
		);
	}

	/**
	 * Filters request ags and adds the data that Spocket expects.
	 *
	 * @param array http args
	 * @param string url
	 * @return array modified http args
	 */
	public static function fillInSpocketData( $args, $url) {
		if (!is_user_logged_in()) {
			return $args;
		}

		$urlHost = parse_url($url, PHP_URL_HOST);

		if (!getenv('IS_DEV') && 'spocket.co' !== $urlHost && '.spocket.co' !== substr($urlHost, -11)) {
			return $args;
		}

		$body = json_decode($args['body'], true);

		if (!is_array($body)) {
			return $args;
		}

		if (!isset($body['consumer_key'])) {
			return $args;
		}

		// We are sending API keys to spocket, set our option here
		$currentUser = wp_get_current_user();

		$body['user_email'] = $currentUser->get('user_email');
		$body['user_name']  = $currentUser->get('display_name');

		$body['store_authorization_key'] = get_option('spocket_store_authorization_key');

		$customer = new \WC_Customer($currentUser->ID);

		$body['user_address'] = sprintf(
			'%s, %s %s, %s',
			$customer->get_billing_address_1(),
			$customer->get_billing_postcode(),
			$customer->get_billing_city(),
			$customer->get_billing_country()
		);

		if (empty(trim(str_replace(',', '', $body['user_address'])))) {
			$body['user_address'] = '';
		}

		$body['store_name'] = get_option('blogname');
		$body['store_url']  = get_site_url();
		$args['body']       = wp_json_encode($body);

		return apply_filters('spocket_http_args', $args, $url);
	}

	/**
	 * Intercepts response and stores an auth token.
	 *
	 * @param array http request response
	 * @param array http args
	 * @param string url
	 * @return array untouched http request response
	 */
	public static function maybeSaveSpocketAuthToken( $response, $r, $url) {
		$urlHost = parse_url($url, PHP_URL_HOST);

		if (!getenv('IS_DEV') && 'spocket.co' !== $urlHost && substr($urlHost, -11) !== '.spocket.co') {
			return $response;
		}

		if (is_wp_error($response) || intval($response['response']['code']) !== 200) {
			return $response;
		}

		$body = json_decode($response['body'], true);

		if (!is_array($body)) {
			return $response;
		}

		if (!isset($body['auth_token'])) {
			return $response;
		}

		update_option('spocket_auth_token', $body['auth_token'], false);
		update_option('spocket_connected', true, false);
		return $response;
	}

	/**
	 * Disconnects Spocket from the store.
	 *
	 * @return boolean
	 */
	public static function disconnectSpocket () {
		global $wpdb;

		update_option('spocket_connected', false, false);

		$spocketKey = self::$object->getSpocketConsumerSecret();

		if (empty($spocketKey)) {
			return true;
		}

		$consumerSecret = $spocketKey->consumer_secret;
		$userId         = get_option('spocket_user_id', '');
		$wpdb->query(
			"
                DELETE
                FROM {$wpdb->prefix}woocommerce_api_keys
                WHERE description LIKE '%spocket%'
            "
		);

		if (empty($userId)) {
			return true;
		}

		$deleteIntegrationResponse = wp_remote_request(
			sprintf(
				self::$object->plugin->getApiURL() . '/woocommerce/integration?user_id=%s&consumer_secret=%s',
				$userId,
				$consumerSecret
			),
			array(
				'method' => 'DELETE',
			)
		);

		return true;
	}

	/**
	 * Saves the user id to the database upon successful Spocket connection.
	 *
	 * @return void
	 */
	public function maybeSaveUserId() {
		if (!isset($_GET['success']) || !isset($_GET['user_id'])) {
			return;
		}

		if (intval($_GET['success']) !== 1) {
			return;
		}

		$savedUserId = get_option('spocket_user_id', '');
		$newUserId   = sanitize_text_field($_GET['user_id']);

		if ($savedUserId === $newUserId) {
			return;
		}

		update_option('spocket_user_id', $newUserId, false);
	}

	/**
	 * Saves spocket_shop_url if the option is empty on wp_options table.
	 *
	 * @return void
	 */
	public static function saveShopUrl() {
		$shopUrl  = get_option('spocket_shop_url', '');
		$site_url = get_site_url();
		if ('' === $shopUrl) {
			update_option('spocket_shop_url', $site_url, false);
		}
	}


	/**
	 * Finishes the Direct Signup process
	 *
	 * @return void
	 */
	public static function finishDirectSignup( $storeAuthorizationKey) {
		/**
		* Authorization key generated when the user signs up through
		* direct signup process.
		* PS. That is not our Spocket Auth Token key.
		*/
		if ('' !== $storeAuthorizationKey) {
			update_option('spocket_store_authorization_key', $storeAuthorizationKey, false);
		}

		return true;
	}

	/**
	 * Add the spocket_shop_url to webhook payload.
	 *
	 * @return $payload
	 */
	public function addAdditionalParamsToWebhookPayload( $payload) {
		$shopUrl                                = get_option('spocket_shop_url', '');
		$payload['spocket_shop_url']            = $shopUrl;
		$payload['spocket_plugin_version']      = $this->plugin->getVersion();
		$payload['spocket_integrated_store_id'] = get_option('spocket_user_id', '');

		return $payload;
	}

	/**
	 * Just a over write for the Webhook disable rule
	 * to explain that, the webhooks have a limit of 5 failed requests,
	 * after that the webhooks will be disabled on its own.
	 */
	public function overruleWebhookDisableRule() {
		return 999999999999;
	}

	/**
	 * Action to create a collection on Spocket when it's created on WooCommerce
	 */
	public function createCategoryOnSpocket( $category_id) {
		$category         = $this->getProductCategory($category_id);
		$spocketAuthToken = get_option('spocket_auth_token');

		$requestBody = array(
			'collection' => array(
				'uid'    => $category_id,
				'title'  => $category->name,
				'handle' => $category->slug
			)
		);

		if (!empty($spocketAuthToken)) {
			wp_safe_remote_post(
				$this->plugin->getApiURL() . '/dropshippers/woocommerces/collections',
				array(
					'headers' => array(
						'Content-Type' => 'application/json',
						'Authorization' => 'Bearer ' . $spocketAuthToken
					),
					'body' => json_encode($requestBody)
				)
			);
		}
	}

	public function deleteCategoryOnSpocket( $category_id) {
		$category         = $this->getProductCategory($category_id);
		$spocketAuthToken = get_option('spocket_auth_token');

		if (!empty($spocketAuthToken)) {
			wp_remote_request(
				$this->plugin->getApiURL() . '/dropshippers/woocommerces/collections',
				array(
					'method' => 'DELETE',
					'headers' => array(
						'Content-Type' => 'application/json',
						'Authorization' => 'Bearer ' . $spocketAuthToken
					),
					'body' => json_encode(array('uid' => $category_id))
				)
			);
		}
	}

	/**
	 * Registers filters and actions.
	 *
	 * @return void
	 */
	public function run() {
		self::saveShopUrl(); // save spocket_shop_url

		add_filter('http_request_args', array($this, 'fillInSpocketData'), 10, 2);
		add_filter('http_response', array($this, 'maybeSaveSpocketAuthToken'), 10, 3);
		add_action('spocket_before_interface', array($this, 'maybeSaveUserId'));

		// change default woocommerce webhook requests
		add_filter('woocommerce_webhook_payload', array($this, 'addAdditionalParamsToWebhookPayload'), 10, 3);

		// overrule woocommerce disable webhooks rule
		add_filter( 'woocommerce_max_webhook_delivery_failures', array($this, 'overruleWebhookDisableRule'));

		// create category on Spocket
		add_action('create_product_cat', array($this, 'createCategoryOnSpocket'));

		// delete category on Spocket
		add_action('delete_product_cat', array($this, 'deleteCategoryOnSpocket'));
	}
}
