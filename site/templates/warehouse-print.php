<?php
	if ($input->get->referenceID) {
		$sessionID = $input->get->text('referenceID');
		$login =  get_loginrecord($sessionID);
		$user->loginid = $login['loginid'];
	} else {
		$sessionID = session_id();
	}

	$whsesession = WhseSession::load($sessionID);
	$whsesession->init();
	$whseconfig = WhseConfig::load($whsesession->whseid);

	$permission = (!empty($page->dplusfunction)) ? has_dpluspermission($user->loginid, $page->dplusfunction) : true;

	if ($permission) {
		include ($config->paths->content."{$page->parent->path}print-logic.php");
	} else {
		include $config->paths->content."common/permission-denied-page.php";
	}
