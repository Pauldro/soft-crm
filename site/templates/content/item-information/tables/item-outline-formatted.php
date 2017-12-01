<?php
	$tb = new Table('class=table table-striped table-bordered table-condensed table-excel|id=');
	$tb->tablesection('thead');
		for ($x = 1; $x < $table['header']['maxrows'] + 1; $x++) {
			$tb->tr();
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['header']['rows'][$x]['columns'][$i])) {
					$column = $table['header']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['header'][$column['id']]['headingjustify']];
					$colspan = $column['col-length'];
					$tb->th('colspan='.$colspan.'|class='.$class, $column['label']);
					if ($colspan > 1) { $i = $i + ($colspan - 1); }
				} else {
					$tb->th();
				}
			}
		}
	$tb->closetablesection('thead');
	$tb->tablesection('tbody');
		$tb->tr();
		for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
			if (isset($table['header']['rows'][$x]['columns'][$i])) {
				$column = $table['header']['rows'][$x]['columns'][$i];
				$class = $config->textjustify[$fieldsjson['data']['header'][$column['id']]['datajustify']];
				$colspan = $column['col-length'];
				$celldata = Table::generatejsoncelldata($fieldsjson['data']['header'][$column['id']]['type'], $itemjson, $column);
				$tb->td('colspan='.$colspan.'|class='.$class, $celldata);
				if ($colspan > 1) { $i = $i + ($colspan - 1); }
			} else {
				$tb->td();
			}
		}
	$tb->closetablesection('tbody');
	echo $tb->close();
