$(function() {
	// BINR FORM INPUTS
	var input_bin = $('input[name=binID]');
	var form_physicalcount = $('.physical-count-form');
	
	$(".select-bin-form").validate({
		submitHandler : function(form) {
			update_total_count();
			var valid_form = new SwalError(false, '', '');
			var valid_bin = validate_binID();
			
			if (valid_bin.error) {
				valid_form = valid_bin;
			}
			
			if (valid_form.error) {
				swal({
					type: 'error',
					title: valid_form.title,
					text: valid_form.msg
				});
			} else {
				form.submit();
			}
		}
	});
	
	$("body").on("change", ".uom-value", function(e) {
		e.preventDefault();
		var input = $(this);
		var uomrow = input.closest('.uom-row');
		var unitqty = parseInt(uomrow.find('[data-unitqty]').data('unitqty'));
		var totalqty = unitqty * parseInt(input.val());
		uomrow.find('.uom-total-qty').text(totalqty);
		update_total_count();
	});
	
	$("body").on("focus", ".uom-value", function(e) {
		e.preventDefault();
		var input = $(this);
		input.val('');
	});
	
	$("body").on("focusout", ".uom-value", function(e) {
		e.preventDefault();
		var input = $(this);
		var uomrow = input.closest('.uom-row');
		var unitqty = parseInt(uomrow.find('[data-unitqty]').data('unitqty'));
		var totalqty = parseInt(uomrow.find('.uom-total-qty').text());
		var inputqty = totalqty / unitqty;
		
		if (input.val() == '') {
			input.val(inputqty);
		}
	});
	
	function update_total_count() {
		var totalqty = 0;
		var td_total = form_physicalcount.find('.physical-count-total');
		
		form_physicalcount.find('.uom-row').each(function() {
			var row = $(this);
			var row_totalqty = parseInt(row.find('.uom-total-qty').text());
			totalqty += row_totalqty;
		});
		td_total.text(totalqty);
	}
	
	function validate_binID() {
		var error = false;
		var title = '';
		var msg = '';
		var bin_lower = input_bin.val();
		input_bin.val(bin_lower.toUpperCase());
		
		if (input_bin.val() == '') {
			error = true;
			title = 'Error';
			msg = 'Please Fill in the Bin ID';
		} else if (whsesession.whse.bins.arranged == 'list' && whsesession.whse.bins.bins[input_bin.val()] === undefined) {
			error = true;
			title = 'Invalid Bin ID';
			msg = 'Please Choose a valid bin ID';
		} else if (whsesession.whse.bins.arranged == 'list' && input_bin.val() < whsesession.whse.bins.bins.from || input_bin.val() > whsesession.whse.bins.bins.through) {
			error = true;
			title = 'Invalid Bin ID';
			msg = 'Bin must be between ' + whsesession.whse.bins.bins.from + ' and ' + whsesession.whse.bins.bins.through;
		}
		return new SwalError(error, title, msg);
	}
});
