<?php
	$notesfile = $config->jsonfilepath.session_id()."-vinotes.json";
	// $notesfile = $config->jsonfilepath."vintv-vinotes.json";

	if ($config->ajax) {
		echo $page->bootstrap->openandclose('p', '', $page->bootstrap->makeprintlink($config->filename, 'View Printable Version'));
	}

	if (file_exists($notesfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$notesjson = json_decode(file_get_contents($notesfile), true);
		$notesjson = $notesjson ? $notesjson : array('error' => true, 'errormsg' => 'The Vendor Notes JSON contains errors. JSON ERROR: '.json_last_error()); 

		if ($notesjson['error']) {
			echo $page->bootstrap->createalert('warning', $notesjson['errormsg']); 
		} else {
			$internalcolumns = array_keys($notesjson['columns']['internal notes']);
			$purchasecolumns = array_keys($notesjson['columns']['purchase order notes']);
			
			if (sizeof($notesjson['data']) > 0) {
				echo '<div class="row">';
                    echo '<div class="col-sm-6">';
    					$tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
                        $tb->tablesection('thead');
    					foreach ($internalcolumns as $column) {
    						$tb->tr();
    						$tb->th('class='.$config->textjustify[$notesjson['columns']['internal notes'][$column]['headingjustify']], $notesjson['columns']['internal notes'][$column]['heading']);
                            $tb->closetablesection('thead');
                            $tb->tablesection('tbody');
                            $internalcount = count($notesjson['data']['internal notes']);
                            for ($i = 1; $i < $internalcount + 1; $i++) {
                                $tb->tr();
                                $tb->td('class='.$config->textjustify[$notesjson['columns']['internal notes'][$column]['datajustify']], $notesjson['data']['internal notes']["$i"]['internal note']);
                            }
    					}
                        $tb->closetablesection('tbody');
    					echo $tb->close();
    				echo '</div>';

    				echo '<div class="col-sm-6">';
                        $tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
                        $tb->tablesection('thead');
                        foreach ($purchasecolumns as $column) {
                            $tb->tr();
                            $tb->th('class='.$config->textjustify[$notesjson['columns']['purchase order notes'][$column]['headingjustify']], $notesjson['columns']['purchase order notes'][$column]['heading']);
                            $tb->closetablesection('thead');
                            $tb->tablesection('tbody');
                            $purchasecount = count($notesjson['data']['purchase order notes']);
                            for ($i = 1; $i < $purchasecount + 1; $i++) {
                                $tb->tr();
                                $tb->td('class='.$config->textjustify[$notesjson['columns']['purchase order notes'][$column]['datajustify']], $notesjson['data']['purchase order notes']["$i"]['purchase order note']);
                            }
                        }
                        $tb->closetablesection('tbody');
    					echo $tb->close();
    				echo '</div>';
                echo '</div>';    
			} else {
				echo $page->bootstrap->createalert('warning', 'Information Not Available'); 
			} // END if (sizeof($notesjson['data']) > 0)
		}
	} else {
		echo $page->bootstrap->createalert('warning', 'Vendor has no Notes'); 
	}
?>
