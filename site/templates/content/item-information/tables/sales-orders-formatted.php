

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
		foreach($whse['orders'] as $order) {
			if ($order != $whse['orders']['TOTAL']) {
				for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
					$tb->row('');
					for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
						if (isset($table['detail']['rows'][$x]['columns'][$i])) {
							$column = $table['detail']['rows'][$x]['columns'][$i];
							$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
							$colspan = $column['col-length'];
							if ($i == 1 && !empty($order["Sales Order Number"])) {
								$ordn = $order['Ordn'];
								$onclick = 'loadorderdocuments("'.$ordn.'")';
								$extracelldata = "&nbsp; <a href='#' title='load order documents' data-load='#ajax-modal' onclick='$onclick'><i class='fa fa-folder-open' aria-hidden='true'></i></a>";
								$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'],$order, $column, $extracelldata ));
							} else {

								$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'],$order, $column, false));
							}

							if ($colspan > 1) { $i = $i + ($colspan - 1); }
						} else {
							$tb->cell();
						}
					}
				}
			}
		}
	$tb->closesection('tbody');
	$tb->section('tfoot');
		$order = $whse['orders']['TOTAL'];
		//for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
		$x = 1;
			$tb->row('class=has-warning');
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['detail']['rows'][$x]['columns'][$i])) {
					$column = $table['detail']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
					$colspan = $column['col-length'];
					$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'],$order, $column, false));
					if ($colspan > 1) { $i = $i + ($colspan - 1); }
				} else {
					$tb->cell('');
				}
			}
		//}
	$tb->closesection('tfoot');
	echo $tb->close();
