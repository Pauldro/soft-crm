<form action="<?= $config->pages->cart.'redir/'; ?>" method="post" class="quick-entry-add allow-enterkey-submit" id="quick-entry-add" data-validated="">
	<input type="hidden" name="action" value="add-to-cart">
	<input type="hidden" name="custID" value="<?= $custID; ?>">
	<div class="row">
		<div class="col-xs-9 sm-padding">
			<div class="col-md-4 form-group sm-padding">
				<span class="detail-line-field-name">Item/Description:</span>
				<span class="detail-line-field numeric">
					<input class="form-control input-xs underlined" type="text" name="itemID" placeholder="Item ID">
				</span>
			</div>
			<div class="col-md-1 form-group sm-padding"> </div>
			<div class="col-md-1 form-group sm-padding">
				<span class="detail-line-field-name">Qty:</span>
				<span class="detail-line-field numeric">
					<input class="form-control input-xs text-right underlined" type="text" size="6" name="qty" value="">
				</span>
			</div>
			<div class="col-md-2 form-group text-right sm-padding">
				<button type="submit" class="btn btn-sm btn-primary">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp; Add
				</button>
			</div>
			<div class="col-md-2 form-group text-right sm-padding">
				<button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#item-lookup-modal">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span> &nbsp; Search Items
				</button>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 sm-padding"> </div>
	</div>

	</br>
	<div>
		<div class="results">

		</div>
	</div>
</form>

<script>
	$(function () {
		$("body").on("submit", ".quick-entry-add", function(e) {
			var form = $(this);
			var itemsearch = form.find('input[name=itemID]').val();
			var custID = form.find('input[name=custID]').val();
			var qtyfield = form.find('input[name=qty]');

			if (form.attr('data-validated') != itemsearch) {
				e.preventDefault();
				var searchurl = URI(config.urls.json.validateitemid).addQuery('itemID', itemsearch).toString();
				$.getJSON(searchurl, function(json) {
					if (json.exists) {
						var validitemid = json.itemID;
						form.attr('data-validated', validitemid);
						form.find('input[name=itemID]').val(validitemid);
						form.submit();
					} else {
						swal ({
							title: 'Item not found.',
							text: itemsearch + ' cannot be found.',
							type: 'warning',
							confirmButtonClass: 'btn btn-sm btn-success',
							cancelButtonClass: 'btn btn-sm btn-danger',
							showCancelButton: true,
							confirmButtonText: 'Make Dplus search?'
						}).then(function (result) {
							var productsearchurl = URI(config.urls.products.redir.itemsearch).addQuery('q', itemsearch).addQuery('custID', custID).toString();
							var productresultsurl = URI(config.urls.load.quickentry_searchresults).addQuery('q', itemsearch).toString();
							showajaxloading();
							dplusrequest(productsearchurl, function() {
								form.find('.results').loadin(productresultsurl, function() {
									hideajaxloading();
									if (focus.length > 0) {
										$('html, body').animate({scrollTop: $(focus).offset().top - 60}, 1000);
									}
								});
							});
						}).catch(swal.noop);
					}
				});
			} else if (qtyfield.val() == '') {
				e.preventDefault();
				qtyfield.parent().addClass('has-error');
				qtyfield.focus();
			} else {
				showajaxloading();
				form.postform({formdata: false, jsoncallback: true, action: false}, function() {
					window.location.reload(true);
				});
			}
		});

		$("body").on("click", ".qe-item-results", function(e) {
			e.preventDefault();
			var item = $(this);
			var itemID = item.data('itemid');
			var form = $(".quick-entry-add");
			form.find('input[name=itemID]').val(itemID);
			form.find('.results').empty();
			form.attr('data-validated', itemID);
			form.submit();
		});
	});
</script>
