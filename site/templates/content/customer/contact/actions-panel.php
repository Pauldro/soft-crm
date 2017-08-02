<?php
    if (!isset($actiontype)) {$actiontype = 'all';}
	if (!isset($partialid)) {$partialid = 'actions';}
    $actionpanel = new UserActionPanel('contact', $actiontype, $partialid, '#ajax-modal', $config->ajax, $config->modal);
    $actionpanel->setupcontactpanel($custID, $shipID, $contactID);
    $actionpanel->setuptasks($input->get->text('action-status'));
    $actionpanel->querylinks = UserAction::getlinkarray();

    $actionpanel->querylinks['assignedto'] = $user->loginid;
    $actionpanel->querylinks['completed'] = $actionpanel->databasetaskstatus();
    $actionpanel->querylinks['customerlink'] = $custID;
    $actionpanel->querylinks['shiptolink'] = $shipID;
    $actionpanel->querylinks['contactlink'] = $contactID;
    if ($actiontype != 'all') {
        $actionpanel->querylinks['actiontype'] = $actiontype;
    }
    $actionpanel->count = getuseractionscount($user->loginid, $actionpanel->querylinks, false);
    include $config->paths->content."actions/actions-panel.php";
