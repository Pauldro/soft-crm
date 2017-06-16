<?php
    $whsestockfile = $config->jsonfilepath.session_id()."-iistkbywhse.json";
    //$whsestockfile = $config->jsonfilepath."debugstkbywhse-iistkbywhse.json";

?>
<?php if ($config->ajax) : ?>
	<p> <a href="<?php echo $config->filename; ?>" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php endif; ?>
<?php if (file_exists($whsestockfile)) : ?>
    <?php $whsestock = json_decode(file_get_contents($whsestockfile), true); ?>
    <?php if (!$whsestock) { $whsestock = array('error' => true, 'errormsg' => 'The warehouse stock JSON contains errors');} ?>

    <?php if ($whsestock['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $whsestock['errormsg']; ?></div>
    <?php else : ?>
        <?php
            if (!$whsestock['error']) {
                $whsecolumns = array_keys($whsestock['columns']['warehouse']);
                $lotcolumns = array_keys($whsestock['columns']['lots']);
                $ordercolumns = array_keys($whsestock['columns']['orders']);
            }
        ?>
        <?php foreach ($whsestock['data'] as $whse) : ?>

            <?php if ($whse != $whsestock['data']['zz']) : ?>
                <div>
                    <h3><?php echo $whse['Whse Name']; ?></h3>
                    <table class="table table-striped table-bordered table-condensed table-excel">
                        <thead>
                            <tr>
                                <?php foreach($whsestock['columns']['warehouse'] as $column) : ?>
                                    <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php foreach($whsecolumns as $column) : ?>
                                    <td class="<?= $config->textjustify[$whsestock['columns']['warehouse'][$column]['datajustify']]; ?>"><?php echo $whse[$column]; ?></td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped table-bordered table-condensed table-excel">
                        <tr>
                            <?php foreach($whsestock['columns']['lots'] as $column) : ?>
                                <td class="<?= $config->textjustify[$column['headingjustify']]; ?>"><b><?php echo $column['heading']; ?></b></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <?php foreach($whsestock['columns']['orders'] as $column) : ?>
                                <td class="<?= $config->textjustify[$column['headingjustify']]; ?>"><b><?php echo $column['heading']; ?></b></td>
                            <?php endforeach; ?>
                        </tr>

                        <?php foreach ($whse['lots'] as $lot) : ?>
                            <tr>
                                <?php foreach($lotcolumns as $column) : ?>
                                    <td class="<?= $config->textjustify[$whsestock['columns']['lots'][$column]['datajustify']]; ?>"><?php echo $lot[$column]; ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <?php foreach($lot['orders'] as $order) : ?>
                                <tr>
                                    <?php foreach($ordercolumns as $column) : ?>
                                        <td class="<?= $config->textjustify[$whsestock['columns']['orders'][$column]['datajustify']]; ?>"><?php echo $order[$column]; ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
        <div>

        <h3><?php echo $whsestock['data']['zz']['Whse Name']; ?></h3>
        <table class="table table-striped table-bordered table-condensed table-excel">
            <thead>
                <tr>
                    <?php foreach($whsestock['columns']['warehouse'] as $column) : ?>
                        <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach($whsecolumns as $column) : ?>
                        <td class="<?= $config->textjustify[$whsestock['columns']['warehouse'][$column]['datajustify']]; ?>"><?php echo $whsestock['data']['zz'][$column]; ?></td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
