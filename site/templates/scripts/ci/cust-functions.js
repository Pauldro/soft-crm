/* =============================================================
   CI ITEM FUNCTIONS
 ============================================================ */
	function ci_shiptos(custid, callback) {
		var url = config.urls.customer.redir.ci_shiptos+"&custID="+urlencode(custid);
		$.get(url, function() { callback();});
	}

	function ci_shiptoinfo(custid, shiptoid, callback) {
		var url = config.urls.customer.redir.ci_shiptoinfo+"&custID="+urlencode(custid)+"&shipID="+urlencode(shiptoid);
		$.get(url, function() { callback();});
	}

	function ci_openinvoices(custid, callback) {
		var url = config.urls.customer.redir.ci_openinvoices+"&custID="+urlencode(custid);
		$.get(url, function() { callback();});
	}

	function ci_standingorders(custid, shiptoid, callback) {
		var url = config.urls.customer.redir.ci_standingorders+"&custID="+urlencode(custid)+"&shipID="+urlencode(shiptoid);
		$.get(url, function() { callback();});
	}

	function ci_paymenthistory(custid, callback) {
		var url = config.urls.customer.redir.ci_paymenthistory+"&custID="+urlencode(custid);
		$.get(url, function() { callback();});
	}

	function ci_documents(custid, callback) {
		var url = config.urls.customer.redir.ci_documents+"&custID="+urlencode(custid);
		$.get(url, function() { callback();});
	}

	function ci_quotes(custid, callback) {
		var url = config.urls.customer.redir.ci_quotes+"&custID="+urlencode(custid);
		$.get(url, function() { callback();});
	}

	function ci_contacts(custid, callback) {
		var url = config.urls.customer.redir.ci_contacts+"&custID="+urlencode(custid);
		$.get(url, function() { callback();});
	}

	function ci_credit(custid, callback) {
		var url = config.urls.customer.redir.ci_credit+"&custID="+urlencode(custid);
		$.get(url, function() { callback();});
	}

	function ci_salesorder(custid, shipid, callback) {
		var url = config.urls.customer.redir.ci_salesorders+"&custID="+urlencode(custid)+"&shipID="+urlencode(shipid);
		$.get(url, function() { callback();});
	}

	function ci_saleshistory(custid, shipid, callback) {
		var url = config.urls.customer.redir.ci_saleshistory+"&custID="+urlencode(custid)+"&shipID="+urlencode(shipid);
		$.get(url, function() { callback();});
	}

	function ci_custpo(custid, shipid, custpo, callback) {
		var url = config.urls.customer.redir.ci_custpo+"&custID="+urlencode(custid)+"&shipID="+urlencode(shipid)+"&custpo="+urlencode(custpo);
		$.get(url, function() { callback();});
	}
