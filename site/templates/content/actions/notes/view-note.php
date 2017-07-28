<?php
    $noteID = $input->get->id;
    $fetchclass = true;
    $note = loaduseraction($noteID, $fetchclass, false);

    if ($note->hascontactlink) {
        $contactinfo = getcustcontact($note->customerlink, $note->shiptolink, $note->contactlink, false);
    } else {
        $contactinfo = getshiptocontact($note->customerlink, $note->shiptolink, false);
    }
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="ajax-modal-label">Viewing note for <?php echo get_customer_name($note->customerlink); ?> </h4>
</div>
<div class="modal-body">
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#note" aria-controls="note" role="tab" data-toggle="tab">Note ID: <?= $noteID; ?></a></li>
        </ul>
        <br>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="note"><?php include $config->paths->content."actions/notes/view/view-note-details.php"; ?></div>
        </div>
    </div>
</div>
