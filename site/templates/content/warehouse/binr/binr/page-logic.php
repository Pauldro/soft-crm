<?php
	// NOTE THE FOLLOWING IS FOR NORMAL ITEMS ONLY
	
	if ($input->get->scan) {
		$scan = $input->get->text('scan');
		$resultscount = count_invsearch(session_id());
		
		if ($resultscount == 0) {
			$page->body = $config->paths->content."{$page->path}item-form.php";
		} elseif ($resultscount == 1) {
			$item = get_firstinvsearchitem(session_id());
			$page->body = $config->paths->content."{$page->path}binr-form.php";
		} else {
			
		}
	} else {
		$page->body = $config->paths->content."{$page->path}item-form.php";
	}
	$toolbar = false;
	include $config->paths->content."common/include-toolbar-page.php";
