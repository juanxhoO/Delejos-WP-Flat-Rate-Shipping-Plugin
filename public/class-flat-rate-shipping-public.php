<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sds
 * @since      1.0.0
 *
 * @package    Flat_Rate_Shipping
 * @subpackage Flat_Rate_Shipping/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Flat_Rate_Shipping
 * @subpackage Flat_Rate_Shipping/public
 * @author     Juan Granja <ggjuanb@hotmail.com>
 */
class Flat_Rate_Shipping_Public
{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Flat_Rate_Shipping_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Flat_Rate_Shipping_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/flat-rate-shipping-public.css', array(), '1.1.1', 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Flat_Rate_Shipping_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Flat_Rate_Shipping_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/flat-rate-shipping-public.js', array('jquery'), '1.1.1', false);
		wp_localize_script($this->plugin_name, 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')), '1.0.1', false);

		if (is_cart() || is_checkout()) {
			// This is the checkout page
			wp_enqueue_script($this->plugin_name . 'checkout', plugin_dir_url(__FILE__) . 'js/checkout-shipping-updater.js', array('jquery'), '1.1.1', false);
		}
	}


	public function update_shipping_rate($rates)
	{
		foreach ($rates as $rate) {
			echo ($rate);
			error_log(print_r($rates, true));
			$cost = $rate->cost;
			$rate->cost = 15;
		}
		wp_send_json_success("Row updated successfully.", 200);
		return $rates;
	}

	public function get_cities(){
		wp_send_json_success("Row updated successfully.", 200);
	}


	function change_flat_rate_cost($rates, $package) {
		// Output rates on the checkout page
		echo '<pre>';
		print_r($rates);
		echo '</pre>';
	
		// foreach ($rates as $key => $rate) {
		// 	if ('flat_rate' === $rate->method_id) {
		// 		$rates[$key]->cost = 11;
		// 	}
		// }
	
		//return $rates;
	}
	
}
