<?php
	$soconfig = json_decode(file_get_contents($config->paths->templates."configs/so-config.json"), true);

	include $config->paths->templates."libs/crm/src/UserAction.class.php";
	include $config->paths->templates."libs/crm/src/UserActionPanel.class.php";
	include $config->paths->templates."libs/crm/src/ContactClass.php";
