<?php include "{$config->paths->content}warehouse/session.js.php";  ?>

<div>
    <form action="<?= "{$config->pages->menu_binr}redir/"; ?>" method="POST">
        <input type="hidden" name="action" value="inventory-search">
        <input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
        
        <table class="table table-condensed table-striped">
            <tr>
                <td>Bin</td>
                <td>
                    <input type="text" class="form-control input-sm" name="binID" value="<?= $binID; ?>">
                </td>
            </tr>
            <tr>
                <td>Item</td>
                <td>
                    <input type="text" class="form-control input-sm" name="scan">
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary not-round"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
    </form>
</div>
