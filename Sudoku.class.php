<?php

/*

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

*/


class Sudoku{
	protected $sudoku;

	public function __construct($sudoku){
		$sudoku = trim($sudoku);
		$len = strlen($sudoku);
		if($len !== 81){
			trigger_error("Bad lenght of Sudoku", E_USER_WARNING);
			return;
		}
		$this->sudoku = array();	
		for($i = 0; $i < 81; ++$i){
			$x = $i % 9;
			if(($i % 9)	=== 0){
				$y = $i / 9;
				$this->sudoku[$y] = array();
			}
			$this->sudoku[$y][$x] = ($sudoku{$i} === "." or $sudoku{$i} === "0" or $sudoku{$i} === "_" or $sudoku{$i} === "*") ? array(1,2,3,4,5,6,7,8,9):intval($sudoku{$i});
		}
		$this->checkCandidates();
		print_r($this->sudoku);
	}
	
	public function getCell($x, $y){
		return $this->sudoku[$y][$x];		
	}
	
	public function setCell($x, $y, $n){
		$this->sudoku[$y][$x] = $n;
	}
	
	public function getColumn($x){
		$column = array();
		for($y = 0; $y < 9; ++$y){
			$column[$y] = $this->getCell($x, $z);
		}
		return $column;
	}
	
	public function getRow($y){
		$row = array();
		for($x = 0; $x < 9; ++$x){
			$row[$x] = $this->getCell($x, $z);
		}
		return $row;
	}
	
	public function getBox($x, $y){
		$box = array();
		$xT = $x * 3;
		$yT = $y * 3;
		for($x = 0; $x < 3; ++$x){
			for($y = 0; $y < 3; ++$y){
				$box[] = $this->getCell($xT + $x, $yT + $y);
			}
		}
		return $box;
	}
	
	public function isSolved($x, $z){
		$b = $this->getCell($x, $z);
		
		if($b === 0){
			$this->setCell($x, $z, array());
			return false;
		}elseif(is_array($b)){
			if(count($b) === 1){
				$this->setCell($x, $z, array_pop($b));
				return true;
			}
			return false;
		}
		return true;
	}
	
	public function checkCandidates(){
		for($x = 0; $x < 9; ++$x){
			for($y = 0; $y < 9; ++$y){
				if($this->isSolved($x, $y) === false){
					$b = $this->getCell($x, $y);
					for($i = 0; $i < 9; ++$i){
						if($i !== $x and $this->isSolved($i, $y)){
							$v = $this->getCell($i, $y);
							$j = array_search($v, $b, true);
							if($j !== false){
								unset($b[$j]);
							}
						}
						if($i !== $y and $this->isSolved($x, $i)){
							$v = $this->getCell($x, $i);
							$j = array_search($v, $b, true);
							if($j !== false){
								unset($b[$j]);
							}
						}
					}
					$this->setCell($x, $y, $b);
				}
			}
		}
		for($y = 0; $y < 3; ++$y){
			for($x = 0; $x < 3; ++$x){
				$c = $this->getBox($x, $y);
				foreach($c as $i => $bl){
					$bY = ($i % 3) + $y * 3;
					$bX = floor($i / 3) + $x * 3;
					if($this->isSolved($bX, $bY) === false){
						foreach($c as $n){
							if(!is_array($n)){
								$z = array_search($n, $bl, true);
								if($z !== false){
									unset($bl[$z]);
								}
							}
						}
						$this->setCell($bX, $bY, $bl);
						$this->isSolved($bX, $bY);
					}
				}
			}
		}
	}
}