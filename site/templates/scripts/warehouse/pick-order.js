$(function() {
    $("body").on("click", ".finish-item", function(e) {
        e.preventDefault();
        var button = $(this);
        
        if (pickitem.item.qty.remaining > 0) {
            swal({
                title: 'Are you sure?',
                text: "You have not met the Quantity Requirments",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                confirmButtonText: 'Yes!'
            }).then(function (result) {
                console.log(result);
                if (result) {
                    window.location.href = button.attr('href');
                }
            }).catch(swal.noop);
        } else {
            window.location.href = button.attr('href');
        }
    });
    
    
    $("body").on("click", ".exit-order", function(e) {
        e.preventDefault();
        var button = $(this);
        
        swal({
            title: 'Are you sure?',
            text: "You are trying to leave this order",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            confirmButtonText: 'Yes!'
        }).then(function (result) {
            console.log(result);
            if (result) {
                window.location.href = button.attr('href');
            }
        }).catch(swal.noop);
    });
    
    $("body").on("click", ".change-bin", function(e) {
        e.preventDefault();
        var button = $(this);
        
        swal({
			title: "Enter the Bin you'd like to change to",
			text: "Bin ID",
			input: 'text',
			showCancelButton: true,
			inputValidator: function (value) {
				return new Promise(function (resolve, reject) {
					if (value) {
						resolve();
					} else {
						reject('You need to write something!');
					}
				})
			}
		}).then(function (input) {
			if (input) {
				var binID = input;
                var pageurl = URI();
                var uri = URI(config.urls.warehouse.picking.sales_order.redir.redir);
                uri.addQuery('action', 'select-bin').addQuery('bin', binID).addQuery('page', pageurl);
                window.location.href = uri.toString();
			}
		}).catch(swal.noop);
    });
    
    $("body").on("click", ".remove-sales-order-locks", function(e) {
        e.preventDefault();
        
        swal({
			title: "Enter the Order Number you'd like to erase locks for",
			text: "Order Number",
			input: 'text',
			showCancelButton: true,
			inputValidator: function (value) {
				return new Promise(function (resolve, reject) {
					if (value) {
						resolve();
					} else {
						reject('You need to write something!');
					}
				})
			}
		}).then(function (input) {
			if (input) {
				var ordn = input;
                var pageurl = URI();
                var uri = URI(config.urls.warehouse.picking.sales_order.redir.redir);
                uri.addQuery('action', 'remove-order-locks').addQuery('ordn', ordn);
                window.location.href = uri.toString();
			}
		}).catch(swal.noop);
    });
});
