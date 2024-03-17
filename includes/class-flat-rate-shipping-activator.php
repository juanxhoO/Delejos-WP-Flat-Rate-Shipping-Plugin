<?php

/**
 * Fired during plugin activation
 *
 * @link       https://sds
 * @since      1.0.0
 *
 * @package    Flat_Rate_Shipping
 * @subpackage Flat_Rate_Shipping/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Flat_Rate_Shipping
 * @subpackage Flat_Rate_Shipping/includes
 * @author     Juan Granja <ggjuanb@hotmail.com>
 */
class Flat_Rate_Shipping_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'custom_cities';
		
		// Check if the table already exists
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		
			$sql = "CREATE TABLE $table_name (
				id INT NOT NULL AUTO_INCREMENT,
				cityId VARCHAR(255) NOT NULL,
				countryCode VARCHAR(4) NOT NULL,
				stateCode VARCHAR(4) NOT NULL,
				price DECIMAL(10,2) NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (stateCode) REFERENCES states(stateCode),
				FOREIGN KEY (cityId) REFERENCES cities(cityId)
			)";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		
	}

}
