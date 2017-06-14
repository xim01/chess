<?php
include_once('mysql.php');
$gameDB = new GameDB;
$data = $gameDB->initData();
unset($data['game_info']['id']);
$i=0;
function getProp($str,$prop,$number=true){
	if($number == true){
		if($prop==1)
			$str = (int)substr($str,0,-1);
		if($prop==2)
			$str = (int)substr($str,-1);
		return $str;		
	}else{
		if($prop==1)
			$str = substr($str,0,-1);
		if($prop==2)
			$str = substr($str,-1);
		return $str;		
	}

}	
function getColor($color){
	if($color==0)
		$color = 'white';
	else
		$color = 'black';
	return $color;
}
function getPieceName($array,$curentId){
	foreach($array as $id => $name){
		if($id == $curentId)
			return $name;
	}
}
echo '<div  id="chessBoard">';
foreach($data['game_info'] as $field => $piece){
	$boardRow = getProp($field,1,false);
	if(($i%8 == 0 and $i !== 0)){
		echo '</div><div id="row-'.$boardRow.'" class="board-row">';
	}
	if(($i==0)){
		echo '<div id="row-'.$boardRow.'" class="board-row">';
	}
	$color = getProp($piece,2);
	$color = getColor($color);
	$name = getProp($piece,1);
	$name = getPieceName($data['chess_pieces_name'],$name);
	echo '<div id="row-'.$field.'" data-piece="'.$name.'" data-color="'.$color.'" data-field="'.$field.'" class="field"><div class="'.$name.' chess-pieces"><p>'.$name.'</p></div></div>';
	$i++;

}
echo "</div>";
