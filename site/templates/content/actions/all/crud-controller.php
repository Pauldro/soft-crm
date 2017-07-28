<?php
    $actiontype = 'all';
    switch ($input->urlSegment1) {
        case 'load':
            switch ($input->urlSegment2) {
                case 'list':
                    if (!$config->ajax) {
                        $actionpanel = new UserActionPanel($input->urlSegment3, 'all', '#actions-panel', '#actions-panel', '#ajax-modal', $config->ajax);
                        $actionpanel->querylinks = UserAction::getlinkarray();
                        $actionpanel->querylinks['assignedto'] = $user->loginid;
                    }
                    switch($input->urlSegment3) {
                        case 'user':
                            if ($config->ajax) {
        						include $config->paths->content.'dashboard/actions/actions-panel.php';
        					} else {
        						$title = 'Viewing User Action List';
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
        						$title = 'Viewing User Action List';
        						$modalbody = $config->paths->content.'actions/all/lists/cust-list.php';
        						include $config->paths->content."common/include-blank-page.php";
        					}
                            break;
                        case 'order':
                            if ($config->ajax) {
        						include $config->paths->content.'edit/orders/actions/actions-panel.php';
        					} else {
                                $actionpanel->setuporderpanel($ordn);
                                $actionpanel->querylinks['salesorderlink'] = $qnbr;
        						$title = 'Viewing User Actions for Order #' . $qnbr;
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
        						$title = 'Viewing User Actions for Quote ' . $qnbr;
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
