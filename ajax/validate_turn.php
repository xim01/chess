<?php
require_once('tmpl/ajax_header.php');
require_once('../lib/rules.php');
$rules = new Rules;
$startPosition = array();
$endPosition = array();

function validateTurn($peiceType,$startPosition,$endPosition,$enemy,$turn,$player,$gameLogId,$gameInfoId,$firstAction){
	$rules = new Rules;
	$notValidated = false;
	$validated = true;
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
		return $validated;
	}
}

if ($_SERVER['REQUEST_METHOD'] === "POST"){
	$startPosition['hor'] = $data->startPosition[0];
	$startPosition['vert'] = $data->startPosition[1];
	$endPosition['hor'] = $data->endPosition[0];
	$endPosition['vert'] = $data->endPosition[1];
	$data = array("validated"=>validateTurn($data->peiceType,$startPosition,$endPosition,$data->enemy,$data->turn,$data->player,$data->game_log_id,$data->game_info_id,$data->firstAction));
}
$db->ajax_respond($data);
?>