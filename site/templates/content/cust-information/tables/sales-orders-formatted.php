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

			for ($x = 1; $x < $table['header']['maxrows'] + 1; $x++) {
				$tb->row('');
				for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
					if (isset($table['header']['rows'][$x]['columns'][$i])) {
						$column = $table['header']['rows'][$x]['columns'][$i];
						$class = $config->textjustify[$fieldsjson['data']['header'][$column['id']]['datajustify']];
						$colspan = $column['col-length'];
						
						if ($i == 1 && !empty($order['Order Number'])) {
							  $ordn = $order['Ordn'];
							  $onclick = 'loadorderdocuments("'.$ordn.'")';
							  $extracelldata = "&nbsp; <a href='#' title='load order documents' data-load='#ajax-modal' onclick='$onclick'><i class='fa fa-folder-open' aria-hidden='true'></i></a>";
							 $tb->cell('colspan='.$colspan.'|class='.$class, '<b>'.$column['label'].'</b>: '.generatecelldata($fieldsjson['data']['header'][$column['id']]['type'],$order, $column, $extracelldata ));
						  } else {
							  $tb->cell('colspan='.$colspan.'|class='.$class, '<b>'.$column['label'].'</b>: '.generatecelldata($fieldsjson['data']['header'][$column['id']]['type'],$order, $column, false));
						  }

						if ($colspan > 1) { $i = $i + ($colspan - 1); }
					} else {
						$tb->cell('');
					}
				}
			}


			foreach ($order['details'] as $item) {
				for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
					$tb->row('');
					for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
						if (isset($table['detail']['rows'][$x]['columns'][$i])) {
							$column = $table['detail']['rows'][$x]['columns'][$i];
							$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
							$colspan = $column['col-length'];
							$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'],$item, $column, false));
							if ($colspan > 1) { $i = $i + ($colspan - 1); }
						} else {
							$tb->cell('');
						}
					}
				}
				$tb->row('');
				for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
					if (isset($table['itemstatus']['rows'][1]['columns'][$i])) {
						$column = $table['itemstatus']['rows'][1]['columns'][$i];
						$class = $config->textjustify[$fieldsjson['data']['itemstatus'][$column['id']]['datajustify']];
						$colspan = $column['col-length'];
						$celldata = '<b>'.$column['label'] . ':</b> ' .generatecelldata($fieldsjson['data']['itemstatus'][$column['id']]['type'],$item['itemstatus'], $column, false);
						$tb->cell('colspan='.$colspan.'|class='.$class, $celldata);
						if ($colspan > 1) { $i = $i + ($colspan - 1); }
					} else {
						$tb->cell('false');
					}

				}

				foreach ($item['purchordrs'] as $purchaseorder) {
					$tb->row('');
					for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
						if (isset($table['purchaseorder']['rows'][1]['columns'][$i])) {
							$column = $table['purchaseorder']['rows'][1]['columns'][$i];
							$class = $config->textjustify[$fieldsjson['data']['purchaseorder'][$column['id']]['datajustify']];
							$colspan = $column['col-length'];
							$celldata = '<b>'.$column['label'] . ':</b> ' .generatecelldata($fieldsjson['data']['purchaseorder'][$column['id']]['type'],$purchaseorder, $column, false);
							$tb->cell('colspan='.$colspan.'|class='.$class, $celldata);
							if ($colspan > 1) { $i = $i + ($colspan - 1); }
						} else {
							$tb->cell('false');
						}
					}
				}
			}

			for ($x = 1; $x < $table['total']['maxrows'] + 1; $x++) {
				$tb->row('');
				for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
					if (isset($table['total']['rows'][$x]['columns'][$i])) {
						$column = $table['total']['rows'][$x]['columns'][$i];
						$class = $config->textjustify[$fieldsjson['data']['total'][$column['id']]['datajustify']];
						$colspan = $column['col-length'];
						$tb->cell('', '<b>'.$column['label'] . '</b>');
						$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['total'][$column['id']]['type'],$order['totals'], $column, false));
						$i++;
						if ($colspan > 1) { $i = $i + ($colspan - 1); }
					} else {
						$tb->cell('');
					}
				}
			}

			foreach ($order['shipments'] as $shipment) {
				for ($x = 1; $x < $table['shipments']['maxrows'] + 1; $x++) {
					$tb->row('');
					for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
						if (isset($table['shipments']['rows'][$x]['columns'][$i])) {
							$column = $table['shipments']['rows'][$x]['columns'][$i];
							$class = $config->textjustify[$fieldsjson['data']['shipments'][$column['id']]['headingjustify']];
							$colspan = $column['col-length'];
							$tb->headercell('colspan='.$colspan.'|class='.$class, $column['label']);

							if ($colspan > 1) { $i = $i + ($colspan - 1); }
						} else {
							$tb->headercell('');
						}
					}
				}

				for ($x = 1; $x < $table['shipments']['maxrows'] + 1; $x++) {
					$tb->row('');
					for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
						if (isset($table['shipments']['rows'][$x]['columns'][$i])) {
							$column = $table['shipments']['rows'][$x]['columns'][$i];
							$class = $config->textjustify[$fieldsjson['data']['shipments'][$column['id']]['datajustify']];
							$colspan = $column['col-length'];
							$celldata = generatecelldata($fieldsjson['data']['shipments'][$column['id']]['type'],$shipment, $column, false);
							$tb->cell('colspan='.$colspan.'|class='.$class, $celldata);

							if ($colspan > 1) { $i = $i + ($colspan - 1); }
						} else {
							$tb->cell('');
						}
					}
				}
			}




			$tb->row('class=last-row-bottom');
			$tb->cell('colspan='.$table['maxcolumns'],'&nbsp;');

		}

	$tb->closesection('tbody');

	echo $tb->close();
