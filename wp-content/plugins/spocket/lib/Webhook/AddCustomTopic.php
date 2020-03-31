<?php

namespace Spocket\Webhook;

class AddCustomTopic {

	private $topic;
	private $name;
	private $deliveryEndpoint;
	private $apiUrl;

	private function getSecret() {
		global $wpdb;

		return $wpdb->get_row($wpdb->prepare('select secret from `%1$s` where status = "active" limit 1', $this->table));
	}

	private function queryTopic() {
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare('select secret from `%1$s` where status = "active" and topic = "%2$s"', $this->table, $this->topic));
	}

	public function __construct( $name, $topic, $deliveryEndpoint) {
		global $wpdb;

		$this->name             = $name;
		$this->topic            = $topic;
		$this->deliveryEndpoint = $deliveryEndpoint;
		$this->apiUrl           = !empty(getenv('API_URL')) ? getenv('API_URL') : 'https://newapi.spocket.co/';
		$this->table            = "{$wpdb->prefix}wc_webhooks";
	}

	public function add() {
		if (!empty($this->getSecret())) {
			$secret      = $this->getSecret()->secret;
			$query_topic = $this->queryTopic();
			
			if (!empty($secret) && empty($query_topic)) {
				$webhook = new \WC_Webhook();
				$webhook->set_props(array(
					'secret'           => $secret,
					'status'           => 'active',
					'api_version'      => 2,
					'name'             => $this->name,
					'delivery_url'     => $this->apiUrl . '/' . $this->deliveryEndpoint,
					'topic'            => $this->topic,
					'user_id'          => get_current_user_id()
				));

				$webhook->save();
			}
		}
	}

	public function run() {
		add_action('admin_init', array($this, 'add'));
	}
}
