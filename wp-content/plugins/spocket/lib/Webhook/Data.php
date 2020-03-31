<?php

namespace Spocket\Webhook;

class Data {

	private $table = 'wc_webhooks';

	public function find_webhook_by_topic( $topic) {
		global $wpdb;

		$tableName = $wpdb->prefix . $this->table;

		return $wpdb->get_row($wpdb->prepare('select * from `%1$s` where topic = "%2$s"', $tableName, $topic));
	}
}
