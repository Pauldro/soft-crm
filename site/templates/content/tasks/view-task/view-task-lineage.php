<?php
    $count = 0;
    foreach ($task->tasklineage as $taskid) {
        $task = loadtask($taskid, false);
        if ($task->hascontactlink) {
            $contactinfo = getcustcontact($task->customerlink, $task->shiptolink, $task->contactlink, false);
        } else {
            $contactinfo = getshiptocontact($task->customerlink, $task->shiptolink, false);
        }
        include $config->paths->content."tasks/view-task/view-task-details.php";
        if ($count < sizeof($task->tasklineage)) {
            echo '<h3 class="text-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h3>';
        }
        $count++;
    }
?>
