var vendlookupform = "#vi-vend-lookup";


$(function() {
    
});

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
