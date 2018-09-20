<?php 
	$config->user_roles = array(
		'default' => array(
			'label' => 'Default',
			'homepage' => $config->pages->dashboard
		),
		'sales-manager' => array(
			'label' => 'Sales Manager',
			'homepage' => $config->pages->dashboard
		),
		'sales-rep' => array(
			'label' => 'Sales Rep',
			'homepage' => $config->pages->dashboard
		),
		'warehouse' => array(
			'label' => 'Warehouse',
			'homepage' => $config->pages->warehouse
		),
	);
