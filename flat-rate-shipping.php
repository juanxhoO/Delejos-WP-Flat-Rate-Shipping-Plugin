<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sds
 * @since             1.0.0
 * @package           Flat_Rate_Shipping
 *
 * @wordpress-plugin
 * Plugin Name:       Delejos-WP-Flat-Rate-Shipping-Plugin
 * Plugin URI:        https://dsd
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Juan Granja
 * Author URI:        https://sds/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       flat-rate-shipping
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
define( 'FLAT_RATE_SHIPPING_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-flat-rate-shipping-activator.php
 */
function activate_flat_rate_shipping() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flat-rate-shipping-activator.php';
	Flat_Rate_Shipping_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-flat-rate-shipping-deactivator.php
 */
function deactivate_flat_rate_shipping() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flat-rate-shipping-deactivator.php';
	Flat_Rate_Shipping_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_flat_rate_shipping' );
register_deactivation_hook( __FILE__, 'deactivate_flat_rate_shipping' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-flat-rate-shipping.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_flat_rate_shipping() {

	$plugin = new Flat_Rate_Shipping();
	$plugin->run();

}
run_flat_rate_shipping();
