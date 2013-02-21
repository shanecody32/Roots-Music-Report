<?php
class BandDetail extends AppModel {
	var $name = 'BandDetail';
	var $displayField = 'rs_band_link';
	var $validate = array(
		'rs_band_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'You must enter a valid integer.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Band' => array(
			'className' => 'Band',
			'foreignKey' => 'band_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>