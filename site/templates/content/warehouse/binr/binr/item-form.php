<form action="<?= $page->child('name=redir')->url; ?>" method="post" class="allow-enterkey-submit">
    <input type="hidden" name="action" value="scan-item">
    <input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
    <label>Scan barcode, UPC, Item ID, or Serial #</label>
    <div class="input-group form-group">
        <input class="form-control" name="scan" placeholder="barcode, UPC, Item ID, Serial #" type="text">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-emerald not-round">Submit</button>
        </span>
    </div>
</form>
