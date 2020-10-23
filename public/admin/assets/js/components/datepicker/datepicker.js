(function ($) {

    'use strict';
	
    // ------------------------------------------------------- //
    // Datepicker
    // ------------------------------------------------------ //	
	$(function () {
		//default date range picker
		$('#daterange').daterangepicker({
			autoApply:true
		});

		//date time picker
		$('#datetime').daterangepicker({
			minDate: -1,
			timePicker: true,
			timePickerIncrement: 10,
			locale: {
				format: 'MM/DD/YYYY h:mm A'
			}
		});

		//single date
		$('#date').daterangepicker({
			singleDatePicker: true,
		});
	});
	
})(jQuery);