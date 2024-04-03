(function ($) {
	'use strict';
	/**
	 * All of the code for your admin-facing JavaScript source
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

	jQuery(document).ready(function ($) {
		$('#country_select').on('change', function () {
			var selectedCountry = $(this).val();
			$('.country-cities').hide(); // Hide all city containers

			if (selectedCountry === 'all') {
				$('.country-cities').show(); // Show all cities if 'All Countries' selected
			} else {
				$('.country-cities[data-country="' + selectedCountry + '"]').show(); // Show cities for the selected country
			}
		});

		jQuery(".delete-city").on("click", delete_city);
		function delete_city() {
			var id = jQuery(this).attr('data-value');
			var data = {
				action: 'delete_city',
				id: id
				// 'whatever': ajax_object.we_value      // We pass php values differently!
			};
			// // We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.post(ajax_object.ajax_url, data, function (response) {
				console.log(response)

				//location.reload();
			});
		}

		jQuery(".update-city").on("click", update_city);

		function update_city() {
			var id = jQuery(this).attr('data-value');
			var new_price = jQuery(this).siblings('input.form-control').val();
			var data = {
				action: 'update_city',
				id: id,
				new_price: new_price
			};
			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.post(ajax_object.ajax_url, data, function (response) {
				console.log(response)
				location.reload();
			});
		}
	});
})(jQuery);
