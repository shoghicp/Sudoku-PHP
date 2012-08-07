<?php

/*

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

*/

if(!class_exists("Sudoku")){
	require_once(dirname(__FILE__) . "/Sudoku.class.php");
}

class SudokuSolver extends Sudoku{
	public function __construct($sudoku){
		parent::__construct($sudoku);
	}
	
	public function set($sudoku){
		parent::__construct($sudoku);
	}
	
	public function isSolved(){
		for($y = 0; $y < 9; ++$y){
			for($x = 0; $x < 9; ++$x){
				if(is_array($this->getCell($x, $y))){
					return false;
				}
			}
		}
		return true;
	}
	
	public function solve($type = ""){
		switch($type){
			case "hidden_singles":
				for($y = 0; $y < 3; ++$y){
					for($x = 0; $x < 3; ++$x){
						$c = $this->getBox($x, $y);
						foreach($c as $i => $bl){
							$bY = ($i % 3) + $y * 3;
							$bX = floor($i / 3) + $x * 3;
							if($this->isCellSolved($bX, $bY) === false){
								foreach($bl as $b){
									$single = true;
									$single2 = true;
									$single3 = true;
									foreach($this->getColumn($bX) as $j => $cl){
										if($j == $bY){
											continue;
										}
										if((is_array($cl) and in_array($b, $cl, true)) or (is_numeric($cl) and $cl == $b)){
											$single = false;
										}
									}
									foreach($this->getRow($bY) as $j => $r){
										if($j == $bX){
											continue;
										}
										if((is_array($r) and in_array($b, $r, true)) or (is_numeric($r) and $r == $b)){
											$single2 = false;
										}
									}
									foreach($c as $j => $v){
										if($j != $i and ((is_array($v) and in_array($b, $v, true)) or (is_numeric($v) and $v == $b))){
											$single3 = false;
										}
									}
									if($single == true or $single2 == true or $single3 == true){
										$this->setCell($bX, $bY, $b);
										echo "HIDDEN SINGLE: ".$this->coord($bX, $bY)." set to ".$b.PHP_EOL;
										break;
									}
								}
							}
						}
					}
				}
				break;
			default:
				$this->checkCandidates();
				$this->solve("hidden_singles");
				break;
		}	
	}
}