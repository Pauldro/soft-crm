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
						getquoteheadresults(qnbr, formid, function() {

						});
					}
				});
			});
		}
	});

	$(".page").on("change", "#quotehead-form .shipto-select", function(e) {
		e.preventDefault();
		var custid = $(this).data('custid');
		var shiptoid = $(this).val();
		var jsonurl = config.urls.json.getshipto+"?custID="+urlencode(custid)+"&shipID="+urlencode(shiptoid);
		$.get(jsonurl, function(json) {
			var shipto = json.response.shipto;
			$('.shipto-select').val(shiptoid); $('.shipto-name').val(shipto.name); $('.shipto-address').val(shipto.addr1);
			$('.shipto-address2').val(shipto.addr2);
			$('.shipto-city').val(shipto.ccity); $('.shipto-state').val(shipto.cst); $('.shipto-zip').val(shipto.czip);
		});
	});

	$(".page").on("click", "#quotehead-form .save-unlock-quotehead", function(e) {
		e.preventDefault();
		var form = $(this).closest('form');
		var formid = '#'+form.attr('id');

		var qnbr = form.find('#qnbr').val();
		console.log(formid);
		console.log(qnbr);
		var custid = form.find('.shipto-select').data('custid');
		if (form.formiscomplete('tr')) {
			$(formid).postform({formdata: false, jsoncallback: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				$.notify({
					icon: "glyphicon glyphicon-floppy-disk",
					message: "Your quotehead changes have been submitted",
				},{
					type: "info",
					onClose: function() {
						getquoteheadresults(qnbr, formid, function() {
							window.location.href = config.urls.customer.page + urlencode(custid) + "/";
						});
					}
				});
			});
		}

	});
});



function getquoteheadresults(qnbr, form, callback) {
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
				onClose: function() {
					callback();
				}
			});
		}
	});
}
