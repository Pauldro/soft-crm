<tr>
    <th>Detail</th>
    <th>
        <?php $ajax->url->query->set("orderby", "orderno-".get_sorting_rule($orderby, $sortrule, "orderno")); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>
            Order #<?= $orderno_sym; ?>
        </a>
    </th>

    <th>
        <?php $ajax->url->query->set("orderby", 'custpo-'.get_sorting_rule($orderby, $sortrule, "custpo")); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>
            Customer PO: <?= $custpo_sym; ?>
        </a>
    </th>
    <th>Ship-To</th>
    <th>
        <?php $ajax->url->query->set("orderby", 'subtotal-'.get_sorting_rule($orderby, $sortrule, "subtotal")); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>
            Order Totals <?= $total_sym; ?>
        </a>
    </th>

    <th>
        <?php $ajax->url->query->set("orderby", 'orderdate-'.get_sorting_rule($orderby, $sortrule, "orderdate")); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>
            Order Date: <?= $orderdate_sym; ?>
        </a>
    </th>

    <th class="text-center">
        <?php $ajax->url->query->set("orderby", 'status-'.get_sorting_rule($orderby, $sortrule, "status")); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>
            Status:<?= $status_sym; ?>
        </a>
    </th>


    <th colspan="2">
        <?php $ajax->url->query->remove('orderby'); ?>
        <a tabindex="0" <?= $legendiconcontent; ?> data-content="<?= $legendcontent; ?>">Icon Definitions</a>
        <?php if (isset($input->get->orderby)) : ?>
            <a class="btn btn-warning btn-sm load-link" href="<?= $ajax->url; ?>" <?= $ajax->data; ?>> (Clear Sort) </a>
        <?php endif; ?>
    </th>
    <th colspan="2"> </th>
</tr>
