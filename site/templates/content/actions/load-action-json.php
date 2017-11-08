<?php
    header('Content-Type: application/json');
    $actionID = $input->get->id;
    $action = loaduseraction($actionID, true, false); // (id, bool fetchclass, bool debug)

    if ($action) {
        $urls = array(
            'completion' => $action->generate_completionurl('true'),
            'view' => $action->generate_viewactionurl(),
            'reschedule' => $action->generate_rescheduleurl()
        );
        $action->urls = $urls;
        echo json_encode(array(
            'response' => array(
                'error' => false,
                'action' => $action
            )
        ));
    } else {
        echo json_encode( array(
            'response' => array(
                'error' => true,
                'message' => 'Error finding Action with ID ' . $actionID
            )
        ));
    }
