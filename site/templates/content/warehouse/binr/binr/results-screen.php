<?php if ($whsesession->had_succeeded()) : ?>
	<div class="alert alert-success" role="alert">
		<strong>Success:</strong> <?= strtoupper($item->get_itemtypepropertydesc()) . ": ". $item->get_itemidentifier(); ?> has been moved
	</div>
<?php elseif (!empty($whsesession->status)) : ?>
	<div class="alert alert-danger" role="alert">
		<strong>Error:</strong> <?= $whsesession->status; ?>
	</div>
<?php endif; ?>

<a href="<?= $page->parent->url; ?>" class="btn btn-primary not-round"><?= $page->parent->title; ?> Menu</a>

<a href="<?= $page->url; ?>" class="btn btn-warning not-round">Next Item</a>
