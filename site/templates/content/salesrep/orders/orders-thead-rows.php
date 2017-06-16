<tr>
   <th>Detail</th>
   <th>
       <a href="<?= $ajax->path.querystring_replace($ajax->querystring, array("orderby"), array("orderno-".$nextorder)); ?>" class="load-link" <?= $ajax->data; ?>>
           Order #<?= $orderno_sym; ?>
       </a>
   </th>
   <th>
       Customer
   </th>
   <th>
       <a href="<?= $ajax->path.querystring_replace($ajax->querystring, array("orderby"), array("custpo-".$nextorder)); ?>" class="load-link" <?= $ajax->data; ?>>
           Customer PO: <?= $custpo_sym; ?>
       </a>
   </th>
   <th>Ship-To</th>
   <th>
       <a href="<?=$ajax->path.querystring_replace($ajax->querystring, array("orderby"), array("subtotal-".$nextorder)); ?>" class="load-link" <?= $ajax->data; ?>>
           Order Totals <?= $total_sym; ?>
       </a>
   </th>
   <th>
       <a href="<?= $ajax->path.querystring_replace($ajax->querystring, array("orderby"), array("orderdate-".$nextorder)); ?>" class="load-link" <?= $ajax->data; ?>>
           Order Date: <?= $orderdate_sym; ?>
       </a>
   </th>
   <th class="text-center">
       <a href="<?= $ajax->path.querystring_replace($ajax->querystring, array("orderby"), array("status-".$nextorder)); ?>" class="load-link" <?= $ajax->data; ?>>
           Status:<?= $status_sym; ?>
       </a>
   </th>
   <th colspan="2"> <a tabindex="0" <?= $legendiconcontent; ?> data-content="<?= $legendcontent; ?>">Icon Definitions</a>
       <?php if (isset($input->get->orderby)) : ?>
           <a class="btn btn-warning btn-sm load-link" href="<?= $ajax->path.querystring_replace($ajax->querystring, array("orderby"), array(false)); ?>" <?= $ajax->data; ?>> (Clear Sort) </a>
       <?php endif; ?>
   </th>
   
</tr>
