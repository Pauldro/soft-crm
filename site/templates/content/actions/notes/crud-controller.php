<?php
    $actiontype = "note";
	if ($input->get->modal) {
		$partialid = 'actions-modal';
		$config->modal = true;
	} else {
		$partialid = 'actions';
	}
    switch ($input->urlSegment1) {
        case 'add':
            switch($input->urlSegment2) {
                case 'new':
                    if ($config->ajax) {
                		include $config->paths->content."actions/notes/new-note.php";
                    } else {
                        $title = 'Viewing User Note List';
                        $modalbody = $config->paths->content."actions/notes/new-note.php";
                        include $config->paths->content."common/include-blank-page.php";
                    }
                    break;
                default:
                    include $config->paths->content."actions/notes/crud/add-note.php";
                    break;
            }
            break;
        case 'load':
            switch ($input->urlSegment2) {
                case 'list':
                    if (!$config->ajax) {
    					$actionpanel = new UserActionPanel($input->urlSegment3, 'note', $partialid, '#ajax-modal', $config->ajax, $config->modal);
                        $actionpanel->querylinks = UserAction::getlinkarray();
                        $actionpanel->querylinks['assignedto'] = $user->loginid;
                        $actionpanel->querylinks['actiontype'] = 'note';
                    }

                    switch($input->urlSegment3) {
                        case 'user':
                            if ($config->ajax) {
        						include $config->paths->content.'dashboard/actions/actions-panel.php';
        					} else {
        						$title = 'Viewing User Note List';
        						$modalbody = $config->paths->content.'actions/notes/lists/user-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                        case 'cust':
                            if ($config->ajax) {
        						include $config->paths->content.'customer/cust-page/actions/actions-panel.php';
        					} else {
                                $actionpanel->setupcustomerpanel($custID, $shipID);
                                $actionpanel->querylinks['customerlink'] = $custID;
                                $actionpanel->querylinks['shiptolink'] = $shipID;
        						$title = 'Viewing Customer Note List';
        						$modalbody = $config->paths->content.'actions/notes/lists/cust-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
						case 'contact':
                            if ($config->ajax) {
        						include $config->paths->content.'customer/contact/actions-panel.php';
        					} else {
                                $actionpanel->setupcontactpanel($custID, $shipID, $contactID);
                                $actionpanel->querylinks['customerlink'] = $custID;
                                $actionpanel->querylinks['shiptolink'] = $shipID;
								$actionpanel->querylinks['contactlink'] = $contactID;
        						$title = 'Viewing User Actions List';
        						$modalbody = $config->paths->content.'actions/notes/lists/contact-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                        case 'order':
                            if ($config->ajax) {
        						include $config->paths->content.'edit/orders/actions/actions-panel.php';
        					} else {
                                $actionpanel->setuporderpanel($ordn);
                                $actionpanel->querylinks['salesorderlink'] = $ordn;
        						$title = 'Viewing Order #'.$ordn.' Notes List';
        						$modalbody = $config->paths->content.'actions/notes/lists/order-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                        case 'quote':
                            if ($config->ajax) {
        						include $config->paths->content.'edit/orders/actions/actions-panel.php';
        					} else {
                                $actionpanel->setupquotepanel($qnbr);
                                $actionpanel->querylinks['quotelink'] = $qnbr;
        						$title = 'Viewing Quote #'.$qnbr.' Notes List';
        						$modalbody = $config->paths->content.'actions/notes/lists/order-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;

                    }
                    break;
                default:
                    if ($config->ajax) {
                        include $config->paths->content.'actions/notes/view-note.php';
                    } else {
                        $title = 'Note ID: ' . $input->get->text('id');
                        $modalbody = $config->paths->content.'actions/notes/view-note.php';
                        include $config->paths->content."common/include-blank-page.php";
                    }
                    break;
            }
            break;
    }
