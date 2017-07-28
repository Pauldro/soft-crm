<tr>
   <th>Detail</th>
   <th>
       <a href="<?= $ajax->url->query->set("orderby", "orderno-".$nextorder); ?>" class="load-link" <?= $ajax->data; ?>>
           Order #<?= $orderno_sym; ?>
       </a>
   </th>
   <th>
       Customer
   </th>

   <th>
       <a href="<?= $ajax->url->query->set("orderby", "custpo-".$nextorder); ?>" class="load-link" <?= $ajax->data; ?>>
           Customer PO: <?= $custpo_sym; ?>
       </a>
   </th>
   <th>Ship-To</th>

   <th>
       <a href="<?= $ajax->url->query->set("orderby", "subtotal-".$nextorder);?>" class="load-link" <?= $ajax->data; ?>>
           Order Totals <?= $total_sym; ?>
       </a>
   </th>

   <th>
       <a href="<?= $ajax->url->query->set("orderby", "orderdate-".$nextorder); ?>" class="load-link" <?= $ajax->data; ?>>
           Order Date: <?= $orderdate_sym; ?>
       </a>
   </th>
   <th class="text-center">
       <a href="<?= $ajax->url->query->set("orderby", "status-".$nextorder); ?>" class="load-link" <?= $ajax->data; ?>>
           Status:<?= $status_sym; ?>
       </a>
   </th>
   <th colspan="3"> <a tabindex="0" <?= $legendiconcontent; ?> data-content="<?= $legendcontent; ?>">Icon Definitions</a>
       <?php if (isset($input->get->orderby)) : ?>
           <a class="btn btn-warning btn-sm load-link" href="<?= $ajax->url->query->remove("orderby"); ?>" <?= $ajax->data; ?>> (Clear Sort) </a>
       <?php endif; ?>
   </th>

</tr>
