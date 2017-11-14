<?php 
	$tb = new Table('class=table table-striped table-condensed table-excel');
	$tb->tr();
		$tb->td('', '<b>Item ID</b>');
		$tb->td('', $costjson['itemid']);
		$tb->td('colspan=2', $costjson['desc1']);
	$tb->tr();
		$tb->td('', '<b>Customer ID</b>');
		$button = $page->bootstrap->openandclose('button', "type=button|class=btn btn-primary btn-sm|data-dismiss=modal|onclick=iicust('ii-pricing')", 'Change Customer');
		$content = $costjson['vendorID']." - ".$costjson['cust name'] . ' &nbsp; ';
		$tb->td('colspan=2', $content);
	$tb->tr();
		$tb->td('', '<b>Cust Price Code</b>');
		$tb->td('colspan=2', $costjson['cust price code']." - ".$costjson['cust price desc']);
	$itemtable = $tb->close();

	// STANDARD CUSTOMER PRICING TABLE
	$tb = new Table('class=table table-striped table-condensed table-excel');
	$tb->tablesection('thead');
		$tb->tr();
		foreach($costjson['columns']['standard pricing'] as $column) {
			$class = $config->textjustify[$column['headingjustify']];
			$tb->th("class=$class", $column['heading']);
		}
	$tb->closetablesection('thead');
	$tb->tablesection('body');
		$tb->tr();
			$tb->td('', '<b>Last Price Date: </b>');
			$tb->td('', $costjson['data']['standard pricing']['last price date']);
		foreach ($costjson['data']['standard pricing']['standard breaks'] as $standardpricing) {
			$tb->tr();
			foreach($standardpricecolumns as $column) {
				$class = $config->textjustify[$costjson['columns']['standard pricing'][$column]['datajustify']];
				$tb->td("class=$class", $standardpricing[$column]);
			}
		}
	$tb->closetablesection('tbody');
	$standardpricingtable = $tb->close();

	// CUSTROMER PRICING TABLE
	$tb = new Table('class=table table-striped table-condensed table-excel');
	$tb->tablesection('thead');
		$tb->tr();
		foreach($costjson['columns']['customer pricing'] as $column) {
			$class = $config->textjustify[$column['headingjustify']];
			$tb->th("class=$class", $column['heading']);
		}
	$tb->closetablesection('thead');
	$tb->tablesection('body');
		foreach ($costjson['data']['customer pricing']['cust breaks'] as $customerpricing) {
			$tb->tr();
			foreach($customerpricecolumns as $column) {
				$class = $config->textjustify[$costjson['columns']['customer pricing'][$column]['datajustify']];
				$tb->td("class=$class", $customerpricing[$column]);
			}
		}
	$tb->closetablesection('tbody');
	$customerpricingtable = $tb->close();

	// DERIVED PRICING TABLE
	$tb = new Table('class=table table-striped table-condensed table-excel');
	$tb->tablesection('thead');
		$tb->tr();
		foreach($costjson['columns']['pricing derived from'] as $column) {
			$class = $config->textjustify[$column['headingjustify']];
			$tb->th("class=$class", $column['heading']);
		}
	$tb->closetablesection('thead');
	$tb->tablesection('body');
		foreach ($costjson['data']['pricing derived from'] as $derivedpricing) {
			$tb->tr();
			foreach($derivedpricecolumns as $column) {
				$class = $config->textjustify[$costjson['columns']['pricing derived from'][$column]['datajustify']];
				$tb->td("class=$class", $derivedpricing[$column]);
			}
		}
	$tb->closetablesection('tbody');
	$derivedpricingtable = $tb->close();
?>
