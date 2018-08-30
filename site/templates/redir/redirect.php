<?php
	$loggedin = is_validlogin(session_id());
	$url = !empty($session->loc) ? $session->loc : $config->pages->index;
	$session->remove('loc');

	// Check if user was trying to log in, then handle redirect of login
	if ($session->loggingin) {
		$session->remove('loggingin');

		if (!$loggedin) {
			$url = $config->pages->login;
		} else {
			$url = $config->pages->index;
		}
	}

	header("Location: $url");
	exit;
