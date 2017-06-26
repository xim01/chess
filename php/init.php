<?php
include_once('mysql.php');
include_once('functions.php');
$gameDB = new GameDB;

if($gameId = $gameDB->selectLastGame()){
	$data = $gameDB->initData($gameId);
}else{
	$data = $gameDB->initData();
}
unset($data['game_info']['id']);
$i=0;
echo '<div  id="chessBoard">';
foreach($data['game_info'] as $field => $piece){
	$boardRow = Functions::getProp($field,1,false);
	if(($i%8 == 0 and $i !== 0)){
		echo '</div><div id="row-'.$boardRow.'" class="board-row">';
	}
	if(($i==0)){
		echo '<div id="row-'.$boardRow.'" class="board-row">';
		$form = '<form id="chessboardData"  name="chessboardData" enctype="multipart/form-data" method="POST">';
	}
	$color = Functions::getProp($piece,2);
	$color = Functions::getColor($color);
	$name = Functions::getProp($piece,1);
	$name = Functions::getPieceName($data['chess_pieces_name'],$name);
	$firstAction = Functions::getProp($piece,3);
	echo '<div id="row-'.$field.'" data-action="'.$firstAction.'" data-piece="'.$name.'" data-color="'.$color.'" data-field="'.$field.'" class="field"><div class="'.$name.' chess-pieces"><p>'.$name.'</p></div></div>';
	//$form .= '<input type="hidden" name="'.$field.'" value="'.$piece.'" />';
	$i++;
}
echo "</div>";
$form .= '	<input id="turn" type="hidden" name="turn" value="'.$data['game_log']['turn'].'" />
			<input id="player" type="hidden" name="player" value="'.$data['game_log']['player'].'" />
			<input id="startPosition" type="hidden" name="startPosition" value="" />
			<input id="gameInfoId" type="hidden" name="gameInfoId" value="'.$data['game_log']['game_info_id'].'" />
			<input id="gameLogId" type="hidden" name="gameLogId" value="'.$data['game_log']['id'].'" />
			<input id="peiceType" type="hidden" name="peiceType" value="" />
			<input id="enemy" type="hidden" name="enemy" value="" />
			<input id="firstAction" type="hidden" name="firstAction" value="" />
			<input id="endPosition" type="hidden" name="endPosition" value="" /></form></div>';
			
echo $form;
echo 		'<div class="row">
			<p class="col-xs-12 "><button id="endTheGame">End the game</button></p>
			</div>';
