var custlookupform = "#ci-cust-lookup";

$(function() {
	$("body").on("focus", ".sweet-alert.show-input input", function(event) {
        console.log('focused');
        listener.stop_listening();
    });

	$(config.modals.ajax).on('hide.bs.modal', function(event) {
        listener.listen();
    });

    $(config.modals.ajax).on('shown.bs.modal', function(event) {
        listener.stop_listening();
		hidetoolbar();
    });

	listener.simple_combo("n", function() {toggleshipto();});

	$("body").on("submit", custlookupform, function(e) {
		e.preventDefault();
		var custid = $(this).find('.custid').val();
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var href = URI($(this).attr('action')).addQuery('q', custid).normalizeQuery().toString();
		showajaxloading();
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();

		});
	});


	$("body").on("submit", "#cust-sales-history-form", function(event) {
		event.preventDefault();
		var form = $(this);
		var custid = form.find('input[name=custID]').val();
		var shipid = form.find('input[name=shipID]').val();
		var startdate = form.find('input[name=date]').val();
		var shownotes = 'N';
		if (form.find('input[name=shownotes]').is(':checked')) { shownotes = 'Y'; }
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.customer.load.ci_saleshistory).addQuery("custID", custid)
																 .addQuery("shipID", shipid)
																 .addQuery("startdate", startdate)
																 .addQuery("shownotes", shownotes)
																 .toString();
		showajaxloading();
		ci_saleshistory(custid, shipid, startdate, function() {
			loadin(href, loadinto, function() {
				console.log(href);
				hideajaxloading();
				$(modal).resizemodal('lg').modal();
			});
		});
	});

	$("body").on("change", "select#shownotes", function(event) {
		event.preventDefault();
		var select = $(this);
		var shownotesvalue = select.val();
		var href = URI(select.data('link')).addQuery('shownotes', shownotesvalue).toString();
		var ajax = select.data('ajax');
		if (ajax == 'Y') {
			var modal = config.modals.ajax;
	        var loadinto =  modal+" .modal-content";
			showajaxloading();
			loadin(href, loadinto, function() {
				console.log(href);
				hideajaxloading();
				$(modal).resizemodal('lg').modal();
			});
		} else {
			window.location.href = href;
		}
	});

});




function shipto() { //CAN BE USED IF SHIPTO IS DEFINED
	var custid = $(custlookupform + " .custid").val();
	var shipid = $(custlookupform + " .shipid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_shiptos).addQuery("custID", custid).addQuery("shipID", shipid).query(cleanparams).toString();
	showajaxloading();
	console.log(config.urls.json.ci_shiptolist);
	$.getJSON(config.urls.json.ci_shiptolist, function( json ) {
		console.log(json.data.length);
		if (json.data.length == 1) {
			loadshipto(custid, json.data[0].shipid);
		} else {
			loadin(href, loadinto, function() {
				console.log(href);
				hideajaxloading();
				$(modal).resizemodal('lg').modal();
			});
		}
	});
}

function contact() {
	var custid = $(custlookupform + " .custid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_contacts).addQuery("custID", custid).toString();
	showajaxloading();
	ci_contacts(custid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});
}

function pricing() {
	var custid = $(custlookupform + " .custid").val();
	var href = URI(config.urls.customer.load.ci_pricingform+'modal/').addQuery("custID", custid).toString();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	showajaxloading();
	loadin(href, loadinto, function() {
		console.log(href);
		hideajaxloading();
		$(modal).resizemodal('lg').modal();
	});
}

function choosecipricingitem(itemid) {
	var custid = $(custlookupform + " .custid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_pricing).addQuery("custID", custid).addQuery("itemid", itemid).toString();
	ci_pricing(custid, itemid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});
}
function salesorder() { //CAN BE USED IF SHIPTO IS DEFINED
	var custid = $(custlookupform + " .custid").val();
	var shipid = $(custlookupform + " .shipid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_salesorders).addQuery("custID", custid).addQuery("shipID", shipid).toString();
	showajaxloading();
	ci_salesorder(custid, shipid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});
}
function saleshist() { //CAN BE USED IF SHIPTO IS DEFINED
	var custid = $(custlookupform + " .custid").val();
	var shipid = $(custlookupform + " .shipid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_saleshistory+"form/").addQuery("custID", custid).addQuery("shipID", shipid).toString();
	showajaxloading();

	loadin(href, loadinto, function() {
		console.log(href);
		hideajaxloading();
		$(modal).resizemodal('sm').modal();
	});

}
function custpo() { //CAN BE USED IF SHIPTO IS DEFINED
	var custid = $(custlookupform + " .custid").val();
	var shipid = $(custlookupform + " .shipid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_custpo).addQuery("custID", custid).addQuery("shipID", shipid).toString();
	swal({
		title: "Customer PO Inquiry",
	 	text: "Enter a PO:",
		input: 'text',
		showCancelButton: true,
		inputValidator: function (value) {
			return new Promise(function (resolve, reject) {
				if (value === false) {
					reject("You need to write something!");
				} else if (value === "") {
					reject("You need to write something!");
				} else {
					resolve();
				}
			})
		}
	}).then(function (input) {
		if (input) {
			swal.close();
			href = URI(href).addQuery("custpo", input).toString();
			ci_custpo(custid, shipid, input, function() {
				loadin(href, loadinto, function() {
					console.log(href);
					hideajaxloading();
					$(modal).resizemodal('lg').modal();
				});
			});

		} else {
			listener.listen();
		}
	});
}
function quotes() {
	var custid = $(custlookupform + " .custid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_quotes).addQuery("custID", custid).toString();
	showajaxloading();
	ci_quotes(custid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('xl').modal();
		});
	});
}

function openinv() {
	var custid = $(custlookupform + " .custid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_openinvoices).addQuery("custID", custid).toString();
	showajaxloading();
	ci_openinvoices(custid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});
}

function loadorderdocuments(ordn) {
	var custid = $(custlookupform + " .custid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_orderdocuments).addQuery("custID", custid).addQuery('ordn', ordn).toString();
	showajaxloading();
	ci_getorderdocuments(custid, ordn, function() {
		wait(500, function() {
			loadin(href, loadinto, function() {
				console.log(href);
				hideajaxloading();
				$(modal).resizemodal('lg').modal();
			});
		});
	});
}

function payment() {
	var custid = $(custlookupform + " .custid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_paymenthistory).addQuery("custID", custid).toString();
	showajaxloading();
	ci_paymenthistory(custid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});
}

function custcredit() {
	var custid = $(custlookupform + " .custid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_credit).addQuery("custID", custid).toString();
	showajaxloading();
	ci_credit(custid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});
}

function standorders() { //CAN BE USED IF SHIPTO IS DEFINED
	var custid = $(custlookupform + " .custid").val();
	var shipid = $(custlookupform + " .shipid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_standingorders).addQuery("custID", custid).addQuery("shipID", shipid).toString();
	ci_standingorders(custid, shipid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});
}

function customerstock() { //CAN BE USED IF SHIPTO IS DEFINED
	//TODO
}

function notes() { //CAN BE USED IF SHIPTO IS DEFINED
	//TODO
}

function docview() {
	var custid = $(custlookupform + " .custid").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.load.ci_documents).addQuery("custID", custid).toString();
	showajaxloading();
	ci_documents(custid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});

}

/*==============================================================
   SUPPLEMENTAL FUNCTIONS
=============================================================*/

function toggleshipto() {
	showajaxloading();
	var custid = $(custlookupform + " .custid").val();
	var nextshipid = '';
	if (!$(custlookupform + " .shipid").val() != '') { nextshipid = $(custlookupform + " .nextshipid").val(); }
	ci_shiptoinfo(custid, nextshipid, function() {
		var href = config.urls.customer.ci + "/"+urlencode(custid)+"/";
		if (nextshipid != '') {
			href += 'shipto-'+nextshipid+'/';
		}
		hideajaxloading();
		window.location.href = href;
	});
}


function loadshiptoinfo(custid, shiptoid) {
	var href = URI(config.urls.customer.load.ci_shiptoinfo).addQuery("custID", custid)
														   .addQuery('shipID', shiptoid)
														   .toString();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	showajaxloading();
	ci_shiptoinfo(custid, shiptoid, function() {
		loadin(href, loadinto, function() {
			console.log(href);
			hideajaxloading();
			$(modal).resizemodal('lg').modal();
		});
	});
}

function choosecisaleshistoryitem(itemid) {
	var row = $('[href=#'+itemid+']');
	row.siblings().remove();
	$('.ci-item-search').val(itemid);
}
