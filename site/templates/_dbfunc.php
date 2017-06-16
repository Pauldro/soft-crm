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
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM (SELECT * FROM custindex WHERE custid = :custid AND source = 'CS') t WHERE splogin1 IN (:loginid, :shared) OR splogin2 = :loginid OR splogin3 = :loginid");
			$switching = array(':custid' => $custID, ':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
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
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM (SELECT * FROM custindex WHERE custid = :custid AND shiptoid = :shiptoid AND source = 'CS') t WHERE splogin1 IN (:loginid, :shared) OR splogin2 = :loginid OR splogin3 = :loginid");
			$switching = array(':custid' => $custID, ':shiptoid' => $shipID, ':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
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
		$sql = wire('database')->prepare("SELECT name FROM custindex WHERE custid = :custid LIMIT 1");
		$switching = array(':custid' => $custID);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_shipto_name($custID, $shipID, $debug) {
		$sql = wire('database')->prepare("SELECT name FROM custindex WHERE custid = :custid AND shiptoid = :shipid LIMIT 1");
		$switching = array(':custid' => $custID, ':shipid' => $shipID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}

	}

	function get_customer_info($session, $custID, $debug) {
		$sql = wire('database')->prepare("SELECT custindex.*, customer.dateentered FROM custindex JOIN customer ON custindex.custid = customer.custid WHERE custindex.custid = :custID AND customer.sessionid = :sessionid LIMIT 1");
		$switching = array(':sessionid'=> $session, ':custID'=> $custID);
		$withquotes = array(true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function get_shipto_count($login, $restrictions, $custID, $debug) {
		$SHARED_ACCOUNTS = wire('config')->sharedaccounts;
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM view_distinct_cust_shiptos WHERE recno IN (SELECT recno FROM view_distinct_cust_shiptos WHERE splogin1 IN (:loginid, :shared)  OR splogin2 = :loginid  OR splogin3 = :loginid) AND custid = :custid");
			$switching = array(':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid, ':custid' => $custID);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT COUNT(*) FROM view_distinct_cust_shiptos WHERE custid = :custid");
			$switching = array(':custid' => $custID); $withquotes = array(true);
		}
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_shipto_info($custID, $shipID, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM view_distinct_cust_shiptos WHERE custid = :custid AND shiptoid = :shipid");
		$switching = array(':custid' => $custID, ':shipid' => $shipID); $withquotes = array(true, true);
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
			$sql = wire('database')->prepare("SELECT * FROM view_distinct_cust_shiptos WHERE custid = :custid AND recno IN (SELECT recno FROM view_distinct_cust_shiptos WHERE splogin1 IN (:loginid, :shared) OR splogin2 = :loginid  OR splogin3 = :loginid)");
			$switching = array(':custid' => $custID, ':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM view_distinct_cust_shiptos WHERE custid = :custid");
			$switching = array(':custid' => $custID); $withquotes = array(true);
		}

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

	}

	function get_allowed_shiptos($custid, $loginid, $restrictions, $debug) { //DEPRECATE
		if ($restrictions) {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custid AND shiptoid != '' AND recno IN (SELECT recno FROM custindex WHERE (splogin1 IN (:loginid, :sharedaccounts) OR splogin2 = :loginid OR splogin3 = :loginid)) GROUP BY shiptoid");
			$switching = array(':custid'=> $custid, ':loginid' => $loginid, ':sharedaccounts' => wire('config')->sharedaccounts, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custid AND shiptoid != '' GROUP BY shiptoid");
			$switching = array(':custid'=> $custid);
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
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custid AND recno IN (SELECT recno FROM custindex WHERE splogin1 IN (:loginid, :shared) OR splogin2 = :loginid  OR splogin3 = :loginid)");
			$switching = array(':custid' => $custID, ':loginid' => $loginid, ':shared' => $SHARED_ACCOUNTS, ':loginid' => $loginid, ':loginid' => $loginid);
			$withquotes = array(true, true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custid");
			$switching = array(':custid' => $custID); $withquotes = array(true);
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

	function getcustcontact($custid, $shipid, $contactid, $debug) {
		if (strlen($contactid) > 0) {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custid AND shiptoid = :shiptoid AND contact = :contactid LIMIT 1");
			$switching = array(':custid' => $custid, ':shiptoid' => $shipid, ':contactid' => $contactid);
			$withquotes = array(true, true, true);
		} else {
			$sql = wire('database')->prepare("SELECT * FROM custindex WHERE custid = :custid AND shiptoid = :shiptoid LIMIT 1");
			$switching = array(':custid' => $custid, ':shiptoid' => $shipid);
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
			$switching = array(':login' => $login, ':sharedaccounts' => $SHARED_ACCOUNTS);
			$withquotes = array(true);
		} else {
			$sql = wire('database')->prepare("SELECT custid, name, amountsold, timesold, lastsaledate FROM custindex GROUP BY custid ORDER BY CAST(amountsold as Decimal(10,8)) DESC LIMIT 25 ");
			$switching = array();
			$withquotes = array();
		}
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
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
		$sql = wire('database')->prepare("SELECT COUNT(*) as count FROM ordrhed WHERE sessionid = :sessionid AND custid = :custid AND type = 'O'");
		$switching = array(':sessionid' => $sessionid, ':custid' => $custID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_cust_orders($sessionid, $custID, $limit = 10, $page = 1, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT * FROM ordrhed WHERE sessionid = :sessionid AND custid = :custid AND type = 'O' ".$limiting);
		$switching = array(':sessionid' => $sessionid, ':custid' => $custID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_cust_orders_orderby($sessionid, $custID, $limit = 10, $page = 1, $sortrule, $orderby, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT ordrhed.*, CAST(odrsubtot AS DECIMAL(8,2)) AS subtotal FROM ordrhed WHERE sessionid = :sessionid AND custid = :custid AND type = 'O' ORDER BY $orderby $sortrule ".$limiting);
		$switching = array(':sessionid' => $sessionid, ':custid' => $custID); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_cust_orders_orderdate($sessionid, $custID, $limit = 10, $page = 1, $sortrule, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT orderdate, STR_TO_DATE(orderdate, '%m/%d/%Y') as dateoforder, orderno, custpo, shiptoid, sname, saddress, saddress2, scity, sst, szip, havenote, status, havetrk, havedoc, odrsubtot, odrtax, odrfrt, odrmis, odrtotal, error, errormsg, shipdate, custid, custname, invdate, editord FROM ordrhed WHERE sessionid = :sessionid AND custid = :custid AND type = 'O' ORDER BY dateoforder $sortrule ".$limiting);
		$switching = array(':sessionid' => $sessionid, ':custid' => $custID); $withquotes = array(true, true);
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

	function get_cust_quote_count($sessionid, $custid, $debug) {
		$sql = wire('database')->prepare("SELECT COUNT(*) as count FROM quothed WHERE sessionid = :sessionid AND custid = :custid");
		$switching = array(':sessionid'=> $sessionid, ':custid' => $custid); $withquotes = array(true,true);
		if ($debug) {
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_cust_quotes($sessionid, $custid, $limit, $page, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$sql = wire('database')->prepare("SELECT * FROM quothed WHERE sessionid = :sessionid AND custid = :custid $limiting");
		$switching = array(':sessionid'=> $sessionid, ':custid' => $custid); $withquotes = array(true, true);
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
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getquotelinedetail($sessionid, $qnbr, $line, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM quotdet WHERE sessionid = :sessionid AND quotenbr = :qnbr AND linenbr = :line");
		$switching = array(':sessionid'=> $sessionid, ':qnbr' => $qnbr, ':line' => $line); $withquotes = array(true, true, true);
		if ($debug) {
			returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function edit_quotehead($sessionid, $qnbr, $quote, $debug) {
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

	function edit_quoteline($sessionid, $qnbr, $linenbr, $detail, $debug) {
		$originaldetail = getquotelinedetail(session_id(), $qnbr, $linenbr, false);
		$withquotes = $switching = array();
		$columns = array_keys($originaldetail);
		$setstmt = '';
		foreach ($columns as $column) {
			if (strlen($detail[$column])) {
				if ($originaldetail[$column] != $detail[$column]) {
					$prepped = ':'.$column;
					$setstmt .= $column." = ".$prepped.", ";
					$switching[$prepped] = $detail[$column];
					$withquotes[] = true;
				}
			}
		}
		if (empty($switching)) {
			return;
		}
		$setstmt = rtrim($setstmt, ', ');
		$sql = wire('database')->prepare("UPDATE quotdet SET $setstmt WHERE sessionid = :sessionid AND quotenbr = :qnbr AND linenbr = :linenbr");
		$switching[':sessionid'] = $sessionid; $switching[':qnbr'] = $qnbr; $switching[':linenbr'] = $linenbr;
		$withquotes[] = true; $withquotes[] = true; $withquotes[] = true;
		if ($debug) {
			return	returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
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

	function edit_note($session, $key1, $key2, $form1, $form2, $form3, $form4, $form5, $note, $recno, $date, $time, $width) {
		$sql = "UPDATE qnote SET notefld = '$note' WHERE sessionid = '$session' AND key1 = '$key1' AND key2 = '$key2' AND recno = '$recno'";
		wire('database')->query($sql);
		return $sql;
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
		$results = $res->fetch();
		$nextrecnbr =  intval($results['max']) + 1;
		return $nextrecnbr;
	}


/* =============================================================
	CRM NOTES FUNCTIONS
============================================================ */
	function getlinkednotescount($linkarray, $debug) {
		$query = buildlinkquery($linkarray);
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM crmnotes WHERE ".$query['querylinks']."");
		$switching = $query['switching'];
		$withquotes = $query['withquotes'];
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchColumn();
		}
	}

	function buildlinkquery($linkarray) {
		$querylinks = ''; $switching = $withquotes = array();
		foreach ($linkarray as $link => $value) {
			if ($value) {
				$querylinks .= $link . ' = :'.$link . ' AND ';
				$switching[':'.$link] = $value;
				$withquotes[] = true;
			}
		}
		return array('querylinks' => rtrim($querylinks, ' AND '), 'switching' => $switching, 'withquotes' => $withquotes);
	}

	function getlinkednotes($linkarray, $limit, $page, $debug) {
		$limiting = returnlimitstatement($limit, $page);
		$query = buildlinkquery($linkarray);
		$sql = wire('database')->prepare("SELECT *FROM crmnotes WHERE ".$query['querylinks']. " ". $limiting);
		$switching = $query['switching'];
		$withquotes = $query['withquotes'];
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}


	function loadcrmnote($noteid, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM crmnotes WHERE id = :noteid");
		$switching = array(':noteid'=> $noteid);
		$withquotes = array(true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Note');
			return $sql->fetch();
		}
	}

	function get_user_note_maxrec($loginid) {
		$sql = wire('database')->prepare("SELECT MAX(id) AS id FROM crmnotes WHERE writtenby = :login ");
		$switching = array(':login' => $loginid);
		$withquotes = array(true, true);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function writecrmnote($loginid, $date, $custid, $shipto, $contact, $ordn, $qnbr, $textbody) {
		$sql = wire('database')->prepare("INSERT INTO crmnotes (textbody,datecreated,writtenby,customerlink,shiptolink,contactlink,salesorderlink,quotelink) VALUES (:textbody, :date, :loginid, :custid, :shipto, :contact, :ordn, :qnbr)");
		$switching = array(':textbody' => $textbody, ':date' => $date, ':loginid' => $loginid, ':custid' => $custid, ':shipto' => $shipto, ':contact' => $contact, ':ordn' => $ordn,':qnbr' => $qnbr);
		$withquotes = array(true, true, true, true, true, true, true, true);
		$sql->execute($switching);
		return array('sql' => returnsqlquery($sql->queryString, $switching, $withquotes), 'insertedid' => wire('database')->lastInsertId());
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

	function getitemavailability($session, $itemid, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM whseavail WHERE sessionid = :sessionid AND itemid = :itemid");
		$switching = array(':sessionid' => $session, ':itemid' => $itemid); $withquotes = array(true, true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}


/* =============================================================
	TASK FUNCTIONS
============================================================ */
	function loadtask($id, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM crmtasks WHERE id = :taskid");
		$switching = array(':taskid' => $id); $withquotes = array(true);
		$sql->execute($switching);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Task');
			return $sql->fetch();
		}
	}

	function get_linked_task_count($user, $custid, $shipto, $contact, $ordn, $qnbr, $noteid, $complete, $debug) {
		if ($complete) {$table = 'view_completed_tasks';} else {$table = 'view_incomplete_tasks';}
		$query = buildtaskquerylinks($user, $custid, $shipto, $contact, $ordn, $qnbr, $noteid, false);
		$querylinks = $query['querylink'];
		$sql = wire('database')->prepare("SELECT COUNT(*) FROM $table WHERE $querylinks");
		$switching = $query['switching'];
		$withquotes = $query['withquotes'];

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function get_linked_tasks($user, $custid, $shipto, $contact, $ordn, $qnbr, $noteid, $complete, $limit, $page, $debug) {
		if ($complete) {$table = 'view_completed_tasks';} else {$table = 'view_incomplete_tasks';}
		$limiting = returnlimitstatement($limit, $page);
		$query = buildtaskquerylinks($user, $custid, $shipto, $contact, $ordn, $qnbr, $noteid, false);
		$querylinks = $query['querylink'];
		$sql = wire('database')->prepare("SELECT * FROM $table WHERE $querylinks $limiting");
		$switching = $query['switching'];
		$withquotes = $query['withquotes'];

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Task');
			return $sql->fetchAll();
		}
	}


	function buildtaskquerylinks($user, $custid, $shipto, $contact, $ordn, $qnbr, $noteid, $schedule) {
		if ($schedule) {
			$query = array('user' => ':user', 'customerlink' => ':custid', 'shiptolink' => ':shipto', 'contactlink' => ':contact');
		$switching = array(':user' => $user, ':custid'=> $custid, ':shipto' => $shipto, ':contact' => $contact);
		} else {
			$query = array('assignedto' => ':user', 'customerlink' => ':custid', 'shiptolink' => ':shipto', 'contactlink' => ':contact', 'salesorderlink' => ':ordn', 'quotelink' => ':quote',' notelink' => ':note');
		$switching = array(':user' => $user, ':custid'=> $custid, ':shipto' => $shipto, ':contact' => $contact, ':ordn' => $ordn, ':quote' => $qnbr, ':note' => $noteid);
		}
		$querylinks = '';
		$switchingarray = array();
		$withquotes = array();
		foreach ($query as $column => $val) {
			if ($switching[$val] != '') {
				$querylinks .= $column .' = '. $val." AND ";
				$switchingarray[$val] = $switching[$val];
				$withquotes[] = true;
			}
		}


		return array('querylink' => rtrim($querylinks, ' AND '), 'switching' => $switchingarray, 'withquotes' => $withquotes);


	}

	function updatetaskcompletion($taskid, $completedate, $updatedate, $completed) {
		$sql = wire('database')->prepare("UPDATE crmtasks SET completedate = :completedate, updatedate = :updatedate, completed = :completed WHERE id = :taskid");
		$switching = array(':completedate' => $completedate, ':updatedate' => $updatedate, ':completed' => $completed, ':taskid' => $taskid);
		$withquotes = array(true, true, true, true);
		$sql->execute($switching);
		$success = $sql->rowCount();
		if ($success) {
			return array("error" => false,  "sql" => returnsqlquery($sql->queryString, $switching, $withquotes));
		} else {
			return array("error" => true,  "sql" => returnsqlquery($sql->queryString, $switching, $withquotes));
		}

	}

	function writetask($loginid, $date, $custid, $shipto, $contact, $ordn, $qnbr, $noteid, $textbody, $tasktype, $duedate, $assignedto) {
		$sql = wire('database')->prepare("INSERT INTO crmtasks (textbody,datewritten,writtenby,customerlink,shiptolink,contactlink,salesorderlink,quotelink,notelink, tasktype, duedate, assignedto, updatedate) VALUES (:textbody, :date, :loginid, :custid, :shipto, :contact, :ordn, :qnbr, :noteid, :tasktype, :duedate, :assignedto, :updatedate)");
		$switching = array(':textbody' => $textbody, ':date' => $date, ':loginid' => $loginid, ':custid' => $custid, ':shipto' => $shipto, ':contact' => $contact, ':ordn' => $ordn,':qnbr' => $qnbr, ':noteid' => $noteid, ':tasktype' => $tasktype, ':duedate' => $duedate, ':assignedto' => $assignedto, ':updatedate' => $date);
		$withquotes = array(true, true, true, true, true, true, true, true, true, true, true, true, true);
		$sql->execute($switching);
		return array('sql' => returnsqlquery($sql->queryString, $switching, $withquotes), 'insertedid' => wire('database')->lastInsertId());
	}


	function get_user_task_maxrec($loginid) {
		$sql = wire('database')->prepare("SELECT MAX(id) AS id FROM crmtasks WHERE writtenby = :login");
		$switching = array(':login' => $loginid);
		$withquotes = array(true, true);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}


	function createtaskschedule($date, $startdate, $loginid, $repeatlogic, $desc, $customerlink, $shiptolink, $contactlink, $tasktype, $debug) {
		$active = 'Y';
		$sql = wire('database')->prepare("INSERT INTO taskscheduler (datecreated, startdate, user, active, description, repeatlogic, customerlink, shiptolink, contactlink, tasktype) VALUES (:datecreated, :startdate, :user, :active, :description, :repeatlogic, :custid, :shiptoid, :contactid, :taskstype)");
		$switching = array(':datecreated' => $date,':startdate' => $startdate, ':user' => $loginid, ':active' => $active, ':description' => $desc, ':repeatlogic' => $repeatlogic, ':custid' => $customerlink, ':shiptoid' => $shiptolink, ':contactid' => $contactlink, ':taskstype' => $tasktype);
		$withquotes = array(true, true, true, true, true, true, true, true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return array('sql' => returnsqlquery($sql->queryString, $switching, $withquotes), 'insertedid' => wire('database')->lastInsertId());
		}

	}

	function change_taskschedule_active($scheduleid, $activate, $debug) {
		if ($activate) { $active = 'Y'; } else { $active = 'N'; }
		$sql = wire('database')->prepare("UPDATE taskscheduler SET active = :active WHERE id = :id");
		$switching = array(':active' => $active, ':id' => $scheduleid);
		$withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		}
	}

	function get_user_taskscheduler_maxrec($loginid) {
		$sql = wire('database')->prepare("SELECT MAX(id) FROM taskscheduler WHERE user = :login");
		$switching = array(':login' => $loginid);
		$withquotes = array(true, true);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

	function get_user_scheduled_tasks($user, $customerlink, $shiptolink, $contactlink, $debug) {
		$query = buildtaskquerylinks($user, $custid, $shipto, $contact, $ordn, $qnbr, $noteid, false);
		$querylinks = $query['querylink'];
		$sql = wire('database')->prepare("SELECT * FROM taskscheduler WHERE $querylinks");
		$switching = $query['switching'];
		$withquotes = $query['withquotes'];
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_current_taskschedules() {
		$sql = wire('database')->prepare("SELECT * FROM taskscheduler WHERE active = 'Y' AND DATE_FORMAT(startdate, '%Y-%m-%e') >= CURDATE()");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function scheduletask($user, $date, $duedate, $text, $customerlink, $shiptolink, $contactlink, $debug) {
		$sql = wire('database')->prepare("INSERT INTO crmtasks (datewritten, duedate, writtenby, assignedto, assignedby, textbody, customerlink, shiptolink, contactlink) VALUES (:datewritten, :duedate, 'task-scheduler', :user, 'task-scheduler', :text, :custid, :shiptoid, :contactid)");
		$switching = array(':datewritten' => $date, ':duedate', $duedate, ':user' => $user, ':text' => $text, ':custid' => $customerlink, ':shiptoid' => $shiptolink, ':contactid' => $contactlink);
		$withquotes = array(true, true, true, true, true, true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return array('sql' => returnsqlquery($sql->queryString, $switching, $withquotes), 'insertedid' => wire('database')->lastInsertId());
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
		$sql = wire('database')->prepare("INSERT INTO carthed (sessionid, custid, shiptoid, date, time) VALUES (:sessionid, :custid, :shipid, :date, :time)");
		$switching = array(':sessionid' => $sessionid, ':custid' => $custID, ':shipid' =>$shipID, ':date' => date('Ymd'), ':time' =>date('His')); $withquotes = array(true, true, true, false, false);

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		}
	}

	function getcreatedordn($sessionid, $debug) {
		$sql = wire('database')->prepare("SELECT orderno FROM carthed WHERE sessionid = :sessionid");
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

	function edit_orderline($sessionid, $ordn, $linenbr, $detail, $debug) {
		$originaldetail = getorderlinedetail(session_id(), $ordn, $linenbr, false);
		$columns = array_keys($originaldetail);
		$withquotes = $switching = array();
		$setstmt = '';
		foreach ($columns as $column) {
			if (strlen($detail[$column])) {
				if ($originaldetail[$column] != $detail[$column]) {
					$prepped = ':'.$column;
					$setstmt .= $column." = ".$prepped.", ";
					$switching[$prepped] = $detail[$column];
					$withquotes[] = true;
				}
			}
		}
		$setstmt = rtrim($setstmt, ', ');
		$sql = wire('database')->prepare("UPDATE ordrdet SET $setstmt WHERE sessionid = :sessionid AND orderno = :ordn AND linenbr = :linenbr");
		$switching[':sessionid'] = $sessionid; $switching[':ordn'] = $ordn; $switching[':linenbr'] = $linenbr;
		$withquotes[] = true; $withquotes[] = true; $withquotes[] = true;
		if ($debug) {
			return	returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
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

/* =============================================================
	EDIT PRICING FUNCTIONS
============================================================ */
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


/* =============================================================
	ITEM FUNCTIONS
============================================================ */
	function getiteminfo($session, $itemid, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM pricing WHERE sessionid = :session AND itemid = :itemid LIMIT 1");
		$switching = array(':session' => $session, ':itemid' => $itemid); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function getitemfromim($itemid, $debug) {
		$sql = wire('database')->prepare("SELECT * FROM pricing WHERE itemid = :itemid LIMIT 1");
		$switching = array(':itemid' => $itemid); $withquotes = array(true);
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

	function getitemdescription($itemid, $debug) {
		$sql = wire('database')->prepare("SELECT desc1 FROM itemsearch WHERE itemid = :itemid LIMIT 1");
		$switching = array(':itemid' => $itemid); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}

	function getnextrecno($itemid, $nextorprev, $debug) {
		if ($nextorprev == 'next') {
			$sql = wire('database')->prepare("SELECT MAX(recno) + 1 FROM itemsearch WHERE itemid = :itemid");
		} else {
			$sql = wire('database')->prepare("SELECT MIN(recno) - 1 FROM itemsearch WHERE itemid = :itemid");
		}
		$switching = array(':itemid' => $itemid); $withquotes = array(true);
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
























?>
