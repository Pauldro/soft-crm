<?php
    $count = 0;
    $tasklineage = $task->actionlineage;
    foreach ($tasklineage as $taskid) {
        $task = loaduseraction($taskid, true, false);
        if ($task->hascontactlink) {
            $contactinfo = getcustcontact($task->customerlink, $task->shiptolink, $task->contactlink, false);
        } else {
            $contactinfo = getshiptocontact($task->customerlink, $task->shiptolink, false);
        }

        if ($task->isrescheduled) {
            $rescheduledtask = loaduseraction($task->rescheduledlink, true, false);
        }

        include $config->paths->content."actions/tasks/view/view-task-details.php";
        $count++;
        if ($count < sizeof($tasklineage)) {
            echo '<h3 class="text-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h3>';
        }
    }
?>
