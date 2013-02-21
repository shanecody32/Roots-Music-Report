<?php
class Label extends AppModel {
	var $name = 'Label';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
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

	var $hasMany = array(
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'label_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    function create($data = NULL, $i=0){
	   if(!$data){
		  return false;
	   }
	   $data['name'] = Inflector::humanize(strtolower(trim($data['name'])));
	   $result = $this->findByName($data['name']);
	   if(!$result){
		  unset($this->id);
		  $data['seo_name'] = strtolower(Inflector::slug($data['name']));
		  $result = $this->save($data);
		  $result = $this->findByName($data['name']);
		  
		  if(!$result) return false;
	   }
	   return $result;
    }

}
?>