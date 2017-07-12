<?php

	$tasktypes = array(
		'email' => array(
			'icon' => '<i class="material-icons md-18">&#xE0BE;</i>',
			'value' => 'email',
			'label' => 'Email'
		),
		'follow' => array(
			'icon' => '<i class="glyphicon glyphicon-time"></i>',
			'value' => 'follow',
			'label' => 'Follow up'
		),
		'phone' => array(
			'icon' => '<i class="glyphicon glyphicon-earphone"></i>',
			'value' => 'phone',
			'label' => 'call'
		)
	);

	$sojson = file_get_contents($config->paths->site."so-config.json");
	$soconfig = json_decode($sojson, true);

	include $config->paths->assets."classes/crm/src/TaskClass.php";
	include $config->paths->assets."classes/crm/src/NoteClass.php";
	include $config->paths->assets."classes/crm/src/ContactClass.php";
	include $config->paths->assets."classes/crm/src/NotePanelClass.php";
	include $config->paths->assets."classes/crm/src/TaskPanelClass.php";
	//include $config->paths->assets."classes/TaskScheduler.php";
