var itemlookupform = "#ii-item-lookup";



$(function() {
    //listener.simple_combo("u", function() {iicust()});
    listener.simple_combo("c", function() {costing();});
    listener.simple_combo("d", function() {purchorder();});
    listener.simple_combo("e", function() {docview();});
    listener.simple_combo("i", function() {compinq();});
    listener.simple_combo("h", function() {saleshist();});
    listener.simple_combo("k", function() {whsestock();});
    listener.simple_combo("n", function() {general();});
    listener.simple_combo("o", function() {salesorder();});
	listener.simple_combo("p", function() {pricing();});
    listener.simple_combo("q", function() {quotes();});
    listener.simple_combo("r", function() {requirements();});
    listener.simple_combo("s", function() {seriallot();});
    listener.simple_combo("t", function() {purchhist();});
    listener.simple_combo("u", function() {substitute();});
    listener.simple_combo("v", function() {activity();});
    listener.simple_combo("w", function() {whereused();});
	listener.simple_combo("pageup", function() {previousitem();});
	listener.simple_combo("pagedown", function() {nextitem();});

	$("body").on("focus", ".swal2-container .swal2-input", function(event) {
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

	$("body").on("submit", "#ii-search-item", function(e) {
		e.preventDefault();
	});

	$("body").on("submit", itemlookupform, function(e) {
		e.preventDefault();
		var itemid = $(this).find('.itemid').val();
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var href = URI($(this).attr('action')).addQuery('q', itemid).addQuery("modal", "modal").normalizeQuery().toString();
		showajaxloading();
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});


	$("body").on("submit", "#ii-item-activity-form", function(e) {
        e.preventDefault();
        var formid = '#'+$(this).attr('id');
        var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
        var itemid = $(itemlookupform + " .itemid").val();
        var custid = $(itemlookupform + " .custid").val();
        var href = URI(config.urls.load.ii_activity).addQuery("itemid", itemid)
													.addQuery("custID", custid)
													.addQuery("modal", "modal")
													.query(cleanparams)
													.toString();
        showajaxloading();
        $(formid).postform({formdata: false, jsoncallback: false}, function() { //form, overwriteformdata, returnjson, callback
            $(modal).modal('hide');
            wait(500, function() {
                $(loadinto).loadin(href, function() {
                    hideajaxloading(); console.log(href);
					$(modal).find('.modal-body').addClass('modal-results');
                    $(modal).resizemodal('lg').modal();
                    listener.listen();
                });
            });
        });
    });

	$("body").on("submit", "#ii-sales-history-form", function(e) {
        e.preventDefault();
        var formid = '#'+$(this).attr('id');
        var modal = config.modals.ajax;
        var loadinto = modal+" .modal-content";
        var itemid = $(itemlookupform + " .itemid").val();
        var custid = $(itemlookupform + " .custid").val();
        var href = URI(config.urls.load.ii_saleshistory).addQuery("itemid", itemid)
														.addQuery("custID", custid)
														.addQuery("modal", "modal")
														.query(cleanparams)
														.toString();
        showajaxloading();
        $(formid).postform({formdata: false, jsoncallback: false}, function() { //form, overwriteformdata, returnjson, callback
            $(modal).modal('hide');
            $(loadinto).loadin(href, function() {
                hideajaxloading(); console.log(href);
                wait(500, function() {
					$(modal).find('.modal-body').addClass('modal-results');
                    $(modal).resizemodal('lg').modal();
                    listener.listen();
                });

            });
        });
    });
});

/*==============================================================
   ITEM INFO FUNCTIONS
 =============================================================*/
	function pricing() {
		var custid = $(itemlookupform+' .custid').val();
		var shiptoid = $(itemlookupform+' .shipid').val();
		var itemid = $(itemlookupform+' .itemid').val();
		if (custid.length > 0) {
			iipricing(custid, shiptoid, itemid);
		} else {
			iicust('ii-pricing');
		}
	}
    function costing() {
        var itemid = $(itemlookupform + " .itemid").val();
        var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_costing).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
        showajaxloading();
        ii_costing(itemid, function() {
            $(loadinto).loadin(href, function() {
                hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
                $(modal).resizemodal('lg').modal();
            });
        });
    }
    function purchorder() {
        var itemid = $(itemlookupform + " .itemid").val();
        var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_purchaseorder).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
        showajaxloading();
        ii_purchaseorder(itemid, function() {
            $(loadinto).loadin(href, function() {
                hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
                $(modal).resizemodal('xl').modal();
            });
        });
    }
	function quotes() {
		var itemid = $(itemlookupform + " .itemid").val();
		var custid = $(itemlookupform+' .custid').val();
		var modal = config.modals.ajax;
		var loadinto = modal+" .modal-content";
		var href = URI(config.urls.load.ii_quotes).addQuery("itemid", itemid)
												  .addQuery("custID", custid)
												  .addQuery("modal", "modal")
												  .query(cleanparams)
												  .toString();
		showajaxloading();
		ii_quotes(itemid, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}
	function purchhist() {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_purchasehistory).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_purchasehistory(itemid, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}
	function whereused() {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_whereused).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_whereused(itemid, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}
    function compinq() {
        var itemid = $(itemlookupform + " .itemid").val();
        var loadinto =  config.modals.ajax+" .modal-content";
        swal({
            title: "Component Inquiry Selection",
            text: "Kit or BOM Inquiry (K/B)",
            input: 'text',
            showCancelButton: true,
            inputValidator: function (value) {
                return new Promise(function (resolve, reject) {
                    if (value.toUpperCase() == 'K') {
                        resolve();
                    } else if (value.toUpperCase() == 'B') {
                        resolve();
                    } else {
                        reject('You need to write something!');
                    }
                })
            }
        }).then(function (input) {
            if (input) {
                if (input.toUpperCase() == 'K') {
                    askkitqtyneeded(itemid);
                } else if (input.toUpperCase() == 'B') {
                    askbomqtyneed(itemid);
                }

            } else {
                listener.listen();
            }
        }).catch(swal.noop);
    }
	function general() {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_general).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_notes(itemid, function() {
			ii_misc(itemid, function() {
				ii_usage(itemid, function() {
					$(loadinto).loadin(href, function() {
						hideajaxloading(); console.log(href);
						$(modal).find('.modal-body').addClass('modal-results');
						$(modal).resizemodal('lg').modal();
					});
				});
			});
		});
	}
	function activity() {
		var itemid = $(itemlookupform + " .itemid").val();
		var custid = $(itemlookupform + " .custid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_activityform).addQuery("itemid", itemid)
														.addQuery("custID", custid)
														.addQuery("modal", "modal")
														.query(cleanparams)
														.toString();
		console.log(href);
		$(loadinto).loadin(href, function() {
			listener.stop_listening();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('sm').modal();
			setTimeout(function (){ $(modal).find('.datepicker').focus();}, 500);
		});
	}
	function requirements(screentype, whse, refreshpage) {
		if (typeof screentype === 'undefined' || screentype === false) { screentype = ''; } else {whse = $('.item-requirements-whse').val();}
		if (typeof whse === 'undefined' || whse === false) { whse = ''; } else {screentype = $('.item-requirements-screentype').val();}
		if (typeof refreshpage === 'undefined' || refreshpage === false) { refreshpage = false; } else {refreshpage = true;}
		var itemid = $(itemlookupform + " .itemid").val();
		if (refreshpage) {
			itemid = $("#itemid-req").val();
		}
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_requirements).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_requirements(itemid, screentype, whse, function() {
			if (refreshpage) {
				hideajaxloading();
				window.location.reload(false);
			} else {
				$(loadinto).loadin(href, function() {
					hideajaxloading(); console.log(href);
					$(modal).find('.modal-body').addClass('modal-results');
					listener.stop_listening();
					$(modal).resizemodal('lg').modal();
				});
			}

		});
	}
	function seriallot() {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_lotserial).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_lotserial(itemid, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}
	function salesorder() {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_salesorder).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_salesorder(itemid, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				listener.stop_listening();
				$(modal).resizemodal('xl').modal();
			});
		});
	}
	function saleshist() {
		var itemid = $(itemlookupform + " .itemid").val();
		var custid = $(itemlookupform + " .custid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_saleshistoryform).addQuery("itemid", itemid).addQuery("custID", custid).addQuery("modal", "modal").toString();
		console.log(href);
		$(loadinto).loadin(href, function() {
			listener.stop_listening();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('sm').modal();
			setTimeout(function (){ $(modal).find('.datepicker').focus();}, 500);
		});
	}
	function whsestock() {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_stock).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_stock(itemid, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		})
	}
	function substitute() {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_substitutes).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_substitutes(itemid, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}
	function iicust(dplusfunction) {
		if (typeof dplusfunction === 'undefined' || dplusfunction === false) { dplusfunction = 'ii'; }
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.customer.load.loadindex).addQuery('function', dplusfunction).addQuery("modal", "modal").normalizeQuery().toString();
		$('.modal').modal('hide');
		$(loadinto).loadin(href, function() {
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
			setTimeout(function (){ $(modal).find('.query').focus();}, 500);
		});
	}
	function docview() {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_documents).addQuery("itemid", itemid).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_documents(itemid, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}

/*==============================================================
   EXTENSION FUNCTIONS
 =============================================================*/
     function askkitqtyneeded(itemid) {
        var href = URI(iiurl(config.urls.load.ii_kitcomponents, itemid, false, false)).addQuery("modal", "modal").toString();
        var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
        swal({
            title: "Kit Quantity",
            text: "Enter the Kit Quantity Needed",
            input: 'text',
            showCancelButton: true,
            inputValidator: function (value) {
                return new Promise(function (resolve, reject) {
                    if (!isNaN(value)) {
                        resolve();
                    } else {
                        reject("Your input is not numeric");
                    }
                })
            }
        }).then(function (input) {
            if (input) {
                var qty = input;
                swal.close();
                showajaxloading();
                ii_kitcomponents(itemid, qty, function() {
                    $(loadinto).loadin(href, function() {
                        hideajaxloading(); console.log(href);
						$(modal).find('.modal-body').addClass('modal-results');
                        $(modal).resizemodal('lg').modal();
                        listener.listen();
                    });
                });
            } else {
                listener.listen();
            }
        }).catch(swal.noop);

    }
    function askbomqtyneed(itemid) {
        swal({
            title: "Bill of Material Inquiry",
            text: "Enter the Bill of Material Qty Needed",
            input: 'text',
            showCancelButton: true,
            inputValidator: function (value) {
                return new Promise(function (resolve, reject) {
                    if (!isNaN(value)) {
                        resolve();
                    } else {
                        reject("Your input is not numeric");
                    }
                })
            }
        }).then(function (input) {
            if (input) {
                var qty = input;
                askbomsingleconsolided(itemid, qty);
            } else {
                listener.listen();
            }
        }).catch(swal.noop);
    }
    function askbomsingleconsolided(itemid, qty) {
        var href = iiurl(config.urls.load.ii_bom, itemid, false, false);
        var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
        swal({
            title: "Bill of Material Inquiry",
            text: "Single or Consolidated Inquiry (S/C)",
            input: 'text',
            showCancelButton: true,
            inputValidator: function (value) {
                return new Promise(function (resolve, reject) {
                    if (value.toUpperCase() == 'S') { //Single
                        resolve();
                    } else if (value.toUpperCase() == 'C') { //Consolidated
                        resolve();
                    } else {
                        reject("The accepted values are S or C");
                    }

                })
            }
        }).then(function (input) {
            if (input) {
                var bom = "single";
                if (input.toUpperCase() == 'S') { //Single
                    bom = "single";
                } else if (input.toUpperCase() == 'C') { //Consolidated
                    bom = "consolidated";
                }
                href = URI(href).addQuery('bom', bom).addQuery("modal", "modal").normalizeQuery().toString();
                ii_bom(itemid, qty, bom, function() {
                    swal.close();
                    showajaxloading();
                    $(loadinto).loadin(href, function() {
                        hideajaxloading(); console.log(href);
						$(modal).find('.modal-body').addClass('modal-results');
                        $(modal).resizemodal('lg').modal();
                        listener.listen();
                    });
                });
            } else {
                listener.listen();
            }
        }).catch(swal.noop);

    }
	function ii_customer(custid) { //WAS ii_customer
		var itemid = $(itemlookupform+' .itemid').val();
		showajaxloading();
		ii_select(itemid, custid, function() {
			hideajaxloading();
			$(this).closest('.modal').modal('hide');
			window.location.href = iiurl(config.urls.products.iteminfo, itemid, custid, false);
		});
	}
	function choosecust() {
		iicust();
	}
	function previousitem() {
		var itemid = $(itemlookupform+' .prev-itemid').val();
		var custid = $(itemlookupform+' .custid').val();
		showajaxloading();
		ii_select(itemid, custid, function() {
			hideajaxloading();
			window.location.href = iiurl(config.urls.products.iteminfo, itemid, custid, false);
		});
	}
	function nextitem() {
		var itemid = $(itemlookupform+' .next-itemid').val();
		var custid = $(itemlookupform+' .custid').val();
		showajaxloading();
		ii_select(itemid, custid, function() {
			hideajaxloading();
			window.location.href = iiurl(config.urls.products.iteminfo, itemid, custid, false);
		});
	}
	function chooseiihistorycust(custid, shipid) {
		var itemid = $(itemlookupform+' .itemid').val();
		$('.modal').modal('hide');
		showajaxloading();
		ii_select(itemid, custid, function() {
			hideajaxloading();
			loadiipage(custid, shipid, itemid, function() {
				saleshist();
			});
		});
	}
	function chooseiipricingcust(custid, shipid) {
		var itemid = $(itemlookupform+' .itemid').val();
		$('.modal').modal('hide');
		showajaxloading();
		ii_select(itemid, custid, function() {
			hideajaxloading();
			loadiipage(custid, shipid, itemid, function() {
				iipricing(custid, shipid, itemid);
			});
		});
	}
	function loadiipage(custid, shipid, itemid, callback) {
		var loadinto = ".page";
		var href = iiurl(config.urls.products.iteminfo, itemid, custid, shipid);
		var msg = "Viewing item "+itemid+" info for " + custid;
		loadreplace(href+" "+loadinto, loadinto, function() {
			window.history.pushState({ id: 35 }, msg, href);
			callback();
		});
	}
	function iipricing(custid, shipid, itemid) {
		var href = URI(iiurl(config.urls.load.ii_pricing, itemid, custid, shipid)).addQuery("modal", "modal").toString();
		var modal = config.modals.ajax;
		var loadinto = modal+" .modal-content";
		$('.modal').modal('hide');
		showajaxloading();
		ii_pricing(itemid, custid, shipid, function() {
			hideajaxloading();
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}
	function iiurl(url, itemid, custid, shipid) {
		var uri = URI(url).addSearch("itemid", itemid);
		uri.search(function(data){
			if (custid) {
				if (custid != "") {
					data.custID = custid;
				}
			}
			if (shipid) {
				if (shipid != "") {
					data.shipID = shipid;
				}
			}
		});
		return uri.normalizeQuery().toString();
	}
	function loadorderdocuments(ordn) {
		var itemid = $(itemlookupform + " .itemid").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.load.ii_order_documents).addQuery("itemid", itemid).addQuery("ordn", ordn).addQuery("modal", "modal").toString();
		showajaxloading();
		ii_order_documents(itemid, ordn, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading(); console.log(href);
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}
