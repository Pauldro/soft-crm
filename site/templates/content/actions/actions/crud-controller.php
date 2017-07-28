<?php
    $actiontype = "action";
    switch ($input->urlSegment1) {
        case 'add':
            switch($input->urlSegment2) {
                case 'new':
                    if ($config->ajax) {
                        include $config->paths->content."actions/actions/new-action.php";
                    } else {
                        $title = 'Add New Action';
                        $modalbody = $config->paths->content."actions/actions/new-action.php";
                        include $config->paths->content."common/include-blank-page.php";
                    }
                    break;
                default:
                    include $config->paths->content."actions/actions/crud/add-action.php";
                    break;
            }
            break;
        case 'load':
            switch ($input->urlSegment2) {
                case 'list':
                    if (!$config->ajax) {
                        $actionpanel = new UserActionPanel($input->urlSegment3, 'action', '#actions-panel', '#actions-panel', '#ajax-modal', $config->ajax);
                        $actionpanel->setuptasks($input->get->text('action-status'));
                        $actionpanel->querylinks = UserAction::getlinkarray();
                        $actionpanel->querylinks['assignedto'] = $user->loginid;
                        $actionpanel->querylinks['actiontype'] = 'action';
                    }

                    switch($input->urlSegment3) {
                        case 'user':
                            if ($config->ajax) {
        						include $config->paths->content.'dashboard/actions/actions-panel.php';
        					} else {
        						$title = 'Viewing User Action List';
        						$modalbody = $config->paths->content.'actions/actions/lists/user-list.php';
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
        						$title = 'Viewing User Actions List';
        						$modalbody = $config->paths->content.'actions/actions/lists/cust-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                        case 'order':
                            if ($config->ajax) {
        						include $config->paths->content.'edit/orders/actions/actions-panel.php';
        					} else {
                                $actionpanel->setuporderpanel($qnbr);
                                $actionpanel->querylinks['salesorderlink'] = $ordn;
        						$title = 'Viewing Order #'.$ordn.' Actions List';
        						$modalbody = $config->paths->content.'actions/actions/lists/order-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                        case 'quote':
                            if ($config->ajax) {
        						include $config->paths->content.'edit/quotes/actions/actions-panel.php';
        					} else {
                                $actionpanel->setupquotepanel($qnbr);
                                $actionpanel->querylinks['quotelink'] = $qnbr;
        						$title = 'Viewing Quote #'.$qnbr.' List';
        						$modalbody = $config->paths->content.'actions/actions/lists/quote-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                    }
                    break;
                default:
                    if ($config->ajax) {
                        include $config->paths->content.'actions/actions/view-action.php';
                    } else {
                        $title = 'Action ID: ' . $input->get->text('id');
                        $modalbody = $config->paths->content.'actions/actions/view-action.php';
                        include $config->paths->content."common/include-blank-page.php";
                    }
                    break;
            }
            break;
    }
