<?php
    if ($input->get->text('q')) {
        $vendresults = search_vendorspaged($input->get->text('q'), $input->pageNum, $session->display);
        $resultscount = count_searchvendors($input->get->text('q'), false);
    }
?>

<div id="vend-results">
    <?php if ($input->get->text('q')) : ?>
        <table id="vend-index" class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="100">VendID</th> <th>Vendor Name</th> <th>Ship-From</th> <th>Address</th> <th>City</th> <th>State</th> <th>Zip</th> <th width="100">Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultscount > 0) : ?>
                    <?php foreach ($vendresults as $vendor) : ?>
                        <tr>
                            <td>
                                <a href="<?= $config->dplusoURLS->get_viURL($vendor->vendid); ?>">
                                    <?= $page->bootstrap->highlight($vendor->vendid, $input->get->text('q'));?>
                                </a> &nbsp; <span class="glyphicon glyphicon-share"></span>
                            </td>
                            <td><?= $page->bootstrap->highlight($vendor->name, $input->get->text('q')); ?></td>
                            <td><?= $page->bootstrap->highlight($vendor->shipfrom, $input->get->text('q')); ?></td>
                            <td>
                                <?= $page->bootstrap->highlight($vendor->address1, $input->get->text('q')); ?>
                                <?= $page->bootstrap->highlight($vendor->address2, $input->get->text('q')); ?>
                            </td>
                            <td><?= $page->bootstrap->highlight($vendor->city, $input->get->text('q')); ?></td>
                            <td><?= $page->bootstrap->highlight($vendor->state, $input->get->text('q')); ?></td>
                            <td><?= $page->bootstrap->highlight($vendor->zip, $input->get->text('q')); ?></td>
                            <td><a href="tel:<?= $vendor->phone; ?>" title="Click To Call"><?= $page->bootstrap->highlight($vendor->phone, $input->get->text('q')); ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <td colspan="5">
                        <h4 class="list-group-item-heading">No Vendor Matches your query.</h4>
                    </td>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
