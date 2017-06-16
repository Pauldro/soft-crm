<?php
	$taskemail = new stdClass();
	$taskemail->icon = '<i class="material-icons md-18">&#xE0BE;</i>';
	$taskemail->value = 'email';
	$taskemail->label = 'Email';

	$taskfollowup = new stdClass();
	$taskfollowup->icon = '<i class="glyphicon glyphicon-time"></i>';
	$taskfollowup->value = 'follow';
	$taskfollowup->label = 'Follow up';

	$taskphone = new stdClass();
	$taskphone->icon = '<i class="glyphicon glyphicon-earphone"></i>';
	$taskphone->value = 'phone';
	$taskphone->label = 'Call';
	$tasktypes = array($taskemail, $taskfollowup, $taskphone);

	$sojson = file_get_contents($config->paths->site."so-config.json");
	$soconfig = json_decode($sojson, true);
	 include $config->paths->assets."classes/crm/src/TaskClass.php";
	include $config->paths->assets."classes/crm/src/NoteClass.php";
	include $config->paths->assets."classes/crm/src/ContactClass.php";
	include $config->paths->assets."classes/crm/src/NotePanelClass.php";
	include $config->paths->assets."classes/crm/src/TaskPanelClass.php";
	//include $config->paths->assets."classes/TaskScheduler.php";
