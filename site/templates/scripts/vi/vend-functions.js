function vi_shipfrom(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_shipfrom+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_payment(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_payment+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_openinv(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_openinv+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}
