<table class="table table-bordered table-striped">
    <tr>
        <td>Written on:</td> <td><?php echo date('m/d/Y g:i A', strtotime($task->datewritten)); ?></td>
    </tr>
    <tr>
        <td>Written by:</td> <td><?php echo $task->writtenby; ?></td>
    </tr>
    <tr>
        <td>Due:</td> <td><?php echo date('m/d/Y g:i A', strtotime($task->duedate)); ?></td>
    </tr>
    <tr>
        <td>Customer:</td>
        <td><?php echo get_customer_name($task->customerlink); ?> <a href="<?php echo $task->generatecustomerurl(); ?>"><i class="glyphicon glyphicon-share"></i> Go to Customer Page</a></td>
    </tr>
    <?php if ($task->hasshiptolink) : ?>
        <tr>
            <td>Ship-to:</td>
            <td><?php echo get_shipto_name($task->customerlink, $task->shiptolink, false); ?> <a href="<?php echo $task->generateshiptourl(); ?>"><i class="glyphicon glyphicon-share"></i> Go to Ship-to Page</a></td>
        </tr>
    <?php endif; ?>
    <?php if ($task->hascontactlink) : ?>
        <tr>
            <td>Contact:</td>
            <td><?php echo $task->contactlink; ?> <a href="<?php echo $task->generatecontacturl(); ?>"><i class="glyphicon glyphicon-share"></i> Go to Contact Page</a></td>
        </tr>
    <?php else : ?>
        <tr>
            <td>Contact:</td>
            <td><?php echo $contactinfo['contact']; ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td>Phone:</td>
        <td>
            <a href="tel:<?php echo $contactinfo['cphone']; ?>"><?php echo $contactinfo['cphone']; ?></a> &nbsp; <?php if ($contactinfo['cphone'] != '') {echo ' Ext. '.$contactinfo['cphext'];} ?>
        </td>
    </tr>
    <?php if ($contactinfo['ccellphone'] != '') : ?>
        <tr>
            <td>Cell Phone:</td>
            <td>
                <a href="tel:<?php echo $contactinfo['ccellphone']; ?>"><?php echo $contactinfo['ccellphone']; ?></a>
            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <td>Email:</td>
        <td><a href="mailto:<?php echo $contactinfo['email']; ?>"><?php echo $contactinfo['email']; ?></a></td>
    </tr>
    <tr>
        <td colspan="2"><b>Notes</b><br><?php echo $task->textbody; ?></td>
    </tr>
</table>
<a href="<?= $task->generatecompletionurl('true'); ?>" class="btn btn-primary complete-task" data-id="<?= $task->id; ?>"><i class="fa fa-check-circle" aria-hidden="true"></i> Complete Task</a>
