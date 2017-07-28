<?php
    if (!isset($actiontype)) {$actiontype = 'all';}
    $actionpanel = new UserActionPanel('user', $actiontype, '#actions-panel', '#actions-panel', '#ajax-modal', $config->ajax);
    $actionpanel->setuptasks($input->get->text('action-status'));
    $actionpanel->querylinks = UserAction::getlinkarray();
    $actionpanel->querylinks['assignedto'] = $user->loginid;

    if ($actiontype != 'all') {
        $actionpanel->querylinks['actiontype'] = $actiontype;
    }

    $actionpanel->count = getuseractionscount($user->loginid, $actionpanel->querylinks, false);

    include $config->paths->content."actions/actions-panel.php";
