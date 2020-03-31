<?php

namespace Spocket;

/**
 * Responsible for setting up backend functionality
 */
class Backend {

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
	 * Runs the class.
	 *
	 * @return void
	 */
	public function run() {
		$BackendAssets = new \Spocket\Backend\Assets($this->plugin);
		$BackendAssets->run();
		$BackendScreen = new \Spocket\Backend\Screen($this->plugin);
		$BackendScreen->run();
	}
}
