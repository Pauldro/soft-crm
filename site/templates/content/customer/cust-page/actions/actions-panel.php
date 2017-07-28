<?php
    if (!isset($actiontype)) {$actiontype = 'all';}
    $actionpanel = new UserActionPanel('cust', $actiontype, '#actions-panel', '#actions-panel', '#ajax-modal', $config->ajax);
    $actionpanel->setupcustomerpanel($custID, $shipID);
    $actionpanel->setuptasks($input->get->text('action-status'));
    $actionpanel->querylinks = UserAction::getlinkarray();

    $actionpanel->querylinks['assignedto'] = $user->loginid;
    $actionpanel->querylinks['completed'] = $actionpanel->databasetaskstatus();
    $actionpanel->querylinks['customerlink'] = $custID;
    $actionpanel->querylinks['shiptolink'] = $shipID;
    if ($actiontype != 'all') {
        $actionpanel->querylinks['actiontype'] = $actiontype;
    }
    $actionpanel->count = getuseractionscount($user->loginid, $actionpanel->querylinks, false);
    include $config->paths->content."actions/actions-panel.php";
