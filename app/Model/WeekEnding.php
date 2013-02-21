<?php
class WeekEnding extends AppModel {
	var $name = 'WeekEnding';
	var $displayField = 'ending_date';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	function update_week(){
		$time = array('id'=>1, 'ending_date' => date('Y-m-d'));
		return $this->save($time);
	}
	
	function last_week(){
		$week = $this->find('first');
		return date('Y-m-j', strtotime('-1 week', strtotime($week['WeekEnding']['ending_date'])));
	}
	
	function current_week(){
		$week = $this->find('first');
		return $week['WeekEnding']['ending_date'];
	}
	
}
?>