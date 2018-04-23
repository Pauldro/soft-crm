<?php

	switch ($input->urlSegment1) {
		case 'add':
			if ($input->requestMethod() == 'POST') { // CREATE IN CRUD
				include $config->paths->content."actions/actions/crud/create-action.php";
			} else { // SHOW FORM
				include $config->paths->content."actions/actions/new-action.php";
			}
			break;
		default: // READ IN CRUD
			if ($input->get->id) {
				$actionID = $input->get->text('id');
				$action = UserAction::load($actionID);
				$messagetemplate = "Viewing Action for {replace}";
				$page->title = $action->generate_message($messagetemplate);
				
				if ($config->ajax) {
					$page->body = $config->paths->content.'actions/actions/read-action.php';
				} else {
					$page->body = $config->paths->content.'actions/actions/read-action.php';
				}
			} else {
				if ($ordn) {
					
				} elseif ($qnbr) {
					
				} elseif ($contactID) {
					
				} elseif ($custID) {
					
				} else {
					$actionpanel = new ActionsPanel(session_id(), $page->fullURL, $input, $config->ajax); 
					$page->body = $config->paths->content.'user-actions/user-actions-panel.php';
				}
			}
			break;
	}
	
	if ($config->modal) {
		include $config->paths->content.'common/modals/include-ajax-modal.php';
	} elseif ($config->ajax) {
		include $page->body;
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}
