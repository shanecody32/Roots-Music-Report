<?php
class RadioEmail extends AppModel {
	var $name = 'RadioEmail';
	var $displayField = 'email';
	var $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'You must enter a valid email address.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'RadioStation' => array(
			'className' => 'RadioStation',
			'foreignKey' => 'radio_station_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function identicalFieldValues( $field=array(), $compare_field=null ){ 
	   foreach( $field as $key => $value ){ 
		  $v1 = $value; 
		  $v2 = $this->data[$this->name][ $compare_field ];			   
		  if($v1 !== $v2) { 
			 return FALSE; 
		  } else { 
			 continue; 
		  } 
	   } 
	   return TRUE; 
    }
}
?>