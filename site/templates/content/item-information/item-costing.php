<?php
    $costfile = $config->jsonfilepath.session_id()."-iicost.json";
    //$costfile = $config->jsonfilepath."iicost-iicost.json";
    if ($config->ajax) {
		echo '<p>' . makeprintlink($config->filename, 'View Printable Version') . '</p>';
	}
?>

<?php if (file_exists($costfile)) : ?>
    <?php $costjson = json_decode(file_get_contents($costfile), true);  ?>
    <?php if (!$costjson) { $costjson = array('error' => true, 'errormsg' => 'The BOM Item Inquiry Single JSON contains errors');} ?>
    <?php if ($costjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $costjson['errormsg']; ?></div>
    <?php else : ?>
        <?php $warehousecolumns = array_keys($costjson['columns']['warehouse']); ?>
        <?php $vendorcolumns = array_keys($costjson['columns']['vendor']); ?>
        <?php $purchasecolumns = array_keys($costjson['columns']['last purchase']); ?>

        <table class="table table-striped table-condensed table-excel">
            <tr>
                <td><b>Item ID</b></td>
                <td><?= $costjson['itemid']; ?></td>
                <td colspan="2"><?= $costjson['desc1']; ?></td>
            </tr>
            <tr>
                <td><b>Sales UoM</b></td>
                <td><?= $costjson['sale uom']; ?></td>
                <td colspan="2"><?= $costjson['desc2']; ?></td>
            </tr>
            <tr>
                <td><b>Stan Cost</b></td>
                <td class="text-center"><?= $costjson['stan cost']; ?></td>
                <td><b>Avg Cost:</b> <?php echo $costjson['avg cost']; ?> </td>
                <td><b>Last Cost:</b> <?php echo $costjson['last cost']; ?></td>
            </tr>
        </table>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#whse" aria-controls="warehouse" role="tab" data-toggle="tab">Warehouse</a></li>
                <li role="presentation"><a href="#vendor" aria-controls="vendor" role="tab" data-toggle="tab">Vendor</a></li>
                <li role="presentation"><a href="#lastpurchase" aria-controls="lastpurchase" role="tab" data-toggle="tab">Last Purchase</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="whse">
                    <?php foreach($costjson['data']['warehouse'] as $whse) : ?>
                        <h3><?php echo $whse['whse name']; ?></h3>
                        <table class="table table-striped table-bordered table-condensed table-excel no-bottom">
                            <thead>
                                <tr>
                                    <?php foreach($costjson['columns']['warehouse'] as $column) : ?>
                                        <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($whse['lots'] as $lot) : ?>
                                    <tr>
                                        <?php foreach ($warehousecolumns as $column) : ?>
                                            <td class="<?= $config->textjustify[$costjson['columns']['warehouse'][$column]['datajustify']]; ?>"><?php echo $lot[$column]; ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="vendor">
                    <?php foreach($costjson['data']['vendor'] as $vendor) : ?>
                        <h3><?php echo $vendor['vend id']; ?></h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <table class="table table-striped table-bordered table-condensed table-excel no-bottom">
                                    <tr> <td>Vendor:</td><td><?php echo $vendor['vend name']; ?></td> </tr>
                                    <tr> <td>Phone Nbr:</td><td><?php echo $vendor['vend phone']; ?></td> </tr>
                                    <tr> <td>Purch UoM:</td><td><?php echo $vendor['vend uom']; ?></td> </tr>
                                    <tr> <td>Case Qty:</td><td><?php echo $vendor['vend case qty']; ?></td> </tr>
                                    <tr> <td>List Price:</td><td><?php echo $vendor['vend price']; ?></td> </tr>
                                    <tr> <td>Change Date:</td><td><?php echo $vendor['vend chg date']; ?></td> </tr>
                                    <tr> <td>PO Order Code:</td><td><?php echo $vendor['vend po code']; ?></td> </tr>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <table class="table table-striped table-bordered table-condensed table-excel no-bottom">
                                    <thead>
                                        <tr>
                                            <?php foreach($costjson['columns']['vendor'] as $column) : ?>
                                                <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($vendor['vend cost breaks'] as $costbreak) : ?>
                                            <tr>
                                                <?php foreach ($vendorcolumns as $column) : ?>
                                                    <td class="<?= $config->textjustify[$costjson['columns']['vendor'][$column]['datajustify']]; ?>"><?php echo $costbreak[$column]; ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="lastpurchase"><br>
                    <table class="table table-striped table-bordered table-condensed table-excel no-bottom">
                        <thead>
                            <tr>
                                <?php foreach($costjson['columns']['last purchase'] as $column) : ?>
                                    <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($costjson['data']['last purchase'] as $lastpurchase) : ?>
                                <tr>
                                    <?php foreach ($purchasecolumns as $column) : ?>
                                        <td class="<?= $config->textjustify[$costjson['columns']['last purchase'][$column]['datajustify']]; ?>"><?php echo $lastpurchase[$column]; ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
