<?php
class Catagory extends AppModel {
	var $name = 'Catagory';
	var $displayField = 'catagory';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'catagory_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

}
?>