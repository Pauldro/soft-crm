<?php $trackings = getordertracking(session_id(), $on, false); ?>
<?php foreach($trackings as $tracking) : ?>
	<?php $carrier = $tracking['servtype']; $link = ""; $link = returntracklink($tracking['servtype'], $tracking['tracknbr'], $on); ?>
    <tr class="detail tracking">
        <td colspan="3"><b>Shipped:</b>  <?php echo $carrier; ?></td>
		<td colspan="2"><b>Tracking No.:</b>
            <?php if ($link == "#$on" ): ?>
                <?php echo $tracking['tracknbr']; ?>
            <?php else : ?>
                <b><a href="<?php echo $link; ?>"target="_blank" title="Click To Track"><?php echo $tracking['tracknbr']; ?></a></b>
            <?php endif; ?>
        </td>    
       	<td></td>
		<td colspan="2"><b>Weight: </b><?php echo $tracking['weight']; ?></td> 
       	<td colspan="2"><b>Ship Date: </b><?php echo $tracking['shipdate']; ?> </td>
       	<td></td>
    </tr>
<?php endforeach; ?>
