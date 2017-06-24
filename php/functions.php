<?php
class Functions{
	
	
	static function getProp($str,$prop,$number=true){
		if($str !== NULL){
			if($number == true){
				if($prop==1)
					$str = (int)substr($str,0,1);
				if($prop==2)
					$str = (int)substr($str,1,1);
				if($prop==3)
					$str = (int)substr($str,2,1);
				return $str;		
			}else{
				if($prop==1)
					$str = substr($str,0,1);
				if($prop==2)
					$str = substr($str,1,1);
				if($prop==3)
					$str = substr($str,2,1);
				return $str;		
			}
		}
		return NULL;
	}
		
	static function getColor($color){
		global $color2;
		$color2[] = $color;
		if($color ===0 )
			$color = 'white';
		elseif($color === 1)
			$color = 'black';
		else
			$color = '';
		return $color;
	}

	static function getPieceName($array,$curentId){
		foreach($array as $id => $name){
			if($id == $curentId)
				return $name;
		}
	}
}
?>