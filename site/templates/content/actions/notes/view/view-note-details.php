<table class="table table-bordered table-striped">
    <tr>
        <td>Note ID:</td> <td><?= $note->id; ?></td>
    </tr>
    <tr>
        <td>Note Type</td> <td><?= $note->generate_actionsubtypedescription(); ?></td>
    </tr>
    <tr>
        <td>Written on:</td> <td><?= date('m/d/Y g:i A', strtotime($note->datecreated)); ?></td>
    </tr>
    <tr>
        <td>Written by:</td> <td><?= $note->createdby; ?></td>
    </tr>
    <tr>
        <td>Customer:</td>
        <td><?= get_customername($note->customerlink); ?> &nbsp;<a href="<?= $note->generate_customerurl(); ?>"><i class="glyphicon glyphicon-share"></i> Go to Customer Page</a></td>
    </tr>
    <?php if ($note->has_shiptolink()) : ?>
        <tr>
            <td>Ship-to:</td>
            <td><?= get_shiptoname($note->customerlink, $note->shiptolink, false); ?> &nbsp;<a href="<?= $note->generate_shiptourl(); ?>"><i class="glyphicon glyphicon-share"></i> Go to Ship-to Page</a></td>
        </tr>
    <?php endif; ?>
    <?php if ($note->has_contactlink()) : ?>
        <tr>
            <td>Contact:</td>
            <td><?= $note->contactlink; ?> &nbsp;<a href="<?= $note->generate_contacturl(); ?>"><i class="glyphicon glyphicon-share"></i> Go to Contact Page</a></td>
        </tr>
    <?php endif; ?>
    <?php if ($note->has_salesorderlink()) : ?>
        <tr>
            <td>Sales Order #:</td>
            <td><?= $note->salesorderlink; ?></td>
        </tr>
    <?php endif; ?>
    <?php if ($note->has_quotelink()) : ?>
        <tr>
            <td>Quote #:</td>
            <td><?= $note->quotelink; ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td class="control-label">Title</td> <td><?= $note->title; ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <b>Notes</b><br>
            <div class="display-notes">
                <?= $note->textbody; ?>
            </div>
        </td>
    </tr>
</table>
