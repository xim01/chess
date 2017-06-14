<?php
class Rules{
	public $hor = array('a','b','c','d','e','f','g','h',);
	public $vert = array(1,2,3,4,5,6,7,8);	
	public $options = array();
	
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
	public function pawnRules($startPosition,$endPosition,$turn,$player){
		if($startPosition['hor'] == $endPosition['hor']){
			if($player === 0){
				if($turn == 1 and ($endPosition['vert'] == $startPosition['vert']+1 or $endPosition['vert'] == $startPosition['vert']+2))
					return true;				
				else
					if($endPosition['vert'] == $startPosition['vert']+1)
						return true;
				}else{
					if($turn == 1 and ($endPosition['vert'] == $startPosition['vert']-1 or $endPosition['vert'] == $startPosition['vert']-2))
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
		if($this->hor[$hor] !== 'h'){
			$options['hor'][] = $this->hor[$hor+1];
		}
		if($this->hor[$hor] !== 'a'){
			$options['hor'][] = $this->hor[$hor-1];
		}		
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

	public function pawn($startPosition,$endPosition,$enemy,$turn,$player){
		if(is_array($startPosition) and is_array($endPosition)){
			if($enemy !== true){
				if($this->pawnRules($startPosition,$endPosition,$turn,$player)){
					return true;
				}	
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
	public function rookRules($startPosition,$endPosition){
		if($startPosition['hor'] == $endPosition['hor'] and $endPosition['vert'] !== $startPosition['vert']){
			return true;
		}elseif($startPosition['vert'] == $endPosition['vert'] and $endPosition['hor'] !== $startPosition['hor']){
			return true;
		}
		return false;		
	}
	
	public function rook($startPosition,$endPosition){
		if((is_array($startPosition) == true) and (is_array($endPosition) == true)){
			return $this->rookRules($startPosition,$endPosition);
		}
	}
	/**************
	Bishop 
	**************/
	public function bishop($startPosition,$endPosition){
		if((is_array($startPosition) == true) and (is_array($endPosition) == true)){
			return $this->bishopRules($startPosition,$endPosition);
		}
	}

	public function bishopRules($startPosition,$endPosition){
		$hor = $this->getHor($startPosition);
		$mah = count($this->hor)-$hor;
		for($i=1;$i<$mah;$i++){
			if(($startPosition['vert']+$i) > 8){
				break;
			}
			if(($this->hor[$hor+$i] == $endPosition['hor']) and ($startPosition['vert']+$i == $endPosition['vert'])){
				return true;
			}
		}		
		for($i=1;$i<$mah;$i++){
			if(($startPosition['vert']-$i) == 0){
				break;
			}
			if(($this->hor[$hor+$i] == $endPosition['hor']) and ($startPosition['vert']-$i == $endPosition['vert'])){
				return true;
			}
		}
		for($i=1;$i<=$hor;$i++){
			if(($startPosition['vert']+$i) > 8){
				break;
			}
			if(($this->hor[$hor-$i] == $endPosition['hor']) and ($startPosition['vert']+$i == $endPosition['vert'])){
				return true;
			}
		}
		for($i=1;$i<=$hor;$i++){
			if(($startPosition['vert']-$i) == 0){
				break;
			}
			if(($this->hor[$hor-$i] == $endPosition['hor']) and ($startPosition['vert']-$i == $endPosition['vert'])){
				return true;
			}
		}
		return false;
	}
	/**************
	Queen 
	**************/
	public function queen($startPosition,$endPosition){
		if((is_array($startPosition) == true) and (is_array($endPosition) == true)){
			return $this->queenRules($startPosition,$endPosition);
		}
	}
	public function queenRules($startPosition,$endPosition){
		if($this->rookRules($startPosition,$endPosition) or $this->bishopRules($startPosition,$endPosition))
			return true;
		return false;
	}
	/**************
	King
	**************/
	public function king($startPosition,$endPosition){
		if((is_array($startPosition) == true) and (is_array($endPosition) == true)){
			return $this->kingRules($startPosition,$endPosition);
		}
	}
	public function kingRules($startPosition,$endPosition){
		if($this->pawnEnemyRules($startPosition,$endPosition))
			return true;
		$hor = $this->getHor($startPosition);
		if($this->hor[$hor] !== 'h'){
			$options['hor'][] = $this->hor[$hor+1];
		}
		if($this->hor[$hor] !== 'a'){
			$options['hor'][] = $this->hor[$hor-1];
		}	
		if($startPosition['vert'] !== 8){
			$options['vert'][] = $startPosition['vert']+1;
		}
		if($startPosition['vert'] !== 1){
			$options['vert'][] = $startPosition['vert']-1;
		}	
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
		if((is_array($startPosition) == true) and (is_array($endPosition) == true)){
			return $this->knightRules($startPosition,$endPosition);
		}
	}
	public function knightRules($startPosition,$endPosition){
		$hor = $this->getHor($startPosition);
		if((int)$startPosition['vert'] !== 8 and ($startPosition['hor'] !== 'g' and $startPosition['hor'] !== 'h')){
			if($endPosition['hor'] == $this->hor[$hor+2] and (int)$endPosition['vert'] == (int)$startPosition['vert']+1)
				return true;
		}
		if((int)$startPosition['vert'] !== 1 and ($startPosition['hor'] !== 'g' and $startPosition['hor'] !== 'h')){
			if($endPosition['hor'] == $this->hor[$hor+2] and (int)$endPosition['vert'] == (int)$startPosition['vert']-1)
				return true;
		}
		if((int)$startPosition['vert'] !== 8 and ($startPosition['hor'] !== 'a' and $startPosition['hor'] !== 'b')){
			if($endPosition['hor'] == $this->hor[$hor-2] and (int)$endPosition['vert'] == (int)$startPosition['vert']+1)
				return true;
		}
		if((int)$startPosition['vert'] !== 1 and ($startPosition['hor'] !== 'a' and $startPosition['hor'] !== 'b')){
			if($endPosition['hor'] == $this->hor[$hor-2] and (int)$endPosition['vert'] == (int)$startPosition['vert']-1)
				return true;
		}
		/*vert*/
		if($startPosition['hor'] !== 'h' and ((int)$startPosition['vert'] !== 8 and (int)$startPosition['vert'] !== 7)){
			if($endPosition['hor'] == $this->hor[$hor+1] and (int)$endPosition['vert'] == (int)$startPosition['vert']+2)
				return true;
		}
		if($startPosition['hor'] !== 'h' and ((int)$startPosition['vert'] !== 1 and (int)$startPosition['vert'] !== 2)){
			if($endPosition['hor'] == $this->hor[$hor+1] and (int)$endPosition['vert'] == (int)$startPosition['vert']-2)
				return true;
		}
		if($startPosition['hor'] !== 'a' and ((int)$startPosition['vert'] !== 8 and (int)$startPosition['vert'] !== 7)){
			if($endPosition['hor'] == $this->hor[$hor-1] and (int)$endPosition['vert'] == (int)$startPosition['vert']+2)
				return true;
		}
		if($startPosition['hor'] !== 'a' and ((int)$startPosition['vert'] !== 1 and (int)$startPosition['vert'] !== 2)){
			if($endPosition['hor'] == $this->hor[$hor-1] and (int)$endPosition['vert'] == (int)$startPosition['vert']-2)
				return true;
		}
		return false;
	}
}
?>