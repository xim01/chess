<?php
include_once('rules.php');
include_once('functions.php');
//include_once('mysql.php');
$startPosition = array();
$endPosition = array();
$startPosition['hor'] = Functions::getProp($_POST['startPosition'],1,false);
$startPosition['vert'] = Functions::getProp($_POST['startPosition'],2);
$endPosition['hor'] = Functions::getProp($_POST['endPosition'],1,false);
$endPosition['vert'] = Functions::getProp($_POST['endPosition'],2);
$turn = (int)$_POST['turn'];
$gameInfoId = (int)$_POST['gameInfoId'];
$gameLogId = (int)$_POST['gameLogId'];
$player = (int)$_POST['player'];
$peiceType = $_POST['peiceType'];
$enemy = false;
//$GameDB = new GameDB;
$rules = new Rules;
//$piecesList = $GameDB->getPiecesList();
if($peiceType == "pawn"){
	if($rules->pawn($startPosition,$endPosition,$enemy,$turn,$player)){
		echo "Correct move!";
	}else{
		echo "Incorrect turn!!!!";
	}
}
if($peiceType == "rook"){
	if($rules->rook($startPosition,$endPosition,$enemy,$turn)){
		echo "Correct move!";
	}else{
		echo "Incorrect turn!!!!";
	}
}
if($peiceType == "bishop"){
	if($rules->bishop($startPosition,$endPosition,$enemy,$turn)){
		echo "Correct move!";
	}else{
		echo "Incorrect turn!!!!";
	}
}
if($peiceType == "knight"){
	if($rules->knight($startPosition,$endPosition,$enemy,$turn)){
		echo "Correct move!";
	}else{
		echo "Incorrect turn!!!!";
	}
}
if($peiceType == "queen"){
	if($rules->queen($startPosition,$endPosition,$enemy,$turn)){
		echo "Correct move!";
	}else{
		echo "Incorrect turn!!!!";
	}
}
if($peiceType == "king"){
	if($rules->pawn($startPosition,$endPosition,$enemy,$turn)){
		echo "Correct move!";
	}else{
		echo "Incorrect turn!!!!";
	}
}
?>