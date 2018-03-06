<?php 
	class CustomerQuotePanel extends QuotePanel implements OrderPanelCustomerInterface {
		use OrderPanelCustomerTraits;
		
		public $quotes = array();
		public $filterable = array(
			'quotnbr' => array(
				'querytype' => 'between',
				'datatype' => 'char',
				'label' => 'Quote #'
			),
			'quotdate' => array(
				'querytype' => 'between',
				'datatype' => 'date',
				'label' => 'Quote Date'
			),
			'revdate' => array(
				'querytype' => 'between',
				'datatype' => 'date',
				'label' => 'Review Date'
			),
			'expdate' => array(
				'querytype' => 'between',
				'datatype' => 'date',
				'label' => 'Expire Date'
			),
			'ordertotal' => array(
				'querytype' => 'between',
				'datatype' => 'char',
				'label' => 'Order Total'
			)
		);
		
		/* =============================================================
			QuotePanelInterface Functions
		============================================================ */
		public function get_quotecount() {
			$this->count = count_customerquotes($this->sessionID, $this->custID, $this->filters, $this->filterable, false);
		}
		
		public function get_quotes($debug = false) {
			$useclass = true;
			if ($this->tablesorter->orderby) {
				if ($this->tablesorter->orderby == 'quotdate') {
					$quotes = get_customerquotesquotedate($this->sessionID, $this->custID, Processwire\wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $this->filters, $this->filterable, $useclass, $debug);
				} elseif ($this->tablesorter->orderby == 'revdate') {
					$quotes = get_customerquotesrevdate($this->sessionID, $this->custID, Processwire\wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $this->filters, $this->filterable, $useclass, $debug);
				} elseif ($this->tablesorter->orderby == 'expdate') {
					$quotes = get_customerquotesexpdate($this->sessionID, $this->custID, Processwire\wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $this->filters, $this->filterable, $useclass, $debug); 
				} else {
					$quotes = get_customerquotesorderby($this->sessionID, $this->custID, Processwire\wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $this->tablesorter->orderby, $this->filters, $this->filterable, $useclass, $debug);
				}
			} else {
				$quotes = get_customerquotes($this->sessionID, $this->custID, Processwire\wire('session')->display, $this->pagenbr, $this->filters, $this->filterable, $useclass, $debug);
			}
			return $debug ? $quotes: $this->quotes = $quotes;
		}
		
		/* =============================================================
			OrderPanelInterface Functions
			LINKS ARE HTML LINKS, AND URLS ARE THE URLS THAT THE HREF VALUE
		============================================================ */
		public function generate_loadurl() { 
			$url = new \Purl\Url(parent::generate_loadurl());
			$url->query->set('action', 'load-cust-quotes');
			$url->query->set('custID', $this->custID);
			return $url->getUrl();
		}
		
		public function generate_searchurl() {
			$url = new \Purl\Url(parent::generate_searchurl());
			$url->path = Processwire\wire('config')->pages->ajax.'load/quotes/search/cust/';
			$url->query->set('custID', $this->custID);
			if ($this->shipID) {
				$url->query->set('shipID', $this->shipID);
			}
			return $url->getUrl();
		}
		
		public function generate_loaddetailsurl(Order $quote) {
			$url = new \Purl\Url(parent::generate_loaddetailsurl($quote));
			$url->query->set('custID', $quote->custid);
			return $url->getUrl();
		}
		
		public function generate_lastloadeddescription() {
			if (Processwire\wire('session')->{'quotes-loaded-for'}) {
				if (Processwire\wire('session')->{'quotes-loaded-for'} == $this->custID) {
					return 'Last Updated : ' . Processwire\wire('session')->{'quotes-updated'};
				}
				return '';
			}
			return '';
		}
		
		public function generate_filter(WireInput $input) {
			parent::generate_filter($input);
			
			if (isset($this->filters['quotdate'])) {
				if (empty($this->filters['quotdate'][1])) {
					$this->filters['quotdate'][1] = date('m/d/Y');
				}
			} elseif (isset($this->filters['revdate'])) {
				if (empty($this->filters['revdate'][1])) {
					$this->filters['revdate'][1] = date('m/d/Y');
				}
			} elseif (isset($this->filters['expdate'])) {
				if (empty($this->filters['expdate'][1])) {
					$this->filters['expdate'][1] = date('m/d/Y');
				}
			}
		}
		
		/* =============================================================
			OrderDisplayInterface Functions
			LINKS ARE HTML LINKS, AND URLS ARE THE URLS THAT THE HREF VALUE
		============================================================ */
		public function generate_editlink(Order $quote) {
			return $quote->can_Edit() ? parent::generate_editlink($quote) : '';
		}
		
		public function generate_documentsrequesturl(Order $quote, OrderDetail $quotedetail = null) {
			$url = new \Purl\Url(parent::generate_documentsrequesturl($quote, $quotedetail));
			$url->query->set('custID', $this->custID);
			return $url->getUrl();
		}
	}
