<?php
	$tb = new Table('class=table table-striped table-bordered table-condensed table-excel|id='.urlencode($whse['Whse Name']));
	$tb->section('thead');
		/*
		for ($x = 1; $x < $table['header']['maxrows'] + 1; $x++) {
			$tb->row('');
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['header']['rows'][$x]['columns'][$i])) {
					$column = $table['header']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['header'][$column['id']]['headingjustify']];
					$colspan = $column['col-length'];
					$tb->headercell('colspan='.$colspan.'|class='.$class, $column['label']);
				} else {
					$tb->headercell('');
				}
			}
		}
		*/

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
		foreach($whse['quotes'] as $quote) {

			for ($x = 1; $x < $table['header']['maxrows'] + 1; $x++) {
				$tb->row('');
				for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
					if (isset($table['header']['rows'][$x]['columns'][$i])) {
						$column = $table['header']['rows'][$x]['columns'][$i];
						$class = $config->textjustify[$fieldsjson['data']['header'][$column['id']]['datajustify']];
						$colspan = $column['col-length'];
						$tb->cell('colspan='.$colspan.'|class='.$class, '<b>'.$column['label'].'</b>: '.generatecelldata($fieldsjson['data']['header'][$column['id']]['type'],$quote, $column, false));
						if ($colspan > 1) { $i = $i + ($colspan - 1); }
					} else {
						$tb->cell('');
					}
				}
			}


			foreach ($quote['details'] as $item) {
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
			}

			$tb->row('class=last-row-bottom');
			$tb->cell('colspan='.$table['maxcolumns'],'&nbsp;');

		}

	$tb->closesection('tbody');

	echo $tb->close();
