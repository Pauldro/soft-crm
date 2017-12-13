$(function() {
	$('.screen-formatter-form').submit(function(e) {
		e.preventDefault();
		var form = $(this);
		console.log(form.serialize());
		form.find('[name=action]').val('save-formatter');
		// swal({
		// 	title: "Error!",
		// 	text: json.response.message,
		// 	type: "warning",
		// 	showCancelButton: true,
		// 	confirmButtonText: "Yes, overwrite it",
		// 	cancelButtonText: "Cancel",
		// 	html: true
		// },
		// function(isConfirm){
		// 	if (isConfirm) {
        // 
		// 		$(formid).postform({formdata: false, jsoncallback: true, html: true}, function(json) {
		// 			$.notify({
		// 				icon: json.response.icon,
		// 				message: json.response.message,
		// 			},{
		// 				type: json.response.notifytype
		// 			});
		// 		});
		// 	} 
		// });
	});
});

function preview_tableformatter(formidentifier) {
	var form = $(formidentifier);
	form.find('[name=action]').val('preview');
	
	form.postform({jsoncallback: true, html: true}, function(html) {
		var title = form.find('.panel-title').text();
		$(config.modals.ajax).find('.modal-body').addClass('modal-results').html(html);
		$(config.modals.ajax).find('.modal-title').text('Previewing ' + title + ' Formatter');
		$(config.modals.ajax).resizemodal('xl').modal();
		
	});
}
