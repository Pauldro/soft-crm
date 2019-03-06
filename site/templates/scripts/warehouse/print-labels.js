$(function() {
	var printlabelform = $('#print-label-form');

	/**
	 * The Order of Functions based on Order of Events
	 * 1. Select Label Format
	 * 2. Select Printer
	 * 3. Validate form on Submit
	 */

/////////////////////////////////////
// 1. Select Label Format
////////////////////////////////////
	$('#labelformats-modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var inputname = button.data('input'); // Extract info from data-* attributes
		var modal = $(this);
		modal.attr('data-input', inputname);
	});

	$("body").on("click", ".select-labelformat", function(e) {
		e.preventDefault();
		var button  = $(this);
		var labelID = button.find('.format-id').text();
		var desc    = button.find('.format-desc').text();
		var modal   = button.closest('.modal');
		var inputname = modal.attr('data-input');
		var input = printlabelform.find('input[name="'+inputname+'"]');
		input.val(labelID);
		input.closest('.label-input').find('.label-desc').text(desc);
		modal.modal('hide');
	});

/////////////////////////////////////
// 1. Select Printer
////////////////////////////////////
	$('#labelprinters-modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var inputname = button.data('input'); // Extract info from data-* attributes
		var modal = $(this);
		modal.attr('data-input', inputname);
	});

	$("body").on("click", ".select-labelprinter", function(e) {
		e.preventDefault();
		var button  = $(this);
		var labelID = button.find('.printer-id').text();
		var desc    = button.find('.printer-desc').text();
		var modal   = button.closest('.modal');
		var inputname = modal.attr('data-input');
		var input = printlabelform.find('input[name="'+inputname+'"]');
		input.val(labelID);
		input.closest('.printer-input').find('.printer-desc').text(desc);
		modal.modal('hide');
	});

/////////////////////////////////////
// 3. Validate form
////////////////////////////////////
	$("#print-label-form").validate({
		errorClass: "has-error",
		submitHandler : function(form) {
			var isformcomplete = printlabelform.formiscomplete('tr');

			if (isformcomplete) {
				form.submit();
			}
		}
	});
});
