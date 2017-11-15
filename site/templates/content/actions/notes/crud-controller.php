<?php
    $actiontype = "notes";
	$page->useractionpanelfactory = new UserActionPanelFactory($assigneduserID, $page->fullURL, $actiontype);
    
    switch ($input->urlSegment1) {
        case 'add':
            switch($input->urlSegment2) {
                case 'new':
                    if (file_exists($config->paths->content."actions/notes/$config->cptechcustomer-new-note.php")) {
                        include $config->paths->content."actions/notes/$config->cptechcustomer-new-note.php";
                    } else {
                        include $config->paths->content."actions/notes/new-note.php";
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
                    switch($input->urlSegment3) {
                        case 'user':
                            if ($config->ajax) {
                                include $config->paths->content.'dashboard/actions/actions-panel.php';
                            } else {
                                $page->title = '';
                                $page->body = $config->paths->content.'dashboard/actions/actions-list.php';
                                include $config->paths->content.'common/include-blank-page.php';
                            }
                            break;
                        case 'cust':
                            if ($config->ajax) {
                                include $config->paths->content.'customer/cust-page/actions/actions-panel.php';
                            } else {
                                $page->title = '';
                                $page->body = $config->paths->content.'customer/cust-page/actions/actions-list.php';
                                include $config->paths->content.'common/include-blank-page.php';
                            }
                            break;
						case 'contact':
                            if ($config->ajax) {
                                include $config->paths->content.'customer/contact/actions/actions-panel.php';
                            } else {
                                $page->title = '';
                                $page->body = $config->paths->content.'customer/contact/actions/actions-list.php';
                                include $config->paths->content.'common/include-blank-page.php';
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
                                $page->title = '';
                                $page->body = $config->paths->content.'edit/orders/actions/actions-list.php';
                                include $config->paths->content.'common/include-blank-page.php';
                            }
                            break;
                        case 'quote':
                            if ($config->ajax) {
                                include $config->paths->content.'edit/quotes/actions/actions-panel.php';
                            } else {
                                $page->title = '';
                                $page->body = $config->paths->content.'edit/quotes/actions/actions-list.php';
                                include $config->paths->content.'common/include-blank-page.php';
                            }
                            break;
                    }
                    break;
                default:
					$noteID = $input->get->text('id');
					$fetchclass = true;
					$note = get_useraction($noteID, $fetchclass, false);
					$messagetemplate = "Viewing Note for {replace}";
					$page->title = $note->generate_message($messagetemplate);

                    if ($config->ajax) {
                        $page->body = $config->paths->content.'actions/notes/view-note.php';
						include $config->paths->content.'common/modals/include-ajax-modal.php';
                    } else {
                        $page->body = $config->paths->content.'actions/notes/view-note.php';
                        include $config->paths->content."common/include-blank-page.php";
                    }
                    break;
            }
            break;
    }
