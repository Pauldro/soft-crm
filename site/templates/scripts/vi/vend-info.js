var vendlookupform = "#vi-vend-lookup";

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

	$("body").on("submit", vendlookupform, function(e) {
		e.preventDefault();
		var vendorID = $(this).find('.vendorID').val();
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var href = URI($(this).attr('action')).addQuery('q', vendorID).addQuery('function', 'vi').addQuery('modal', 'modal').normalizeQuery().toString();
		showajaxloading();
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
});

    // ADD LINE BELOW under vendorID to buttons that pull from both... also addQuery to href in function
    // var vendorshipfromID = $(vendlookupform + " .vendorshipfromID").val();

function payment() { 
	var vendorID = $(vendlookupform + " .vendorID").val();
    console.log(vendorID);
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_payment).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_payment(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function openinv() { 
	var vendorID = $(vendlookupform + " .vendorID").val();
    console.log(vendorID);
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_openinv).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_openinv(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function purchasehist() { 
	var vendorID = $(vendlookupform + " .vendorID").val();
    console.log(vendorID);
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_purchasehist).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_purchasehist(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function shipfrom() { 
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	showajaxloading();
    console.log(config.urls.vendor.json.vi_shipfromlist);
    $.getJSON(config.urls.vendor.json.vi_shipfromlist, function(json) {
        if (json.response.error) {
            swal({
              title: 'Error!',
              text: json.response.errormsg,
              type: 'error',
              confirmButtonText: 'OK'
            })
        } else {
            console.log(json);
            if (json.response.shipfromlist) {
                var shipfromID = json.response.shipfromlist[1].shipid;
                vi_shipfrom(vendorID, shipfromID, function() {
            		generateurl(function(url) {
                		window.location.href=url;
                	});
            	});
            } else {
                swal({
                  title: 'Error!',
                  text: 'This vendor has no Ship-Froms',
                  type: 'error',
                  confirmButtonText: 'OK'
                })
            }
        }
    });
}
