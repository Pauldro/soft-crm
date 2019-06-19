<?php
	use Dplus\Content\Paginator;

	$pageurl = $page->fullURL;
	$pageurl->path = ($input->get->q) ? $pageurl->path : $config->pages->ajaxload."customers/cust-index/";
	$pageurl->query->set('function', 'ci');
	$custindex->set_pagenbr($input->pageNum);
	$custindex->generate_filter($input);
	$resultscount = $custindex->count_searchcustindex($input->get->text('q'));
	$paginator = new Paginator($custindex->pagenbr, $resultscount, $custindex->pageurl, 'cust-index', $custindex->ajaxdata);
?>

<div id="cust-results">
		<div class="form-group">
	<?php if ($appconfig->allow_customeradd) : ?>
			<a href="<?= $config->pages->customer.'add/'; ?>" class="btn btn-primary">
				<i class="fa fa-user-plus" aria-hidden="true"></i>&ensp;Add Customer
			</a>
	<?php endif; ?>
			<a href="<?= $config->pages->customer.'add-prospect/'; ?>" class="btn btn-primary">
				<i class="fa fa-user" aria-hidden="true"></i>&ensp;Add Prospect
			</a>
		</div>
	<?= $paginator->generate_showonpage(); ?>
	<div class="table-responsive">
		<table id="cust-index" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th width="100">
						<a href="<?= $custindex->generate_sortbyURL("custid") ; ?>" class="load-link" <?= $custindex->ajaxdata; ?>>
							CustID <?= $custindex->tablesorter->generate_sortsymbol('custid'); ?>
						</a>
					</th>
					<th>
						<a href="<?= $custindex->generate_sortbyURL("name") ; ?>" class="load-link" <?= $custindex->ajaxdata; ?>>
							Customer Name <?= $custindex->tablesorter->generate_sortsymbol('name'); ?>
						</a>
					</th>
					<th>Ship-To</th>
					<th>Address</th>
					<th>
						<a href="<?= $custindex->generate_sortbyURL("city") ; ?>" class="load-link" <?= $custindex->ajaxdata; ?>>
							City <?= $custindex->tablesorter->generate_sortsymbol('city'); ?>
						</a>
					</th>
					<th>
						<a href="<?= $custindex->generate_sortbyURL("state") ; ?>" class="load-link" <?= $custindex->ajaxdata; ?>>
							State <?= $custindex->tablesorter->generate_sortsymbol('state'); ?>
						</a>
					</th>
					<th>
						<a href="<?= $custindex->generate_sortbyURL("zip") ; ?>" class="load-link" <?= $custindex->ajaxdata; ?>>
							Zip <?= $custindex->tablesorter->generate_sortsymbol('zip'); ?>
						</a>
					</th>
					<th width="100">
						<a href="<?= $custindex->generate_sortbyURL("phone") ; ?>" class="load-link" <?= $custindex->ajaxdata; ?>>
							Phone <?= $custindex->tablesorter->generate_sortsymbol('phone'); ?>
						</a>
					</th>
					<th class="text-right">
						<a href="<?= $custindex->generate_sortbyURL("lastsaledate") ; ?>" class="load-link" <?= $custindex->ajaxdata; ?>>
							Last Sale Date <?= $custindex->tablesorter->generate_sortsymbol('lastsaledate'); ?>
						</a>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($resultscount > 0) : ?>
					<?php $customers = $custindex->search_custindexpaged($input->get->text('q'), $input->pageNum); ?>
					<?php foreach ($customers as $cust) : ?>
						<tr>
							<td>
								<a href="<?= $cust->generate_ciloadurl(); ?>">
									<?= $page->bootstrap->highlight($cust->custid, $input->get->text('q')); ?>
								</a> &nbsp; <span class="glyphicon glyphicon-share"></span>
							</td>
							<td><?= $page->bootstrap->highlight($cust->name, $input->get->q); ?></td>
							<td><?= $page->bootstrap->highlight($cust->shiptoid, $input->get->q); ?></td>
							<td><?= $page->bootstrap->highlight($cust->addr1, $input->get->q); ?></td>
							<td><?= $page->bootstrap->highlight($cust->city, $input->get->q); ?></td>
							<td><?= $page->bootstrap->highlight($cust->state, $input->get->q); ?></td>
							<td><?= $page->bootstrap->highlight($cust->zip, $input->get->q); ?></td>
							<td><a href="tel:<?= $cust->phone; ?>" title="Click To Call"><?= $page->bootstrap->highlight($cust->phone, $input->get->q); ?></a></td>
							<td class="text-right"><?= $cust->lastsaledate == 0 ? 'N/A' : Dplus\Base\DplusDateTime::format_date($cust->lastsaledate); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<td colspan="5">
						<h4 class="list-group-item-heading">No Customer Matches your query.</h4>
					</td>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<?= $resultscount ? $paginator : ''; ?>
</div>
