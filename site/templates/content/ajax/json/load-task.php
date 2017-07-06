<?php
    header('Content-Type: application/json');
    $taskid = $input->get->id;
    $task = loadtask($taskid, false);

    if ($task) {
        echo json_encode(array('response' => $task));
    }
