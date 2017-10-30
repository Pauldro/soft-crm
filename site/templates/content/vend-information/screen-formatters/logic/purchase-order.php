<?php 
    if (checkformatterifexists($user->loginid, 'vi-purchase-orders', false)) {
        $formatterjson = json_decode(getformatter($user->loginid, 'vi-purchase-orders', false), true);
    } else {
        $default = $config->paths->content."vend-information/screen-formatters/default/vi-purchase-orders.json";
        $formatterjson = json_decode(file_get_contents($default), true);
    }

    $columns = array_keys($formatterjson['data']['detail']['columns']);
    $fieldsjson = json_decode(file_get_contents($config->companyfiles."json/vipofmattbl.json"), true);

    $table = array(
        'maxcolumns' => $formatterjson['data']['cols'], 
        'detail' => array(
            'maxrows' => $formatterjson['data']['detail']['rows'], 
            'rows' => array()
        ), 
    );
    
    for ($i = 1; $i < $formatterjson['data']['detail']['rows'] + 1; $i++) {
        $table['data']['detail']['rows'][$i] = array('columns' => array());
        $count = 1;
        foreach($columns as $column) {
            if ($formatterjson['data']['detail']['columns'][$column]['line'] == $i) {
                $col = array(
                    'id' => $column, 
                    'label' => $formatterjson['data']['detail']['columns'][$column]['label'], 
                    'column' => $formatterjson['data']['detail']['columns'][$column]['column'], 
                    'col-length' => $formatterjson['data']['detail']['columns'][$column]['col-length'], 
                    'before-decimal' => $formatterjson['data']['detail']['columns'][$column]['before-decimal'], 
                    'after-decimal' => $formatterjson['data']['detail']['columns'][$column]['after-decimal'], 
                    'date-format' => $formatterjson['data']['detail']['columns'][$column]['date-format']
                );
                $table['data']['detail']['rows'][$i]['columns'][$formatterjson['data']['detail']['columns'][$column]['column']] = $col;
                $count++;
            }
        }
    }
    
    return $table;
