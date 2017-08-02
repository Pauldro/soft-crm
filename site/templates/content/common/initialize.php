<?php



	$sojson = file_get_contents($config->paths->site."so-config.json");
	$soconfig = json_decode($sojson, true);

	include $config->paths->assets."classes/crm/src/UserAction.class.php";
	include $config->paths->assets."classes/crm/src/UserActionPanel.class.php";
	include $config->paths->assets."classes/crm/src/ContactClass.php";
