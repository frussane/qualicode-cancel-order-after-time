<?php

/**
 * Fired during plugin activation
 *
 * @link       https://qualicode.pt
 * @since      1.0.0
 *
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/includes
 * @author     Qualicode <geral@qualicode.pt>
 */
class Qualicode_CancelOrderAfterTime_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	    $optionsSet = get_option('qualicode-coat-order-statuses');
	    if(!$optionsSet){
            $activeStatus = array('wc-pending','wc-on-hold');
            update_option('qualicode-coat-order-statuses', json_encode($activeStatus));
        }
	}
}
