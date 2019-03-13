<?php
    use Dplus\Content\Paginator;
    use Dplus\Dpluso\Customer\CustomerIndex;

    $pageurl = $page->fullURL;
    $custindex = new CustomerIndex($pageurl, '#cust-index-search-form', '#cust-index-search-form');
    $custindex->set_pagenbr($input->pageNum);
    $resultscount = $custindex->count_searchcustindex($input->get->text('q'));
    $paginator = new Paginator($custindex->pagenbr, $resultscount, $custindex->pageurl, 'user-actions');
?>
<form action="<?= $page->fullURL->getURL(); ?>" method="GET" class="allow-enterkey-submit">
	<input type="hidden" name="filtercust" value="true">
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control cust-index-search" name="q" placeholder="Type customer phone, name, ID, contact">
            <span class="input-group-btn">
            	<button type="submit" class="btn btn-default not-round"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
            </span>
        </div>
    </div>
</form>
<div id="cust-results">
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
                    <th>Location</th>
                    <th width="100">
                        <a href="<?= $custindex->generate_sortbyURL("phone") ; ?>" class="load-link" <?= $custindex->ajaxdata; ?>>
                            Phone <?= $custindex->tablesorter->generate_sortsymbol('phone'); ?>
                        </a>
                    </th>
                    <th>Last Sale Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultscount > 0) : ?>
                    <?php $customers = $custindex->search_custindexpaged($input->get->text('q'), $input->pageNum); ?>
                    <?php foreach ($customers as $cust) : ?>
						<?php $customerfilter = !empty($customerfilterquery) ? "$customerfilterquery,$cust->custid" : $cust->custid; ?>
						<?php $customerfilterurl->query->set('customerlink', $customerfilter); ?>
                        <tr>
                            <td>
                                <a href="<?= $customerfilterurl->getUrl(); ?>">
                                    <?= $page->bootstrap->highlight($cust->custid, $input->get->text('q'));?>
                                </a> &nbsp; <span class="glyphicon glyphicon-share"></span>
                            </td>
                            <td><?= $page->bootstrap->highlight($cust->name, $input->get->text('q')); ?></td>
                            <td><?= $page->bootstrap->highlight($cust->shiptoid, $input->get->text('q')); ?></td>
                            <td><?= $page->bootstrap->highlight($cust->generate_address(), $input->get->text('q')); ?></td>
                            <td><a href="tel:<?= $cust->phone; ?>" title="Click To Call"><?= $page->bootstrap->highlight($cust->phone, $input->get->text('q')); ?></a></td>
                            <td class="text-right"><?= empty($cust->get_lastsaledate($user->loginid)) ? 'N/A' : Dplus\Base\DplusDateTime::format_date($cust->get_lastsaledate($user->loginid)); ?></td>
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
