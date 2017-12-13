<?php
	$soconfig = json_decode(file_get_contents($config->paths->templates."configs/so-config.json"), true);
	
	$dplusoclasses = require $config->paths->vendor."cptechinc/dpluso-processwire-classes/vendor/composer/autoload_files.php";
	foreach ($dplusoclasses as $class) {
		include_once($class);
	}
	
	include_once($config->paths->vendor."cptechinc/dpluso-screen-formatters/vendor/autoload.php");
	
//	TableFormatter::set_filedirectory($config->jsonfilepath);
	//TableFormatter::set_testfiledirectory($config->paths->vendor."cptechinc/dpluso-screen-formatters/src/examples/");
	//TableFormatter::set_fieldfiledirectory($config->companyfiles."json/");
