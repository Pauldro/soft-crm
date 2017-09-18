<?php  

/*
 *    author:		Kyle Gadd
 *    documentation:	http://www.php-ease.com/classes/table.html
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


class Table {

	private $tableOpen = ''; // so we can save the opening statement for later
	private $rowOpen = false; // after the first row in a table this $var stays true
	private $cellOpen = false; // after the first cell in a row this $var stays true
	private $sectionOpen = false;
	private $openSection = '';
	private $rowAlign = ''; // to align all of the cells in a row
	private $tablestring = '';
	private static $count = 0;

	function __construct ($vars='') {
		self::$count++;
		$this->tableOpen = $this->indent() . '<table' . $this->values($vars) . '>';
		$this->tablestring .= $this->tableOpen;
	}

	public function row($vars='') { // (across the board in every cell)
		$add = '';
		if ($this->cellOpen && $this->rowOpen) {
			if ($openSection = 'thead') {
				$add .= '</th></tr>';
				$this->rowAlign = '';
			} else {
				$add .= '</td></tr>';
				$this->rowAlign = '';
			}

		}
		$this->rowOpen = true;
		$this->cellOpen = false;
		$this->tablestring .= $add . $this->indent() . '<tr' . $this->values($vars) . '>';
	}

	public function section($section) {
		$add = '';
		$this->sectionOpen = true;
		$this->openSection = $section;

		$this->tablestring .= $add . $this->indent() . '<'.$section.'>';
	}

	public function closesection($section) {
		$add = '';
		$this->sectionOpen = false;
		$this->openSection = '';
		if ($this->cellOpen && $this->rowOpen) {
			if ($openSection = 'thead') {
				$add .= '</th></tr>';
			} else {
				$add .= '</td></tr>';
			}

		}

		$this->tablestring .= $add . $this->indent() . '</'.$section.'>';
	}


	public function cell ($vars='', $content='&nbsp; ') {
		$add = '';
		if (!$this->rowOpen) $add .= $this->row();
		if ($this->cellOpen) $add .='</td>';
		$this->cellOpen = true;

		$this->tablestring .= $add . $this->indent() . '<td' . $this->values($vars) . '>' . $content;
	}

	public function headercell ($vars='', $content='') {
		$add = '';
		if (!$this->rowOpen) $add .= $this->row();
		if ($this->cellOpen) $add .='</th>';
		$this->cellOpen = true;

		$this->tablestring .= $add . $this->indent() . '<th' . $this->values($vars) . '>' . $content;

	}

	public function close () {
		$add = '';
		if (!$this->cellOpen) $add .= $this->cell();
		$add .= '</td></tr>' . $this->indent() . '</table>';
		self::$count--;

		$this->tablestring .= $add;
		return $this->tablestring;
	}

	private function values ($vars) {
		$put = array();
		if (!empty($vars)) {
		$values = explode('|', $vars);
		foreach ($values as $value) {
			$pieces = explode('=', $value);
			$put[array_shift($pieces)] = implode('=', $pieces);
		}
	}
	if (!empty($this->rowAlign)) $put['align'] = $this->rowAlign;
		$vars = '';
		if (!empty($put)) {
			foreach ($put as $key => $value) {
				$vars .= ' ' . $key . '="' . $value . '"';
			}
		}
		return $vars;
	}

	private function indent () {
		$indent = "\n";
		for ($i=0; $i<self::$count; $i++) {
			$indent .= '  ';
		}
		return $indent;
	}

}

?>
