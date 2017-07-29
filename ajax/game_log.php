<?php
require_once('tmpl/ajax_header.php');	
if ($_SERVER['REQUEST_METHOD'] === "POST"){
	if(isset($data->createChessLog))
		$data = $db->createGameLog($data->createChessLog);
	elseif(isset($data->getChessLogById))
		$data = $db->getGameLogById($data->getChessLogById);
}
if ($_SERVER['REQUEST_METHOD'] === "GET")
	$data = $db->getLastGameLog();
if ($_SERVER['REQUEST_METHOD'] === "PUT")
	$data = $db->updateGameLog($data->id,$data->turn,$data->player,$data->game_is_ended);
if ($_SERVER['REQUEST_METHOD'] === "DELETE")
	$data = $db->destroyGameLog($data->id);
$db->ajax_respond($data);
?>