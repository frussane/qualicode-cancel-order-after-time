<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://qualicode.pt
 * @since             1.0.0
 * @package           Qualicode_CancelOrderAfterTime
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Cancel Order After Expiry Time
 * Plugin URI:        https://qualicode.pt
 * Description:       Allows to define an expiring time for WooCommerce orders based on payment used
 * Version:           1.0.0
 * Author:            Qualicode
 * Author URI:        https://qualicode.pt
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       qualicode-cancel-order-after-time
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'Qualicode_CancelOrderAfterTime_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-qualicode-cancel-order-after-time-activator.php
 */
function activate_Qualicode_CancelOrderAfterTime() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-qualicode-cancel-order-after-time-activator.php';
	Qualicode_CancelOrderAfterTime_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-qualicode-cancel-order-after-time-deactivator.php
 */
function deactivate_Qualicode_CancelOrderAfterTime() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-qualicode-cancel-order-after-time-deactivator.php';
	Qualicode_CancelOrderAfterTime_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Qualicode_CancelOrderAfterTime' );
register_deactivation_hook( __FILE__, 'deactivate_Qualicode_CancelOrderAfterTime' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-qualicode-cancel-order-after-time.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Qualicode_CancelOrderAfterTime() {

	$plugin = new Qualicode_CancelOrderAfterTime();
	$plugin->run();
}


run_Qualicode_CancelOrderAfterTime();
