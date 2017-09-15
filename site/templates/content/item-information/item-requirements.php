<?php
    $warehousesfile = $config->companyfiles."json/whsetbl.json";
    $whsejson = json_decode(file_get_contents($warehousesfile), true);
    $warehouses = array_keys($whsejson['data']);
    $requirementsfile = $config->jsonfilepath.session_id()."-iirequire.json";
    //$requirementsfile = $config->jsonfilepath."iireq-iirequire.json";
    $screentypes = array("REQ" => "requirements", "AVL" => 'available');
	$refresh = 'true';
?>
<?php if ($config->ajax) : ?>
	<?php $refresh = 'false'; ?>
	<p> <a href="<?php echo $config->filename; ?>" class="h4" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php else : ?>
	<input type="hidden" id="itemid-req" value="<?php echo $itemID; ?>">
<?php endif; ?>

<?php if (file_exists($requirementsfile)) : ?>
    <?php $requirementsjson = json_decode(file_get_contents($requirementsfile), true);  ?>
    <?php if (!$requirementsjson) { $requirementsjson = array('error' => true, 'errormsg' => 'The item requirements JSON contains errors');} ?>

    <?php if ($requirementsjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $requirementsjson['errormsg']; ?></div>
    <?php else : ?>
        <?php $columns = array_keys($requirementsjson['columns']); ?>
        <div class="row">
            <div class="col-xs-12">
                <h3>Viewing <?php echo $screentypes[$requirementsjson['reqavl']]; ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <table class="table table-striped table-bordered table-condensed table-excel">
                    <tr><td>Item ID:</td><td><?= $requirementsjson['itemid']; ?></td></tr>
                    <tr>
                        <td>Whse:</td>
                        <td>
                            <select class="form-control input-sm item-requirements-whse" onchange="requirements(false, this.value, <?php echo $refresh; ?>)">
                                <?php foreach ($warehouses as $warehouse) : ?>
                                    <?php if ($warehouse == $requirementsjson['whse']) : ?>
                                        <option value="<?= $warehouse; ?>" selected><?= $whsejson['data'][$warehouse]['warehouse name']; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $warehouse; ?>"><?= $whsejson['data'][$warehouse]['warehouse name']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>View</td>
                        <td>
                            <select class="form-control input-sm item-requirements-screentype" onchange="requirements(this.value, false, <?php echo $refresh; ?>)">
                                <?php foreach ($screentypes as $key => $value) : ?>
                                    <?php if ($key == $requirementsjson['reqavl']) : ?>
                                        <option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>.
                                    <?php else : ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>.
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="table table-striped table-bordered table-condensed table-excel">
            <thead>
                <tr>
                    <?php foreach($requirementsjson['columns'] as $column) : ?>
                        <?php if ($column['heading'] != '') : ?>
                            <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requirementsjson['data']['orders'] as $order) : ?>
                    <tr>
                        <?php foreach($columns as $column) : ?>
                            <?php if ($requirementsjson['columns'][$column]['heading']!= '') : ?>
                                <td class="<?= $config->textjustify[$requirementsjson['columns'][$column]['datajustify']]; ?>"><?php echo $order[$column]; ?></td>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
