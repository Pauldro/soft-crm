<?php
	$user->loggedin = is_validlogin(session_id());
	$url = !empty($session->loc) ? $session->loc : $config->pages->index;
	$session->remove('loc');

	// Check if user was trying to log in, then handle redirect of login
	if ($session->loggingin) {
		$session->remove('loggingin');

		if (!$user->loggedin) {
			$url = $config->pages->login;
		} else {
			if ($config->roles->does_role_exist($user->mainrole)) {
				$url = $config->roles->get_role_homepage($user->mainrole);
			} else {
				$url = $config->roles->get_role_homepage('default');
			}
		}
	}

	header("Location: $url");
	exit;
