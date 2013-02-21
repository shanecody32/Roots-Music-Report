<?php

class AlbumTrack extends AppModel {

	var $name = 'AlbumTrack';



	

	/*var $belongsTo = array(

		'Album' => array(

			'className' => 'Album',

			'foriegnKey' => 'album_id',

		),

		'Song' => array(

			'className' => 'Song',

			'foriegnKey' => 'song_id',

		),

	);*/

	

	function create($album_id, $song_id, $track_num = false){

		$data = array();

		unset($this->id);

		$check = $this->find('first', array(

			'conditions' => array(

				'album_id' => $album_id,

				'song_id' => $song_id

			)

		));

		if(!empty($check)){

			return true;

		}

		$data['AlbumTrack']['album_id'] = $album_id;

		$data['AlbumTrack']['song_id'] = $song_id;

		if($track_num)

			$data['AlbumTrack']['track_num'] = $track_num;

		$this->save($data);

	}

	

	function update($id, $album_id, $song_id, $track_num = false){

		unset($this->id);

		$data = array();

		$data['AlbumTrack']['id'] = $id;

		$data['AlbumTrack']['album_id'] = $album_id;

		$data['AlbumTrack']['song_id'] = $song_id;

		if($track_num)

			$data['AlbumTrack']['track_num'] = $track_num;

		$this->save($data);

	}	

	

}





?>