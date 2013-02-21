<?php
class Chart extends AppModel {
	var $name = 'Chart';
	var $uses = '';
	
	function getChart($type, $genre, $time, $type2, $limit = 50){
		
		$genre_model = ClassRegistry::init(Inflector::classify($type2));
		$genre_model->recursive = -1;
		$genre = $genre_model->findByName($genre);
		
		$model_name = $this->buildModelName($type, $time, $type2);
		$model = ClassRegistry::init($model_name);
		$model->Behaviors->attach('Containable');
		if(strtolower($type) == 'album'){
			$model->contain(array('Album.Band', 'Album.Label', 'Album.AlbumStat'));
		} else {
			$model->contain(array('Song.Band', 'Song.Album.Label', 'Song.SongStat', 'Song.SubGenre'));
		}
		
		$chart = $model->find('all', array(
			'conditions' => array(
				$model_name.'.'.Inflector::underscore($type2).'_id' => $genre[$type2]['id']
			),
			'order' => array(
				'rank' => 'ASC'
			),
			'limit' => $limit
		));
		
		return $chart; 
		
	}

	function buildModelName($input, $input2, $input3){
		return Inflector::camelize($input).Inflector::camelize($input2).Inflector::camelize($input3).'Chart';
	
	}	
}
?>