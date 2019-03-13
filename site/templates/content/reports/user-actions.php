<?php
	use Dplus\Dpluso\UserActions\ActionsPanel;
	use Dplus\Content\Paginator;

	$actionpanel = new ActionsPanel(session_id(), $page->fullURL, $input);
	$page->title = $actionpanel->generate_title();
	$salespersonjson = json_decode(file_get_contents($config->companyfiles."json/salespersontbl.json"), true);
	$salespersoncodes = array_keys($salespersonjson['data']);
	$actionpanel->set_view('list');

	$customerfilterurl = new Purl\Url($page->fullURL);

	if ($input->get->report) {
		$paginator = new Paginator($actionpanel->pagenbr, $actionpanel->count_actions(), $actionpanel->generate_refreshurl(), $actionpanel->paginateafter, $actionpanel->ajaxdata);
		include __DIR__."/user-actions/list-view.php";
		include __DIR__."/user-actions/user-actions.js.php";
	} else {
		if ($input->get->filtercust) {
			$customerfilterurl->query->remove('filtercust');
			$customerfilterurl->query->remove('q');
			$customerfilterquery = $input->get->text('customerlink');
			include __DIR__."/user-actions/customer-list.php";
		} else {
			$customerfilterurl->query->set('filtercust', 'true');
			$customers = explode(',', $input->get->text('customerlink'));
			include __DIR__."/user-actions/filter-form.php";
		}

	}
