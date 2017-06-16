<tr class="domestic <?php echo $hidden_domestic; ?>">
    <td class="control-label">Contact Phone</td>
    <td> <input type="text" name="contact-phone" class="form-control input-sm required" id="shiptophone" onKeyup='addDashes(this)' value="<?php echo $quote['telenbr']; ?>"> </td>
</tr>
<tr class="domestic <?php echo $hidden_domestic; ?>">
    <td class="control-label">Contact Fax</td>
    <td> <input type="text" name="contact-fax" class="form-control input-sm" onKeyup='addDashes(this)' value="<?php echo $quote['faxnbr']; ?>"> </td>
</tr>
