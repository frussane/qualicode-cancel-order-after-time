<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://qualicode.pt
 * @since      1.0.0
 *
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/includes
 * @author     Qualicode <geral@qualicode.pt>
 */
class Qualicode_CancelOrderAfterTime_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'qualicode-cancel-order-after-time',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
