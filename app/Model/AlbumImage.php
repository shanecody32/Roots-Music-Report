<?php
App::uses('Folder', 'Utility');
class AlbumImage extends AppModel {
	var $name = 'AlbumImage';
	var $displayField = 'name';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	// $data contains Band and Albums
	function createDirectory($data){
		$name = Inflector::slug(strtolower($data['Album']['name']), '-');
		$artist_name = Inflector::slug(strtolower($data['Band']['name']), '-');
		$folder = new Folder();
		if ($folder->create(WWW_ROOT.DS.'img'.DS.'bands'.DS.$artist_name.DS.'albums'.DS.$name)) {
			return 'bands'.DS.$artist_name.DS.'albums'.DS.$name.DS;
		}	
		return false;
	}
}
?>