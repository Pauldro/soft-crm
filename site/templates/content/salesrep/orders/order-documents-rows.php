<tr class="detail document-header">
    <td colspan="3">ORDER #<?php echo $on; ?> Documents</td> <td>Document Type</td> <td align="right">Date</td> <td align="right">Time</td>
    <td></td> <td></td> <td></td> <td></td> <td></td> 
</tr>
<?php $orderdocs = get_order_docs(session_id(), $on, false); ?>
<?php foreach ($orderdocs->fetchAll() as $orderdoc) : ?>
	<?php $filename = $orderdoc['pathname']; ?>
	<tr class="detail">
		<td colspan="2"></td>
		<td>
			<b><a href="<?php echo $config->documentstorage.$filename; ?>" title="Click to View Document" target="_blank" ><?php echo $orderdoc['title']; ?></a></b>
		</td>
		<td align="right"><?php echo $orderdoc['createdate']; ?></td>
		<td align="right"><?php echo get_time($orderdoc['createtime']); ?></td> <td></td> <td></td><td></td> <td></td> <td></td> <td></td>
	</tr>
<?php endforeach; ?>
