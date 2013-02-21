<?php

class ChartSort extends AppModel {
	var $name = "ChartSort";
	
	var $hasOne = array(
		'Band',
		'Song',
		'Album',
		'Genre'
	);	
}


?>