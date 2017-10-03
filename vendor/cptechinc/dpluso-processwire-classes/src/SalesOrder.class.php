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
            $this->update_properties();
        }
        
        public function update_properties() {
            if ($this->havedoc == 'Y') { $this->hasdocuments = true; }
            if ($this->havetrk == 'Y') { $this->hastracking = true; }
            if ($this->havenote == 'Y') { $this->hasnotes = true; }
            if ($this->editord == 'Y') { $this->canedit = true; }
            if ($this->phintl == 'Y') { $this->phoneinternational = true; }
            if ($this->error == 'Y') { $this->haserror = true; }
        }
        
        public function generate_editorderlink() {
            // TODO USE Purl
            return wire('config')->pages->orders."redir/?action=get-order-details&ordn=$this->orderno&lock=lock";
        }
        
        public function generate_rowclass($ordn) {
            if ($ordn == $this->orderno) {
                return 'selected';
            } else {
                return '';
            }
        }
        
        public function generate_clicktoexpand($ordn) {
            if ($ordn == $this->orderno) {
                
            } else {
                
            }
        }
        
        public function generate_getorderdetailslink($ajaxpath) {
            $orderlink = new \Purl\Url(wire('page')->httpUrl);
            $orderlink->path = wire('config')->pages->orders."redir";
            $orderlink->query->setData(array('action' => 'get-order-details', 'ordn' => $this->orderno, 'show' => false, 'orderby' => false));
            return $orderlink;
        }
        
        public function generate_generateclosedetailslink($ajaxpath) {
            $orderlink = new \Purl\Url(wire('page')->httpUrl);
            $orderlink->path = $ajaxpath;
            $orderlink->query->setData(array('ordn' => '', 'show' => false, 'orderby' => false));
            return $orderlink;
        }
        
        public static function create_fromarray(array $array) {
           $myClass = get_class();
           $object  = new $myClass(); 

           foreach ($array as $key => $val) {
               $object->$key = $val;
           }
           
           $object->update_properties();
           return $object;
       }
        
        public static function generate_classarray() {
            return SalesOrder::remove_nondbkeys(get_class_vars('SalesOrder'));
        }
        
        public static function remove_nondbkeys($array) {
            unset($array['canedit']);
            unset($array['hasnotes']);
            unset($array['hasdocuments']);
            unset($array['hastracking']);
            unset($array['haserror']);
            unset($array['phoneinternational']);
            return $array;
        }
        
    }
    
    
