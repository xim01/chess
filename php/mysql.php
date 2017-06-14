<?php
class GameDB {
	private $bd = "chess";
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $charset = "utf8";
	private $gameInfoTable = "game_info";
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
		if(!$result['data'] = $this->mysqli->query($data)){
			var_dump("last query was failed");
			return false;
		}
		if($returnId)
			$result['id'] = $this->mysqli->insert_id;
		return $result; 
	}
	
	public function updateData(){
		/*UPDATE `game_info` SET `a1` = NULL WHERE `game_info`.`id` = 3;*/
	}
	
	public function deleteData(){
		/*"DELETE FROM `chess`.`game_info` WHERE `game_info`.`id` = 3"*/
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
	
	public function initData(){
		$gameInfo = $this->sendQuery("INSERT INTO `".$this->gameInfoTable."` (	`a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `a8`,
																`b1`, `b2`, `b3`, `b4`, `b5`, `b6`, `b7`, `b8`, 
																`c1`, `c2`, `c3`, `c4`, `c5`, `c6`, `c7`, `c8`, 
																`d1`, `d2`, `d3`, `d4`, `d5`, `d6`, `d7`, `d8`, 
																`e1`, `e2`, `e3`, `e4`, `e5`, `e6`, `e7`, `e8`, 
																`f1`, `f2`, `f3`, `f4`, `f5`, `f6`, `f7`, `f8`, 
																`g1`, `g2`, `g3`, `g4`, `g5`, `g6`, `g7`, `g8`, 
																`h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `h7`, `h8`, `id`)
																VALUES ('50', '60', NULL, NULL, NULL, NULL, 
																'61', '51', '40', '60', NULL, NULL, NULL, NULL, 
																'61', '41', '30', '60', NULL, NULL, NULL, NULL, 
																'61', '31', '10', '60', NULL, NULL, NULL, NULL, 
																'61', '21', '20', '60', NULL, NULL, NULL, NULL, 
																'61', '11', '30', '60', NULL, NULL, NULL, NULL, 
																'61', '31', '40', '60', NULL, NULL, NULL, NULL, 
																'61', '41', '50', '60', NULL, NULL, NULL, NULL, '61', '51', NULL);",true);
		$gameLog = $this->sendQuery("INSERT INTO `".$this->gameLogTable."` (`id`, `game_info_id`, `turn`, `move`, `player`) VALUES (NULL, '".$gameInfo['id']."', '1', '', '0');",true);
		$row = $this->sendQuery("SELECT * FROM `".$this->gameInfoTable."` WHERE id = ".$gameInfo['id']);
		$data['game_info'] = $row['data']->fetch_assoc();
		$row = $this->sendQuery("SELECT * FROM `".$this->gameLogTable."` WHERE id = ".$gameLog['id']);
		$data['game_log'] = $row['data']->fetch_assoc();
		$nameList = $this->getPiecesList();
		$data['chess_pieces_name'] = $nameList;
		return $data;
	}
	public function clearData(){
		$this->sendQuery("TRUNCATE TABLE `".$this->gameInfoTable."`");
		$this->sendQuery("TRUNCATE TABLE `".$this->gameLogTable."`");
	}
}
?>