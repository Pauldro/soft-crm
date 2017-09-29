<?php 

    class SalesOrder {
        public $sessionid;
        public $recno;
        public $date;
        public $time;
        public $type;
        public $custid;
        public $shiptoid;
        public $custname;
        public $orderno;
        public $custpo;
        public $custref;
        public $status;
        public $orderdate;
        public $careof;
        public $quotdate;
        public $invdate;
        public $shipdate;
        public $revdate;
        public $expdate;
        public $havedoc;
        public $havetrk;
        public $odrsubtot;
        public $odrtax;
        public $odrfrt;
        public $odrmis;
        public $odrtotal;
        public $havenote;
        public $editord;
        public $error;
        public $errormsg;
        public $sconame;
        public $sname;
        public $saddress;
        public $saddress2;
        public $scity;
        public $sst;
        public $szip;
        public $scountry;
        public $contact;
        public $phintl;
        public $phone;
        public $extension;
        public $faxnumber;
        public $email;
        public $releasenbr;
        public $shipviacd;
        public $shipviadesc;
        public $priccode;
        public $pricdesc;
        public $pricdisp;
        public $taxcode;
        public $taxcodedesc;
        public $taxcodedisp;
        public $termcode;
        public $termtype;
        public $termdesc;
        public $rqstdate;
        public $shipcom;
        public $sp1;
        public $sp1name;
        public $sp2;
        public $sp2name;
        public $sp2disp;
        public $sp3;
        public $sp3name;
        public $sp3disp;
        public $fob;
        public $deliverydesc;
        public $whse;
        public $ccno;
        public $xpdate;
        public $ccvalidcode;
        public $ccapproval;
        public $costtot;
        public $totdisc;
        public $paytype;
        public $srcdatefrom;
        public $srcdatethru;
        public $btname;
        public $btadr1;
        public $btadr2;
        public $btadr3;
        public $btctry;
        public $btcity;
        public $btstate;
        public $btzip;
        public $prntfmt;
        public $prntfmtdisp;
        public $dummy;       
        
        public $hasdocuments = false;
        public $hastracking = false;
        public $hasnotes = false;
        public $canedit = false;
        public $haserror = false;
        public $phoneinternational = false;
        
        
        public function __construct() {
            if ($this->havedoc == 'Y') { $this->hasdocuments = true; }
            if ($this->havetrk == 'Y') { $this->hastracking = true; }
            if ($this->havenote == 'Y') { $this->hasnotes = true; }
            if ($this->editord == 'Y') { $this->canedit = true; }
            if ($this->phintl == 'Y') { $this->phoneinternational = true; }
            if ($this->error == 'Y') { $this->haserror = true; }
        }
        
        public status function getlinkarray() {
            return array(
                'sessionid' => false,
                'recno' => false,
                'date' => false,
                'time' => false,
                'type' => false,
                'custid' => false,
                'shiptoid' => false,
                'custname' => false,
                'orderno' => false,
                'custpo' => false,
                'custref' => false,
                'status' => false,
                'orderdate' => false,
                'careof' => false,
                'quotdate' => false,
                'invdate' => false,
                'shipdate' => false,
                'revdate' => false,
                'expdate' => false,
                'havedoc' => false,
                'havetrk' => false,
                'odrsubtot' => false,
                'odrtax' => false,
                'odrfrt' => false,
                'odrmis' => false,
                'odrtotal' => false,
                'havenote' => false,
                'editord' => false,
                'error' => false,
                'errormsg' => false,
                'sconame' => false,
                'sname' => false,
                'saddress' => false,
                'saddress2' => false,
                'scity' => false,
                'sst' => false,
                'szip' => false,
                'scountry' => false,
                'contact' => false,
                'phintl' => false,
                'phone' => false,
                'extension' => false,
                'faxnumber' => false,
                'email' => false,
                'releasenbr' => false,
                'shipviacd' => false,
                'shipviadesc' => false,
                'priccode' => false,
                'pricdesc' => false,
                'pricdisp' => false,
                'taxcode' => false,
                'taxcodedesc' => false,
                'taxcodedisp' => false,
                'termcode' => false,
                'termtype' => false,
                'termdesc' => false,
                'rqstdate' => false,
                'shipcom' => false,
                'sp1' => false,
                'sp1name' => false,
                'sp2' => false,
                'sp2name' => false,
                'sp2disp' => false,
                'sp3' => false,
                'sp3name' => false,
                'sp3disp' => false,
                'fob' => false,
                'deliverydesc' => false,
                'whse' => false,
                'ccno' => false,
                'xpdate' => false,
                'ccvalidcode' => false,
                'ccapproval' => false,
                'costtot' => false,
                'totdisc' => false,
                'paytype' => false,
                'srcdatefrom' => false,
                'srcdatethru' => false,
                'btname' => false,
                'btadr1' => false,
                'btadr2' => false,
                'btadr3' => false,
                'btcity' => false,
                'btstate' => false,
                'btzip' => false,
                'prntfmt' => false,
                'prntfmtdisp' => false,
                'dummy' => false,
            );
        }
    }
    
    
