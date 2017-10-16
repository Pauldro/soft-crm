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

function shipfrom() { 
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_shipfrom).addQuery("vendID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_shipfrom(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}
