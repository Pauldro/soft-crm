<?php
	$ordn = $input->get->text('ordn');
	$linenbr = $input->get->text('linenbr');
	$canwrite = can_write_sales_note(session_id(), $ordn);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="notes-modal-label">Reviewing Sales Order Notes for Order #<?php echo $ordn." Line #".$linenbr; ?></h4>
</div>
<div class="modal-body">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<div class="row">
            	<div class="col-sm-3 col-xs-2">Pick Ticket</div> <div class="col-sm-3 col-xs-2">Pack Ticket</div>
                <div class="col-sm-3 col-xs-2">Invoice</div> <div class="col-sm-3 col-xs-2">Acknowledgement</div>
            </div>
        </div>
        <ul class="list-group">
        	<?php $notes = get_dplusnotes(session_id(), $ordn, $linenbr, 'SORD', false); ?>
            <?php foreach ($notes as $note) : ?>
				<?php $readnote = $config->pages->ajax."json/dplus-notes/?key1=".$ordn."&key2=".$linenbr."&recnbr=".$note['recno']."&type=".$config->dplusnotes['order']['type']; ?>
                <a href="<?php echo $readnote; ?>" class="list-group-item salesnote rec<?php echo $note['recno']; ?>" data-form="#notes-form">
                    <div class="row">
                        <div class="col-xs-2 col-sm-3"><?php echo $note['form1']; ?></div> <div class="col-xs-2 col-sm-3"><?php echo $note['form2']; ?></div>
                        <div class="col-xs-2 col-sm-3"><?php echo $note['form3']; ?></div> <div class="col-xs-2 col-sm-3"><?php echo $note['form4']; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="well">
        <form class="notes" action="<?php echo $config->pages->notes."redir/"; ?>" method="POST" id="notes-form">
            <div class="response"></div>
            <div class="row">
                <div class="form-group col-xs-6 col-sm-2">
                    <label class="control-label">Pick Ticket</label><br><input type="checkbox" name="form1" id="so-form1" class="check-toggle" data-size="small" data-width="73px" value="Y">
                </div>
                <div class="form-group col-xs-6 col-sm-offset-1 col-sm-2">
                    <label class="control-label">Pack Ticket</label><br><input type="checkbox" name="form2" id="so-form2" class="check-toggle" data-size="small" data-width="73px" value="Y">
                </div>
                <div class="form-group col-xs-6 col-sm-offset-1 col-sm-2">
                    <label class="control-label">Invoice</label><br><input type="checkbox" name="form3" id="so-form3" class="check-toggle" data-size="small" data-width="73px" value="Y">
                </div>
                <div class="form-group col-xs-6 col-sm-offset-1 col-sm-2">
                    <label class="control-label">Acknowledgement</label><input type="checkbox" name="form4" id="so-form4" class="check-toggle" data-size="small" data-width="73px" value="Y">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="notes" class="control-label">Note: <span class="which"></span></label>
                    <textarea class="form-control note" rows="3" cols="35" name="note" placeholder="Add a Note.." style="max-width: 35em;"></textarea>
                    <input type="hidden" name="action" value="write-sales-order-note">
                    <input type="hidden" name="key1" class="key1"value="<?php echo $ordn; ?>">
                    <input type="hidden" name="key2" class="key2" value="<?php echo $linenbr; ?>">
                    <input type="hidden" class="type" value="<?php echo $config->dplusnotes['order']['type']; ?>">
                    <input type="hidden" name="recnbr" class="recno" value="">
                    <input type="hidden" name="editorinsert" class="editorinsert" value="insert">
                    <input type="hidden" name="notepage" class="notepage" value="<?php echo $config->filename; ?>">
                    <span class="help-block"></span>
                    <?php if ($canwrite) : ?>
                    	<button type="submit" class="btn btn-success">Save Changes</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
	var form = {
		form1: '#so-form1', form2: '#so-form2', form3: '#so-form3', form4: '#so-form4', type: '.type', key1: '.key1', key2: '.key2'
	}
	$('.check-toggle').bootstrapToggle({
		on: 'Yes',
		off: 'No',
		onstyle: 'info'
	});

	$("body").on("click", ".salesnote", function(e) {
		e.preventDefault();
		$('.bg-warning').removeClass('bg-warning');
		var button = $(this);
		var geturl = button.attr('href');
		var form = button.data('form');
		$.getJSON(geturl, function(json) {
			var note = json.note;
			for (var i = 1; i < 6; i++) {
				$('#so-form'+i).bootstrapToggle(togglearray[note["form"+i]]);
			}
			$(form + ' .note').val(note.notefld);
			$(form + ' .editorinsert').val('edit');
			$(form + ' .recno').val(note.recno);
			button.addClass('bg-warning');
		});
	});

	$("body").on("submit", "#notes-form", function(e)  {
		e.preventDefault();
		console.log('trying to submit');
		var validateurl = config.urls.json.dplusnotes+"?key1="+$(form.key1).val()+"&key2="+$(form.key2).val()+"&type="+$(form.type).val();
		var formid = "#"+$(this).attr('id');
		var formvalues = new dplusnotevalues(form, false);
		var formcombo = formvalues.form1 + formvalues.form2 + formvalues.form3 + formvalues.form4;
		var loadinto = config.modals.ajax+" .modal-body";
		var url = $(formid +' .notepage').val();
		var alreadyexists = false;
		var recnbr = 0;
		$.getJSON(validateurl, function(json) {

			if (json.notes.length > 0) {
				$(json.notes).each(function(index, note) {
					var notecombo = note.form1 + note.form2 + note.form3 + note.form4 + note.form5;
					if (formcombo == notecombo) {
						alreadyexists = true;
					}
					recnbr = note.recno;
				});
			} else {
				recnbr = 1;
			}

			if (alreadyexists && recnbr != $(formid + ' .recno').val()) {
				var onclick = '$(".rec'+recnbr+'").click()';
				var button = "<button type='button' class='btn btn-primary salesnote' onclick='"+onclick+"'>Click to Edit note</button>";
				createalertpanel('#notes-form .response', 'This note already exists <br> '+button, 'Error!', 'warning');
			} else {
				$(formid).postform({formdata: false, jsoncallback: false}, function() {  //{formdata: data/false, jsoncallback: true/false}
					wait(500, function() {
						loadin(url, loadinto, function() {
							 $.notify({
								icon: "&#xE8CD;",
								message: "Your note has been saved",
							},{
								type: "success",
								icon_type: 'material-icon',
								 onShown: function() {
									 $(".rec"+recnbr).click()
								 },
							});
						});

					});
				});
			}
		});

	});

</script>
