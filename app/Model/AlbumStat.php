<?php
class AlbumStat extends AppModel {
	var $name = 'AlbumStat';
	var $displayField = 'total_spins';
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

    function createBlank($data = NULL){
	   if(!$data){
		  return false;
	   }
	   $result = $this->find('first',array(
		  'conditions' => array(
			 $this->alias.'.album_id' => $data['album_id']
		  )
	   ));
	   if(!$result){
		  unset($this->id);
		  $result = $this->save($data);
		  $result = $this->find('first',array(
			 'conditions' => array(
				$this->alias.'.album_id' => $data['album_id']
			 )
		  ));
	   }
	   return $result;
    }
}
?>