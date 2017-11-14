<?php 
    $tb = new Table('class=table table-striped table-condensed table-excel');
    $tb->tr();
        $tb->td('', '<b>Item ID</b>');
        $tb->td('', $subjson['itemid']);
        $tb->td('colspan=2', $subjson['desc1']);
    $subtable = $tb->close();

    if (!empty($subjson['data']['substitute items'])) {
        $tb = new Table('class=table table-striped table-condensed table-excel');
    	$tb->tablesection('thead');
    		$tb->tr();
    		foreach ($subjson['columns']['substitute items'] as $column) {
    			$class = $config->textjustify[$column['headingjustify']];
    			$tb->th("class=$class", $column['heading']);
    		}
    	$tb->closetablesection('thead');
    	$tb->tablesection('body');
    		$count = count($subjson['data']['substitute items']);
    		for ($i = 1; $i < $count + 1; $i++) {
    			$title = $subjson['data']['substitute items'][$i]['sub item'];
    			$tb->tr();
    				$tb->td('class='.$config->textjustify[$subjson['columns']['substitute items']['sub item']['headingjustify']], "<b>$title</b>");
    				$tb->td('class='.$config->textjustify[$subjson['columns']['substitute items']['sub desc']['headingjustify']], $subjson['data']['substitute items'][$i]['sub desc']);
    				$tb->td('class='.$config->textjustify[$subjson['columns']['substitute items']['same/like']['headingjustify']], $subjson['data']['substitute items'][$i]['same/like']);
    		}
    	$tb->closetablesection('tbody');
        $subitemstable = $tb->close();
    }
    
    if (!empty($subjson['data']['internal notes'])) {
        $tb = new Table('class=table table-striped table-condensed table-excel');
        $tb->tablesection('body');
            $count = count($subjson['data']['internal notes']);
            for ($i = 1; $i < $count + 1; $i++) {
                $tb->tr();
                    $tb->td('class='.$config->textjustify[$subjson['columns']['internal notes']['internal note']['headingjustify']], $subjson['data']['internal notes'][$i]['internal note']);
            }
        $tb->closetablesection('tbody');
        $notestable = $tb->close();
    }

?>
