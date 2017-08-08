<?php
    $vendors = getvendors(false);
?>
<table class="table table-bordered table-condensed" id="vendors-table">
	<thead>
		<tr>
			<th>VendorID</th> <th>Name</th> <th>Address1</th> <th>Address2</th> <th>Address3</th> <th>City, State Zip</th> <th>Country</th> <th>Phone</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($vendors as $vendor) : ?>
			<tr id="tr-<?= $vendor['vendid']; ?>">
				<td><button class="btn btn-sm btn-primary" onClick="choosevendor('<?= $vendor['vendid']; ?>')"><?= $vendor['vendid']; ?></button></td>
				<td class="name"><?= $vendor['name']; ?></td>
				<td><?= $vendor['address1']; ?></td>
				<td><?= $vendor['address2']; ?></td>
                <td><?= $vendor['address3']; ?></td>
				<td><?= $vendor['city'].', '.$vendor['state'].' '.$vendor['zip']; ?></td>
				<td><?= $vendor['country']; ?></td>
				<td><?= $vendor['phone']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<form>
    <table class="table table-condensed table-bordered table-striped">
        <tr>
            <td class="control-label">Vend ID:</td>
            <td>
                <input type="hidden" class="required" id="vendorID">
                <p class="form-control-static" id="vendortext"></p>
            </td>
        </tr>
        <tr>
            <td class="control-label">Ship From</td>
            <td> <select class="form-control input-sm" id="shipfrom"> <option value="n/a">Choose a Vendor</option> </select> </td>
        </tr>
        <tr>
            <td class="control-label">Item ID</td>
            <td> <input type="text" class="form-control input-sm required" name="itemID"> </td>
        </tr>
        <tr>
            <td class="control-label">Group</td> <td><input type="text" class="form-control input-sm" name="group"></td>
        </tr>
        <tr>
            <td class="control-label">PO Nbr</td> <td><input type="number" class="form-control input-sm" name="ponumberr"></td>
        </tr>
        <tr>
            <td class="control-label">Reference</td> <td><input type="text" class="form-control input-sm" name="poref"></td>
        </tr>
    </table>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
<script>
	$(function() {
		$('#vendors-table').DataTable();
        $('#vendorID').change(function(){
            var vendorID = $(this).val();
            var url = config.urls.json.vendorshipfrom + '?vendorID=' + urlencode(vendorID);
            $('#shipfrom option').remove();
            $.getJSON(url, function( json ) {
                if (json.response.shipfroms.length) {
                    $('<option value="n/a">Choose A Ship-from</option>').appendTo('#shipfrom');
                        $('<option value="n/a">None</option>').appendTo('#shipfrom');
                    $.each( json.response.shipfroms, function( key, shipfrom ) {
                        $('<option value="'+shipfrom.shipfrom+'">'+shipfrom.name+'</option>').appendTo('#shipfrom');
                    });
                } else {
                    $('<option value="N/A">No Ship-froms found</option>').appendTo('#shipfrom');
                }
            });
        })
	});
    function choosevendor(vendorID) {
        $('#vendors-table_filter input').val(vendorID).keyup();
        $('#vendorID').val(vendorID).change();
        $('#vendortext').text($('#tr-'+vendorID).find('.name').text());
    }
</script>
