<?php

class RadioStaffPlaylistArchivesController extends AppController {

	var $name = 'RadioStaffPlaylistArchives';

	var $page_limit = 1000;

	//var $components = array('RequestHandler');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('view', 'view_all');
	}
	

	function view($radio_staff_id = 0, $date = 0){		
		$this->set('styles',array('playlists'));
		if(!$radio_staff_id){
			$this->Session->setFlash(__('Invalid radio staff member'));
			$this->redirect(array('controller'=>'radio_staff_members','action' => 'search'));
		}
		if(!$date){
			$date = $this->RadioStaffPlaylistArchive->get_last_playlist($radio_staff_id);
		}
		$this->loadModel('RadioStaffMember');
		$this->RadioStaffPlaylistArchive->Behaviors->attach('Containable');
		$this->set('staff',$this->RadioStaffMember->findById($radio_staff_id));
		$this->paginate = array(
			'conditions' => array(
				'radio_staff_member_id' => $radio_staff_id,
				'week_ending' => $date
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
		$this->set('date', $date);
	}

	function admin_view($radio_staff_id = 0, $highlight = NULL){
		$this->set('styles',array('playlists'));
		if(!$radio_staff_id){
			$this->Session->setFlash(__('Invalid radio staff member'));
			$this->redirect(array('controller'=>'radio_staff_members','action' => 'admin_index'));
		}
		$this->loadModel('RadioStaffMember');
		$this->RadioStaffPlaylistArchive->Behaviors->attach('Containable');
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

} // end class

?>