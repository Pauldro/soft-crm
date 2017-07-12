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

	include $config->paths->assets."classes/purl/vendor/autoload.php";
	include_once($config->paths->assets.'classes/crm/src/utfport.php');

	$config->sessionName = session_name();

	$page->fullURL = new \Purl\Url($page->httpUrl);
	$page->fullURL->join($config->filename);
	$page->querystring = $querystring = $page->fullURL->query;
	$page->PageURL = $page->httpUrl.'?'.$page->querystring;


	$config->styles->append($config->urls->templates.'styles/bootstrap.min.css');
	$config->styles->append('https://fonts.googleapis.com/icon?family=Material+Icons');
	$config->styles->append($config->urls->templates.'styles/libraries.css');
	$config->styles->append($config->urls->templates.'styles/styles.css');
	$config->styles->append($config->urls->templates.'styles/libs/fuelux.css');

	$config->scripts->append($config->urls->templates.'scripts/js-config.js');
	$config->scripts->append($config->urls->templates.'scripts/libraries.js');
	$config->scripts->append($config->urls->templates.'scripts/libs/key-listener.js');
	$config->scripts->append($config->urls->templates.'scripts/classes.js');
	$config->scripts->append($config->urls->templates.'scripts/scripts.js');
	$config->scripts->append($config->urls->templates.'scripts/fuelux.js');



	$user->loggedin = is_valid_login(session_id());
	if ($user->loggedin) {
		setupuser(session_id());
		//$restrictions = does_user_have_contact_restrictions(session_id()); Deprecate
		//$user->username
	} elseif (strtolower($page->title) != 'login' && strtolower($page->title) != 'redir' ) {
		header('location: ' . $config->pages->login);
		exit;
	}
