<form action="<?= $page->child('name=redir')->url; ?>" method="post" class="allow-enterkey-submit">
    <input type="hidden" name="action" value="start-order">
    <div class="input-group form-group">
        <input class="form-control" name="ordn" placeholder="Order #" type="text" autofocus>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-emerald not-round confirm-order-assignment"> Grab Order </button>
        </span>
    </div>
</form>
