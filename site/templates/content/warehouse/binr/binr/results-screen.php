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
<?php if ($input->get->tobin || $input->get->frombin) : ?>
	<?php $url = new Purl\Url($page->fullURL->getUrl()); ?>
	<?php $url->query->remove('itemID'); ?>
	<a href="<?= $url; ?>" class="btn btn-warning not-round">Next Item</a>
<?php else : ?>
	<a href="<?= $page->url; ?>" class="btn btn-warning not-round">Next Item</a>
<?php endif; ?>
