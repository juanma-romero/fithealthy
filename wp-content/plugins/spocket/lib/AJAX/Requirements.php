<?php

namespace Spocket\AJAX;

use \Spocket\Common\Requirements as CommonRequirements;

/**
 * Handles AJAX requests related to plugin requirements
 */
class Requirements {

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
	public function getRequirementsStatus() {
		check_ajax_referer('spocket-get-requirements-status-nonce', 'nonce');
		$requirementsStatus = CommonRequirements::getRequirementsStatus();
		wp_send_json_success(array(
			'requirementsStatus' => $requirementsStatus,
		));
	}

	/**
	 * Registeres and enqueues assets.
	 *
	 * @return void
	 */
	public function run() {
		add_action('wp_ajax_spocket_requirements_status', array($this, 'getRequirementsStatus'));
	}
}
