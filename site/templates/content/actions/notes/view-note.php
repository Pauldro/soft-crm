<?php
    // $note is loaded by Crud Controller

    if ($note->hascontactlink) {
        $contactinfo = getcustcontact($note->customerlink, $note->shiptolink, $note->contactlink, false);
    } else {
        $contactinfo = getshiptocontact($note->customerlink, $note->shiptolink, false);
    }
?>

<div>
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#note" aria-controls="note" role="tab" data-toggle="tab">Note ID: <?= $noteID; ?></a></li>
	</ul>
	<br>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="note"><?php include $config->paths->content."actions/notes/view/view-note-details.php"; ?></div>
	</div>
</div>

