$(function() {
	var input_frombin = $('.binr-form').find('input[name=from-bin]');
	var input_tobin = $('.binr-form').find('input[name=to-bin]');
	var input_qty = $('.binr-form').find('input[name=qty]');
	
	$("body").on("click", ".choose-bin", function(e) {
		e.preventDefault();
		var binrow = $(this);
		var binID = binrow.data('binid');
		var qty = binrow.data('qty');
		var bindirection = binrow.data('direction');
		
		$('.binr-form').find('input[name='+bindirection+'-bin]').val(binID);
		$('.binr-form').find('input[name=qty]').val(qty);
		$('.binr-form').find('.qty-available').text(qty);
		binrow.closest('.list-group').parent().addClass('hidden');
	});
	
	$("body").on("change", "input[name=from-bin]", function(e) {
		e.preventDefault();
	});
	
	$("body").on("click", ".show-select-bins", function(e) {
		e.preventDefault();
		var button = $(this);
		var bindirection = button.data('direction');
		$('.choose-'+bindirection+'-bins').parent().removeClass('hidden').focus();
	});
	
	$("body").on("click", ".use-bin-qty", function(e) {
		e.preventDefault();
		var button = $(this);
		var bindirection = button.data('direction');
		var binID = $('.binr-form').find('input[name='+bindirection+'-bin]').val();
		var binqty = $('.choose-'+bindirection+'-bins').find('[data-binid="'+binID+'"]').data('qty');
		$('.binr-form').find('.qty-available').text(binqty);
		$('.binr-form').find('input[name=qty]').val(binqty);
	});
	
	// $(".binr-form").validate({
	// 	submitHandler : function(form) {
	// 		if (input_frombin.val() == '') {
	// 			swal({
	// 				type: 'error',
	// 				title: 'Error',
	// 				text: 'Please Fill in the From Bin'
	// 			});
	// 		} else if (input_qty.val() == '') {
	// 			swal({
	// 				type: 'error',
	// 				title: 'Error',
	// 				text: 'Please fill in the Qty'
	// 			});
	// 		} else if (input_tobin.val() == '') {
	// 			swal({
	// 				type: 'error',
	// 				title: 'Error',
	// 				text: 'Please fill in the To Bin'
	// 			});
	// 		} else {
	// 			form.submit();
	// 		}
	// 	}
	// });
});
