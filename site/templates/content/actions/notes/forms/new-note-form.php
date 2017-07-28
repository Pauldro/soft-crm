<?php
	$salespersonjson = json_decode(file_get_contents($config->companyfiles."json/salespersontbl.json"), true);
	$salespersoncodes = array_keys($salespersonjson['data']);
?>
<form action="<?php echo $config->pages->actions."notes/add/"; ?>" method="post" id="new-action-form" data-refresh="#notes-panel" data-modal="#ajax-modal">
	<input type="hidden" name="action" value="write-crm-note">
	<input type="hidden" name="custlink" value="<?php echo $custID; ?>">
	<input type="hidden" name="shiptolink" value="<?php echo $shipID; ?>">
	<input type="hidden" name="contactlink" value="<?php echo $contactID; ?>">
	<input type="hidden" name="salesorderlink" value="<?php echo $ordn; ?>">
	<input type="hidden" name="quotelink" value="<?php echo $qnbr; ?>">
	<input type="hidden" name="tasklink" value="<?php echo $taskID; ?>">
	<input type="hidden" name="actionlink" value="<?php echo $actionID; ?>">
	<table class="table table-bordered table-striped">
	    <tr>  <td>Note Create Date:</td> <td><?php echo date('m/d/Y g:i A'); ?></td> </tr>
	    <tr>
	        <td class="control-label">Assigned To:</td>
	        <td>
	            <select name="assignedto" class="form-control input-sm" style="width: 200px;">
	                <?php foreach ($salespersoncodes as $salespersoncode) : ?>
	                    <?php if ($salespersonjson['data'][$salespersoncode]['splogin'] == $user->loginid) : ?>
	                        <option value="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>" selected><?= $salespersoncode.' - '.$salespersonjson['data'][$salespersoncode]['spname']; ?></option>
	                    <?php else : ?>
	                        <option value="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>"><?= $salespersoncode.' - '.$salespersonjson['data'][$salespersoncode]['spname']; ?></option>
	                    <?php endif; ?>

	                <?php endforeach; ?>
	            </select>
	        </td>
	    </tr>
		<tr>
			<td class="control-label">Note Type <br><small>(Click to choose)</small></td>
			<td>
				<?php include $config->paths->content."actions/notes/forms/select-note-type.php"; ?>
			</td>
		</tr>
	    <?php include $config->paths->content."notes/crm/show-note-link-rows.php"; ?>
		<tr>
			<td class="control-label">Title</td>
			<td>
				<input type="text" name="title" class="form-control">
			</td>
		</tr>
	    <tr>
	        <td colspan="2">
	            <label for="" class="control-label">Notes</label>
	            <textarea name="textbody" cols="30" rows="10" class="form-control note"> </textarea> <br>
				<button type="submit" class="btn btn-success">Save Note</button>
	        </td>
	    </tr>
	</table>

</form>
