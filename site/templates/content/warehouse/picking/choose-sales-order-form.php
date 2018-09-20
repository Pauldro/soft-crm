<h3>Enter Order Number</h3>
<form action="<?= $page->child('name=redir')->url; ?>" method="post" class="allow-enterkey-submit">
    <input type="hidden" name="action" value="start-order">
    <input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
    <div class="input-group form-group">
        <input class="form-control" name="ordn" placeholder="Order #" type="text" autofocus>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-emerald not-round confirm-order-assignment"> Grab Order </button>
        </span>
    </div>
</form>

<button type="button" class="btn btn-default remove-sales-order-locks">Remove Lock on Sales Order</button>