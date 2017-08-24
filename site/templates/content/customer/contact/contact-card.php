<div class="panel panel-primary not-round">
    <div class="panel-heading not-round"> <h3 class="panel-title"><?php echo $contact['contact']; ?></h3> </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-8 ">
                <table class="table table-user-information">
                    <tbody>
                        <tr>
                            <td>CustID:</td>
                            <td><?= $contact['custid']. ' - '. get_customer_name($contact['custid'], false); ?></td>
                        </tr>
                        <?php if (strlen($contact['shiptoid']) > 0) : ?>
                            <tr> <td>Ship-to ID:</td> <td><?php echo $contact['shiptoid']; ?></td></tr>
                        <?php endif; ?>
                        <tr> <td>Title:</td><td><?php //echo $contact['title']; ?></td> </tr>
                        <tr> <td>Email:</td> <td><a href="mailto:<?php echo $contact['email']; ?>"><?php echo $contact['email']; ?></a></td></tr>
                        <tr>
                            <td>Office Phone:</td>
                            <td>
                                <a href="tel:<?php echo $contact['cphone']; ?>"><?php echo $contact['cphone']; ?></a><b> &nbsp;
                                <?php if (strlen($contact['cphext']) > 0) { echo 'Ext. ' . $contact['cphext'];} ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td>Cell Phone:</td> <td><a href="tel:<?php echo $contact['ccellphone']; ?>"> <?php echo $contact['ccellphone']; ?></a></td>
                        </tr>
                        <!--<tr> <td>Fax:</td> <td><?php //echo $contact['faxnumber']; ?></td> </tr>     -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <form action="editcontact.php" method="post" class="hidden">
            <input type="hidden" name="custID" value="<?php echo $custID; ?>"> <input type="hidden" name="shipID" value="<?php echo $shipID; ?>">
            <input type="hidden" name="contact" value="<?php echo $contact['contact']; ?>">
            <button type="submit" class="btn btn-warning"> <span class="glyphicon glyphicon-edit"></span> Edit Contact</button>
        </form>
    </div>
</div>
