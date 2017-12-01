<?php 
	if (checkformatterifexists($user->loginid, 'ii-outline', false)) {
		$formatterjson = json_decode(getformatter($user->loginid, 'ii-outline', false), true);
	} else {
		$default = $config->paths->content."item-information/screen-formatters/default/ii-outline.json";
		$formatterjson = json_decode(file_get_contents($default), true);
	}

	$headercolumns = array_keys($formatterjson['header']['columns']);
    
	$fieldsjson = json_decode(file_get_contents($config->companyfiles."json/iihfmattbl.json"), true);

	$table = array(
		'maxcolumns' => $formatterjson['cols'],
		'header' => array('maxrows' => $formatterjson['header']['rows'], 'rows' => array()),
	);

	for ($i = 1; $i < $formatterjson['header']['rows'] + 1; $i++) {
		$table['header']['rows'][$i] = array('columns' => array());
		foreach($headercolumns as $column) {
			if ($formatterjson['header']['columns'][$column]['line'] == $i) {
				$col = array(
					'id' => $column, 
					'label' => $formatterjson['header']['columns'][$column]['label'], 
					'column' => $formatterjson['header']['columns'][$column]['column'], 
					'col-length' => $formatterjson['header']['columns'][$column]['col-length'], 
					'before-decimal' => $formatterjson['header']['columns'][$column]['before-decimal'],
					'after-decimal' => $formatterjson['header']['columns'][$column]['after-decimal'], 
					'date-format' => $formatterjson['header']['columns'][$column]['date-format']
				 );
				$table['header']['rows'][$i]['columns'][$formatterjson['header']['columns'][$column]['column']] = $col;
			}
		}
	}

	return $table;
