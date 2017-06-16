<tr class="detail">
    <th>Item ID</th>
    <th>Description</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Ext Price</th>
    <th>Notes</th>
    <th></th>
    <th></th>
</tr>

<?php $quotedetails = get_quote_details(session_id(), $qtnbr, false); ?>
<?php foreach ($quotedetails as $quotedetail) : ?>
    <?php
        $detailnoteurl = $config->pages->notes.'redir/?action=get-order-notes&ordn='.$qtnbr.'&linenbr='.$quotedetail['linenbr']; //TODO
        if ($quotedetail['notes'] == 'Y') {
            $detnoteicon = '<a class="h3 load-notes" href="'.$detailnoteurl.'" data-modal="#notes-modal"> <i class="material-icons" title="View order notes">&#xE0B9;</i></a>';
        } else {
            $detnoteicon = '<a class="h3 load-notes text-muted" href="'.$detailnoteurl.'" data-modal="#notes-modal"><i class="material-icons" title="View order notes">&#xE0B9;</i></a>';
        }


    ?>
    <tr class="detail">
        <td><?php echo $quotedetail['itemid']; ?></td>
        <td><?php echo $quotedetail['desc1']; ?></td>
        <td class="text-right">$ <?php echo $quotedetail['quotprice']; ?></td>
        <td class="text-right"><?php echo $quotedetail['quotunit']; ?></td>
        <td class="text-right">$ <?php echo formatmoney($quotedetail['quotprice'] * $quotedetail['quotunit']); ?></td>
        <td><?php echo $detnoteicon; ?></td>
        <td></td>
        <td></td>
    </tr>
<?php endforeach; ?>
