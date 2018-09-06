<?php
	$user->loggedin = is_validlogin(session_id());
	$L = $session->loc;

	if ($L == "") {
		if (in_array($user->mainrole, array_keys($config->rolehomepages))) {
			$L = $config->rolehomepages[$user->mainrole]; 
		} else {
			$L = $config->rolehomepages['default']; 
		}
	} elseif ($L == 'login') {
		if (!$user->loggedin) {
			$L = $config->pages->login;
		} else {
			if (in_array($user->mainrole, array_keys($config->rolehomepages))) {
				$L = $config->rolehomepages[$user->mainrole]; 
			} else {
				$L = $config->rolehomepages['default']; 
			}
		}
	}
	header("Location: ". $L);
	exit;
