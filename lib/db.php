<?php
class GameDB {
	/****DB Settings****/
	private $bd = "chess";
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $pdo;
	/****DB Settings****/
	/****DB Tables******/
	private $gameInfoTable = "game_info";
	private $gameLogTable = "game_log";
	private $chessPiecesNameTable = "chess_pieces_name";
	/****DB Tables******/
	private $hor = array('a','b','c','d','e','f','g','h',);
	private $vert = array(1,2,3,4,5,6,7,8);
	public  $error = array("error"=>"No data");
	function __construct() {
		$this->pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->bd, $this->user, $this->password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	}
	
	public function checkEnemyExist($hor,$vert,$id){
		if($vert > 0 and $vert < 8 and !is_null($hor)){
			$sql = "SELECT ".$hor."".$vert." FROM ".$this->gameInfoTable." WHERE id=".$id;
			$statement = $this->pdo->query($sql);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$position = $statement->fetch();
			foreach($position as $prop) {
			   $position = $prop;
			   break; // or exit or whatever exits a foreach loop...
			} 
			if(empty($position)){
				return false;
			}
			else{
				return true;
			}
		}	
	}
	
	public function createGameInfo(){
		$sql  = "INSERT INTO ".$this->gameInfoTable." (	a1, a2, a3, a4, a5, a6, a7, a8,b1, b2, b3, b4, b5, b6, b7, b8,";
		$sql .= "c1, c2, c3, c4, c5, c6, c7, c8,d1, d2, d3, d4, d5, d6, d7, d8,e1, e2, e3, e4, e5, e6, e7, e8,";
		$sql .= "f1, f2, f3, f4, f5, f6, f7, f8,g1, g2, g3, g4, g5, g6, g7, g8,h1, h2, h3, h4, h5, h6, h7, h8, id)";
		$sql .= "VALUES ('500', '601', NULL, NULL, NULL, NULL,'611', '510', '400', '601', NULL, NULL, NULL, NULL,'611', '410', '300', '601', NULL, NULL, NULL, NULL, ";
		$sql .= "'611', '310', '100', '601', NULL, NULL, NULL, NULL,'611','210', '200', '601', NULL, NULL, NULL, NULL,'611', '110', '300', '601', NULL, NULL, NULL, NULL,";
		$sql .= "'611', '310', '400', '601', NULL, NULL, NULL, NULL,'611', '410', '500', '601', NULL, NULL, NULL, NULL, '611', '510', NULL);";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		$lastInsertId = $this->pdo->lastInsertId();
		$sql = "SELECT * FROM ".$this->gameInfoTable." WHERE id = '".$lastInsertId."'";
		$statement = $this->pdo->query($sql);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		return $statement->fetch();
	}
	
	public function updateGameInfo($a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$b1,$b2,$b3,$b4,$b5,$b6,$b7,$b8,$c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,
	$d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$e1,$e2,$e3,$e4,$e5,$e6,$e7,$e8,$f1,$f2,$f3,$f4,$f5,$f6,$f7,$f8,$g1,$g2,$g3,$g4,$g5,$g6,$g7,$g8,
	$h1,$h2,$h3,$h4,$h5,$h6,$h7,$h8,$id){
		$sql = "UPDATE ".$this->gameInfoTable." SET a1 = :a1, a2 = :a2, a3 = :a3, a4 = :a4, a5 = :a5, a6 = :a6, a7 = :a7, a8 = :a8, ";
		$sql .= "b1 = :b1, b2 = :b2, b3 = :b3, b4 = :b4, b5 = :b5, b6 = :b6, b7 = :b7, b8 = :b8, c1 = :c1, c2 = :c2, c3 = :c3, ";
		$sql .= "c4 = :c4, c5 = :c5, c6 = :c6, c7 = :c7, c8 = :c8, d1 = :d1, d2 = :d2, d3 = :d3, d4 = :d4,";
		$sql .= "d5 = :d5, d6 = :d6, d7 = :d7, d8 = :d8, e1 = :e1, e2 = :e2, e3 = :e3, e4 = :e4, e5 = :e5, e6 = :e6, e7 = :e7, e8 = :e8, ";
		$sql .= "f1 = :f1, f2 = :f2, f3 = :f3, f4 = :f4, f5 = :f5, f6 = :f6, f7 = :f7, f8 = :f8, g1 = :g1, g2 = :g2, g3 = :g3,";
		$sql .= "g4 = :g4, g5 = :g5, g6 = :g6, g7 = :g7, g8 = :g8, h1 = :h1, h2 = :h2, h3 = :h3, h4 = :h4, h5 = :h5, h6 = :h6, h7 = :h7,";
		$sql .= "h8 = :h8 WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute(array(":a1"=>$a1, ":a2"=>$a2, ":a3"=>$a3, ":a4"=>$a4, ":a5"=>$a5, ":a6"=>$a6, 
		":a7"=>$a7, ":a8"=>$a8, ":b1"=>$b1, ":b2"=>$b2, ":b3"=>$b3, ":b4"=>$b4, ":b5"=>$b5, ":b6"=>$b6, 
		":b7"=>$b7, ":b8"=>$b8, ":c1"=>$c1, ":c2"=>$c2, ":c3"=>$c3, ":c4"=>$c4, ":c5"=>$c5, 
		":c6"=>$c6, ":c7"=>$c7, ":c8"=>$c8, ":d1"=>$d1, ":d2"=>$d2, ":d3"=>$d3, ":d4"=>$d4, 
		":d5"=>$d5, ":d6"=>$d6, ":d7"=>$d7, ":d8"=>$d8, ":e1"=>$e1, ":e2"=>$e2, ":e3"=>$e3,
		":e4"=>$e4, ":e5"=>$e5, ":e6"=>$e6, ":e7"=>$e7, ":e8"=>$e8, ":f1"=>$f1, ":f2"=>$f2, 
		":f3"=>$f3, ":f4"=>$f4, ":f5"=>$f5, ":f6"=>$f6, ":f7"=>$f7, ":f8"=>$f8, ":g1"=>$g1,
		":g2"=>$g2, ":g3"=>$g3, ":g4"=>$g4, ":g5"=>$g5, ":g6"=>$g6, ":g7"=>$g7, ":g8"=>$g8, 
		":h1"=>$h1, ":h2"=>$h2, ":h3"=>$h3, ":h4"=>$h4, ":h5"=>$h5, ":h6"=>$h6, ":h7"=>$h7, 
		":h8"=>$h8, ":id"=>$id));
		return true;
	}
	
	public function updateGameLog($id,$turn,$player,$game_is_ended){
		$sql = "UPDATE ".$this->gameLogTable." SET turn = :turn, player = :player, game_is_ended = :game_is_ended WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute(array(":id"=>$id,":turn"=>$turn,":player"=>$player,":game_is_ended"=>$game_is_ended));
		return true;
	}
	
	public function createGameLog($gameInfoId){
		$sql = "INSERT INTO ".$this->gameLogTable." (id, game_info_id, turn, game_is_ended, player) VALUES (NULL, '".$gameInfoId."', '1', '1', '0');";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		$lastInsertId = $this->pdo->lastInsertId();
		$sql = "SELECT * FROM ".$this->gameLogTable." WHERE id = '".$lastInsertId."'";
		$statement = $this->pdo->query($sql);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		return $statement->fetch();
	}
	
	public function clearData(){
		$sql = "TRUNCATE TABLE ".$this->gameInfoTable."";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		$sql = "TRUNCATE TABLE ".$this->gameLogTable."";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		return true;
	}

	public function destroyGameInfo($gameInfoId){
		$sql = "DELETE FROM ".$this->gameInfoTable." WHERE id = ".$gameInfoId."";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
	}
	
	public function destroyGameLog($gameLogId){
		$sql = "DELETE FROM ".$this->gameLogTable." WHERE id = ".$gameLogId."";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
	}
	
	public function getLastGame(){
		$sql = "SELECT id,game_info_id FROM ".$this->gameLogTable." WHERE game_is_ended = 1 ORDER BY id DESC LIMIT 1";
		$statement = $this->pdo->query($sql);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		return $statement->fetch();
	}
	
	public function getGameInfoById($id){
		$sql = "SELECT * FROM ".$this->gameInfoTable." WHERE id = ".$id;
		$statement = $this->pdo->query($sql);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		return $statement->fetch();
	}
	
	public function getLastGameInfo(){
		$sql = "SELECT * FROM ".$this->gameInfoTable." ORDER BY id DESC LIMIT 1";
		$statement = $this->pdo->query($sql);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		return $statement->fetch();
	}	
	
	public function getLastGameLog(){
		$sql = "SELECT * FROM ".$this->gameLogTable." ORDER BY id DESC LIMIT 1";
		$statement = $this->pdo->query($sql);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		return $statement->fetch();
	}
	
	public function getGameLogById($id){
		$sql = "SELECT * FROM ".$this->gameLogTable." WHERE id = ".$id;
		$statement = $this->pdo->query($sql);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		return $statement->fetch();	
	}
	
	public function getPiecesList(){
		$sql = "SELECT * FROM ".$this->chessPiecesNameTable;
		$statement = $this->pdo->query($sql);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		for ($data['chess_pieces_name'] = array (); $result = $statement->fetchAll(); $data['chess_pieces_name'] = $result);
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

	public function ajax_respond($data){
		if(!empty($data))
			$answer = $data;
		else
			$answer = $this->error;
		echo json_encode($answer);
	}
}
?>