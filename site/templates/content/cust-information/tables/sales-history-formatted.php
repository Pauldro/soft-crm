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

			for ($x = 1; $x < $table['lotserial']['maxrows'] + 1; $x++) {
				$tb->row('');
				for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
					if (isset($table['lotserial']['rows'][$x]['columns'][$i])) {
						$column = $table['lotserial']['rows'][$x]['columns'][$i];
						$class = $config->textjustify[$fieldsjson['data']['lotserial'][$column['id']]['headingjustify']];
						$colspan = $column['col-length'];
						$celldata = '<b>'.$column['label'] . '</b>';
						$tb->cell('colspan='.$colspan.'|class='.$class, $celldata);
						if ($colspan > 1) { $i = $i + ($colspan - 1); }
					} else {
						$tb->cell('false');
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
						$tb->cell('colspan='.$colspan.'|class='.$class, '<b class="pull-left">'.$column['label'].'</b> &nbsp;'.generatecelldata($fieldsjson['data']['header'][$column['id']]['type'],$order, $column));
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
							$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'],$item, $column));
							if ($colspan > 1) { $i = $i + ($colspan - 1); }
						} else {
							$tb->cell('');
						}
					}
				}



				foreach ($item['lotserial'] as $lotserial) {
					for ($x = 1; $x < $table['lotserial']['maxrows'] + 1; $x++) {
						$tb->row('');
						for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
							if (isset($table['lotserial']['rows'][$x]['columns'][$i])) {
								$column = $table['lotserial']['rows'][$x]['columns'][$i];
								$class = $config->textjustify[$fieldsjson['data']['lotserial'][$column['id']]['datajustify']];
								$colspan = $column['col-length'];
								$celldata = generatecelldata($fieldsjson['data']['lotserial'][$column['id']]['type'],$lotserial, $column);
								$tb->cell('colspan='.$colspan.'|class='.$class, $celldata);
								if ($colspan > 1) { $i = $i + ($colspan - 1); }
							} else {
								$tb->cell('false');
							}

						}
					}
				}

				foreach ($item['detailnotes'] as $ordernote) {
					$tb->row('');
					for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
						if ($i == 2) {
							$tb->cell('colspan=2', $ordernote['Detail Notes']);
							$i++;

						} else {
							$tb->cell('');
						}
					}
				}

			} //ENDS DETAILS 

			foreach ($order['ordernotes'] as $ordernote) {
				$tb->row('');
				for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
					if ($i == 2) {
						$tb->cell('colspan=2', $ordernote['Order Notes']);
						$i++;

					} else {
						$tb->cell('');
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
						$tb->cell('colspan='.$colspan.'|class='.$class, generatecelldata($fieldsjson['data']['total'][$column['id']]['type'],$order['totals'], $column));
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
							$celldata = generatecelldata($fieldsjson['data']['shipments'][$column['id']]['type'],$shipment, $column);
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
