<tr>
    <th>Detail</th>
        <th>
        <?php $ajax->url->query->set("orderby", "orderno-".$nextorder); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>> Order #<?= $orderno_sym; ?> </a>
    </th>
    <th> Customer </th>
    <th>
        <?php $ajax->url->query->set("orderby", "orderno-".$nextorder); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>Customer PO: <?= $custpo_sym; ?></a>
    </th>
    <th>Ship-To</th>
    <th>
        <?php $ajax->url->query->set("orderby", "subtotal-".$nextorder); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>Order Totals <?= $total_sym; ?> </a>
    </th>
    <th>
        <?php $ajax->url->query->set("orderby", "orderdate-".$nextorder); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>Order Date: <?= $orderdate_sym; ?></a>
    </th>
    <th class="text-center">
        <?php $ajax->url->query->set("orderby", "status-".$nextorder); ?>
        <a href="<?= $ajax->url; ?>" class="load-link" <?= $ajax->data; ?>>Status:<?= $status_sym; ?></a>
    </th>
    <th colspan="3">
        <a tabindex="0" <?= $legendiconcontent; ?> data-content="<?= $legendcontent; ?>">Icon Definitions</a>
        <?php $ajax->url->query->remove("orderby");  ?>
        <?php if (isset($input->get->orderby)) : ?>
            <a class="btn btn-warning btn-sm load-link" href="<?= $ajax->url; ?>" <?= $ajax->data; ?>> (Clear Sort) </a>
        <?php endif; ?>
    </th>
</tr>
