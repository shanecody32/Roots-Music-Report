<?php
class UserDetail extends AppModel {
	var $name = 'UserDetail';
	var $displayField = 'first_name';
	var $validate = array(
		'first_name' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'You must enter your first name. Must be alpha-numeric.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_name' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'You must enter your last name. Must be alpha-numeric.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'email_check' => array(
			'identicalFieldValues' => array( 
				'rule' => array('identicalFieldValues', 'email'), 
				'message' => 'Emails do not match.' 
			)
		),
		'primary_phone' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter a valid phone number.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'agreed_to_terms' => array(
			'allowedChoice' => array(
				 'rule'    => array('inList', array('1')),
				 'message' => 'You must agree to user terms and conditions.'
			)
		)
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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