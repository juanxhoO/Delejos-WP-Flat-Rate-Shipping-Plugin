(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function (jQuery) {
		jQuery("#shipping_city").on("change", function () {
			console.log(jQuery(this).val());
			var city = jQuery(this).val();
			var body_req = {
				action: 'update_shipping_rates',
				city: city
			}

			//Evaluate if Country have states or is empty 
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: body_req,
				success: function (data) {
					console.log(data);
				}

			})
		})

		
		jQuery("#shipping_country").on("change", function () {

			//Añadir Logica para ver si no tiene estados, si no tiene etados se retorna todas las ciudades adjuntadas al Pais 
			var country = jQuery(this).val();
			var body_req = {
				action: 'update_shipping_rate',
				country: country
			}

			console.log(country);

			// jQuery.ajax({
			// 	type: 'POST',
			// 	url: ajax_object.ajax_url,
			// 	data: body_req,
			// 	success: function (data) {
			// 		console.log(data);
			// 	}
			// })

		})

		jQuery("#shipping_state").on("change", function () {
			console.log(jQuery(this).val());

			var state = jQuery(this).val();
			var body_req = {
				action: 'get_cities',
				state: state
			}

			jQuery.ajax({
				type: 'POST',
				url: ajax_object.ajax_url,
				data: body_req,
				success: function (data) {
					console.log(data);
				}

			})
		})
	})


	function get_cities(state,country) {
		var body_req = {
			action: 'get_cities',
			state: state,
			country: country
		}

		jQuery.ajax({
			type: 'POST',
			url: ajax_object.ajax_url,
			data: body_req,
			success: function (data) {
				console.log(data);
			}

		})
	}

})(jQuery);
