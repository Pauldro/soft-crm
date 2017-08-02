<?php
	// $action is Loaded by Crud Controller
    if ($action->hascontactlink) {
        $contactinfo = getcustcontact($action->customerlink, $action->shiptolink, $action->contactlink, false);
    } else {
        $contactinfo = getshiptocontact($action->customerlink, $action->shiptolink, false);
    }

    if ($action->isrescheduled) {
        $rescheduledtask = loaduseraction($action->rescheduledlink, true, false);
    }
?>

<div>
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#action" aria-controls="action" role="tab" data-toggle="tab">Action ID: <?= $actionid; ?></a></li>
	</ul>
	<br>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="action"><?php include $config->paths->content."actions/actions/view/view-action-details.php"; ?></div>
	</div>
</div>
