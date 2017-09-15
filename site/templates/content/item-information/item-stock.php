<?php
	$stockfile = $config->jsonfilepath.session_id()."-iistkstat.json";
	$itemlink = $config->pages->products."redir/?action=ii-select&custID=".urlencode($custID);
?>

<?php if (file_exists($stockfile)) : ?>
    <?php $jsonstock = json_decode(file_get_contents($stockfile), true); $columns = array(); ?>
    <?php if (!$jsonstock) { $jsonstock = array('error' => true, 'errormsg' => 'The stock info JSON contains errors');} ?>

    <?php if ($jsonstock['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $jsonstock['errormsg']; ?></div>
    <?php else : ?>
        <?php $columns = array_keys($jsonstock['columns']); ?>
        <div class="table-responsive">
            <table class="table table-striped table-condensed table-bordered table-excel">
                <thead>
                    <tr>
                        <?php foreach($jsonstock['columns'] as $column) : ?>
                            <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jsonstock['data'] as $warehouse) : ?>
                        <tr>
                            <?php foreach($columns as $column) : ?>
                                <?php if ($column == "Item ID") : ?>
                                    <td class="<?= $config->textjustify[$jsonstock['columns'][$column]['datajustify']]; ?>">
                                        <a href="<?= $itemlink."&itemID=".$warehouse[$column]; ?>"><?php echo $warehouse[$column]; ?></a>
                                    </td>
                                <?php else :?>
                                    <td class="<?= $config->textjustify[$jsonstock['columns'][$column]['datajustify']]; ?>"><?php echo $warehouse[$column]; ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
