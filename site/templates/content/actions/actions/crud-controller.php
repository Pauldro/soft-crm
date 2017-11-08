<?php
    $actiontype = "actions";
	$page->useractionpanelfactory = new UserActionPanelFactory($assigneduserID, $page->fullURL, $actiontype);

    switch ($input->urlSegment1) {
        case 'add':
            switch($input->urlSegment2) {
                case 'new':
                    if (file_exists($config->paths->content."actions/actions/$config->cptechcustomer-new-action.php")) {
                        include $config->paths->content."actions/actions/$config->cptechcustomer-new-action.php";
                    } else {
                        include $config->paths->content."actions/actions/new-action.php";
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
                    switch($input->urlSegment3) {
                        case 'user':
                            if ($config->ajax) {
        						include $config->paths->content.'dashboard/actions/actions-panel.php';
        					} else {
        						include $config->paths->content.'dashboard/actions/actions-panel.php';
        					}
                            break;
                        case 'cust':
                            if ($config->ajax) {
        						include $config->paths->content.'customer/cust-page/actions/actions-panel.php';
        					} else {
                                 // TODO ACTION LIST
        					}
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
        						include $config->paths->content.'edit/orders/actions/actions-panel.php';
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
					$actionid = $input->get->id;
					$fetchclass = true;
					$action = loaduseraction($actionid, $fetchclass, false);
					$messagetemplate = "Viewing Action for {replace}";
					$page->title = $action->generate_message($messagetemplate);

                    if ($config->ajax) {
                        $page->body = $config->paths->content.'actions/actions/view-action.php';
						include $config->paths->content.'common/modals/include-ajax-modal.php';
                    } else {
                        $page->body = $config->paths->content.'actions/actions/view-action.php';
                        include $config->paths->content."common/include-blank-page.php";
                    }
                    break;
            }
            break;
    }
