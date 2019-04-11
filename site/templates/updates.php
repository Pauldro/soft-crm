<?php
	$template = 'warehouse-function';
	$binrpage = $pages->get('/warehouse/binr/');
	$binrpage->of(false);
	$binrpage->dplusfunction = 'mbinr';
	$binrpage->save();

	$binr_pages = array(
		'binr' => array(
			'name' => 'binr',
			'title' => 'Bin Reassignment',
			'summary' => 'Move Bin Item',
			'function' => 'pbinr'
		),
		'move-from' => array(
			'name' => 'move-from',
			'title' => 'Move From',
			'summary' => 'Move Single items from same from bin',
			'function' => 'pbnrf'
		),
		'move-to' => array(
			'name' => 'move-to',
			'title' => 'Move To',
			'summary' => 'Move Single Items to the same to bin',
			'function' => 'pbnrt'
		),
		'move-bin-contents' => array(
			'name' => 'move-bin-contents',
			'title' => 'Move Bin Contents',
			'summary' => 'Move all Bin Items',
			'function' => 'pmvbn'
		)
	);

	foreach ($binr_pages as $pagename => $page) {
		if ($binrpage->numChildren("name=$pagename,include=hidden")) {
			$p = $binrpage->child("name=$pagename,,include=hidden");
			$p->of(false);
			$p->title = $page['title'];
			$p->summary = $page['summary'];
			$p->dplusfunction = $page['function'];
			$p->save();
		} else {
			$p = new Page();
			$p->template = $template; // set template
			$p->parent = $binrpage;
			$p->name = $page['name']; // give it a name used in the url for the page
			$p->title = $page['title']; // set page title (not neccessary but recommended)
			$p->summary = $page['summary'];
			$p->dplusfunction = $page['function'];
			$p->save();
		}
	}

	$inventorypage = $pages->get('/warehouse/inventory/, include=hidden');
	$inventorypage->of(false);
	$inventorypage->dplusfunction = 'mivty';
	$inventorypage->save();

	$inventory_pages = array(
		'physical-count' => array(
			'name' => 'physical-count',
			'title' => 'Physical Count',
			'summary' => 'Update Inventory with Item Tag Entry',
			'function' => 'ite'
		),
		'find-item' => array(
			'name' => 'find-item',
			'title' => 'Find Item',
			'summary' => 'Find Location(s) for an Item',
			'function' => 'pfini'
		),
		'bin-inquiry' => array(
			'name' => 'bin-inquiry',
			'title' => 'Bin Inquiry',
			'summary' => 'Show Items that are in a bin',
			'function' => 'pbini'
		),
		'print-item-label' => array(
			'name' => 'print-item-label',
			'title' => 'Print Item Label',
			'summary' => 'Print a Label for a bin Item',
			'function' => 'pilbl'
		)
	);

	foreach ($inventory_pages as $pagename => $page) {
		if ($inventorypage->numChildren("name=$pagename,include=hidden")) {
			$p = $inventorypage->child("name=$pagename,include=hidden");
			$p->of(false);
			$p->title = $page['title'];
			$p->summary = $page['summary'];
			$p->dplusfunction = $page['function'];
			$p->save();
		} else {
			$p = new Page();
			$p->template = $template; // set template
			$p->parent = $inventorypage;
			$p->name = $page['name']; // give it a name used in the url for the page
			$p->title = $page['title']; // set page title (not neccessary but recommended)
			$p->summary = $page['summary'];
			$p->dplusfunction = $page['function'];
			$p->save();
		}
	}

	$pickingpage = $pages->get('/warehouse/picking/, include=hidden');
	$pickingpage->of(false);
	$pickingpage->dplusfunction = 'mppik';
	$pickingpage->save();


	$picking_pages = array(
		'pick-order' => array(
			'name' => 'pick-order',
			'title' => 'Sales Order Picking',
			'summary' => 'Pick Items for a Sales Order',
			'function' => 'porpk'
		),
		'pick-pack' => array(
			'name' => 'pick-pack',
			'title' => 'Sales Order Picking & Packing',
			'summary' => 'Pick & Pack Items for a Sales Order',
			'function' => 'popp'
		)
	);

	foreach ($picking_pages as $pagename => $page) {
		if ($pickingpage->numChildren("name=$pagename,include=hidden")) {
			$p = $pickingpage->child("name=$pagename,include=hidden");
			$p->of(false);
			$p->title = $page['title'];
			$p->summary = $page['summary'];
			$p->dplusfunction = $page['function'];
			$p->save();
		} else {
			$p = new Page();
			$p->template = $template; // set template
			$p->parent = $pickingpage;
			$p->name = $page['name']; // give it a name used in the url for the page
			$p->title = $page['title']; // set page title (not neccessary but recommended)
			$p->summary = $page['summary'];
			$p->dplusfunction = $page['function'];
			$p->save();
		}
	}

	$warehousepage = $pages->get('/warehouse/');
	$warehousepage->of(false);
	$warehousepage->dplusfunction = 'wm';
	$warehousepage->save();


	$whseprint_template = "warehouse-print";
	$whseprint_pages = array(
		'bin-inquiry-print' => array(
			'name' => 'print',
			'title' => 'Print',
			'parent' => '/warehouse/inventory/bin-inquiry/'
		),
		'item-inquiry-print' => array(
			'name' => 'print',
			'title' => 'Print',
			'parent' => '/warehouse/inventory/find-item/'
		),
	);

	if (!$templates->get($whseprint_template)) {

		if (!$fieldgroups->get($whseprint_template)) {
			$pw_fields = new Fieldgroup();
			$pw_fields->name = $whseprint_template;
			$pw_fields->save();
		}

		$t = new Template();
		$t->name = $whseprint_template;
		$t->fieldgroup = $fieldgroups->get($whseprint_template);
		$t->save();
	}

	foreach ($whseprint_pages as $printpage) {
		$parent = $pages->get($printpage['parent']);

		if (!boolval($parent->numChildren("name=print,include=hidden"))) {
			$p = new Page();
			$p->template = $whseprint_template; // set template
			$p->parent = $parent;
			$p->name = $printpage['name']; // give it a name used in the url for the page
			$p->title = $printpage['title']; // set page title (not neccessary but recommended)
			$p->save();
		}
	}
