<?php
class GameDB {
	private $bd = "chess";
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $charset = "utf8";
	public $gameInfoTable = "game_info";
	private $gameLogTable = "game_log";
	private $chessPiecesNameTable = "chess_pieces_name";
	private $mysqli;
	public $hor = array('a','b','c','d','e','f','g','h',);
	public $vert = array(1,2,3,4,5,6,7,8);	
	
	function __construct() {
		$this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->bd);
		mysqli_set_charset ( $this->mysqli , $this->charset );
		if ($this->mysqli->connect_errno) {
			exit();
		}
	}
	
	public function sendQuery($data,$returnId=false){
		if(!$result['data'] = $this->mysqli->query($data))
			return false;
		if($returnId)
			$result['id'] = $this->mysqli->insert_id;
		return $result; 
	}
	
	public  function getPiecesList(){
		$row = $this->sendQuery("SELECT * FROM `".$this->chessPiecesNameTable."`");
		for ($data['chess_pieces_name'] = array (); $result = $row['data']->fetch_assoc(); $data['chess_pieces_name'][] = $result);
		foreach($data['chess_pieces_name'] as $nameArray){
			foreach($nameArray as $key => $value){
				if($key == 'id')
					$nameListArray['id'] = $value;
				else
					$nameListArray['name'] = $value;
			}
			$nameList[$nameListArray['id']] = $nameListArray['name']; 
		}
		return $nameList;
	}
	
	public function initData($gameInfoId=NULL){
		if(!$gameInfoId){
			$gamesId = $this->createNewGame();		
			$gameInfoId = $gamesId['gameInfoId'];
			$gameLogId = $gamesId['gameLogId'];
		}
		$data['game_info'] = $this->getGameInfoById($gameInfoId);
		$data['game_log'] = $this->getGameLogById($gameInfoId);
		$data['chess_pieces_name'] = $this->getPiecesList();
		return $data;
	}
	private function createNewGame(){
		$query  = "INSERT INTO `".$this->gameInfoTable."` (	`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`,`b1`, `b2`, `b3`, `b4`, `b5`, `b6`, `b7`, `b8`,";
		$query .= "`c1`, `c2`, `c3`, `c4`, `c5`, `c6`, `c7`, `c8`,`d1`, `d2`, `d3`, `d4`, `d5`, `d6`, `d7`, `d8`,`e1`, `e2`, `e3`, `e4`, `e5`, `e6`, `e7`, `e8`,";
		$query .= "`f1`, `f2`, `f3`, `f4`, `f5`, `f6`, `f7`, `f8`,`g1`, `g2`, `g3`, `g4`, `g5`, `g6`, `g7`, `g8`,`h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `h7`, `h8`, `id`)";
		$query .= "VALUES ('500', '601', NULL, NULL, NULL, NULL,'611', '510', '400', '601', NULL, NULL, NULL, NULL,'611', '410', '300', '601', NULL, NULL, NULL, NULL, ";
		$query .= "'611', '310', '100', '601', NULL, NULL, NULL, NULL,'611','210', '200', '601', NULL, NULL, NULL, NULL,'611', '110', '300', '601', NULL, NULL, NULL, NULL,";
		$query .= "'611', '310', '400', '601', NULL, NULL, NULL, NULL,'611', '410', '500', '601', NULL, NULL, NULL, NULL, '611', '510', NULL);";
		$gameInfo = $this->sendQuery($query,true);
		$query = "INSERT INTO `".$this->gameLogTable."` (`id`, `game_info_id`, `turn`, `game_is_ended`, `player`) VALUES (NULL, '".$gameInfo['id']."', '1', '1', '0');";
		$gameLog = $this->sendQuery($query,true);
		$data['gameInfoId'] = $gameInfo['id'];
		$data['gameLogId'] = $gameLog['id'];
		return $data;
			
	}
	
	public function getGameInfoById($gameInfoId){
		$query = 'SELECT * FROM '.$this->gameInfoTable.' WHERE id = '.$gameInfoId;
		$row = $this->sendQuery($query);
		$data = $row['data']->fetch_assoc();
		return $data;
	}
	
	private function getGameLogById($gameLogId){
		$query = "SELECT * FROM `".$this->gameLogTable."` WHERE id = ".$gameLogId;
		$row = $this->sendQuery($query);
		$data = $row['data']->fetch_assoc();
		return $data;
	}
	
	public function updateBoard($startPosition,$endPosition,$piece,$color,$gameLogId){
		$piecesList = $this->getPiecesList();
		foreach($piecesList as $key => $value){
			if($value == $piece)
				$piece = $key;
		}
		$this->sendQuery("UPDATE `".$this->gameInfoTable."` SET `".$startPosition."` = NULL, `".$endPosition."` = '".$piece.$color."' WHERE `".$this->gameInfoTable."`.`id` = ".$gameLogId);
	}
	
	public function clearData(){
		$this->sendQuery("TRUNCATE TABLE `".$this->gameInfoTable."`");
		$this->sendQuery("TRUNCATE TABLE `".$this->gameLogTable."`");
	}
	
	public function endTheGame($gameLogId){
		$this->sendQuery("UPDATE `".$this->gameLogTable."` SET `game_is_ended` = 0 WHERE `".$this->gameLogTable."`.`id` = ".$gameLogId);
	}
	
	public function selectLastGame(){
		$query = 'SELECT * FROM '.$this->gameLogTable.' WHERE game_is_ended = 1 ORDER BY id DESC LIMIT 1 ';
		$result = $this->sendQuery($query,true);
		$id = $result['data']->fetch_row();
		return $id[0];
	}
	
	public function checkEnemyExist($hor,$vert,$id){
		if($vert > 0 and $vert < 8 and !is_null($hor)){
			$query = "SELECT ".$hor."".$vert." FROM `".$this->gameInfoTable."` WHERE id=".$id;
			if($result = $this->sendQuery($query)){
				$position = $result['data']->fetch_row();
				if(is_null($position[0]))
					return false;
				else{
					return true;
				}
			}
		}	
	}
}
?>