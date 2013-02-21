<?php
class CityPostalCode extends AppModel {
	var $name = 'CityPostalCode';
	
	function add($city_id, $postal_code_id){
		$data = array();
		unset($this->id);
		$check = $this->find('first', array(
			'conditions' => array(
				'city_id' => $city_id,
				'postal_code_id' => $postal_code_id
			)
		));
		if(empty($check)){
			$data['CityPostalCode']['city_id'] = $city_id;
			$data['CityPostalCode']['postal_code_id'] = $postal_code_id;
			$this->save($data);
		}
	}
}


?>