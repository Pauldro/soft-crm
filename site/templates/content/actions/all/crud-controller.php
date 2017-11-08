<?php
    $actiontype = 'all';
    $page->useractionpanelfactory = new UserActionPanelFactory($assigneduserID, $page->fullURL, $actiontype);

    switch ($input->urlSegment1) {
        case 'load':
            switch ($input->urlSegment2) {
                case 'list':
                    switch($input->urlSegment3) {
                        case 'user':
                            if ($config->ajax) {
								include $config->paths->content.'dashboard/actions/actions-panel.php';
        					} else {
        					    // TODO ACTION LIST
        					}
                            break;
                        case 'cust':
                            include $config->paths->content.'customer/cust-page/actions/actions-panel.php';
                            break;
						case 'contact':
                            if ($config->ajax) {
        						include $config->paths->content.'customer/contact/actions-panel.php';
        					} else {
                                 // TODO ACTION LIST
        					}
                            break;
                        case 'salesorder':
                            if ($config->ajax) {
								if ($config->modal) {
									$page->title = 'Viewing actions for Order #'.$ordn;
									$page->body = $config->paths->content.'edit/orders/actions/actions-panel.php';
									include $config->paths->content."common/modals/include-ajax-modal.php";
								} else {
									include $config->paths->content.'edit/orders/actions/actions-panel.php';
								}
        					} else {
                                 // TODO ACTION LIST
        					}
                            break;
                        case 'quote':
                            if ($config->ajax) {
        						include $config->paths->content.'edit/quotes/actions/actions-panel.php';
        					} else {
                                 // TODO ACTION LIST
        					}
                            break;
                    }
                    break;
                default:
                    if ($config->ajax) {
                        include $config->paths->content.'actions/tasks/view-task.php';
                    } else {
                        $page->title = 'Task ID: ' . $input->get->text('id');
                        $page->body = $config->paths->content.'actions/tasks/view-task.php';
                        include $config->paths->content."common/include-blank-page.php";
                    }
                    break;
            }
            break;
    }
