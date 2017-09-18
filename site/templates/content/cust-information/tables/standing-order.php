<?php
	$tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
	$tb->section('tbody');
		
	foreach ($order['custinfo'] as $custinfo) {
		$tb->row('');
		foreach ($custcolumns as $column) {
			$tb->cell('',$custinfo[$column]); 
		}
		$tb->cell('', '&nbsp;');
		$tb->cell('', '&nbsp;');
	}

		$tb->row('');
		$tb->cell('colspan=6|class=text-center', '------ STANDING ORDER DETAILS ------');
	
	foreach ($order['iteminfo'] as $iteminfo) {
		$tb->row('');
		$tb->cell('', $iteminfo['itemidtext']);
		$tb->cell('', $iteminfo['itemid']);
		$tb->cell('', $iteminfo['itemdesc']);
		$tb->cell('', '&nbsp;');
		$tb->cell('', '&nbsp;');
		$tb->cell('', '&nbsp;');
		
		foreach ($iteminfo['itemlines'] as $itemline) {
			$tb->row('');
			foreach ($itemcolumns as $column) {
				$tb->cell('', $itemline[$column]); 
			}
		}
		
	}


	$tb->closesection('tbody');
	$tb->section('tfoot');

	$tb->closesection('tfoot');
	echo $tb->close();	
	echo '<hr class="dark">';