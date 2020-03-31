<?php

namespace Spocket;

/**
 * Responsible for setting up functionality on both frontend and the backend
 */
class Common {

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
		$CommonSpocket = new \Spocket\Common\Spocket($this->plugin);
		$CommonSpocket->run();
	}
}
