<?php
    $whereusedfile = $config->jsonfilepath.session_id()."-iiwhereused.json";
    //$whereusedfile = $config->jsonfilepath."iiuse-iiwhereused.json";
    //$whereusedfile = $config->jsonfilepath."iiuse2-iiwhereused.json";
 ?>
<?php if ($config->ajax) : ?>
	<p> <a href="<?php echo $config->filename; ?>" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php endif; ?>

<?php if (file_exists($whereusedfile)) : ?>
    <?php $whereusedjson = json_decode(file_get_contents($whereusedfile), true);  ?>
    <?php if (!$whereusedjson) { $whereusedjson = array('error' => true, 'errormsg' => 'The item where used JSON contains errors');} ?>

    <?php if ($whereusedjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $whereusedjson['errormsg']; ?></div>
    <?php else : ?>
        <?php $kitcolumns = array_keys($whereusedjson['columns']['kit']); ?>
        <?php $bomcolumns = array_keys($whereusedjson['columns']['bom']); ?>

        <?php if (isset($whereusedjson['data']['kit'])) : ?>
            <h3>Kit</h3>
            <table class="table table-striped table-bordered table-condensed table-excel">
                <thead>
                    <tr>
                        <?php foreach($whereusedjson['columns']['kit'] as $column) : ?>
                            <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($whereusedjson['data']['kit'] as $kit) : ?>
                        <tr>
                            <?php foreach ($kitcolumns as $column) : ?>
                                <td class="<?= $config->textjustify[$quotesjson['columns']['kit'][$column]['datajustify']]; ?>"><?php echo $kit[$column]; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (isset($whereusedjson['data']['bom'])) : ?>
            <h3>BOM</h3>
            <table class="table table-striped table-bordered table-condensed table-excel">
                <thead>
                    <tr>
                        <?php foreach($whereusedjson['columns']['bom'] as $column) : ?>
                            <th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($whereusedjson['data']['bom'] as $bom) : ?>
                        <tr>
                            <?php foreach ($bomcolumns as $column) : ?>
                                <td class="<?= $config->textjustify[$quotesjson['columns']['bom'][$column]['datajustify']]; ?>"><?php echo $bom[$column]; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
