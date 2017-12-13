<?php
	class SalesOrderFormatter extends TableScreenFormatter {
        protected $tabletype = 'normal'; // grid or normal
		protected $type = 'ii-sales-orders'; // ii-sales-history
		protected $title = 'Item Sales Orders';
		protected $datafilename = 'iisalesordr'; // iisaleshist.json
		protected $testprefix = 'iiso'; // iish
		protected $formatterfieldsfile = 'iisofmattbl'; // iishfmtbl.json
        
        public function generate_screen() {
            $bootstrap = new Contento();
            $content = '';
			$this->generate_tableblueprint();
			
            foreach ($this->json['data'] as $whse) {
                $tb = new Table('class=table table-striped table-bordered table-condensed table-excel|id='.urlencode($whse['Whse Name']));
            	$tb->tablesection('thead');
            		for ($x = 1; $x < $this->tableblueprint['detail']['maxrows'] + 1; $x++) {
            			$tb->tr();
            			for ($i = 1; $i < $this->tableblueprint['cols'] + 1; $i++) {
            				if (isset($this->tableblueprint['detail']['rows'][$x]['columns'][$i])) {
            					$column = $this->tableblueprint['detail']['rows'][$x]['columns'][$i];
            					$class = wire('config')->textjustify[$this->fields['data']['detail'][$column['id']]['headingjustify']];
            					$colspan = $column['col-length'];
            					$tb->th('colspan='.$colspan.'|class='.$class, $column['label']);
            					if ($colspan > 1) { $i = $i + ($colspan - 1); }
            				} else {
            					$tb->th();
            				}
            			}
            		}
            	$tb->closetablesection('thead');
            	$tb->tablesection('tbody');
            		foreach($whse['invoices'] as $invoice) {
            			if ($invoice != $whse['invoices']['TOTAL']) {
            				for ($x = 1; $x < $this->tableblueprint['detail']['maxrows'] + 1; $x++) {
            					$tb->tr();
            					for ($i = 1; $i < $this->tableblueprint['cols'] + 1; $i++) {
            						if (isset($this->tableblueprint['detail']['rows'][$x]['columns'][$i])) {
            							$column = $this->tableblueprint['detail']['rows'][$x]['columns'][$i];
            							$class = wire('config')->textjustify[$this->fields['data']['detail'][$column['id']]['datajustify']];
            							$colspan = $column['col-length'];
            							$celldata = Table::generatejsoncelldata($this->fields['data']['detail'][$column['id']]['type'], $invoice, $column);
            							$tb->td('colspan='.$colspan.'|class='.$class, $celldata);
            							if ($colspan > 1) { $i = $i + ($colspan - 1); }
            						} else {
            							$tb->td();
            						}
            					}
            				}
            				
            				if (sizeof($invoice['lots']) > 0) {
            					for ($x = 1; $x < $this->tableblueprint['lotserial']['maxrows'] + 1; $x++) {
            						$tb->tr();
            						for ($i = 1; $i < $this->tableblueprint['cols'] + 1; $i++) {
            							if (isset($this->tableblueprint['lotserial']['rows'][$x]['columns'][$i])) {
            								$column = $this->tableblueprint['lotserial']['rows'][$x]['columns'][$i];
            								$class = wire('config')->textjustify[$this->fields['data']['lotserial'][$column['id']]['headingjustify']];
            								$colspan = $column['col-length'];
            								$tb->th('colspan='.$colspan.'|class='.$class, $column['label']);
            								if ($colspan > 1) { $i = $i + ($colspan - 1); }
            							} else {
            								$tb->th();
            							}
            						}
            					}
            					
            					foreach ($invoice['lots'] as $lot) {
            						for ($x = 1; $x < $this->tableblueprint['lotserial']['maxrows'] + 1; $x++) {
            							$tb->tr();
            							for ($i = 1; $i < $this->tableblueprint['cols'] + 1; $i++) {
            								if (isset($this->tableblueprint['lotserial']['rows'][$x]['columns'][$i])) {
            									$column = $this->tableblueprint['lotserial']['rows'][$x]['columns'][$i];
            									$class = wire('config')->textjustify[$this->fields['data']['lotserial'][$column['id']]['datajustify']];
            									$colspan = $column['col-length'];
            									$celldata = Table::generatejsoncelldata($this->fields['data']['lotserial'][$column['id']]['type'], $lot, $column);
            									$tb->td('colspan='.$colspan.'|class='.$class, $celldata);
            									if ($colspan > 1) { $i = $i + ($colspan - 1); }
            								} else {
            									$tb->td();
            								}
            							}
            						}
            					}
            				} // END IF (sizeof($invoice['lots']) > 0)
            			} // END IF ($invoice != $whse['invoices']['TOTAL'])
            		}
            	$tb->closetablesection('tbody');
            	$tb->tablesection('tfoot');
            		$invoice = $whse['invoices']['TOTAL'];
        			$x = 1;
        			$tb->tr('class=has-warning');
        			for ($i = 1; $i < $this->tableblueprint['cols'] + 1; $i++) {
        				if (isset($this->tableblueprint['detail']['rows'][$x]['columns'][$i])) {
        					$column = $this->tableblueprint['detail']['rows'][$x]['columns'][$i];
        					$class = wire('config')->textjustify[$this->fields['data']['detail'][$column['id']]['datajustify']];
        					$celldata = Table::generatejsoncelldata($this->fields['data']['detail'][$column['id']]['type'], $invoice, $column);
        					$tb->td('colspan=|class='.$class, $celldata);
        				} else {
        					$tb->td();
        				}
        			}
            	$tb->closetablesection('tfoot');
                $table = $tb->close();
                $content .= $bootstrap->div('', $table);
            } // FOREACH Whse
            return $content;
        }
    }
