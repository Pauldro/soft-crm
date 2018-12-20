<?php include "{$config->paths->content}warehouse/session.js.php"; ?>
<div>
    <form action="<?= $page->fullURL->getUrl(); ?>" method="GET" class="select-bin-form">
        <div class="form-group">
            <label for="binID">Bin ID</label>
            <input type="text" class="form-control" id="binID" name="binID">
        </div>
        <button type="submit" class="btn btn-primary not-round"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
    </form>
</div>
