<?php
	switch ($input->urlSegment1) {
		case 'add':
			if ($input->requestMethod() == 'POST') { // CREATE IN CRUD
				$config->json = true;
				// MOST Actions will have a verb-type format. ex. create-task reschedule-task
				$type = preg_replace("(\w+-)", '', $input->post->text('action'));
				$page->body = $config->paths->content."user-actions/crud/create/$type.php";
			} else { // SHOW FORM
				$type = $input->get->text('type');
				$action = new UserAction();
				$action->set('assignedto', $user->loginid);
				$action->set('customerlink', $input->get->text('custID'));
				$action->set('shiptolink', $input->get->text('shiptoID'));
				$action->set('contactlink', $input->get->text('contactID'));
				$action->set('salesorderlink', $input->get->text('ordn'));
				$action->set('quotelink', $input->get->text('qnbr'));
				$action->set('actionlink', $input->get->text('actionID'));
				$$type = $action;

				$page->title = $action->generate_message("Creating $type for {replace}");
				$page->body = $config->paths->content."user-actions/crud/create/$type-form.php";
			}
			break;
		case 'update':
			if ($input->requestMethod() == 'POST') { // CREATE IN CRUD
				$config->json = true;
				$id = $input->post->text('id');
				$action = UserAction::load($id);
				$type = UserAction::$types[$action->actiontype];
				$page->body = $config->paths->content."user-actions/crud/update/$type.php";
			} else {
				$id = $input->get->text('id');
				$action = UserAction::load($id);
				$type = UserAction::$types[$action->actiontype];
				$$type = $action;

				if ($input->get->complete) {
					$config->json = true;
					$page->body = $config->paths->content."user-actions/crud/update/$type.php";
				} else {
					$message = "Writing $type for {replace} ";
					$page->title = $action->generate_message($message);
					$editactiondisplay = new EditUserActionsDisplay($page->fullURL);
					include $config->paths->content."user-actions/crud/update/$type-form-router.php";
				}
			}
			break;
		default: // READ IN CRUD
			if ($input->get->id) {
				$id = $input->get->text('id');
				$action = UserAction::load($id);
				$type = UserAction::$types[$action->actiontype];
				$$type = $action;
				$page->title = $action->generate_message("Viewing Action for {replace}");
				$page->body = $config->paths->content."user-actions/crud/read/$type.php";
			} else {
				if ($input->get->ordn) {
					$actionpanel = new SalesOrderActionsPanel(session_id(), $page->fullURL, $input, $config->ajax);
					$actionpanel->set_ordn($input->get->text('ordn'));
					$page->body = $config->paths->content.'user-actions/user-actions-panel.php';
				} elseif ($input->get->qnbr) {
					$qnbr = $input->get->text('qnbr');
					$actionpanel = new QuoteActionsPanel(session_id(), $page->fullURL, $input);
					$actionpanel->set_qnbr($qnbr);
				} elseif ($input->get->contactID) {
					$actionpanel = new ContactActionsPanel(session_id(), $page->fullURL, $input, $config->ajax);
					$actionpanel->set_contact($input->get->text('custID'), $input->get->text('shiptoID'), $input->get->text('contactID'));
					$page->body = $config->paths->content.'user-actions/user-actions-panel.php';
				} elseif ($input->get->custID) {
					$actionpanel = new CustomerActionsPanel(session_id(), $page->fullURL, $input, $config->ajax);
					$actionpanel->set_customer($input->get->text('custID'), $input->get->text('shiptoID'));
					$page->body = $config->paths->content.'user-actions/user-actions-panel.php';
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
