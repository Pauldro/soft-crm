/* =============================================================
   II ITEM FUNCTIONS
 ============================================================ */


	function ii_pricing(itemid, custid, shipid, callback) {
		var url = config.urls.products.redir.ii_pricing+"&itemid="+urlencode(itemid)+"&custID="+urlencode(custid)+"&shipID="+urlencode(shipid);
		$.get(url, function() { callback();});
	}

	function ii_select(itemid, custid, callback) {
		var url = config.urls.products.redir.ii_select+"&itemid="+urlencode(itemid)+"&custID="+urlencode(custid);
		$.get(url, function() { callback(); });
	}

	function ii_costing(itemid, callback) {
		var url = config.urls.products.redir.ii_costing+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback();});
	}

	function ii_purchaseorder(itemid, callback) {
		var url = config.urls.products.redir.ii_purchaseorder+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback(); });
	}

	function ii_quotes(itemid, callback) {
		var url = config.urls.products.redir.ii_quotes+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback();});
	}

	function ii_purchasehistory(itemid, callback) {
		var url = config.urls.products.redir.ii_purchasehistory+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback(); });
	}

	function ii_whereused(itemid, callback) {
		var url = config.urls.products.redir.ii_whereused+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback();});
	}

	

	function ii_bom(itemid, qty, bomtype, callback) {
		var url = config.urls.products.redir.ii_bom+"&itemid="+urlencode(itemid)+"&qty="+urlencode(qty)+"&bom="+bomtype;
		$.get(url, function() { callback();});
	}

	function ii_general(itemid, callback) {
		var url = config.urls.products.redir.ii_general+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback();});
	}

	function ii_usage(itemid, callback) {
		var url = config.urls.products.redir.ii_usage+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback();});
	}

	function ii_misc(itemid, callback) {
		var url = config.urls.products.redir.ii_misc+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback();});
	}

	function ii_notes(itemid, callback) {
		var url = config.urls.products.redir.ii_notes+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback();});
	}

	function ii_requirements(itemid, screentype, whse, callback) {
		var url = config.urls.products.redir.ii_requirements+"&itemid="+urlencode(itemid)+"&screentype="+urlencode(screentype)+"&whse="+urlencode(whse);
		$.get(url, function() {	callback(); });
	}

	function ii_lotserial(itemid, callback) {
		var url = config.urls.products.redir.ii_lotserial+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback();	});
	}

	function ii_salesorder(itemid, callback) {
		var url = config.urls.products.redir.ii_salesorder+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback(); });
	}

	function ii_stock(itemid, callback) {
		var url = config.urls.products.redir.ii_stock+"&itemid="+urlencode(itemid);
		$.get(url, function() { callback(); });
	}

	function ii_substitutes(itemid, callback) {
		var url = config.urls.products.redir.ii_substitutes+"&itemid="+urlencode(itemid);
		$.get(url, function() {	callback(); });
	}

	function ii_documents(itemid, callback) {
		var url = config.urls.products.redir.ii_documents+"&itemid="+urlencode(itemid);
		$.get(url, function() {	callback(); });
	}
