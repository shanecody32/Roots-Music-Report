<?php
class SongStat extends AppModel {
	var $name = 'SongStat';
	var $displayField = 'total_spins';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Song' => array(
			'className' => 'Song',
			'foreignKey' => 'song_id',
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
			 $this->alias.'.song_id' => $data['song_id']
		  )
	   ));
	   if(!$result){
		  unset($this->id);
		  $result = $this->save($data);
		  $result = $this->find('first',array(
			 'conditions' => array(
				$this->alias.'.song_id' => $data['song_id']
			 )
		  ));
	   }
	   return $result;
    }
}
?>