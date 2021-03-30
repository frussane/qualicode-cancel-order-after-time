<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://qualicode.pt
 * @since      1.0.0
 *
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/includes
 * @author     Qualicode <geral@qualicode.pt>
 */
class Qualicode_CancelOrderAfterTime_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}


	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

        //update the timestamp of the order status
        add_action('woocommerce_order_status_changed', 'qualicode_order_status_change_custom', 10, 3);
        function qualicode_order_status_change_custom($order_id, $old_status, $new_status) {
            $activeStatuses = json_decode(get_option('qualicode-coat-order-statuses'));
            if(in_array($new_status, str_replace('wc-','', $activeStatuses))){
                update_post_meta($order_id, 'qualicode-coat-time-on-pending', current_time('timestamp') );
            }
        }

        //update the timestamp of the order status
        add_action( 'woocommerce_new_order', 'create_invoice_for_wc_order',  1, 1  );
        function create_invoice_for_wc_order( $order_id ) {
            $order          = new WC_Order( $order_id );
            $status         = $order->get_status();
            $activeStatuses = json_decode(get_option('qualicode-coat-order-statuses'));
            if(in_array($status, str_replace('wc-','', $activeStatuses))){
                update_post_meta($order_id, 'qualicode-coat-time-on-pending', current_time('timestamp') );
            }
        };

        //send cancellation e-mail for order
        add_action('woocommerce_order_status_changed', 'send_custom_email_notifications', 10, 4 );
        function send_custom_email_notifications( $order_id, $old_status, $new_status, $order ){
            if ( $new_status == 'cancelled'){
                $wc_emails = WC()->mailer()->get_emails(); // Get all WC_emails objects instances
                $customer_email = $order->get_billing_email(); // The customer email

                $wc_emails['WC_Email_Cancelled_Order']->recipient = $customer_email;
                $wc_emails['WC_Email_Cancelled_Order']->trigger( $order_id );
            }
        }


    }

}
