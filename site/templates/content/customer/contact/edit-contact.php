<?php if (can_accesscustomercontact($user->loginid, $user->hasrestrictions, $custID, $shipID, $contactID, false)) : ?>
	<?php $contact = get_customercontact($custID, $shipID, $contactID, false); ?>
    
	<div class="panel panel-primary not-round">
		<div class="panel-heading not-round">
			<h3 class="panel-title">Edit Contact Details</h3>
		 </div>
		 <form action="<?= $config->pages->customer.'redir/'; ?>" method="post">
			 <input type="hidden" name="action" value="edit-contact">
			 <input type="hidden" name="custID" value="<?= $contact->custid; ?>">
			 <input type="hidden" name="shipID" value="<?= $contact->shiptoid; ?>">
			 <input type="hidden" name="contactID" value="<?= $contact->contact; ?>">
			 <input type="hidden" name="page" value="<?= $page->fullURL; ?>">
			 <table class="table table-striped table-condensed table-user-information">
				 <tbody>
					 <tr>
	                     <td>Customer:</td>
	                     <td>
	                         <a href="<?= $contact->generate_customerurl(); ?>" target="_blank">
	                             <strong><?= $contact->custid. ' - '. $contact->name ?> <i class="glyphicon glyphicon-share" aria-hidden="true"></i></strong>
	                         </a>
	                     </td>
						 <td></td>
	                 </tr>
					 <tr>
						 <td>Address:</td>
 	                    <td>
 	                        <strong>
 	                            <?= $contact->addr1; ?><br>
 	                            <?= (strlen($contact->addr2) > 0) ? $contact->addr2.'<br>' : ''; ?>
 	                            <?= $contact->city . ', ' . $contact->state . ' ' . $contact->zip; ?>
 	                        </strong>
 	                    </td>
						<td></td>
					 </tr>
					 <?php if ($contact->has_shipto()) : ?>
	                     <tr> 
	                         <td>Shipto ID:</td> 
	                         <td><a href="<?= $contact->generate_shiptourl(); ?>" target="_blank"><?= $contact->shiptoid; ?> <i class="glyphicon glyphicon-share" aria-hidden="true"></i></a></td>
							 <td></td>
	                     </tr>
	                 <?php endif; ?>
					 <tr>
						 <td class="control-label">Name</td>
						 <td><?php echo $contact->contact; ?></td>
						 <td><input class="form-control input-sm required" name="contact-name" value="<?= $contact->contact; ?>"></td>
					 </tr>
					 <tr> 
						 <td>Title:</td>
						 <td><?= $contact->title; ?></td> 
						 <td><input type="text" class="form-control input-sm" name="contact-title" value="<?= $contact->title; ?>"></td>
					 </tr><tr>
						 <td class="control-label">Email</td>
						 <td><a href="mailto:<?php echo $contact->email; ?>"><?php echo $contact->email; ?></a></td>
						 <td><input class="form-control input-sm required" name="contact-email" value="<?= $contact->email; ?>"></td>
					 </tr>
					 <tr>
						 <td class="control-label">Office Phone</td>
						 <td>
							 <a href="tel:<?= $contact->phone; ?>"><?= $page->stringerbell->format_phone($contact->phone); ?></a><b> &nbsp;
                         	<?php if ($contact->has_extension()) { echo 'Ext. ' . $contact->extension;} ?></b>
					 	</td>
						 <td>
							 <div class="row">
								 <div class="col-sm-8">
									 <input class="form-control input-sm phone-input required" name="contact-phone" value="<?= $page->stringerbell->format_phone($contact->phone); ?>">
								 </div>
								 <div class="col-sm-4">
									 <input class="form-control input-sm" name="contact-extension" value="<?= $contact->extension; ?>" placeholder="Ext.">
								 </div>
							 </div>
						 </td>
					 </tr>
					 <tr>
						 <td class="control-label">Cell Phone</td>
						 <td><a href="tel:<?= $contact->cellphone; ?>"> <?= $page->stringerbell->format_phone($contact->cellphone); ?></a></td>
						 <td><input class="form-control input-sm phone-input " name="contact-cellphone" value="<?= $page->stringerbell->format_phone($contact->cellphone); ?>"></td>
					 </tr>
					 <tr>
						 <td class="control-label">Fax</td>
						 <td><a href="tel:<?= $contact->cellphone; ?>"> <?= $page->stringerbell->format_phone($contact->faxnbr); ?></a></td>
						 <td><input type="tel" class="form-control input-sm phone-input" name="contact-fax" value="<?= $page->stringerbell->format_phone($contact->faxnbr); ?>"></td>
					 </tr>
					 <tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
						 <td class="control-label">AR Contact</td>
						 <td><?= array_flip($config->yesnoarray)[$contact->arcontact]; ?></td>
						 <td>
							 <?= $page->bootstrap->select('class=form-control input-sm|name=arcontact', array_flip($config->yesnoarray), $contact->arcontact); ?>
						 </td>
					 </tr>
					 <tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
						 <td class="control-label">Dunning Contact</td>
						 <td><?= array_flip($config->yesnoarray)[$contact->dunningcontact]; ?></td>
						 <td>
							 <?= $page->bootstrap->select('class=form-control input-sm|name=dunningcontact', array_flip($config->yesnoarray), $contact->dunningcontact); ?>
						 </td>
					 </tr>
					 <tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
						 <td class="control-label">Acknowledgement Contact</td>
						 <td><?= array_flip($config->yesnoarray)[$contact->ackcontact]; ?></td>
						 <td>
							 <?= $page->bootstrap->select('class=form-control input-sm|name=ackcontact', array_flip($config->yesnoarray), $contact->ackcontact); ?>
						 </td>
					 </tr>
					 <tr>
						 <?php if ($primarycontact) : ?>
							 <td class="control-label">Buying Contact <a class="small" href="<?= $primarycontact->generate_contacturl(); ?>" target="_blank">[View Primary]</a></td>
						 <?php else : ?>
							 <td class="control-label">Buying Contact</td>
						 <?php endif; ?>
						 <td><?= $config->buyertypes[$contact->buyingcontact]; ?></td>
						 <td>
							 <?= $page->bootstrap->select('class=form-control input-sm|name=buycontact', $config->buyertypes, $contact->buyingcontact); ?>
						 </td>
					 </tr>
					 <tr>
						 <?php if ($config->cptechcustomer == 'stat') : ?>
							 <td class="control-label">End User</td>
						 <?php else : ?>
							 <td class="control-label">Certificate Contact</td>
						 <?php endif; ?>
						 <td><?= array_flip($config->yesnoarray)[$contact->certcontact]; ?></td>
						 <td>
							 <?= $page->bootstrap->select('class=form-control input-sm|name=certcontact', array_flip($config->yesnoarray), $contact->certcontact); ?>
						 </td>
					 </tr>
				 </tbody>
			 </table>
			 <div class="panel-footer">
 				<button type="submit" class="btn btn-warning btn-sm">
 				 <i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Save Changes
 			   </button>
 		   </div> <!-- end panel footer -->
		</form>
 	</div> <!-- end panel round -->
<?php endif; ?>
