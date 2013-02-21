<?php

class LogicHelper extends AppHelper {

    function unknown($val, $var = false){
		if(!empty($val)){
			if($var)
				return $val[$var];
			else
				return $val;
			} else {
				return 'Unknown';
		}
    }

}

?>