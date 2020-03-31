<?php

namespace Spocket\Webhook;

class CurrencyUpdate {

	private $webhook;

	private static $object = null;

	public function __construct( Data $webhook) {
		self::$object  = $this;
		$this->webhook = new \WC_Webhook($webhook->find_webhook_by_topic('action.woocommerce_settings_saved'));
	}

	/**
	 * AddCurrencyUpdateTopicHook will add a new webhook topic hook.
	 *
	 * @param array $topic_hooks Esxisting topic hooks.
	 */
	public static function addCurrencyUpdateTopicHook( $topic_hooks) {
		$new_hooks = array(
			'action.woocommerce_settings_saved' => array(
				'woocommerce_currency_updated',
			),
		);

		return array_merge($topic_hooks, $new_hooks);
	}

	public static function currencyUpdateEvent( $topic_events) {
		$new_events = array(
			'woocommerce_settings_saved',
		);

		return array_merge($topic_events, $new_events);
	}


	public static function addCurrencyUpdateTopicToMenu( $topics) {
		$new_topics = array(
			'action.woocommerce_settings_saved' => __( 'Currency Update', 'woocommerce' ),
		);

		return array_merge( $topics, $new_topics );
	}

	public static function addCurrencyToWebhookPayload( $payload) {
		if (array_key_exists('action', $payload) && 'woocommerce_settings_saved' == $payload['action']) {
			$payload['id']       = self::$object->webhook->get_new_delivery_id();
			$payload['currency'] = get_woocommerce_currency();
		}

		return $payload;
	}

	public function run() {
		add_filter('woocommerce_webhook_topic_hooks', array($this, 'addCurrencyUpdateTopicHook'), 10, 1);
		add_filter('woocommerce_valid_webhook_events', array($this, 'currencyUpdateEvent'), 10, 1);
		add_filter('woocommerce_webhook_topics', array($this, 'addCurrencyUpdateTopicToMenu'), 10, 1);
		add_filter('woocommerce_webhook_payload', array($this, 'addCurrencyToWebhookPayload'), 10, 2);
	}
}
