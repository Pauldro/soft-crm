<table class="table table-bordered table-striped table-condensed">
    <?php if ($soconfig['config']['show_margin'] == 'Y') : ?>
        <tr>
            <td>Margin </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control input-sm text-right margin"> <div class="input-group-addon input-sm">%</div>
                </div>
            </td>
        </tr>
    <?php endif; ?>
    <tr> <td>Qty</td> <td><input type="text" class="form-control pull-right input-sm text-right qty" name="qty" value="<?= $linedetail['quotunit']+0; ?>"></td> </tr>
    <tr>
        <td>Price</td>
        <td>
            <div class="input-group">
                <div class="input-group-addon input-sm">$ </div>
                <input type="text" class="form-control input-sm text-right price" name="price" value="<?= formatmoney($linedetail['quotprice']); ?>">
            </div>
        </td>
    </tr>
    
    <?php if ($soconfig['config']['use_discount'] == 'Y') : ?>
        <tr>
            <td>Discount Amt.</td>
            <td>
                <div class="input-group">
                    <div class="input-group-addon input-sm">$</div>
                    <input type="text" class="form-control input-sm text-right discount-amt" value="<?= formatmoney(($linedetail['discpct'] / 100) * $linedetail['quotprice']); ?>">
                </div>
            </td>
        </tr>
        <tr>
            <td>Discount %</td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control input-sm text-right discount-percent" name="discount" value="<?= formatmoney($linedetail['discpct']); ?>">
                    <div class="input-group-addon input-sm">%</div>
                </div>
            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <td>Extended Amount</td>
        <td>
            <div class="input-group">
                <div class="input-group-addon input-sm">$</div>
                <input type="text" class="form-control input-sm text-right totalprice" value="<?= formatmoney($linedetail['quotprice'] * $linedetail['quotunit']); ?>" disabled>
            </div>
        </td>
    </tr>
</table>
