<?php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $belongsTo = array('Group');
    public $actsAs = array('Acl' => array('type' => 'requester'));

	var $hasOne = array(
		'UserDetail' => array(
			'className' => 'UserDetail',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserAddress' => array(
			'className' => 'UserAddress',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserEmailSettings' => array(
			'className' => 'UserEmailSettings',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	var $hasMany = array(
		'Review' => array(
			'className' => 'Review',
			'foreignKey' => 'user_id',
		),
	);
	
	var $validate = array(
		'username' => array(
		  'between' => array(
			 'rule'    => array('minLength', '5'),
				'message' => 'Minimum 5 characters long'
		  ),
			'isUnique' => array(
				'rule'    => 'isUnique',
				'message' => 'This email already exists.'
			)
	   ),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter the station or show name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'length' => array(
				'rule' => array('minLength', '6'),
				'message' => 'At least 6 characters'
			)
		),
		'password_1' => array(
			'length' => array(
				'rule' => array('minLength', '6'),
				'message' => 'At least 6 characters',
				'allowEmpty' => true,
			)
		),
		'password_check' => array(
			'password_check' => array( 
				'rule' => array('identicalFieldValues', 'password' ), 
				'message' => 'Passwords do not match.', 
			) 
		),
		'password_check_1' => array(
			'password_check_1' => array( 
				'rule' => array('identicalFieldValues', 'password' ), 
				'message' => 'Passwords do not match.', 
				'allowEmpty' => true,
			) 
		),
		
	);
	
	function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		$data = $this->data;
		if (empty($this->data)) {
			$data = $this->read();
		}
	/*	if (!$data['User']['group_id']) {
			return null;
		} else {
			return array('Group' => array('id' => $data['User']['group_id']));
		} */
	}
	
	public function beforeSave(array $options = array()) {
		if(isset($this->data['User']['password'])){
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
        return true;
    }

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
	
	function getActivationHash($user){
		if (!isset($user['User']['id'])) {
			return false;
		}
		return substr(Security::hash(Configure::read('Security.salt') . $user['User']['created'] . date('Ymd')), 0, 40);
	}

}
?>