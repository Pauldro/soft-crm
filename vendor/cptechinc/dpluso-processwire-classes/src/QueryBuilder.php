<?php
    class QueryBuilder extends atk4\dsql\Query {
        protected $sqlkeywords = array(
            'select',
            'from',
            'where',
            'update',
            'insert',
            'between',
            'and',
            'order',
            'cast',
            'as',
            'by',
            'or', 
            'asc',
            'desc',
            'limit'
        );
        
        public function generate_query($querylinks, $orderby, $limit, $page) {
    		foreach ($querylinks as $column => $val) {
                if (!empty($val)) {
                    $whereinfo = $this->generate_where($val);
                    switch ($whereinfo['type']) {
                        case '=':
                            if (sizeof($whereinfo['values']) == 1) {
                                $this->where($column, $whereinfo['values'][0]);
                            } else {
                                $this->where($column, $whereinfo['values']);
                            }                            
                            break;
                        case '!=':
                            $this->where($column, '!=', $whereinfo['values']);
                            break;
                        case '()':
                            $this->where($column, $q->expr('between "[]" and "[]"', $whereinfo['values']));
                            break;
                    }
                }
    		}
            
    		if ($limit) {
                $this->limit($limit, $this->generate_offset($page, $limit));
            }
            
            if (!empty($orderby)) {
                $this->order($this->generate_orderby($orderby));
            }
    	}
        
        public function generate_where($value) {
           $filter = false;
           if (strpos($value, '|') !== false) {
               $filter = explode('|', $value);
           }
           
           if ($filter) {
               $value = explode(',', $filter[1]);
               return array (
                   'type' => $filter[0],
                   'values' => $value
               );
           } else {
               $value = explode(',', $value);
               return array (
                   'type' => '=',
                   'values' => $value
               );
           }
       }
        
        protected function generate_offset($page, $limit) {
            return $page > 1 ? ($page * $limit) - $limit : 0;
        }
        
        protected function generate_orderby($orderby) {
            if (!empty($orderby)) {
                $orderbyarray = explode('-', $orderby);
                return $orderbyarray[0] . ' ' .strtolower($orderbyarray[1]);
            } else {
                return '';
            }
        }
        
        public function generate_sqlquery() {
            $sql = $this->render();
            $sql = str_replace(',', ', ', $sql);
            
       		foreach ($this->params as $param => $value) {
       			$sql = str_replace($param, "'".$value."'", $sql);
       		}
            
            foreach ($this->sqlkeywords as $keyword) {
                $sql = preg_replace('/\b'.$keyword.'\b/', strtoupper($keyword), $sql);
            }
       		return $sql;
       	}
    }
