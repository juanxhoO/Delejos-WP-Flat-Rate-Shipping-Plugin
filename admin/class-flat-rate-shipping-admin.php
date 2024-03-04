<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sds
 * @since      1.0.0
 *
 * @package    Flat_Rate_Shipping
 * @subpackage Flat_Rate_Shipping/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Flat_Rate_Shipping
 * @subpackage Flat_Rate_Shipping/admin
 * @author     Juan Granja <ggjuanb@hotmail.com>
 */
class Flat_Rate_Shipping_Admin
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
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.1
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/flat-rate-shipping-admin.css', array(), '1.1.1', 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/flat-rate-shipping-admin.js', array('jquery'), $this->version, false);
	}


	public function flat_rate_admin_menu()
	{
		add_menu_page(
			'Custom Admin Section',
			'Flat Rate Shipping',
			'manage_options',
			// Minimum capability required to access
			'flat-rate-shipping',
			array($this, 'custom_admin_page_content'),
			'dashicons-car' // Icon for the menu item (optional)
		);
	}


	public function custom_admin_page_content()
	{
?>
		<div class="custom-shipping-content">
			<h3>
				<?php _e('Custom Shipping Section Content', 'your-text-domain'); ?>
			</h3>
			<!-- Add your form or inputs here -->
			<form method="post" action="">
				<label for="name">Name</label>
				<input type="text" id="name" name="name" required />

				<label for="country_selector">Country</label>
				<select name="country_selector" required>
					<option value="">Select Country</option>

					<?php
					$countries = WC()->countries->get_allowed_countries();

					foreach ($countries as $code => $name) {
						echo '<option value="' . esc_attr($code) . '">' . esc_html($name) . '</option>';
					}
					?>
				</select>

				<label for="flat_rate_price">Flat Rate Price</label>
				<input type="number" step="0.01" id="price" name="flat_rate_price" required /><br />
				<input type="submit" name="custom_shipping_submit" value="Agregar Ciudad">
			</form>

			<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_shipping_submit'])) {
				global $wpdb;
				$table_name = $wpdb->prefix . 'custom_cities';

				// Retrieve form data and sanitize
				$name = sanitize_text_field($_POST['name']);
				$country_code = sanitize_text_field($_POST['country_selector']);
				$flat_rate_price = floatval($_POST['flat_rate_price']); // Convert to float

				//Check if The City is already in the table
				$exists = $wpdb->get_var($wpdb->prepare("SELECT city_name FROM $table_name WHERE city_name = %s", $name));
				echo ($exists);
				if ($exists === $name) {
					// The city already exists, handle this case (e.g., show an error message).
					echo '<div class="error-message">City already exists!</div>';
				} else {
					// Insert data into the custom table
					$wpdb->insert(
						$table_name,
						array(
							'city_name' => $name,
							'country_code' => $country_code,
							'flat_rate' => $flat_rate_price,
						),
						array('%s', '%s', '%f')
					);
				}

				// Optionally, redirect or display a success message
				// Example: wp_redirect('success-page.php');
				// or
				// echo '<div class="success-message">Form submitted successfully!</div>';
			}
			?>
		</div>
<?php
		$this->display_cities_by_country();
	}


	public function display_cities_by_country()
	{
		global $wpdb;

		$table_name = $wpdb->prefix . 'custom_cities';

		// Retrieve cities and countries from the custom table
		$results = $wpdb->get_results("SELECT city_name, country_code, flat_rate, ID FROM $table_name", ARRAY_A);

		if (!empty($results)) {
			echo '<form method="post" action="">';
			echo '<label for="country_select">Select a Country:</label>';
			echo '<select name="country" id="country_select">';
			echo '<option value="all">All Countries</option>';

			// Create an array to store cities by country
			$cities_by_country = array();

			foreach ($results as $row) {
				$city = esc_html($row['city_name']);
				$country = esc_html($row['country_code']);
				$price = number_format(doubleval($row['flat_rate']), 2); // 2 specifies the number of decimal places			echo($price);
				$id = intval($row['ID']);
				// Store cities in an array by country
				if (!isset($cities_by_country[$country])) {
					$cities_by_country[$country] = array();
				}
				$cities_by_country[$country][] = array('city' => $city, 'price' => $price, 'id' => $id);
			}

			// Generate the select options for countries
			$countries = WC()->countries->get_countries();
			foreach ($cities_by_country as $country_code => $cities) {
				echo '<option value="' . esc_attr($country_code) . '">' . esc_html($countries[$country_code]) . '</option>';
			}

			echo '</select>';
			echo '<input type="submit" name="update_prices" value="Ver Ciudades">';
			echo '</form>';

			// Display cities based on the selected country
			echo '<div id="cities_display">';
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['country'])) {
				$selected_country = sanitize_text_field($_POST['country']);
				if ($selected_country !== 'all' && isset($cities_by_country[$selected_country])) {
					echo '<div class="country-cities" data-country="' . esc_attr($selected_country) . '">';
					foreach ($cities_by_country[$selected_country] as $city_data) {
						echo '<p class="col-12">';
						echo '<strong>' . esc_html($city_data['city']) . ':</strong> ';
						echo '<input type="text" step="0.01" class="edit-price" value="' . esc_attr($city_data['price']) . '">';
						echo '<button data-value="' . esc_attr($city_data['id']) . '" class="delete-city">Delete</button>';
						echo '<button data-value="' . esc_attr($city_data['id']) . '" class="update-city">Update</button>';
						echo '</p>';
					}
					echo '</div>';
				}
			}
			echo '</div>';
		} else {
			echo '<p>No cities and countries found.</p>';
		}
	}
}
