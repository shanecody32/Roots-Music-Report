<?php

class RadioStaffPlaylistsController extends AppController {

	var $name = 'RadioStaffPlaylists';

	var $page_limit = 1000;

	//var $components = array('RequestHandler');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('view');
	}
	

	function view($radio_staff_seo = ''){		
		$this->set('styles',array('playlists'));
		if(!$radio_staff_id){
			$this->Session->setFlash(__('Invalid radio staff member'));
			$this->redirect(array('controller'=>'radio_staff_members','action' => 'search'));
		}
		
		$this->loadModel('RadioStaffMember');
		$this->RadioStaffPlaylist->Behaviors->attach('Containable');
		$staff = $this->RadioStaffMember->findBySeoName($radio_staff_seo);
		$this->set('staff', $staff);
		$this->paginate = array(
			'conditions' => array(
				'radio_staff_member_id' => $staff['RadioStaffMember']['id']
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

	

	function playlist_quick_check(){
		$this->set('styles',array('playlists'));
		$this->RadioStaffPlaylist->Behaviors->attach('Containable');
		$this->paginate =  array(
			'limit' => 1000, 
			'order' => array(
				'spins'=>'DESC'
			),
			'contain'=>array(
				'Album.Label',
				'Song.SubGenre.Genre',
				'Band'
			),
			'limit' => $this->page_limit,
		);
		$this->set('lists', $this->paginate());
		$this->set('page_limit', $this->paginate['limit']);	
	}


	function import_rmr_spins(){
		if(!empty($this->data)){
			if($this->data['RadioStaffPlaylist']['submittedfile']['error']){
				$this->Session->setFlash('Error With File Upload - '.$this->upload_errors[$this->data['RadioStaffPlaylist']['submittedfile']['error']]);
			}

			if(!$this->RadioStaffPlaylist->check_file_type($this->data['RadioStaffPlaylist']['submittedfile'])){
				$this->Session->setFlash('Wrong type of file uploaded, please check the file extention.');
			} else {
				$uploaded = $this->RadioStaffPlaylist->process_file($this->data['RadioStaffPlaylist']['submittedfile']);
			}
		}	
	}

	function admin_view($radio_staff_id = 0, $highlight = NULL){
		$this->set('styles',array('playlists'));
		if(!$radio_staff_id){
			$this->Session->setFlash(__('Invalid radio staff member'));
			$this->redirect(array('controller'=>'radio_staff_members','action' => 'admin_index'));
		}
		$this->loadModel('RadioStaffMember');
		$this->RadioStaffPlaylist->Behaviors->attach('Containable');
		$this->set('staff',$this->RadioStaffMember->findById($radio_staff_id));
		$this->paginate = array(
			'conditions' => array(
				'radio_staff_member_id' => $radio_staff_id
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
		if($highlight != NULL)
			$this->set('highlight', $highlight);
	}
	
	function admin_edit($staff_id = 0){
		//pr($this->request->data);
		$this->set('styles',array('playlists', 'forms','jquery.autocomplete'));
		$this->set('scripts',array('jquery.playlist'));

		if(!$staff_id){
			$this->Session->setFlash(__('Invalid Reporting Member'));
			$this->redirect(array('controller'=>'radio_staff_members','action' => 'admin_index'));
		}
		if(!empty($this->request->data)){
			$this->RadioStaffPlaylist->save_spins($this->request->data);
			switch($this->request->data['action']){
				case('Add to Playlist'):
					$name = $this->RadioStaffPlaylist->new_to_playlist($this->request->data);
					$this->Session->setFlash(__($name.' Added to Playlist'));
					$this->redirect(array('action' => 'admin_edit/'.$staff_id));
					break;
				case('Remove Selected'):
					$this->RadioStaffPlaylist->remove_entry($this->request->data);
					$this->Session->setFlash(__('All selected entries have been removed.'));
					break;
				case('Upload Playlist'):
					$this->redirect(array('action' => 'admin_upload_playlist/'.$staff_id));
					break;
				case('Upload Uncompiled Playlist'):
					$this->redirect(array('action' => 'admin_upload_uncompiled_playlist/'.$staff_id));
					break;
				case('Save Spins and Finalise Playlist'):
					$this->Session->setFlash(__('Playlist Finalised and Locked'));
					$this->RadioStaffPlaylist->finalise_toggle($staff_id);
					break;
				case('Unlock Playlist'):
					$this->Session->setFlash(__('Playlist Unlocked'));
					$this->RadioStaffPlaylist->finalise_toggle($staff_id);
					break;
				case('Get Last Weeks Playlist w/ Spins'):
					$this->Session->setFlash(__('Last Weeks Playlist Carried Over'));
					$this->RadioStaffPlaylist->getLastWeekPlaylist($staff_id, true);
					break;
				case('Get Last Weeks Playlist w/o Spins'):
					$this->Session->setFlash(__('Last Weeks Playlist Carried Over'));
					$this->RadioStaffPlaylist->getLastWeekPlaylist($staff_id, false);
					break;
				case('Count/Do Not Count Selected'):
					$this->Session->setFlash(__('All selected entries will not be counted.'));
					$this->RadioStaffPlaylist->toggleInvalid($this->request->data);
					break;
				case('Add Selected to Playlist'):
					$this->Session->setFlash(__('All selected entries have been added to playlist.'));
					$this->RadioStaffPlaylist->selected_to_playlist($this->request->data);
					$this->redirect(array('action' => 'admin_edit/'.$staff_id));
					break;
			}
		}
		$this->loadModel('RadioStaffMember');
		$this->set('staff',$this->RadioStaffMember->findById($staff_id));
		$this->RadioStaffPlaylist->Behaviors->attach('Containable');
		$this->paginate = array(
			'conditions' => array(
				'radio_staff_member_id' => $staff_id
			),
			'contain'=>array(
				'Album.Label',
				'Song.SubGenre.Genre',
				'Band'
			),
			'limit' => $this->page_limit,
			'order' => 'spins DESC'
		);
		$this->set('playlists', $this->paginate());
		$this->loadModel('Song');
		$this->set('sub_genres', $this->Song->SubGenre->find('list', array('order' => array('SubGenre.name ASC'))));
	}
	
	function edit($staff_id = 0){
		//pr($this->request->data);
		$this->set('styles',array('playlists', 'forms','jquery.autocomplete'));
		$this->set('scripts',array('jquery.playlist'));

		if(!$staff_id){
			$this->Session->setFlash(__('Invalid Reporting Member'));
			$this->redirect(array('controller'=>'radio_staff_members','action' => 'admin_index'));
		}
		if(!empty($this->request->data)){
			$this->RadioStaffPlaylist->save_spins($this->request->data);
			switch($this->request->data['action']){
				case('Add to Playlist'):
					$name = $this->RadioStaffPlaylist->new_to_playlist($this->request->data);
					$this->Session->setFlash(__($name.' Added to Playlist'));
					$this->redirect(array('action' => 'edit/'.$staff_id));
					break;
				case('Remove Selected'):
					$this->RadioStaffPlaylist->remove_entry($this->request->data);
					$this->Session->setFlash(__('All selected entries have been removed.'));
					break;
				case('Upload Playlist'):
					$this->redirect(array('action' => 'admin_upload_playlist/'.$staff_id));
					break;
				case('Upload Uncompiled Playlist'):
					$this->redirect(array('action' => 'admin_upload_uncompiled_playlist/'.$staff_id));
					break;
				case('Save Spins and Finalise Playlist'):
					$this->Session->setFlash(__('Playlist Finalised and Locked'));
					$this->RadioStaffPlaylist->finalise_toggle($staff_id);
					break;
				case('Unlock Playlist'):
					$this->Session->setFlash(__('Playlist Unlocked'));
					$this->RadioStaffPlaylist->finalise_toggle($staff_id);
					break;
				case('Get Last Weeks Playlist w/ Spins'):
					$this->Session->setFlash(__('Last Weeks Playlist Carried Over'));
					$this->RadioStaffPlaylist->getLastWeekPlaylist($staff_id, true);
					break;
				case('Get Last Weeks Playlist w/o Spins'):
					$this->Session->setFlash(__('Last Weeks Playlist Carried Over'));
					$this->RadioStaffPlaylist->getLastWeekPlaylist($staff_id, false);
					break;
				case('Count/Do Not Count Selected'):
					$this->Session->setFlash(__('All selected entries will not be counted.'));
					$this->RadioStaffPlaylist->toggleInvalid($this->request->data);
					break;
				case('Add Selected to Playlist'):
					if($this->RadioStaffPlaylist->selected_to_playlist($this->request->data)){
						$this->Session->setFlash(__('All selected entries have been added to playlist.'));
					} else {
						$this->Session->setFlash(__('We encountered and error adding the song to the playlist.'));
					}
					$this->redirect(array('action' => 'edit/'.$staff_id));
					break;
			}
		}
		$this->loadModel('RadioStaffMember');
		$this->set('staff',$this->RadioStaffMember->findById($staff_id));
		$this->RadioStaffPlaylist->Behaviors->attach('Containable');
		$this->paginate = array(
			'conditions' => array(
				'radio_staff_member_id' => $staff_id
			),
			'contain'=>array(
				'Album.Label',
				'Song.SubGenre.Genre',
				'Band'
			),
			'limit' => $this->page_limit,
			'order' => 'spins DESC'
		);
		$this->set('playlists', $this->paginate());
		$this->loadModel('Song');
		$this->set('sub_genres', $this->Song->SubGenre->find('list', array('order' => array('SubGenre.name ASC'))));
	}

	function admin_delete(){}

	function admin_upload_playlist($id = 0){
		if(isset($this->request->data['RadioStaffPlaylist']['radio_staff_member_id'])){
			$id = $this->request->data['RadioStaffPlaylist']['radio_staff_member_id'];
		}

		if(empty($id)){
			$this->Session->setFlash(__('Invalid Radio Staff Member'));
			$this->redirect(Controller::referer());
		}
		
		if($this->request->data){
			if($this->RadioStaffPlaylist->process_playlist($this->request->data)){
				$this->Session->setFlash(__('Playlist Loaded'));
				$this->redirect($this->origReferer());
			}
		}
		$this->setReferer();
		$this->set('staff_id', $id);
	}

	function admin_upload_uncompiled_playlist($id = 0){
		if(isset($this->request->data['RadioStaffPlaylist']['radio_staff_member_id'])){
			$id = $this->request->data['RadioStaffPlaylist']['radio_staff_member_id'];
		}

		if(empty($id)){
			$this->Session->setFlash(__('Invalid Radio Staff Member'));
			$this->redirect(Controller::referer());
		}

		if($this->request->data){
			$this->RadioStaffPlaylist->processUncompiledPlaylist($this->request->data);
		}

		$this->set('staff_id', $id);
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
} // end class

?>