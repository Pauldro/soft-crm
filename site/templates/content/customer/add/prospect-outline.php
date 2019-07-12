<?php
    $custpricejson = json_decode(file_get_contents($config->companyfiles."json/custpricecodetbl.json"), true);
    $pricecodes = array();
    foreach ($custpricejson['data'] as $key => $code) {
        $pricecodes[$key] = $code['custpricecodedesc'];
    }

    $salespersonjson = json_decode(file_get_contents($config->companyfiles."json/salespersontbl.json"), true);
    $salespeople = array();
    foreach ($salespersonjson['data'] as $salesperson) {
        $salespeople[$salesperson['splogin']] = $salesperson['spname'];
    }

    $changesalesrep = $users->find("name=$user->loginid")->count ? ($users->get("name=$user->loginid")->hasRole('manager')) : false;
?>
<div class="form-group">
    <a href="<?= $page->parent->url; ?>" class="btn btn-primary">
        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>&ensp;Back to Customer Page
    </a>
</div>

<form action="<?= $config->pages->customer.'redir/'; ?>" method="post">
    <input type="hidden" name="action" value="add-prospect">
    <div class="row">
        <div class="col-sm-6">
           <legend>Prospect Information</legend>
            <table class="table table-striped table-bordered table-condensed">
                <tbody>
                    <tr>
                        <td class="control-label">Customer</td>
                        <td><p class="form-control-static">PROSPECT</p></td>
                    </tr>
                    <tr>
                        <td class="control-label">Name</td>
                        <td><input type="text" class="form-control input-sm required" name="billto-name" value=""></td>
                    </tr>
                    <tr>
                        <td class="control-label">Address</td>
                        <td><input type="text" class="form-control input-sm" name="billto-address" value=""></td>
                    </tr>
                    <tr>
                        <td class="control-label">Address 2</td>
                        <td><input type="text" class="form-control input-sm" name="billto-address2" value=""></td>
                    </tr>
                    <tr>
                        <td class="control-label">Address 3</td>
                        <td><input type="text" class="form-control input-sm" name="billto-address3" value=""></td>
                    </tr>
                    <tr>
                        <td class="control-label">City</td>
                        <td><input type="text" class="form-control input-sm" name="billto-city" value=""></td>
                    </tr>
                    <tr>
                        <td class="control-label">State</td>
                        <td><input type="text" class="form-control input-sm" name="billto-state" value=""></td>
                    </tr>
                    <tr>
                        <td class="control-label">Zip</td>
                        <td><input type="text" class="form-control input-sm" name="billto-zip" value=""></td>
                    </tr>
                    <tr>
                        <td class="control-label">Country</td>
                        <td>
                            <?php $countries = get_countries(); ?>
                            <select name="billto-country" class="form-control input-sm">
                                <option value="USA">United States</option>
                                <?php foreach ($countries as $country) : ?>
                                    <option value="<?= $country['ccode']; ?>"><?= $country['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
           </table>
        </div> <!-- end bill to column -->

        <div class="col-xs-6">
            <legend>Contact Information</legend>
            <table class="table table-striped table-bordered table-condensed">
                <tr>
                    <td class="control-label">Salesperson1</td>
                    <?php if ($config->cptechcustomer == 'stat' && $changesalesrep === false) : ?>
                        <td>
                            <?= $salespeople[$user->loginid]; ?>
                            <?= $page->bootstrap->input("name=salesperson1|type=hidden|value=$user->salespersonid"); ?>
                        </td>
                    <?php else : ?>
                        <td>
                            <?= $page->bootstrap->select('name=salesperson1|class=form-control input-sm', $salespeople, $user->salespersonid); ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td class="control-label">Phone</td>
                    <td><input type="text" class="form-control input-sm" name="contact-phone" value=""></td>
                </tr>
                <tr>
                    <td class="control-label">Email</td>
                    <td><input type="email" class="form-control input-sm" name="contact-email" value=""></td>
                </tr>
                <tr>
                    <td class="control-label">Type Code</td>
                    <td>
                        <select name="typecode" class="form-control input-sm">
                            <?php foreach ($pricecodes as $pricecode => $description) : ?>
                                <option value="<?= $pricecode; ?>"><?= $description; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="control-label">Notes</td>
                    <td>
                        <textarea name="notes" rows="4" class="form-control input-sm"></textarea>
                    </td>
                </tr>
            </table>
        </div>
    </div> <!-- end top row-->
    <br>
    <button type="submit" class="btn btn-primary">Add New Prospect</button>
</form>
