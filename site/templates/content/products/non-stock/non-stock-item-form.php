<?php
    $vendors = getvendors(false);
?>
<table class="table table-bordered table-condensed" id="vendors-table">
	<thead>
		<tr>
			<th>VendorID</th> <th>Name</th> <th>Address1</th> <th>Address2</th> <th>City, State Zip</th> <th>Country</th> <th>Phone</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($vendors as $vendor) : ?>
			<tr id="tr-<?= $vendor['id']; ?>">
				<td><button class="btn btn-sm btn-primary" onClick="choosevendor('<?= $vendor['id']; ?>')"><?= $vendor['id']; ?></button></td>
				<td class="name"><?= $vendor['name']; ?></td>
				<td><?= $vendor['address1']; ?></td>
				<td><?= $vendor['address2']; ?></td>
				<td><?= $vendor['city'].', '.$vendor['state'].' '.$vendor['zip']; ?></td>
				<td><?= $vendor['country']; ?></td>
				<td><?= $vendor['phone']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<form>
    <div class="form-group row">
        <label for="vendorID" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Vend ID:</label>
        <div class="col-sm-5 col-md-6 col-lg-7">
            <input type="text" class="form-control input-sm" id="vendorID">
        </div>
        <div class="col-sm-5 col-md-4 col-lg-4">
            <span id="vendortext">Placeholder</span>
        </div>
    </div>
    <div id="otherfields" class="">
        <div class="form-group row">
            <label for="shipFr" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Ship Fr:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <select class="form-control input-sm" id="shipFr">
                </select>
            </div>
            <div class="col-sm-5 col-md-4 col-lg-4">
                <span id="shipFrHelp">Placeholder</span>
            </div>
        </div>
        <div class="form-group row">
            <label for="itemID" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Item ID:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <input type="text" class="form-control input-sm" id="itemID">
            </div>
            <div class="col-sm-5 col-md-4 col-lg-4">
                <span id="itemIDHelp">Placeholder</span>
            </div>
        </div>
        <div class="form-group row">
            <label for="group" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Group:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <input type="text" class="form-control input-sm" id="group">
            </div>
            <div class="col-sm-5 col-md-4 col-lg-4">
                <span id="groupHelp">Placeholder</span>
            </div>
        </div>
        <div class="form-group row">
            <label for="poNum" class="col-sm-2 col-md-2 col-lg-1 col-form-label">PO Nbr:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <input type="number" class="form-control input-sm" id="poNbr">
            </div>
        </div>
        <div class="form-group row">
            <label for="ref" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Reference:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <input type="text" class="form-control input-sm" id="ref">
            </div>
        </div>
    </div>


    <button type="submit" class="btn btn-default">Submit</button>
</form>
<script>
	$(function() {
		$('#vendors-table').DataTable();
        $('#vendorID').change(function(){
            var vendorID = $(this).val();
            var url = config.urls.json.vendorshipfrom + '?vendorID=' + urlencode(vendorID);
            $('#shipFr option').remove();
            $.getJSON(url, function( json ) {
                if (json.response.shipfroms.length) {
                    $('<option value="N/A">choose</option>').appendTo('#shipFr');
                    $.each( json.response.shipfroms, function( key, shipfrom ) {
                        $('<option value="'+shipfrom.shipfrom+'">'+shipfrom.name+'</option>').appendTo('#shipFr');
                    });
                } else {
                    $('<option value="N/A">No Ship-froms found</option>').appendTo('#shipFr');
                }
            });
        })
	});
    function choosevendor(vendorID) {
        $('#vendors-table_filter input').val(vendorID);
        $('#vendorID').val(vendorID).change();
        $('#vendortext').text($('#tr-'+vendorID).find('.name').text());
    }
</script>
