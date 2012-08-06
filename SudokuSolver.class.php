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

class SudokuSolver{
	protected $sudoku;

	public function __construct(){
		$sudoku = new Sudoku(str_repeat(".", 81));
	}
	
	public function set($sudoku){
		$sudoku = new Sudoku($sudoku);
	}

}