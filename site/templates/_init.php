<?php

/**
 * Initialization file for template files
 *
 * This file is automatically included as a result of $config->prependTemplateFile
 * option specified in your /site/config.php.
 *
 * You can initialize anything you want to here. In the case of this beginner profile,
 * we are using it just to include another file with shared functions.
 *
 */

	include_once("./_func.php"); // include our shared functions
	include_once("./_dbfunc.php");

	include_once($config->paths->content."common/initialize.php");

	include $config->paths->vendor."cptech/src/UserAction.class.php";
	include $config->paths->vendor."cptech/src/UserActionPanel.class.php";
	include $config->paths->vendor."cptech/src/Contact.class.php";
	include $config->paths->vendor."cptech/src/Table.php";
	include $config->paths->vendor."cptech/src/utfport.php";
	include $config->paths->vendor."cptech/src/DplusDateTime.class.php";

	$session->sessionName = session_name();

	$page->fullURL = new \Purl\Url($page->httpUrl);
	$page->fullURL->path = '';
	if (!empty($config->filename) && $config->filename != '/') {
		$page->fullURL->join($config->filename);
	}

	$page->querystring = $querystring = $page->fullURL->query;
	$page->PageURL = $page->httpUrl.'?'.$page->querystring;

	$config->styles->appendwithfilehash('styles/bootstrap.min.css');
	$config->styles->append('https://fonts.googleapis.com/icon?family=Material+Icons');
	$config->styles->appendwithfilehash('styles/libraries.css');
	$config->styles->appendwithfilehash('styles/styles.css');

	$config->scripts->appendwithfilehash('scripts/js-config.js');
	$config->scripts->appendwithfilehash('scripts/libraries.js');
	$config->scripts->appendwithfilehash('scripts/libs/key-listener.js');
	$config->scripts->appendwithfilehash('scripts/libs/datatables.js');
	$config->scripts->appendwithfilehash('scripts/classes.js');

	if (file_exists($config->paths->templates."scripts/$config->dplusocompany-scripts.js")) {
		$config->scripts->appendwithfilehash("scripts/$config->dplusocompany-scripts.js");
	} else {
		$config->scripts->appendwithfilehash('scripts/scripts.js');
	}

	//$config->scripts->append($config->urls->modules . 'Inputfield/InputfieldCKEditor/ckeditor-4.6.1/ckeditor.js');

	$user->loggedin = is_validlogin(session_id());

	if ($user->loggedin) {
		setupuser(session_id());
	} elseif (strtolower($page->title) != 'login' && strtolower($page->title) != 'redir' ) {
		header('location: ' . $config->pages->login);
		exit;
	}

	if ($input->get->modal) {
		$config->modal = true;
	}
