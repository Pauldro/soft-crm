<?php

	switch ($input->urlSegment1) {
		case 'add':
			if ($input->requestMethod() == 'POST') { // CREATE IN CRUD
				include $config->paths->content."actions/actions/crud/create-action.php";
			} else { // SHOW FORM
				include $config->paths->content."actions/actions/new-action.php";
			}
			break;
		case 'update':
			if ($input->requestMethod() == 'POST') { // CREATE IN CRUD
				$config->json = true;      
				$page->body = $config->paths->content."user-actions/crud/update/$type.php";
			} else {
				$id = $input->get->text('id');
				$type = UserAction::$types[$action->actiontype];
				$$type = $action;
				$message = "Writing {$$type} for {replace} ";
				$page->title = $note->generate_message($message);
				include $config->paths->content."user-actions/crud/update/$type-form-router.php";
			}
			break;
		default: // READ IN CRUD
			if ($input->get->id) {
				$id = $input->get->text('id');

				$action = UserAction::load($id);
				$messagetemplate = "Viewing Action for {replace}";
				$page->title = $action->generate_message($messagetemplate);
				$type = UserAction::$types[$action->actiontype];
				$page->body = $config->paths->content."user-actions/crud/read/$type.php";
				$$type = $action;
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

	if ($config->modal && $config->ajax) {
		include $config->paths->content.'common/modals/include-ajax-modal.php';
	} elseif ($config->ajax) {
		include $page->body;
	} elseif ($config->json) {
		include $page->body;
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}
