<?php
    $vendorfile = $config->companyfiles."json/iishfmattbl.json";
    $creditjson = json_decode(file_get_contents($creditfile), true);

?>
<form>
    <div class="form-group row">
        <label for="vendorID" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Vend ID:</label>
        <div class="col-sm-5 col-md-6 col-lg-7">
            <input type="text" class="form-control" id="vendorID">
        </div>
        <div class="col-sm-5 col-md-4 col-lg-4">
            <span id="vendIDHelp">Placeholder</span>
        </div>
    </div>
    <div id="otherfields" class="hidden">
        <div class="form-group row">
            <label for="shipFr" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Ship Fr:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <input type="text" class="form-control" id="shipFr">
            </div>
            <div class="col-sm-5 col-md-4 col-lg-4">
                <span id="shipFrHelp">Placeholder</span>
            </div>
        </div>
        <div class="form-group row">
            <label for="itemID" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Item ID:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <input type="text" class="form-control" id="itemID">
            </div>
            <div class="col-sm-5 col-md-4 col-lg-4">
                <span id="itemIDHelp">Placeholder</span>
            </div>
        </div>
        <div class="form-group row">
            <label for="group" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Group:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <input type="text" class="form-control" id="group">
            </div>
            <div class="col-sm-5 col-md-4 col-lg-4">
                <span id="groupHelp">Placeholder</span>
            </div>
        </div>
        <div class="form-group row">
            <label for="poNum" class="col-sm-2 col-md-2 col-lg-1 col-form-label">PO Nbr:</label>
            <div class="col-sm-5 col-md-6 col-lg-7">
                <input type="number" class="form-control" id="poNbr">
            </div>
        </div>
        <div class="form-group row">
            <label for="ref" class="col-sm-2 col-md-2 col-lg-1 col-form-label">Reference:</label>
                <div class="col-sm-5 col-md-6 col-lg-7">
                    <input type="text" class="form-control" id="ref">
                </div>
        </div>
    </div>


    <button type="submit" class="btn btn-default">Submit</button>
</form>
