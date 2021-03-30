<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://qualicode.pt
 * @since      1.0.0
 *
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/admin
 * @author     Qualicode <geral@qualicode.pt>
 */
class Qualicode_CancelOrderAfterTime_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;


        /**
         * Check if WooCommerce is active
         **/
        if (
        !in_array(
            'woocommerce/woocommerce.php',
            apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
        )
        ) {
            function sample_admin_notice__error() {
                ?>
                <div class="notice notice-error">
                    <p><?php _e( 'WooCommerce is not activated. Please activate to use Order cancel times plugin', 'qualicode-cancel-order-after-time' ); ?></p>
                </div>
                <?php
            }
            add_action( 'admin_notices', 'sample_admin_notice__error' );
        }

        return;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Qualicode_CancelOrderAfterTime_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Qualicode_CancelOrderAfterTime_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/qualicode-cancel-order-after-time-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Qualicode_CancelOrderAfterTime_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Qualicode_CancelOrderAfterTime_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/qualicode-cancel-order-after-time-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function register_admin_menu(){

        add_submenu_page('woocommerce', __('Order cancel times','qualicode-cancel-order-after-time'), __('Order cancel times','qualicode-cancel-order-after-time'), 'administrator',
            $this->plugin_name.'-settings', array( $this, 'displayPluginAdminSettings' ));
    }

    public function displayPluginAdminDashboard() {
        require_once 'partials/'.$this->plugin_name.'-admin-display.php';
    }

    public function displayPluginAdminSettings() {
        // set this var to be used in the settings-display view
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
        if(isset($_GET['error_message'])){
            add_action('admin_notices', array($this,'pluginNameSettingsMessages'));
            do_action( 'admin_notices', $_GET['error_message'] );
        }
        require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
    }

    public function pluginNameSettingsMessages($error_message){
        switch ($error_message) {
            case '1':
                $message = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'my-text-domain' );
                $err_code = esc_attr( 'plugin_name_example_setting' );
                $setting_field = 'plugin_name_example_setting';
                break;
        }
        $type = 'error';
        add_settings_error(
            $setting_field,
            $err_code,
            $message,
            $type
        );
    }

}
