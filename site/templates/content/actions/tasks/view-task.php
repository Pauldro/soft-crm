<?php
    $taskid = $input->get->id;
    $fetchclass = true;
    $task = loaduseraction($taskid, $fetchclass, false);

    if ($task->hascontactlink) {
        $contactinfo = getcustcontact($task->customerlink, $task->shiptolink, $task->contactlink, false);
    } else {
        $contactinfo = getshiptocontact($task->customerlink, $task->shiptolink, false);
    }
    
    if ($task->isrescheduled) {
        $rescheduledtask = loaduseraction($task->rescheduledlink, true, false);
    }


?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="ajax-modal-label">Viewing Task for <?php echo get_customer_name($task->customerlink); ?> </h4>
</div>
<div class="modal-body">
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#task" aria-controls="task" role="tab" data-toggle="tab">Task ID: <?= $taskid; ?></a></li>
        </ul>
        <br>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="task"><?php include $config->paths->content."actions/tasks/view/view-task-details.php"; ?></div>
        </div>
    </div>
</div>
