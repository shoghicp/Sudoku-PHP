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

				break;
			default:
				$this->checkCandidates();
				$this->solve("hidden_singles");
				break;
		}	
	}
}