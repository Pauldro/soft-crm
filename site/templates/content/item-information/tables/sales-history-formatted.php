

<?php
	$tb = new Table('class=table table-striped table-bordered table-condensed table-excel|id='.urlencode($whse['Whse Name']));
	$tb->section('thead');
		for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
			$tb->row('');
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['detail']['rows'][$x]['columns'][$i])) {
					$column = $table['detail']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['headingjustify']];
					$colspan = $column['col-length'];
					$tb->headercell('colspan='.$colspan.'|class='.$class, $column['label']);
					if ($colspan > 1) { $i = $i + ($colspan - 1); }
				} else {
					$tb->headercell('');
				}
			}
		}
	$tb->closesection('thead');
	$tb->section('tbody');
		foreach($whse['invoices'] as $invoice) {
			if ($invoice != $whse['invoices']['TOTAL']) {
				for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
					$tb->row('');
					for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
						if (isset($table['detail']['rows'][$x]['columns'][$i])) {
							$column = $table['detail']['rows'][$x]['columns'][$i];
							$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
							$colspan = $column['col-length'];
							$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'], $invoice, $column, false));
							if ($colspan > 1) { $i = $i + ($colspan - 1); }
						} else {
							$tb->cell();
						}
					}
				}
				if (sizeof($invoice['lots']) > 0) {
					for ($x = 1; $x < $table['lotserial']['maxrows'] + 1; $x++) {
						$tb->row('');
						for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
							if (isset($table['lotserial']['rows'][$x]['columns'][$i])) {
								$column = $table['lotserial']['rows'][$x]['columns'][$i];
								$class = $config->textjustify[$fieldsjson['data']['lotserial'][$column['id']]['headingjustify']];
								$colspan = $column['col-length'];
								$tb->headercell('colspan='.$colspan.'|class='.$class, $column['label']);
								if ($colspan > 1) { $i = $i + ($colspan - 1); }
							} else {
								$tb->headercell('');
							}
						}
					}
					foreach ($invoice['lots'] as $lot) {
						for ($x = 1; $x < $table['lotserial']['maxrows'] + 1; $x++) {
							$tb->row('');
							for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
								if (isset($table['lotserial']['rows'][$x]['columns'][$i])) {
									$column = $table['lotserial']['rows'][$x]['columns'][$i];
									$class = $config->textjustify[$fieldsjson['data']['lotserial'][$column['id']]['datajustify']];
									$colspan = $column['col-length'];
									$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['lotserial'][$column['id']]['type'], $lot, $column, false));
									if ($colspan > 1) { $i = $i + ($colspan - 1); }
								} else {
									$tb->cell('');
								}
							}
						}
					}
				}
			}

		}

	$tb->closesection('tbody');
	$tb->section('tfoot');
		$invoice = $whse['invoices']['TOTAL'];
		//for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
		$x = 1;
			$tb->row('class=has-warning');
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['detail']['rows'][$x]['columns'][$i])) {
					$column = $table['detail']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
					$tb->cell('colspan=|class='.$class, generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'],$invoice, $column, false));
				} else {
					$tb->cell('');
				}
			}
		//}
	$tb->closesection('tfoot');
	echo $tb->close();
