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
    			if ($subjson['data']['substitute items'][$i]['same/like'] == 'Super') {
                    $tb->tr('class=success');
                } else {
                    $tb->tr();
                }
				$tb->td('', "<b>$title</b>");
				$tb->td('', $subjson['data']['substitute items'][$i]['sub desc']);
				$tb->td('', $subjson['data']['substitute items'][$i]['same/like']);
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
                    $tb->td('', $subjson['data']['internal notes'][$i]['internal note']);
            }
        $tb->closetablesection('tbody');
        $notestable = $tb->close();
    } else {
        $notestable == false;
    }

?>
