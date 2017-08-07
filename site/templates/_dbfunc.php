<?php

/* =============================================================
	LOGIN FUNCTIONS
============================================================ */
	function is_valid_login($sessionid) {
		$sql = wire('database')->prepare("SELECT IF(validlogin = 'Y',1,0) FROM logperm WHERE sessionid = :sessionid LIMIT 1");
		$switching = array(':sessionid' => $sessionid);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_login_error_msg($sessionid) {
		$sql = wire('database')->prepare("SELECT errormsg FROM logperm WHERE sessionid = :sessionid");
		$switching = array(':sessionid' => $sessionid);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_login_name($sessionid) {
		$sql = wire('database')->prepare("SELECT salespername FROM logperm WHERE sessionid = :sessionid");
		$switching = array(':sessionid'=> $sessionid);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_login_id($sessionid) {
		$sql = wire('database')->prepare("SELECT loginid FROM logperm WHERE sessionid = :sessionid");
		$switching = array(':sessionid'=> $sessionid);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function does_user_have_contact_restrictions($session) {
		$sql = wire('database')->prepare("SELECT IF(restrictaccess = 'Y',1,0) FROM logperm WHERE sessionid = '$session'");
		$switching = array(':sessionid' => $sessionid);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_login_record($sessionid) {
		$sql = wire('database')->prepare("SELECT IF(restrictaccess = 'Y',1,0) as restrictedaccess, logperm.* FROM logperm WHERE sessionid = :sessionid");
		$switching = array(':sessionid'=> $sessionid);
		$sql->execute($switching);
		return $sql->fetch(PDO::FETCH_ASSOC);
	}
/* =============================================================
	CUSTOMER FUNCTIONS
============================================================ */
	function has_access_to_customer($loginid, $restrictions, $custID, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM (SELECT * FROM custindex WHERE custid = :custID AND source = 'CS') t WHERE splogin1 IN (:loginid, :shared) OR splogin2 = :loginid OR splogin3 = :loginid");
			$switching = array(':custID' => $custID, ':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true, true);
			if ($debug) {
				return returnsqlquery($sql->queryString, $switching, $withquotes);
			} else {
				$sql->execute($switching);
				return $sql->fetchColumn();
			}
		} else {
			return 1;
		}
	}

	function has_access_to_customer_shipto($loginid, $restrictions, $custID, $shipID, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM (SELECT * FROM custindex WHERE custid = :custID AND shiptoid = :shipID AND source = 'CS') t WHERE splogin1 IN (:loginid, :shared) OR splogin2 = :loginid OR splogin3 = :loginid");
			$switching = array(':custID' => $custID, ':shipID' => $shipID, ':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true, true);
			if ($debug) {
				return returnsqlquery($sql->queryString, $switching, $withquotes);
			} else {
				$sql->execute($switching);
				return $sql->fetchColumn();
			}
		} else {
			return 1;
		}
	}

	function get_customer_name($custID) {
		$sql = wire('database')->prepare("SELECT name FROM custindex WHERE custid = :custID LIMIT 1");
		$switching = array(':custID' => $custID);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_shipto_name($custID, $shipID, $debug) {
		$sql = wire('database')->prepare("SELECT name FROM custindex WHERE custid = :custID AND shiptoid = :shipID LIMIT 1");
		$switching = array(':custID' => $custID, ':shipID' => $shipID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}

	}

	function get_customer_info($session, $custID, $debug) {
		$sql = wire('database')->prepare("SELECT custindex.*, customer.dateentered FROM custindex JOIN customer ON custindex.custid = customer.custid WHERE custindex.custid = :custID AND customer.sessionid = :sessionid LIMIT 1");
		$switching = array(':sessionid'=> $session, ':custID'=> $custID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function get_first_custindex($debug) {
		$sql = wire('database')->prepare("SELECT * FROM custindex LIMIT 1");
		$switching = array(); $withquotes = array();
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute();
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function get_shipto_count($login, $restrictions, $custID, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM view_distinct_cust_shiptos WHERE recno IN (SELECT recno FROM view_distinct_cust_shiptos WHERE splogin1 IN (:loginid, :shared)  OR splogin2 = :loginid  OR splogin3 = :loginid) AND custid = :custID");
			$switching = array(':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid, ':custID' => $custID);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM view_distinct_cust_shiptos WHERE custid = :custID");
			$switching = array(':custID' => $custID); $withquotes = array(true);
		}
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_shipto_info($custID, $shipID, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM view_distinct_cust_shiptos WHERE custid = :custID AND shiptoid = :shipID");
		$switching = array(':custID' => $custID, ':shipID' => $shipID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getcustomershiptos($custID, $loginid, $restrictions, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT * FROM view_distinct_cust_shiptos WHERE custid = :custID AND recno IN (SELECT recno FROM view_distinct_cust_shiptos WHERE splogin1 IN (:loginid, :shared) OR splogin2 = :loginid  OR splogin3 = :loginid)");
			$switching = array(':custID' => $custID, ':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM view_distinct_cust_shiptos WHERE custid = :custID");
			$switching = array(':custID' => $custID); $withquotes = array(true);
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_allowed_shiptos($custID, $loginid, $restrictions, $debug) { //DEPRECATE
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custID AND shiptoid != '' AND recno IN (SELECT recno FROM custindex WHERE (splogin1 IN (:loginid, :sharedaccounts) OR splogin2 = :loginid OR splogin3 = :loginid)) GROUP BY shiptoid");
			$switching = array(':custID'=> $custID, ':loginid' => $loginid, ':sharedaccounts' => wire('config')->sharedaccounts, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custID AND shiptoid != '' GROUP BY shiptoid");
			$switching = array(':custID'=> $custID);
			$withquotes = array(true);
		}
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}


	function get_contacts($loginid, $restrictions, $custID, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custID AND recno IN (SELECT recno FROM custindex WHERE splogin1 IN (:loginid, :shared) OR splogin2 = :loginid  OR splogin3 = :loginid)");
			$switching = array(':custID' => $custID, ':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custID");
			$switching = array(':custID' => $custID); $withquotes = array(true);
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Contact');
			return $sql->fetchAll();
		}
	}

	function does_user_have_access_contact($login, $restrictions, $custID, $shipID, $contact, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM custindex WHERE (splogin1 IN (:loginid, :shared) OR splogin2 = :loginid OR splogin3 = :loginid) AND custid = :custID AND shiptoid = :shipID AND contact = :contact");
			$switching = array(':loginid' => $login, ':shared' => $SHARED_ACCOUNTS, ':custID' => $custID, ':shipID' => $shipID, ':contact' => $contact);
			$withquotes = array(true, true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM custindex WHERE custid = :custID AND shiptoid = :shipID AND contact = :contact");
			$switching = array(':custID' => $custID, ':shipID' => $shipID, ':contact' => $contact);
			$withquotes = array(true, true, true);
		}
		$sql->execute($switching);
		if ($debug) { return returnsqlquery($sql->queryString, $switching, $withquotes); } else { if ($sql->fetchColumn() > 0){return true;} else {return false; } }
	}

	function getcustcontact($custID, $shipID, $contactid, $debug) {
		if (strlen($contactid) > 0) {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custID AND shiptoid = :shipID AND contact = :contactid LIMIT 1");
			$switching = array(':custID' => $custID, ':shipID' => $shipID, ':contactid' => $contactid);
			$withquotes = array(true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custID AND shiptoid = :shipID LIMIT 1");
			$switching = array(':custID' => $custID, ':shipID' => $shipID);
			$withquotes = array(true, true);
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getshiptocontact($custID, $shipID, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custID AND shiptoid = :shipID LIMIT 1");
		$switching = array(':custID' => $custID, ':shipID' => $shipID);
		$withquotes = array(true, true, true);
		$sql->execute($switching);
		if ($debug) { return returnsqlquery($sql->queryString, $switching, $withquotes); } else { return $sql->fetch(PDO::FETCH_ASSOC); }
	}

/* =============================================================
	CUST INDEX FUNCTIONS
============================================================ */
	function get_distinct_custindex_paged($loginid, $limit = 10, $page = 1, $restrictions, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		$limiting = returnlimitstatement($limit, $page);

		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid IN (SELECT DISTINCT(custid) FROM custperm WHERE loginid = :loginid OR loginid = :shared) GROUP BY custid ".$limiting);
			$switching = array(':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE shiptoid = '' GROUP BY custid " . $limiting);
			$switching = array();
			$withquotes = array();
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$sql->setFetchMode(\PDO::FETCH_CLASS, 'Contact');
			return $sql->fetchAll();
		}
	}

	function get_distinct_custindex_count($loginid, $restrictions, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM custindex WHERE custid IN (SELECT DISTINCT(custid) FROM custperm WHERE loginid = :loginid OR loginid = :shared)");
			$switching = array(':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM custindex WHERE shiptoid = ''" . $limiting);
			$switching = array();
			$withquotes = array();
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_custindex_keyword_paged($loginid, $limit = 10, $page = 1, $restrictions, $keyword, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		$limiting = returnlimitstatement($limit, $page);
		$search = '%'.str_replace(' ', '%',$keyword).'%';

		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE (custid, shiptoid) IN (SELECT custid, shiptoid FROM custperm WHERE loginid = :loginid OR loginid = :shared) AND UCASE(CONCAT(custid, ' ', name, ' ', shiptoid, ' ', addr1, ' ', ccity, ' ', cst, ' ', czip, ' ', cphone, ' ', contact, ' ', source, ' ', cphext)) LIKE UCASE(:search) ".$limiting);
			$switching = array(':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':search' => $search);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE UCASE(CONCAT(custid, ' ', name, ' ', shiptoid, ' ', addr1, ' ', ccity, ' ', cst, ' ', czip, ' ', cphone, ' ', contact, ' ', source, ' ', cphext)) LIKE UCASE(:search) " . $limiting);
			$switching = array();
			$withquotes = array();
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Contact');
			return $sql->fetchAll();
		}
	}

	function search_custindex_keyword_paged($loginid, $limit = 10, $page = 1, $restrictions, $keyword, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		$limiting = returnlimitstatement($limit, $page);
		$search = '%'.str_replace(' ', '%',$keyword).'%';

		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE (custid, shiptoid) IN (SELECT custid, shiptoid FROM custperm WHERE loginid = :loginid OR loginid = :shared) AND UCASE(CONCAT(custid, ' ', name, ' ', shiptoid, ' ', addr1, ' ', ccity, ' ', cst, ' ', czip, ' ', cphone, ' ', contact, ' ', source, ' ', cphext)) LIKE UCASE(:search) ".$limiting);
			$switching = array(':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':search' => $search);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE UCASE(CONCAT(custid, ' ', name, ' ', shiptoid, ' ', addr1, ' ', ccity, ' ', cst, ' ', czip, ' ', cphone, ' ', contact, ' ', source, ' ', cphext)) LIKE UCASE(:search) " . $limiting);
			$switching = array();
			$withquotes = array();
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll();
		}
	}

	function get_custindex_keyword_count($loginid, $restrictions, $keyword, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		$search = '%'.str_replace(' ', '%',$keyword).'%';

		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM custindex WHERE (custid, shiptoid) IN (SELECT custid, shiptoid FROM custperm WHERE loginid = :loginid OR loginid = :shared) AND UCASE(CONCAT(custid, ' ', name, ' ', shiptoid, ' ', addr1, ' ', ccity, ' ', cst, ' ', czip, ' ', cphone, ' ', contact, ' ', source, ' ', cphext)) LIKE UCASE(:search)");
			$switching = array(':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':search' => $search);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM custindex WHERE UCASE(CONCAT(custid, ' ', name, ' ', shiptoid, ' ', addr1, ' ', ccity, ' ', cst, ' ', czip, ' ', cphone, ' ', contact, ' ', source, ' ', cphext)) LIKE UCASE(:search)");
			$switching = array();
			$withquotes = array();
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_top_25_selling_customers($login, $restrictions, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT custid, name, amountsold, timesold, lastsaledate FROM custindex WHERE splogin1 IN (:login, :sharedaccounts) OR splogin2 = :login OR splogin3 = :login GROUP BY custid ORDER BY CAST(amountsold as Decimal(10,8)) DESC LIMIT 25");
			$switching = array(':login' => $login, ':sharedaccounts' => $SHARED_ACCOUNTS); $withquotes = array(true);
		} else {
			$sql = wire('database')->prepare("SELECT custid, name, amountsold, timesold, lastsaledate FROM custindex GROUP BY custid ORDER BY CAST(amountsold as Decimal(10,8)) DESC LIMIT 25 ");
			$switching = array(); $withquotes = array();
		}
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function insertnewcustomer($customer, $debug) {
		$query = returninsertlinks($customer);
		$sql = wire('database')->prepare("INSERT INTO custindex (".$query['columnlist'].") VALUES (".$query['valuelist'].")");
		$switching = $query['switching']; $withquotes = $query['withquotes'];
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		}
	}

	function getmaxcustindexrecnbr() {
		$sql = wire('database')->prepare("SELECT MAX(recno) FROM custindex");
		$sql->execute();
		return $sql->fetchColumn();
	}

	function changecustindexcustid($originalcustID, $newcustID) {
		$sql = wire('database')->prepare("UPDATE custindex SET custid = :newcustid WHERE custid = :originalcustid");
		$switching = array(':newcustid' => $newcustID, ':originalcustid' => $originalcustID); $withquotes = array(true, true);
		$sql->execute($switching);
		return returnsqlquery($sql->queryString, $switching, $withquotes);
	}

/* =============================================================
	ORDERS FUNCTIONS
============================================================ */
	function get_salesrep_order_count($session, $debug) {
		$sql = "SELECT IF(COUNT(DISTINCT(custid)) > 1,COUNT(*),0) as count FROM ordrhed WHERE sessionid = '$session' AND type = 'O'";
		if ($debug) {
			return $sql;
		} else {
			$results = wire('database')->query($sql);
			return $results->fetchColumn();
		}
	}
	function get_salesrep_orders_orderdate($sessionid, $limit = 10, $page = 1, $sortrule, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT orderdate, STR_TO_DATE(orderdate, '%m/%d/%Y') as dateoforder, orderno, custpo, shiptoid, sname, saddress, saddress2, scity, sst, szip, havenote,
					status, havetrk, havedoc, odrsubtot, odrtax, odrfrt, odrmis, odrtotal, error, errormsg, shipdate, custid, custname, invdate, editord FROM ordrhed
					WHERE sessionid = :sessionid AND type = :type ORDER BY dateoforder $sortrule " . $limiting);
		$switching = array(':sessionid'=> $sessionid, ':type'=> 'O'); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$results = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		}
	}

	function get_salesrep_orders_orderby($sessionid, $limit = 10, $page = 1, $sortrule, $orderby, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT ordrhed.*, CAST(odrsubtot AS DECIMAL(8,2)) AS subtotal FROM ordrhed WHERE sessionid = :sessionid  AND type = :type ORDER BY $orderby $sortrule " . $limiting);
		$switching = array(':sessionid'=> $sessionid, ':type'=> 'O'); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$results = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		}
	}

	function get_salesrep_orders($sessionid, $limit = 10, $page = 1, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT * FROM ordrhed WHERE sessionid = :sessionid AND type = :type ".$limiting);
		$switching = array(':sessionid'=> $sessionid, ':type'=> 'O'); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$results = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		}
	}
	function get_cust_order_count($sessionid, $custID, $debug) {
		$sql = wire('database')->prepare("SELECT COUNT(*) as count FROM ordrhed WHERE sessionid = :sessionid AND custid = :custID AND type = 'O'");
		$switching = array(':sessionid' => $sessionid, ':custID' => $custID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_cust_orders($sessionid, $custID, $limit = 10, $page = 1, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT * FROM ordrhed WHERE sessionid = :sessionid AND custid = :custID AND type = 'O' ".$limiting);
		$switching = array(':sessionid' => $sessionid, ':custID' => $custID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_cust_orders_orderby($sessionid, $custID, $limit = 10, $page = 1, $sortrule, $orderby, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT ordrhed.*, CAST(odrsubtot AS DECIMAL(8,2)) AS subtotal FROM ordrhed WHERE sessionid = :sessionid AND custid = :custID AND type = 'O' ORDER BY $orderby $sortrule ".$limiting);
		$switching = array(':sessionid' => $sessionid, ':custID' => $custID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_cust_orders_orderdate($sessionid, $custID, $limit = 10, $page = 1, $sortrule, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT orderdate, STR_TO_DATE(orderdate, '%m/%d/%Y') as dateoforder, orderno, custpo, shiptoid, sname, saddress, saddress2, scity, sst, szip, havenote, status, havetrk, havedoc, odrsubtot, odrtax, odrfrt, odrmis, odrtotal, error, errormsg, shipdate, custid, custname, invdate, editord FROM ordrhed WHERE sessionid = :sessionid AND custid = :custID AND type = 'O' ORDER BY dateoforder $sortrule ".$limiting);
		$switching = array(':sessionid' => $sessionid, ':custID' => $custID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_custid_from_order($sessionid, $ordn) {
		$sql = wire('database')->prepare("SELECT custid FROM ordrhed WHERE sessionid = :sessionid AND orderno = :ordn LIMIT 1");
		$switching = array(':sessionid'=> $sessionid, ':ordn' => $ordn);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_order_details($sessionid, $ordn, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM ordrdet WHERE sessionid = :sessionid AND orderno = :ordn");
		$switching = array(':sessionid'=> $sessionid, ':ordn' => $ordn); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function hasanorderlocked($sessionid) {
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM ordlock WHERE sessionid = :sessionid");
		$switching = array(':sessionid'=> $sessionid);
		$sql->execute($switching);
		return $sql->fetchColumn() > 0 ? true : false;
	}

	function getlockedordn($sessionid) {
		$sql = wire('database')->prepare("SELECT orderno FROM ordlock WHERE sessionid = :sessionid");
		$switching = array(':sessionid'=> $sessionid);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_order_docs($session, $ordn, $debug) {
		$sql = "SELECT * FROM orddocs WHERE sessionid = '$session' AND orderno = '$ordn' AND itemnbr = '' ";
		if ($debug) {
			return $sql;
		} else {
			$results = wire('database')->query($sql);
			return $results;
		}
	}
/* =============================================================
	QUOTES FUNCTIONS
============================================================ */
	function hasaquotelocked($session) {
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM quotelock WHERE sessionid = :session");
		$switching = array(':session'=> $session); $withquotes = array(true);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function getlockedquotenbr($session) {
		$sql = wire('database')->prepare("SELECT quotenbr FROM quotelock WHERE sessionid = :session");
		$switching = array(':session'=> $session); $withquotes = array(true);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function caneditquote($sessionid, $qnbr) {
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM quotelock WHERE sessionid = :sessionid AND quotenbr = :qnbr");
		$switching = array(':sessionid'=> $sessionid, ':qnbr' => $qnbr);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_cust_quote_count($sessionid, $custID, $debug) {
		$sql = wire('database')->prepare("SELECT COUNT(*) as count FROM quothed WHERE sessionid = :sessionid AND custid = :custID");
		$switching = array(':sessionid'=> $sessionid, ':custID' => $custID); $withquotes = array(true,true);
		if ($debug) {
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_cust_quotes($sessionid, $custID, $limit, $page, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT * FROM quothed WHERE sessionid = :sessionid AND custid = :custID $limiting");
		$switching = array(':sessionid'=> $sessionid, ':custID' => $custID); $withquotes = array(true, true);
		if ($debug) {
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function getquotecustomer($sessionid, $qnbr, $debug) {
		$sql = wire('database')->prepare("SELECT custid FROM quothed WHERE sessionid = :sessionid AND quotnbr = :qnbr");
		$switching = array(':sessionid'=> $sessionid, ':qnbr' => $qnbr); $withquotes = array(true, true);
		if ($debug) {
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function getquoteshipto($sessionid, $qnbr, $debug) {
		$sql = wire('database')->prepare("SELECT shiptoid FROM quothed WHERE sessionid = :sessionid AND quotnbr = :qnbr");
		$switching = array(':sessionid'=> $sessionid, ':qnbr' => $qnbr); $withquotes = array(true, true);
		if ($debug) {
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_quotehead($sessionid, $qnbr, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM quothed WHERE sessionid = :sessionid AND quotnbr = :qnbr");
		$switching = array(':sessionid'=> $sessionid, ':qnbr' => $qnbr); $withquotes = array(true, true);
		if ($debug) {
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function get_quote_details($sessionid, $qnbr, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM quotdet WHERE sessionid = :sessionid AND quotenbr = :qnbr");
		$switching = array(':sessionid'=> $sessionid, ':qnbr' => $qnbr); $withquotes = array(true, true);
		if ($debug) {
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_quoteline($sessionid, $qnbr, $line, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM quotdet WHERE sessionid = :sessionid AND quotenbr = :qnbr AND linenbr = :line");
		$switching = array(':sessionid'=> $sessionid, ':qnbr' => $qnbr, ':line' => $line); $withquotes = array(true, true, true);
		if ($debug) {
			return	returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getquotelinedetail($sessionid, $qnbr, $line, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM quotdet WHERE sessionid = :sessionid AND quotenbr = :qnbr AND linenbr = :linenbr");
		$switching = array(':sessionid'=> $sessionid, ':qnbr' => $qnbr, ':linenbr' => $line); $withquotes = array(true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function nextquotelinenbr($sessionid, $qnbr) {
		$sql = wire('database')->prepare("SELECT MAX(linenbr) FROM quotdet WHERE sessionid = :sessionid AND quotenbr = :qnbr ");
		$switching = array(':sessionid' => $sessionid, ':qnbr' => $qnbr); $withquotes = array(true, true);
		$sql->execute($switching);
		return intval($sql->fetchColumn()) + 1;
	}

	function edit_quotehead($sessionid, $qnbr, $quote, $debug) {
		//FIXME $query = returnpreppedquery($originaldetail, $newdetails);
		//LOOK AT edit_orderline(
		$originalquote = get_quotehead(session_id(), $qnbr, false);
		$columns = array_keys($originalquote);
		$withquotes = $switching = array();
		$setstmt = '';
		foreach ($columns as $column) {
			if ($originalquote[$column] != $quote[$column]) {
				$prepped = ':'.$column;
				$setstmt .= $column." = ".$prepped.", ";
				$switching[$prepped] = $quote[$column];
				$withquotes[] = true;
			}
		}
		$setstmt = rtrim($setstmt, ', ');
		$sql = wire('database')->prepare("UPDATE quothed SET $setstmt WHERE sessionid = :sessionid AND quotnbr = :quotnbr");
		$switching[':sessionid'] = $sessionid; $switching[':quotnbr'] = $qnbr; $withquotes[] =true; $withquotes[] = true;
		if ($debug) {
			return	returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		}
	}

	function edit_quoteline($sessionid, $qnbr, $newdetails, $debug) {
		$originaldetail = getquotelinedetail(session_id(), $qnbr, $newdetails['linenbr'], false);
		$query = returnpreppedquery($originaldetail, $newdetails);
		$sql = wire('database')->prepare("UPDATE quotdet SET ".$query['setstatement']." WHERE sessionid = :sessionid AND quotenbr = :qnbr AND linenbr = :linenbr");
		$query['switching'][':sessionid'] = $sessionid; $query['switching'][':qnbr'] = $qnbr; $query['switching'][':linenbr'] = $newdetails['linenbr'];
		$query['withquotes'][] = true; $query['withquotes'][]= true; $query['withquotes'][] = true;
		if ($debug) {
			return	returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		} else {
			if ($query['changecount'] > 0) {
				$sql->execute($query['switching']);
			}
			return returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		}
	}


/* =============================================================
	NOTES FUNCTIONS
============================================================ */
	function can_write_sales_note($sessionid, $ordn) {
		$sql = wire('database')->prepare("SELECT status FROM ordrhed WHERE sessionid = :sessionid AND orderno = :ordn LIMIT 1 ");
		$switching = array(':sessionid'=> $sessionid, ':ordn' => $ordn);
		$sql->execute($switching);
		$status = $sql->fetchColumn();
		if (strtolower($status) == "open" || strtolower($status) == "new") {
			return true;
		} else {
			return false;
		}
	}

	function get_dplusnotes($sessionid, $key1, $key2, $type, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM qnote WHERE sessionid = :sessionid AND key1 = :key1 AND key2 = :key2 AND rectype = :type");
		$switching = array(':sessionid'=> $sessionid, ':key1' => $key1, ':key2' => $key2, ':type' => $type);
		$withquotes = array(true, true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function getdplusnotecount($sessionid, $key1, $key2, $type, $debug) {
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM qnote WHERE sessionid = :sessionid AND key1 = :key1 AND key2 = :key2 AND rectype = :type");
		$switching = array(':sessionid'=> $sessionid, ':key1' => $key1, ':key2' => $key2, ':type' => $type);
		$withquotes = array(true, true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function hasdplusnote($sessionid, $key1, $key2, $type) {
		if (getdplusnotecount($sessionid, $key1, $key2, $type, false)) {
			return 'Y';
		} else {
			return 'N';
		}
	}

	function get_dplusnote($sessionid, $key1, $key2, $type, $recnbr, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM qnote WHERE sessionid = :sessionid AND key1 = :key1 AND key2 = :key2 AND rectype = :type AND recno = :recnbr");
		$switching = array(':sessionid'=> $sessionid, ':key1' => $key1, ':key2' => $key2, ':type' => $type, ':recnbr' => $recnbr);
		$withquotes = array(true, true, true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}


	function edit_note($session, $key1, $key2, $form1, $form2, $form3, $form4, $form5, $note, $recnbr, $date, $time, $width) {
		$sql = wire('database')->prepare("UPDATE qnote SET notefld = :note  WHERE sessionid = :session AND key1 = :key1 AND key2 = :key2 AND form1 = :form1 AND form2 = :form2 AND form3 = :form3 AND form4 = :form4 AND form5 = :form5 AND recno = :recnbr");
		$switching = array(':note' => $note, ':form1' => $form1, ':form2' => $form2, ':form3' => $form3, ':form4' => $form4, ':form5' => $form5, ':session' => $session, ':key1' => $key1, ':key2' => $key2, ':recnbr' => $recnbr);
		$withquotes = array(true, true, true, true, true, true, true, true, true, true);
		$sql->execute($switching);
		return returnsqlquery($sql->queryString, $switching, $withquotes);
	}

	function deletenote($session, $key1, $key2, $form1, $form2, $form3, $form4, $form5, $rectype, $recnbr) {
		$sql = wire('database')->prepare("DELETE FROM qnote WHERE sessionid = :session AND key1 = :key1 AND key2 = :key2 AND form1 = :form1 AND form2 = :form2 AND form3 = :form3 AND form4 = :form4 AND form5 = :form5 AND recno = :recnbr AND rectype = :rectype");
		$switching = array(':session' => $session, ':key1' => $key1, ':key2' => $key2, ':form1' => $form1, ':form2' => $form2, ':form3' => $form3, ':form4' => $form4, ':form5' => $form5, ':recnbr' => $recnbr, ':rectype' => $rectype);
		$withquotes = array(true, true, true, true, true, true, true, true, true, true);
		$sql->execute($switching);
		return returnsqlquery($sql->queryString, $switching, $withquotes);
	}

	function insert_note($session, $key1, $key2, $form1, $form2, $form3, $form4, $form5, $note, $rectype, $recno, $date, $time, $width) {
		$sql = "INSERT INTO qnote (sessionid, notefld, key1, key2, form1, form2, form3, form4, form5, rectype, recno, date, time, colwidth) VALUES ('$session', '$note',
		'$key1', '$key2', '$form1', '$form2', '$form3', '$form4', '$form5', '$rectype', '$recno', '$date', '$time', '$width')";
		wire('database')->query($sql);
		return $sql;
	}

	function insertdplusnote($session, $key1, $key2, $form1, $form2, $form3, $form4, $form5, $note, $rectype, $recno, $date, $time, $width) {
		$sql = wire('database')->prepare("INSERT INTO qnote (sessionid, notefld, key1, key2, form1, form2, form3, form4, form5, rectype, recno, date, time, colwidth) VALUES (:session, :note,
		:key1, :key2, :form1, :form2, :form3, :form4, :form5, :rectype, :recno, :date, :time, :width)");
		$switching = array(':session' => $session, ':note' => $note, ':key1' => $key1, ':key2' => $key2, ':form1' => $form1, ':form2' => $form2, ':form3' => $form3, ':form4' => $form4, ':form5' => $form5, ':rectype' => $rectype, ':recno' => $recno, ':date' => $date, ':time' => $time, ':width' => $width);
		$withquotes = array(true, true, true, true, true, true, true, true, true, true, true, true, true, true);
		$sql->execute($switching);
		return array('sql' => returnsqlquery($sql->queryString, $switching, $withquotes), 'insertedid' => wire('database')->lastInsertId());
	}

	function get_next_note_recno($session, $key1, $key2, $rectype) {
		$sql = "SELECT MAX(recno) as max FROM qnote WHERE sessionid = '$session' AND key1 = '$key1' AND key2 = '$key2' AND rectype = '$rectype'";
		$res = wire('database')->query($sql);
		$result = $res->fetchColumn();
		$nextrecnbr =  intval($result) + 1;
		return $nextrecnbr;
	}


/* =============================================================
	PRODUCT FUNCTIONS
============================================================ */
	function get_item_search_results($session, $limit = 10, $page = 1, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT * FROM pricing WHERE sessionid = :session " .$limiting);
		$switching = array(':session' => $session); $withquotes = array(true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_item_search_results_count($session, $debug) {
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM pricing WHERE sessionid = :session ");
		$switching = array(':session' => $session); $withquotes = array(true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchColumn();
		}
	}

	function getitemavailability($session, $itemID, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM whseavail WHERE sessionid = :sessionid AND itemid = :itemid");
		$switching = array(':sessionid' => $session, ':itemid' => $itemID); $withquotes = array(true, true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/* =============================================================
		USER ACTION FUNCTIONS
	============================================================ */

	function getuseractions($user, $querylinks, $limit, $page, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$query = returnwherelinks($querylinks);
		$andlinks = $query['wherestatement'];
		$sql = wire('database')->prepare("SELECT * FROM useractions WHERE $andlinks $limiting");
		$switching = $query['switching'];
		$withquotes = $query['withquotes'];
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'UserAction');
			return $sql->fetchAll();
		}
	}

	function getuseractionscount($user, $querylinks, $debug) {
		$query = returnwherelinks($querylinks);
		$andlinks = $query['wherestatement'];
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM useractions WHERE $andlinks");
		$switching = $query['switching'];
		$withquotes = $query['withquotes'];
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function loaduseraction($id, $fetchclass, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM useractions WHERE id = :id");
		$switching = array(':id' => $id); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			if ($fetchclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'UserAction');
			}
			return $sql->fetch();
		}
	}

	function updateaction($actionID, $action, $debug) {
		$originalaction = loaduseraction($actionID, false, false); // (id, bool fetchclass, bool debug)
		$query = returnpreppedquery($originalaction, $action);
		$sql = wire('database')->prepare("UPDATE useractions SET ".$query['setstatement']." WHERE id = :actionid");
		$query['switching'][':actionid'] = $actionID;$query['withquotes'][] = true;
		if ($debug) {
			return returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		} else {
			$sql->execute($query['switching']);
			$success = $sql->rowCount();
			if ($success) {
				return array("error" => false,  "sql" => returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']));
			} else {
				return array("error" => true,  "sql" => returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']));
			}
		}

	}

	function insertaction($action, $debug) {
		$query = returninsertlinks($action);
		$sql = wire('database')->prepare("INSERT INTO useractions (".$query['columnlist'].") VALUES (".$query['valuelist'].")");
		$switching = $query['switching'];
		$withquotes = $query['withquotes'];
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return array('sql' => returnsqlquery($sql->queryString, $switching, $withquotes), 'insertedid' => wire('database')->lastInsertId());
		}
	}

	function get_useractions_maxrec($loginid) {
		$sql = wire('database')->prepare("SELECT MAX(id) AS id FROM useractions WHERE createdby = :login");
		$switching = array(':login' => $loginid);
		$withquotes = array(true, true);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function getparentaction($actionID, $debug) {
		$sql = wire('database')->prepare("SELECT actionlink FROM useractions WHERE id = :id");
		$switching = array(':id' => $actionID); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}
/* =============================================================
	VENDOR FUNCTIONS
============================================================ */
	function getvendors($debug) {
		$sql = wire('database')->prepare("SELECT * from vendors AND shipfrom != ''");
		$switching = array(); $withquotes = array();
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function getvendorshipfroms($vendorID, $debug) {
		$sql = wire('database')->prepare("SELECT * from vendors WHERE id = :vendor AND shipfrom != ''");
		$switching = array(':vendor' => $vendorID); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

/* =============================================================
	CART FUNCTIONS
============================================================ */
	function getcartheadcount($sessionid, $debug) {
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM carthed WHERE sessionid = :sessionid");
		$switching = array(':sessionid' => $sessionid); $withquotes = array(true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchColumn();
		}
	}

	function getcartcustomer($sessionid, $debug) {
		$sql = wire('database')->prepare("SELECT custid FROM carthed WHERE sessionid = :sessionid");
		$switching = array(':sessionid' => $sessionid); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function getcarthead($sessionid, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM carthed WHERE sessionid = :sessionid");
		$switching = array(':sessionid' => $sessionid); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function editcarthead($sessionid, $carthead, $debug) {
		$orginalcarthead = getcarthead($sessionid, false);
		$query = returnpreppedquery($originalcarthead, $carthead);
		$sql = wire('database')->prepare("UPDATE carthed SET ".$query['setstatement']." WHERE sessionid = :sessionid");
		$query['switching'][':sessionid'] = $sessionid; $query['withquotes'][] = true;
		if ($debug) {
			return returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		} else {
			if ($query['changecount'] > 0) {
				$sql->execute($query['switching']);
			}
			return returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		}
	}

	function getcart($sessionid, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM cartdet WHERE sessionid = :sessionid");
		$switching = array(':sessionid' => $sessionid); $withquotes = array(true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

	}

	function insertcarthead($sessionid, $custID, $shipID, $debug) {
		$sql = wire('database')->prepare("INSERT INTO carthed (sessionid, custid, shiptoid, date, time) VALUES (:sessionid, :custID, :shipID, :date, :time)");
		$switching = array(':sessionid' => $sessionid, ':custID' => $custID, ':shipID' => $shipID, ':date' => date('Ymd'), ':time' =>date('His')); $withquotes = array(true, true, true, false, false);

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		}
	}

	function getcartline($sessionid, $linenbr, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM cartdet WHERE sessionid = :sessionid AND linenbr = :linenbr");
		$switching = array(':sessionid' => $sessionid, ':linenbr' => $linenbr); $withquotes = array(true, true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getcartlinedetail($sessionid, $linenbr, $debug) {
		return getcartline($sessionid, $linenbr, $debug);
	}

	function edit_cartline($sessionid, $newdetails, $debug) {
		$originaldetail = getcartlinedetail($sessionid, $newdetails['linenbr'], false);
		$query = returnpreppedquery($originaldetail, $newdetails);
		$sql = wire('database')->prepare("UPDATE cartdet SET ".$query['setstatement']." WHERE sessionid = :sessionid AND linenbr = :linenbr");
		$query['switching'][':sessionid'] = $sessionid; $query['switching'][':linenbr'] = $newdetails['linenbr'];
		$query['withquotes'][] = true; $query['withquotes'][]= true; $query['withquotes'][] = true;
		if ($debug) {
			return returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		} else {
			if ($query['changecount'] > 0) {
				$sql->execute($query['switching']);
			}
			return returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		}
	}

	function nextcartlinenbr($sessionid) {
		$sql = wire('database')->prepare("SELECT MAX(linenbr) FROM cartdet WHERE sessionid = :sessionid");
		$switching = array(':sessionid' => $sessionid); $withquotes = array(true);
		$sql->execute($switching);
		return intval($sql->fetchColumn()) + 1;
	}

	function getcreatedordn($sessionid, $debug) {
		$sql = wire('database')->prepare("SELECT ordernbr FROM logperm WHERE sessionid = :sessionid");
		$switching = array(':sessionid' => $sessionid); $withquotes = array(true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchColumn();
		}
	}



/* =============================================================
	EDIT ORDER FUNCTIONS
============================================================ */
	function caneditorder($session, $ordn, $debug) {
		$sql = wire('database')->prepare("SELECT editord FROM ordrhed WHERE sessionid = :session AND orderno = :ordn LIMIT 1");
		$switching = array(':session'=> $session, ':ordn' => $ordn); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$column = $sql->fetchColumn();
			if ($column != 'Y') { return false; } else { return true; }
		}
	}

	function get_customer_name_from_order($session, $ordn) {
		$sql = wire('database')->prepare("SELECT custname FROM ordrhed WHERE sessionid = :session AND orderno = :ordn LIMIT 1");
		$switching = array(':session'=> $session, ':ordn' => $ordn);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_shiptoid_from_order($session, $ordn) {
		$sql = wire('database')->prepare("SELECT shiptoid FROM ordrhed WHERE sessionid = :session AND orderno = :ordn LIMIT 1");
		$switching = array(':session'=> $session, ':ordn' => $ordn);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_orderhead($session, $ordn, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM ordrhed WHERE sessionid = :session AND orderno = :ordn AND type = 'O'");
		$switching = array(':session'=> $session, ':ordn' => $ordn); $withquotes = array(true, true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getorderdetails($sessionid, $ordn, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM ordrdet WHERE sessionid = :sessionid AND orderno = :ordn");
		$switching = array(':sessionid'=> $sessionid, ':ordn' => $ordn); $withquotes = array(true, true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function getorderlinedetail($session, $ordn, $linenumber, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM ordrdet WHERE sessionid = :session AND orderno = :ordn AND linenbr = :linenbr");
		$switching = array(':session'=> $session, ':ordn' => $ordn, ':linenbr' => $linenumber); $withquotes = array(true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getallorderdocs($session, $ordn, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM orddocs WHERE sessionid = :session AND orderno = :ordn ORDER BY itemnbr ASC");
		$switching = array(':session'=> $session, ':ordn' => $ordn); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function getordertracking($sessionid, $ordn, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM ordrtrk WHERE sessionid = :sessionid AND orderno = :ordn");
		$switching = array(':sessionid'=> $sessionid, ':ordn' => $ordn); $withquotes = array(true, true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function edit_orderhead($sessionid, $ordn, $order, $debug) {
		//FIXME $query = returnpreppedquery($originaldetail, $newdetails);
		//LOOK AT edit_orderline(
		$orginalorder = get_orderhead(session_id(), $ordn, false);
		$columns = array_keys($orginalorder);
		$withquotes = $switching = array();
		$setstmt = '';
		foreach ($columns as $column) {
			if (strlen($order[$column])) {
				if ($orginalorder[$column] != $order[$column]) {
					$prepped = ':'.$column;
					$setstmt .= $column." = ".$prepped.", ";
					$switching[$prepped] = $order[$column];
					$withquotes[] = true;
				}
			}
		}
		$setstmt = rtrim($setstmt, ', ');
		$sql = wire('database')->prepare("UPDATE ordrhed SET $setstmt WHERE sessionid = :sessionid AND orderno = :ordn");
		$switching[':sessionid'] = $sessionid; $switching[':ordn'] = $ordn; $withquotes[] =true; $withquotes[] = true;
		if ($debug) {
			return	returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		}
	}

	function edit_orderhead_credit($session, $ordn, $paytype, $ccno, $xpd, $ccv) {
		$sql = wire('database')->prepare("UPDATE ordrhed SET paytype = :paytype, ccno = AES_ENCRYPT(:ccno, HEX(:session)), xpdate = AES_ENCRYPT(:xpd, HEX(:session)), ccvalidcode = AES_ENCRYPT(:ccv, HEX(:session)) WHERE sessionid = :session AND orderno = :ordn");
		$switching = array(':paytype' => $paytype, ':ccno' => $ccno, ':session' => $session, ':xpd' => $xpd, ':ccv' => $ccv, ':session' => $session, ':ordn' => $ordn);
		$withquotes = array(true ,true, true, true, true, true,true);
		$sql->execute($switching);
		return returnsqlquery($sql->queryString, $switching, $withquotes);
	}

	function edit_orderline($sessionid, $ordn, $newdetails, $debug) {
		$originaldetail = getorderlinedetail($sessionid, $ordn, $newdetails['linenbr'], false);
		$query = returnpreppedquery($originaldetail, $newdetails);
		$sql = wire('database')->prepare("UPDATE ordrdet SET ".$query['setstatement']." WHERE sessionid = :sessionid AND orderno = :ordn AND linenbr = :linenbr");
		$query['switching'][':sessionid'] = $sessionid; $query['switching'][':ordn'] = $ordn; $query['switching'][':linenbr'] = $newdetails['linenbr'];
		$query['withquotes'][] = true; $query['withquotes'][]= true; $query['withquotes'][] = true;
		if ($debug) {
			return	returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		} else {
			if ($query['changecount'] > 0) {
				$sql->execute($query['switching']);
			}
			return returnsqlquery($sql->queryString, $query['switching'], $query['withquotes']);
		}
	}

	function getordercreditcard($session, $ordn, $debug) {
		$sql = wire('database')->prepare("SELECT AES_DECRYPT(ccno , HEX(sessionid)) AS cardnumber, AES_DECRYPT(ccvalidcode , HEX(sessionid)) AS validation, AES_DECRYPT(xpdate, HEX(sessionid)) AS expiredate FROM ordrhed WHERE sessionid = :session AND orderno = :ordn AND type = 'O'");
		$switching = array(':session'=> $session, ':ordn' => $ordn); $withquotes = array(true, true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getshipvias($session) {
		$sql = wire('database')->prepare("SELECT code, via FROM shipvia WHERE sessionid = :session");
		$switching = array(':session'=> $session); $withquotes = array(true);
		$sql->execute($switching);
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

/* =============================================================
	MISC ORDER FUNCTIONS
============================================================ */
	function getstates() {
		$sql = wire('database')->prepare("SELECT abbreviation as state, name FROM states");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function getcountries() {
		$sql = wire('database')->prepare("SELECT * FROM countries");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}



/* =============================================================
	ITEM FUNCTIONS
============================================================ */
	function getiteminfo($session, $itemID, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM pricing WHERE sessionid = :session AND itemid = :itemid LIMIT 1");
		$switching = array(':session' => $session, ':itemid' => $itemID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getitemfromim($itemID, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM pricing WHERE itemid = :itemid LIMIT 1");
		$switching = array(':itemid' => $itemID); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	/* =============================================================
		ITEM MASTER FUNCTIONS
	============================================================ */

	function searchitem($q, $byitemid, $debug) {
		$search = '%'.str_replace(' ', '%', $q).'%';
		if ($byitemid){
			$sql = wire('database')->prepare("SELECT * FROM itemsearch WHERE UCASE(itemid) LIKE UCASE(:search) GROUP BY itemid");
		} else {
			$sql = wire('database')->prepare("SELECT * FROM itemsearch WHERE UCASE(CONCAT(itemid, ' ', originid, ' ', refitemid, ' ', desc1, ' ', desc2)) LIKE UCASE(:search) GROUP BY itemid");
		}

		$switching = array(':search' => $search); $withquotes = array(true);

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function searchitem_page($q, $byitemid, $limit, $page, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$search = '%'.str_replace(' ', '%', $q).'%';
		if ($byitemid){
			$sql = wire('database')->prepare("SELECT * FROM itemsearch WHERE UCASE(itemid) LIKE UCASE(:search) GROUP BY itemid $limiting");
		} else {
			$sql = wire('database')->prepare("SELECT * FROM itemsearch WHERE UCASE(CONCAT(itemid, ' ', originid, ' ', refitemid, ' ', desc1, ' ', desc2)) LIKE UCASE(:search) GROUP BY itemid $limiting");
		}

		$switching = array(':search' => $search); $withquotes = array(true);

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}


	function searchitemcount($q, $byitemid, $debug) {
		$search = '%'.str_replace(' ', '%', $q).'%';
		if ($byitemid){
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM itemsearch WHERE UCASE(itemid) LIKE UCASE(:search) GROUP BY itemid");
		} else {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM itemsearch WHERE UCASE(CONCAT(itemid, ' ', originid, ' ', refitemid, ' ', desc1, ' ', desc2)) LIKE UCASE(:search) GROUP BY itemid");
		}
		$switching = array(':search' => $search); $withquotes = array(true);

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function getitemdescription($itemID, $debug) {
		$sql = wire('database')->prepare("SELECT desc1 FROM itemsearch WHERE itemid = :itemid LIMIT 1");
		$switching = array(':itemid' => $itemID); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function getnextrecno($itemID, $nextorprev, $debug) {
		if ($nextorprev == 'next') {
			$sql = wire('database')->prepare("SELECT MAX(recno) + 1 FROM itemsearch WHERE itemid = :itemid");
		} else {
			$sql = wire('database')->prepare("SELECT MIN(recno) - 1 FROM itemsearch WHERE itemid = :itemid");
		}
		$switching = array(':itemid' => $itemID); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function getitembyrecno($recno, $debug) {
		$sql = wire('database')->prepare("SELECT itemid FROM itemsearch WHERE recno = :recno");
		$switching = array(':recno' => $recno); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}

	}

	/* =============================================================
		TABLE FORMATTER FUNCTIONS
	============================================================ */
	function getformatter($user, $formatter, $debug) {
		$sql = wire('database')->prepare("SELECT data FROM tableformatter WHERE user = :user AND formattertype = :formatter LIMIT 1");
		$switching = array(':user' => $user, ':formatter' => $formatter); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function addformatter($user, $formatter, $data, $debug) {
		$sql = wire('database')->prepare("INSERT INTO tableformatter (user, formattertype, data) VALUES (:user, :formatter, :data)");
		$switching = array(':user' => $user, ':formatter' => $formatter, ':data' => $data); $withquotes = array(true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return array('sql' => returnsqlquery($sql->queryString, $switching, $withquotes), 'insertedid' => wire('database')->lastInsertId());
		}
	}

	function checkformatterifexists($user, $formatter, $debug) {
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM tableformatter WHERE user = :user AND formattertype = :formatter");
		$switching = array(':user' => $user, ':formatter' => $formatter); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function getmaxtableformatterid($user, $formatter, $debug) {
		$sql = wire('database')->prepare("SELECT MAX(id) FROM tableformatter WHERE user = :user AND formattertype = :formatter");
		$switching = array(':user' => $user, ':formatter' => $formatter); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function editformatter($user, $formatter, $data, $debug) {
		$sql = wire('database')->prepare("UPDATE tableformatter SET data = :data WHERE user = :user AND formattertype =  :formatter");
		$switching = array(':user' => $user, ':formatter' => $formatter, ':data' => $data); $withquotes = array(true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);

			return array('sql' => returnsqlquery($sql->queryString, $switching, $withquotes), 'affectedrows' => $sql->rowCount() ? true : false);
		}
	}

	/* =============================================================
		USER CONFIGS FUNCTIONS
	============================================================ */
	function checkconfigifexists($user, $configuration, $debug) {
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM userconfigs WHERE user = :user AND configtype = :config");
		$switching = array(':user' => $user, ':config' => $configuration); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function getconfiguration($user, $configuration, $debug) {
		$sql = wire('database')->prepare("SELECT data FROM userconfigs WHERE user = :user AND configtype = :config LIMIT 1");
		$switching = array(':user' => $user, ':config' => $configuration); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}


























?>
