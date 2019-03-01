<?php
    $q = '';
    $vendors = search_vendorspaged($q, $page = 1, $session->display);
?>

<div class="table-responsive" id="vend-results">
	<table id="vend-index" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="100">VendID</th> <th>Vendor Name</th> <th>Ship-From</th> <th>Address</th> <th>City</th> <th>State</th> <th>Zip</th> <th width="100">Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendors as $vendor) : ?>
                    <tr>
                        <td>
                            <a href="<?= $config->dplusoURLS->get_viURL($vendor->vendid); ?>">
                                <?= $vendor->vendid;?>
                            </a> &nbsp; <span class="glyphicon glyphicon-share"></span>
                        </td>
                        <td><?= $vendor->name; ?></td>
                        <td><?= $vendor->shipfrom; ?></td>
                        <td>
                            <?= $vendor->address1; ?>
                            <?= $vendor->address2; ?>
                        </td>
                        <td><?= $vendor->city; ?></td>
                        <td><?= $vendor->state; ?></td>
                        <td><?= $vendor->zip; ?></td>
                        <td><a href="tel:<?= $vendor->phone; ?>" title="Click To Call"><?= $vendor->phone; ?></a></td>
                    </tr>
            <?php endforeach; ?>
        </tbody>
	</table>
</div>
