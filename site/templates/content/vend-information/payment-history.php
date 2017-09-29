<?php
	// $paymentfile = $config->jsonfilepath.session_id()."-vipaymenthist.json";
	$paymentfile = $config->jsonfilepath."viph-vipaymenthist.json";
?>

<?php if (file_exists($paymentfile)) : ?>
    <?php $paymentjson = json_decode(convertfiletojson($paymentfile), true);  ?>
    <?php if (!$paymentjson) { $paymentjson = array('error' => true, 'errormsg' => 'The VI Payment History JSON contains errors. JSON ERROR: ' . json_last_error());} ?>

    <?php if ($paymentjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $paymentjson['errormsg']; ?></div>
    <?php else : ?>
        <?php $columns = array_keys($paymentjson['columns']); ?>
        <table class="table table-striped table-bordered table-condensed table-excel">
            <thead>
                <?php foreach ($columns as $column) :?>
                <th><?php echo $column; ?></th>
                <?php endforeach; ?>
            </thead>
            <?php 
            $invoices = array_keys($paymentjson['data']['invoices']);
            foreach ($invoices as $invoice) :
            ?>
                <tr>
                    <?php 
                    $rows = $paymentjson['data']['invoices'][$invoice];
                    foreach ($rows as $row) :
                    ?>
                        <td><?php echo $row; ?></td>
                    <?php endforeach;?>
                </tr>
            <?php endforeach; ?>
        </table>
				
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
