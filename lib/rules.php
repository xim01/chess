<?php
include_once('db.php');

class Rules{
	public $hor = array('a','b','c','d','e','f','g','h',);
	public $vert = array(1,2,3,4,5,6,7,8);	
	public $db;
	
	function __construct(){
		$this->db = new GameDB;
	}
	
	public function getHor($startPosition){
		for($i=0;$i<count($this->hor);$i++){
			if($startPosition['hor'] == $this->hor[$i]){
				$hor = $i;
				break;
			}
		}
		return $hor;
	}

	/**************
	Pawn 
	**************/
	
	public function pawnRules($startPosition,$endPosition,$firstAction,$player){
		if($startPosition['hor'] == $endPosition['hor']){
			if($player == 0){
				if($firstAction == 1 and ($endPosition['vert'] == $startPosition['vert']+1 or $endPosition['vert'] == $startPosition['vert']+2))
					return true;				
				else
					if($endPosition['vert'] == $startPosition['vert']+1)
						return true;
			}else{
				if($firstAction == 1 and ($endPosition['vert'] == $startPosition['vert']-1 or $endPosition['vert'] == $startPosition['vert']-2))
					return true;				
				else
					if($endPosition['vert'] == $startPosition['vert']-1)
						return true;
			}
		}
		return false;		
	}
	
	public function pawnEnemyRules($startPosition,$endPosition){
		$hor = $this->getHor($startPosition);
		if($this->hor[$hor] !== 'h')
			$options['hor'][] = $this->hor[$hor+1];
		if($this->hor[$hor] !== 'a')
			$options['hor'][] = $this->hor[$hor-1];		
		$options['vert'][] = $startPosition['vert']+1;
		$options['vert'][] = $startPosition['vert']-1;
		for($i=0;$i<count($options['hor']);$i++){
			for($j=0;$j<count($options['vert']);$j++){
				if($options['hor'][$i] == $endPosition['hor'] and $options['vert'][$j] == $endPosition['vert'])
					return true;
			}
		}
		return false;
	}

	public function pawn($startPosition,$endPosition,$enemy,$firstAction,$player){
		if(is_array($startPosition) and is_array($endPosition)){
			if((int)$enemy == 0){
				if($this->pawnRules($startPosition,$endPosition,$firstAction,$player))
					return true;	
			}else{
				if($this->pawnEnemyRules($startPosition,$endPosition))
					return true;
			}
		}
		return false;
	}
	
	/**************
	Rook 
	**************/
	
	public function rook($startPosition,$endPosition,$id){
		if(is_array($startPosition) and is_array($endPosition))
			return $this->rookRules($startPosition,$endPosition,$id);
	}
	
	public function rookRules($startPosition,$endPosition,$id){
		$hor = $this->getHor($startPosition);
		$horMah = count($this->hor)-$this->getHor($startPosition);
		$vertMah =count($this->vert)-$startPosition['vert'];
		
		for($i=1;$i<$horMah;$i++){	
			if($this->findValidPositionRook($this->hor[$hor+$i],$startPosition['vert'],$endPosition))
				return true;
			if($this->db->checkEnemyExist($this->hor[$hor+$i],$startPosition['vert'],$id))
				break;
		}
		for($i=1;$i<=$vertMah;$i++){
			if($this->findValidPositionRook($this->hor[$hor],$startPosition['vert']+$i,$endPosition))
				return true;
			if($this->db->checkEnemyExist($this->hor[$hor],$startPosition['vert']+$i,$id))
				break;
		}
		for($i=1;$i<=$hor;$i++){
			if($this->findValidPositionRook($this->hor[$hor-$i],$startPosition['vert'],$endPosition))
				return true;
			if($this->db->checkEnemyExist($this->hor[$hor-$i],$startPosition['vert'],$id))
				break;
		}
		for($i=1;$i<$startPosition['vert'];$i++){
			if($this->findValidPositionRook($this->hor[$hor],$startPosition['vert']-$i,$endPosition))
				return true;
			if($this->db->checkEnemyExist($this->hor[$hor],$startPosition['vert']-$i,$id))
				break;
		}
		return false;		
	}
	
	public function findValidPositionRook($offsetHor,$offsetVert,$endPosition){
		if($offsetVert == $endPosition['vert'] and $offsetHor == $endPosition['hor'])
			return true;
		else
			return false;
	}
	
	/**************
	Bishop 
	**************/
	
	public function bishop($startPosition,$endPosition,$id){
		if(is_array($startPosition) and is_array($endPosition))
			return $this->bishopRules($startPosition,$endPosition,$id);
	}

	public function bishopRules($startPosition,$endPosition,$id){
		$hor = $this->getHor($startPosition);
		$mah = count($this->hor)-$hor;
		
		for($i=1;$i<$mah;$i++){
			$check = $this->findValidPositionBishop($this->hor[$hor+$i],$startPosition['vert']+$i,8,$endPosition['hor'],$endPosition['vert']);
			if($check['limit']){
				$check['validation'] = false;
				break;
			}
			if($check['validation'])
				return true;
			if($this->db->checkEnemyExist($this->hor[$hor+$i],$startPosition['vert']+$i,$id))
				break;
		}
		for($i=1;$i<$mah;$i++){
			$check = $this->findValidPositionBishop($this->hor[$hor+$i],$startPosition['vert']-$i,0,$endPosition['hor'],$endPosition['vert']);
			if($check['limit'])
				break;
			if($check['validation'])
				return true;
			if($this->db->checkEnemyExist($this->hor[$hor+$i],$startPosition['vert']-$i,$id))
				break;
		}
		for($i=1;$i<=$hor;$i++){
			$check = $this->findValidPositionBishop($this->hor[$hor-$i],$startPosition['vert']+$i,8,$endPosition['hor'],$endPosition['vert']);
			if($check['limit'])
				break;
			if($check['validation'])
				return true;
			if($this->db->checkEnemyExist($this->hor[$hor-$i],$startPosition['vert']+$i,$id))
				break;
		}
		for($i=1;$i<=$hor;$i++){
			$check = $this->findValidPositionBishop($this->hor[$hor-$i],$startPosition['vert']-$i,0,$endPosition['hor'],$endPosition['vert']);
			if($check['limit'])
				break;
			if($check['validation'])
				return true;
			if($this->db->checkEnemyExist($this->hor[$hor-$i],$startPosition['vert']-$i,$id))	
			break;
		}
		return false;
	}
	
	private function findValidPositionBishop($offsetHor,$offsetVert,$limitVert,$endPositionHor,$endPositionVert){
		if($offsetVert < 0 or $offsetVert > 8)
			$data['limit'] = true;
		else
			$data['limit'] = false;
		if($offsetHor == $endPositionHor and $offsetVert == $endPositionVert and !is_NULL($offsetHor))
			$data['validation'] = true;
		else
			$data['validation'] = false;
		return $data;	
	}
	
	/**************
	Queen 
	**************/
	public function queen($startPosition,$endPosition,$id){
		if(is_array($startPosition) and is_array($endPosition))
			return $this->queenRules($startPosition,$endPosition,$id);
	}
	
	public function queenRules($startPosition,$endPosition,$id){
		if($startPosition['hor'] == $endPosition['hor'] or $startPosition['vert'] == $endPosition['vert']){
			if($this->rookRules($startPosition,$endPosition,$id))
				return true;
		}
		else{
			if($this->bishopRules($startPosition,$endPosition,$id))
				return true;
		}
		return false;
	}
	
	/**************
	King
	**************/
	
	public function king($startPosition,$endPosition){
		if(is_array($startPosition) and is_array($endPosition))
			return $this->kingRules($startPosition,$endPosition);
	}
	
	public function kingRules($startPosition,$endPosition){
		if($this->pawnEnemyRules($startPosition,$endPosition))
			return true;
		$hor = $this->getHor($startPosition);
		if($this->hor[$hor] !== 'h')
			$options['hor'][] = $this->hor[$hor+1];
		if($this->hor[$hor] !== 'a')
			$options['hor'][] = $this->hor[$hor-1];
		if($startPosition['vert'] !== 8)
			$options['vert'][] = $startPosition['vert']+1;
		if($startPosition['vert'] !== 1)
			$options['vert'][] = $startPosition['vert']-1;	
		$options['vert'][] = (int)$startPosition['vert'];
		$options['hor'][] = $startPosition['hor'];
		for($i=0;$i<count($options['hor']);$i++){
			if($endPosition['vert'] == $startPosition['vert'] and $endPosition['hor'] == $options['hor'][$i])
				return true;
			if($endPosition['hor'] == $startPosition['hor'] and (int)$endPosition['vert'] == (int)$options['vert'][$i])
				return true;
		}
		return false;
	}
	
	/**************
	Knight
	**************/
	public function knight($startPosition,$endPosition){
		if(is_array($startPosition) and is_array($endPosition))
			return $this->knightRules($startPosition,$endPosition);
	}
	
	public function knightRules($startPosition,$endPosition){
		$hor = $this->getHor($startPosition);
		$endPosition['vert'] = (int)$endPosition['vert'];
		$startPosition['vert'] = (int)$startPosition['vert'];
		
		if($startPosition['vert'] !== 8 and ($startPosition['hor'] !== 'g' and $startPosition['hor'] !== 'h'))
			if($endPosition['hor'] == $this->hor[$hor+2] and $endPosition['vert'] == $startPosition['vert']+1)
				return true;
		if((int)$startPosition['vert'] !== 1 and ($startPosition['hor'] !== 'g' and $startPosition['hor'] !== 'h'))
			if($endPosition['hor'] == $this->hor[$hor+2] and $endPosition['vert'] == $startPosition['vert']-1)
				return true;
		if((int)$startPosition['vert'] !== 8 and ($startPosition['hor'] !== 'a' and $startPosition['hor'] !== 'b'))
			if($endPosition['hor'] == $this->hor[$hor-2] and $endPosition['vert'] == $startPosition['vert']+1)
				return true;
		if((int)$startPosition['vert'] !== 1 and ($startPosition['hor'] !== 'a' and $startPosition['hor'] !== 'b'))
			if($endPosition['hor'] == $this->hor[$hor-2] and $endPosition['vert'] == $startPosition['vert']-1)
				return true;
		if($startPosition['hor'] !== 'h' and ((int)$startPosition['vert'] !== 8 and $startPosition['vert'] !== 7))
			if($endPosition['hor'] == $this->hor[$hor+1] and $endPosition['vert'] == $startPosition['vert']+2)
				return true;
		if($startPosition['hor'] !== 'h' and ((int)$startPosition['vert'] !== 1 and $startPosition['vert'] !== 2))
			if($endPosition['hor'] == $this->hor[$hor+1] and $endPosition['vert'] == $startPosition['vert']-2)
				return true;
		if($startPosition['hor'] !== 'a' and ((int)$startPosition['vert'] !== 8 and $startPosition['vert'] !== 7))
			if($endPosition['hor'] == $this->hor[$hor-1] and $endPosition['vert'] == $startPosition['vert']+2)
				return true;
		if($startPosition['hor'] !== 'a' and ((int)$startPosition['vert'] !== 1 and $startPosition['vert'] !== 2))
			if($endPosition['hor'] == $this->hor[$hor-1] and $endPosition['vert'] == $startPosition['vert']-2)
				return true;
		return false;
	}
}
?>