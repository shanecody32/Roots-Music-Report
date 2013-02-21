<?php
class RadioStationPlaylistsController extends AppController {

	var $name = 'RadioStationPlaylists';

	var $page_limit = 10000;

	
	function view($radio_id = 0){
		if(!$radio_id){
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect(array('controller'=>'radio_stations','action' => 'index'));
		}
	}

	function admin_view($radio_id = 0){
		$this->set('styles',array('playlists'));

		if(!$radio_id){
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect(array('controller'=>'radio_stations','action' => 'admin_index'));
		}
		$this->loadModel('RadioStation');
		$this->RadioStationPlaylist->Behaviors->attach('Containable');
		$this->set('radio',$this->RadioStation->findById($radio_id));
		$this->paginate = array(
			'conditions' => array(
				'radio_station_id' => $radio_id
			),
			'contain'=>array(
				'Album.Label',
				'Song.SubGenre.Genre',
				'Band'
			),
			'order' => 'spins DESC',
			'limit' => $this->page_limit,
		);
		$this->set('playlists', $this->paginate());
	}
	function admin_edit($radio_id = 0){
		//pr($this->request->data);
		$this->set('styles',array('playlists','forms', 'tables','jquery.autocomplete'));
		$this->set('scripts',array('jquery.playlist'));

		if(!$radio_id){
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect(array('controller'=>'radio_stations','action' => 'admin_index'));
		}
		if(!empty($this->request->data)){
			switch($this->request->data['action']){
				case('Add to Playlist'):
					$this->RadioStationPlaylist->save_spins($this->request->data);
					$this->RadioStationPlaylist->new_to_playlist($this->request->data);
					$this->redirect(array('action' => 'admin_edit/'.$radio_id));
					break;
				case('Save Spins'):
					$this->RadioStationPlaylist->save_spins($this->request->data);
					break;
				case('Remove Selected'):
					$this->RadioStationPlaylist->remove_entry($this->request->data);
					break;
				case('Upload Playlist'):
					$this->redirect(array('action' => 'admin_upload_playlist/'.$radio_id));
					break;
				case('Save Spins and Finalise Playlist'):
					$this->RadioStationPlaylist->save_spins($this->request->data);
					$this->RadioStationPlaylist->finalise_toggle($radio_id);
					break;
				case('Unlock Playlist'):
					$this->RadioStationPlaylist->finalise_toggle($radio_id);
					break;


			}
		}
		$this->loadModel('RadioStation');
		$this->set('radio',$this->RadioStation->findById($radio_id));
		$this->RadioStationPlaylist->Behaviors->attach('Containable');
		$this->paginate = array(
			'conditions' => array(
				'radio_station_id' => $radio_id
			),
			'contain'=>array(
				'Album.Label',
				'Song.SubGenre.Genre',
				'Band'
			),
			'limit' => $this->page_limit,
		);
		$this->set('playlists', $this->paginate());
		$this->loadModel('Song');
		$sub_genres = $this->Song->SubGenre->find('list', array('order' => array('SubGenre.name ASC')));
		$this->set(compact('sub_genres'));
	}


	function admin_upload_playlist($id = 0){
		if(isset($this->request->data['RadioStationPlaylist']['radio_station_id'])){
			$id = $this->request->data['RadioStationPlaylist']['radio_station_id'];
		}

		if(empty($id)){
			$this->Session->setFlash(__('Invalid Radio Station Id'));
			$this->redirect(Controller::referer());
		}

		if($this->request->data){
			$this->RadioStationPlaylist->process_playlist($this->request->data);
		}

		$this->set('radio_id', $id);

	}


	// Auto Complete Functions

	function band_autocomplete(){
		$query = $this->params['data']['term'];
		$this->loadModel('Band');
		$bands = $this->Band->find('list', array(
			'conditions' => array(
				'Band.name LIKE' => $query.'%'
			),
			'limit' => 10,
			'order' => 'name ASC'
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


	

} // end class
?>