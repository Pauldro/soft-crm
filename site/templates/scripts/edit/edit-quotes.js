$(function() {
	$('#quotehead-form').submit(function(e) {
		e.preventDefault();
		var formid = '#'+$(this).attr('id');
		var qnbr = $(this).find('#qnbr').val();
		if ($(this).formiscomplete('tr')) {
			$(formid).postform({formdata: false, jsoncallback: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				$.notify({
					icon: "glyphicon glyphicon-floppy-disk",
					message: "Your quotehead changes have been submitted",
				},{
					type: "info",
					onClose: function() {
						getquoteheadresults(qnbr, formid);
					}
				});
			});
		}
	});
});

function getquoteheadresults(qnbr, form) {
	console.log(config.urls.json.getquotehead+"?qnbr="+qnbr);
	$.getJSON(config.urls.json.getquotehead+"?qnbr="+qnbr, function( json ) {
		if (json.response.quote.error === 'Y') {
			createalertpanel(form + ' .response', json.response.quote.errormsg, "<i span='glyphicon glyphicon-floppy-remove'> </i> Error! ", "danger");
			$('html, body').animate({scrollTop: $(form + ' .response').offset().top - 120}, 1000);
		} else {
			$.notify({
				icon: "glyphicon glyphicon-floppy-saved",
				message: "Your quotehead changes have been saved" ,
			},{
				type: "success",
				onShow: function() {
					//$('#quotedetail-link').click();
				}
			});
		}
	});
}
