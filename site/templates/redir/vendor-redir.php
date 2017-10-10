<?php
	/**
	* VENDOR REDIRECT
	* @param string $action
	*
	*/

	$action = ($input->post->action ? $input->post->text('action') : $input->get->text('action'));
	$vendorID = ($input->post->custID ? $input->post->text('vendorID') : $input->get->text('vendorID'));
	

	$session->{'from-redirect'} = $page->url;

	$filename = session_id();

	/**
	* CUSTOMER REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	* 	case 'vi-buttons': 760p
	* 		DBNAME=$config->DBNAME
	*		VIBUTTONS
	*		break;
	*	case 'vi-vendor': 759p  //AUTO CALLS vi-buttons and vi-shipfromlist
	*		DBNAME=$config->DBNAME
	*		VIVENDOR
	*		VENDID=$custID
	* 		break;
	* 	case 'vi-shipfrom-list'
	* 		DBNAME=$config->DBNAME
	*		VISHIPFROMLIST
	*		VENDID=$custID
	* 		break;
	* }
	*
	**/


	switch ($action) {
		case 'vi-buttons': //NOT USED WILL BE AUTOCALLED BY vend-vendor
			$data = array('DBNAME' => $config->dbName, 'VIBUTTONS' => false);
			$session->loc = $config->pages->index;
			break;
		case 'vi-vendor':
			$data = array('DBNAME' => $config->dbName, 'VIVENDOR' => $vendorID);
			$session->loc = $config->pages->vendinfo. "$vendorID/";
			break;
		case 'vi-shipfrom-list':
			$data = array('DBNAME' => $config->dbName, 'VISHIPFROMLIST' => $vendorID);
			$session->loc = $config->pages->index;
			break;
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);
 	exit;
