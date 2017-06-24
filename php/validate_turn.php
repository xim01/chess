<?php
include_once('rules.php');
include_once('functions.php');
include_once('mysql.php');
$startPosition = array();
$endPosition = array();
$startPosition['full'] = $_POST['startPosition'];
$startPosition['hor'] = Functions::getProp($_POST['startPosition'],1,false);
$startPosition['vert'] = Functions::getProp($_POST['startPosition'],2);
$endPosition['full'] = $_POST['endPosition'];
$endPosition['hor'] = Functions::getProp($_POST['endPosition'],1,false);
$endPosition['vert'] = Functions::getProp($_POST['endPosition'],2);
$turn = (int)$_POST['turn'];
$gameInfoId = (int)$_POST['gameInfoId'];
$gameLogId = (int)$_POST['gameLogId'];
$player = (int)$_POST['player'];
$peiceType = $_POST['peiceType'];
$enemy = $_POST['enemy'];
$firstAction = (int)$_POST['firstAction'];
//$piecesList = $GameDB->getPiecesList();
function validateTurn($peiceType,$startPosition,$endPosition,$enemy,$turn,$player,$gameLogId,$gameInfoId,$firstAction){
	$rules = new Rules;
	$GameDB = new GameDB;
	if($player==1)
		$nextTurn = $turn+1;
	else
		$nextTurn = $turn;
	$validated = '	<input id="access" type="hidden" name="access" value="0" />
					<input id="turn" type="hidden" name="turn" value="'.$nextTurn.'" /> ';
	if($player == 0){
		$validated .= '<input id="player" type="hidden" name="player" value="1" />';		
	}else{
		$validated .= '<input id="player" type="hidden" name="player" value="0" />';		
	}
	$validated 	 .= '<input id="startPosition" type="hidden" name="startPosition" value="" />';
	$validated 	 .= '<input id="endPosition" type="hidden" name="endPosition" value="" />';
	$validated 	 .= '<input id="peiceType" type="hidden" name="peiceType" value="" />';
	$validated 	 .= '<input id="gameInfoId" type="hidden" name="gameInfoId" value="'.$gameInfoId.'" />';
	$validated 	 .= '<input id="gameLogId" type="hidden" name="gameLogId" value="'.$gameLogId.'" />';
	$validated	 .= '<input id="enemy" type="hidden" name="enemy" value="" />';
	$validated	 .= '<input id="firstAction" type="hidden" name="firstAction" value="0" />';
	$notValidated  = '<input id="access" type="hidden" name="access" value="1" />';
	$notValidated .= '<input id="player" type="hidden" name="player" value="'.$player.'" />';
	$notValidated .= '<input id="turn" type="hidden" name="turn" value="'.$turn.'" />';
	$notValidated .= '<input id="startPosition" type="hidden" name="startPosition" value="'.$startPosition['full'].'" />';
	$notValidated .= '<input id="endPosition" type="hidden" name="endPosition" value="" />';
	$notValidated .= '<input id="peiceType" type="hidden" name="peiceType" value="'.$peiceType.'" />';
	$notValidated .= '<input id="gameInfoId" type="hidden" name="gameInfoId" value="'.$gameInfoId.'" />';
	$notValidated .= '<input id="gameLogId" type="hidden" name="gameLogId" value="'.$gameLogId.'" />';
	$notValidated .= '<input id="enemy" type="hidden" name="enemy" value="" />';
	$notValidated .= '<input id="firstAction" type="hidden" name="firstAction" value="'.$firstAction.'" />';
	
	if($peiceType == "pawn"){
		if($rules->pawn($startPosition,$endPosition,$enemy,$firstAction,$player)){
			$access = true;
		}else{
			$access = false;
			return $notValidated;
		}
	}elseif($peiceType == "rook"){
		if($rules->rook($startPosition,$endPosition,$gameInfoId)){
			$access = true;
		}else{
			$access = false;
			return $notValidated;
		}
	}elseif($peiceType == "bishop"){
		if($rules->bishop($startPosition,$endPosition,$gameInfoId)){
			$access = true;
		}else{
			$access = false;
			return $notValidated;
		}
	}elseif($peiceType == "knight"){
		if($rules->knight($startPosition,$endPosition)){
			$access = true;
		}else{
			$access = false;
			return $notValidated;
		}
	}elseif($peiceType == "queen"){
		if($rules->queen($startPosition,$endPosition,$gameInfoId)){
			$access = true;
		}else{
			$access = false;
			return $notValidated;
		}
	}elseif($peiceType == "king"){
		if($rules->king($startPosition,$endPosition)){
			$access = true;
		}else{
			$access = false;
			return $notValidated;
		}
	}else{
		$access = false;
		return $notValidated;
	}
	if($access === true){
		$GameDB->updateBoard($startPosition['full'],$endPosition['full'],$peiceType,$player,$gameLogId);
		return $validated;
	}
}

echo validateTurn($peiceType,$startPosition,$endPosition,$enemy,$turn,$player,$gameLogId,$gameInfoId,$firstAction);
?>