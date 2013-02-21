<?php

class AutoCompletesController extends AppController {

	var $name = 'AutoCompletes';

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
	
		// Auto Complete Functions
	function band_autocomplete(){
		$query = $this->params['data']['term'];
		$this->loadModel('Band');
		$this->Band->Behaviors->attach('Containable');
		$bands = $this->Band->find('all', array(
			'conditions' => array(
				'Band.name LIKE' => $query.'%'
			),
			'limit' => 10,
			'order' => 'Band.name ASC',
			'contain' => array('Album.Song','Album.Label')
		));
		$this->set('bands', $bands);
		Configure::write('debug',0);
		$this->layout = 'ajax';
	}

	function song_autocomplete($band_id){
		$query = $this->params['data']['term'];
			$this->loadModel('Song');
			$this->Song->Behaviors->attach('Containable');
			$songs = $this->Song->find('all', array(
				'conditions' => array(
					'Song.name LIKE' => $query.'%',
					'Song.band_id' => $band_id
				),
				'limit' => 10,
				'order' => 'Song.name ASC',
				'contain' => array('Album.Label','SubGenre')
		));
		$this->set('songs', $songs);

		Configure::write('debug',0);
		$this->layout = 'ajax';
	}

	function album_autocomplete($band_id){
		$query = $this->params['data']['term'];
			$this->loadModel('Album');
			$this->Album->Behaviors->attach('Containable');
		$albums = $this->Album->find('all', array(
				'conditions' => array(
			'Album.name LIKE' => $query.'%',
					'Album.band_id' => $band_id
				),
				'limit' => 10,
				'order' => 'Album.name ASC',
				'contain' => array('Label')
		));
		$this->set('albums', $albums);
		Configure::write('debug',0);
		$this->layout = 'ajax';
	}

	function label_autocomplete(){
		$query = $this->params['data']['term'];
			$this->loadModel('Label');
		$bands = $this->Label->find('list', array(
				'conditions' => array(
			'Label.name LIKE' => $query.'%'
				),
				'limit' => 10,
				'order' => 'name ASC'
		));
		$this->set('bands', $bands);

		Configure::write('debug',0);
		$this->layout = 'ajax';
	}
}
