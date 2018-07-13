<div class="row">
    <?php foreach ($page->children() as $function) : ?>
        <div class="col-sm-4">
            <h4><a href="<?= $function->url(); ?>"><?= $function->title; ?></a></h4>
        </div>
    <?php endforeach; ?>
</div>
