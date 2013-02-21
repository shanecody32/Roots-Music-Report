<?php
class BandImage extends AppModel {
	var $name = 'BandImage';
	var $displayField = 'filename';
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