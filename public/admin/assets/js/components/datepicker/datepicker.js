(function($) {

	'use strict';

	// ------------------------------------------------------- //
	// Datepicker
	// ------------------------------------------------------ //
	$(function() {
		// default date range picker
		$('#daterange').daterangepicker({
			autoApply : true
		});

		// date time picker
		$('#datetime').daterangepicker({
			minDate : today,
			timePicker : true,
			timePickerIncrement : 60,
			locale : {
				format : 'MM/DD/YYYY h:mm A'
			}
		});

		// single date
		$('#date').daterangepicker({
			singleDatePicker : true,
		});
	});

})(jQuery);