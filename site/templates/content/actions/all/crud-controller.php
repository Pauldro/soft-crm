<?php
    $actiontype = 'all';
	if ($input->get->modal) {
		$partialid = 'actions-modal';
		$config->modal = true;
	} else {
		$partialid = 'actions';
	}
    switch ($input->urlSegment1) {
        case 'load':
            switch ($input->urlSegment2) {
                case 'list':
                    if (!$config->ajax) {
    					$actionpanel = new UserActionPanel($input->urlSegment3, 'all', $partialid, '#ajax-modal', $config->ajax, $config->modal);
                        $actionpanel->querylinks = UserAction::getlinkarray();
                        $actionpanel->querylinks['assignedto'] = $user->loginid;
                    }
                    switch($input->urlSegment3) {
                        case 'user':
                            if ($config->ajax) {
								if ($input->get->modal) {
									$modaltitle = '';
									$modalbody = $config->paths->content.'dashboard/actions/actions-panel.php';
									include $config->paths->content."common/modals/include-ajax-modal-content.php";
								} else {
									include $config->paths->content.'dashboard/actions/actions-panel.php';
								}
        					} else {
        						$title = 'User Action List';
        						$modalbody = $config->paths->content.'actions/all/lists/user-list.php';
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
        						$title = 'User Action List';
        						$modalbody = $config->paths->content.'actions/all/lists/cust-list.php';
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
        						$modalbody = $config->paths->content.'actions/all/lists/contact-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                        case 'order':
                            if ($config->ajax) {
								if ($config->modal) {
									$modaltitle = 'Viewing actions for Order #'.$ordn;
									$modalbody = $config->paths->content.'edit/orders/actions/actions-panel.php';
									include $config->paths->content."common/modals/include-ajax-modal-content.php";
								} else {
									include $config->paths->content.'edit/orders/actions/actions-panel.php';
								}
        						
        					} else {
                                $actionpanel->setuporderpanel($ordn);
                                $actionpanel->querylinks['salesorderlink'] = $ordn;
        						$title = 'User Actions for Order #' . $ordn;
								$page->title = $title;
        						$modalbody = $config->paths->content.'actions/all/lists/order-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                        case 'quote':
                            if ($config->ajax) {
        						include $config->paths->content.'edit/quotes/actions/actions-panel.php';
        					} else {
                                $actionpanel->setupquotepanel($qnbr);
                                $actionpanel->querylinks['quotelink'] = $qnbr;
        						$title = 'User Actions for Quote #' . $qnbr;
        						$modalbody = $config->paths->content.'actions/all/lists/quote-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                    }
                    break;
                default:
                    if ($config->ajax) {
                        include $config->paths->content.'actions/tasks/view-task.php';
                    } else {
                        $title = 'Task ID: ' . $input->get->text('id');
                        $modalbody = $config->paths->content.'actions/tasks/view-task.php';
                        include $config->paths->content."common/include-blank-page.php";
                    }
                    break;
            }
            break;
    }
