<div class="list-group">
    <?php if ($resultscount) : ?>
        <?php foreach ($items as $item) : ?>
            <a href="<?= BinrSession::get_binritemurl($item->get_itemtypeproperty(), $item->get_itemidentifier()); ?>" class="list-group-item">
                <div class="row">
                    <div class="col-xs-2">
                        <h4 class="list-group-item-heading"><?= strtoupper($item->get_itemtypepropertydesc()); ?></h4>
                    </div>
                    <div class="col-xs-10">
                        <h4 class="list-group-item-heading"><?= $item->get_itemidentifier(); ?></h4>
                        <p class="list-group-item-text">ItemID: <?= $item->itemid; ?></p>
                        <p class="list-group-item-text"><?= $item->desc1; ?></p>
                        <p class="list-group-item-text"><?= "Origin: " . strtoupper($item->xorigin); ?></p>
                        <p class="list-group-item-text"><?= "X-ref Item ID: " . $item->xitemid; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else : ?>
        <a href="#" class="list-group-item">
            <div class="row">
                <div class="col-xs-2">
                    <h4 class="list-group-item-heading">Item</h4>
                </div>
                <div class="col-xs-10">
                    <h4 class="list-group-item-heading">No Items Match your query.</h4>
                    <p class="list-group-item-text"></p>
                </div>
            </div>
        </a>
    <?php endif; ?>
</div>
