<?php include "{$config->paths->content}warehouse/session.js.php";  ?>

<div>
    <form action="<?= "{$config->pages->menu_inventory}redir/"; ?>" id="physical-count-item-form" method="POST">
        <input type="hidden" name="action" value="inventory-search">
        <input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
        <table class="table table-condensed table-striped">
            <tr>
                <td>Bin</td>
                <td>
                    <div class="input-group">
        				<input type="text" class="form-control" id="binID" name="binID" value="<?= $binID; ?>">
        				<span class="input-group-btn">
        					<button type="button" class="btn btn-default show-possible-bins"> <span class="fa fa-search" aria-hidden="true"></span> </button>
        				</span>
        			</div>
                    <?php if ($whseconfig->are_binslisted()) : ?>
                        <br>
                        <button class="btn btn-default next-bin">Next Bin</button>
                        &nbsp; &nbsp;
                        <button class="btn btn-default prev-bin">Prev Bin</button>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Item</td>
                <td>
                    <input type="text" class="form-control" name="scan">
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary not-round"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
    </form>
</div>
