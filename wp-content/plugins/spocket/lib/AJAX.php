<?php

namespace Spocket;

/**
 * Responsible for setting up AJAX functionality
 */
class AJAX {

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
		$AJAXRequirements = new \Spocket\AJAX\Requirements($this->plugin);
		$AJAXRequirements->run();
		$AJAXSpocket = new \Spocket\AJAX\Spocket($this->plugin);
		$AJAXSpocket->run();
	}
}
