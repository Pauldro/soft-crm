<?php 
	if (checkformatterifexists($user->loginid, 'ii-outline', false)) {
		$formatterjson = json_decode(getformatter($user->loginid, 'ii-outline', false), true);
	} else {
		$default = $config->paths->content."item-information/screen-formatters/default/ii-outline.json";
		$formatterjson = json_decode(file_get_contents($default), true);
	}

	$detailcolumns = array_keys($formatterjson['detail']['columns']);
    
	$fieldsjson = json_decode(file_get_contents($config->companyfiles."json/iihfmattbl.json"), true);

	$table = array(
		'maxcolumns' => $formatterjson['cols'],
		'detail' => array('maxrows' => $formatterjson['detail']['rows'], 'rows' => array()),
	);

	for ($i = 1; $i < $formatterjson['detail']['rows'] + 1; $i++) {
		$table['detail']['rows'][$i] = array('columns' => array());
		foreach($detailcolumns as $column) {
			if ($formatterjson['detail']['columns'][$column]['line'] == $i) {
				$col = array(
					'id' => $column, 
					'label' => $formatterjson['detail']['columns'][$column]['label'], 
					'column' => $formatterjson['detail']['columns'][$column]['column'], 
					'col-length' => $formatterjson['detail']['columns'][$column]['col-length'], 
					'before-decimal' => $formatterjson['detail']['columns'][$column]['before-decimal'],
					'after-decimal' => $formatterjson['detail']['columns'][$column]['after-decimal'], 
					'date-format' => $formatterjson['detail']['columns'][$column]['date-format']
				 );
				$table['detail']['rows'][$i]['columns'][$formatterjson['detail']['columns'][$column]['column']] = $col;
			}
		}
	}

	return $table;
