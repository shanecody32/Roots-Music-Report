<?php

class SongsController extends AppController {
	var $name = "Songs";
	
	function admin_find_comparisons($id){
		$this->setReferer();
		// search for close match to $id
		$song = $this->Song->findById($id);
		$this->set('song', $song);
		$to_compare = $this->Song->find('all',array(
			'conditions' => array(
				'Song.id NOT' => $id,
				'Song.name SOUNDS LIKE "'.$song['Song']['name'].'"',
				'Song.band_id' => $song['Song']['band_id']
			)
		));

		$comparison = $this->Song->lev_it($song, $to_compare, 'Song', 'name');

		if(empty($comparison)){
			$this->Session->setFlash('No close matches found in database.');
			$this->redirect(array('controller' => 'Songs', 'action' => 'admin_verify', $id));
		} elseif(!isset($comparison[0])){
			$this->Session->setFlash('Exact match found in database based on '. $comparison.'.');
			$this->redirect(array('controller' => 'Song', 'action' => 'admin_compare', $id, $result['Song']['id']));
		} else {
			$this->set('compare_options', $comparison);
		}
	}
	
	function admin_compare($orig_id, $to_compare_id){
		$model = $this->modelClass;
		$this->$model->Behaviors->attach('Containable');
		$original = $this->$model->find('first',array(
			'conditions' => array(
				$model.'.id' => $orig_id
			),
			'contain'=>array(
				'Label',
				'SongStat',
				'SubGenre.Genre',
				'Album.AlbumStat',
				'Band'
			),
		));
		$this->set('original', $original);

		$compare = $this->$model->find('first',array(
			'conditions' => array(
				$model.'.id' => $to_compare_id
			),
			'contain'=>array(
				'Label',
				'SongStat',
				'SubGenre.Genre',
				'Album.AlbumStat',
				'Band'
			),

		));
		$this->set('compare', $compare);
	}
	
	function admin_merge($merge_to, $delete){
		$merge_to = $this->Song->merge($merge_to, $delete);
		$this->Session->setFlash('Songs Merged');
		if(!$merge_to['Song']['approved'])
			$this->redirect(array('controller' => 'Songs', 'action' => 'admin_verify', $merge_to['Song']['id']));
	}
	
	function admin_verify($id = 0, $mode = NULL){
		$this->set('styles', array('tables', 'forms'));
		if(!empty($mode)){
			if($mode == "approve"){
				$this->Song->approve($id);
				$this->Song->verify($id);
				$this->Session->setFlash('Song Approved');
				$this->redirect($this->origReferer());
			}
			if($mode == "deny"){
				$this->Song->deny($id);
				$this->Song->verify($id);
				$this->Session->setFlash('Song Denied');
				$this->redirect($this->origReferer());
			}		
		}
		$this->Song->Behaviors->attach('Containable');
		$results = $this->Song->find('first',array(
			'conditions' => array(
				'Song.id' => $id
			),
			'contain'=>array(
				'Band',
				'Album.Label',
				'SongStat',
				'SubGenre.Genre',
				'Album.AlbumStat'
			),
		));
		
		if(empty($this->request->data)) {
			$this->request->data = $this->Song->read(null, $id);
		} else {
			if ($this->Song->save($this->request->data)) {
				
				$this->Session->setFlash(__('The song has been saved.'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The song could not be saved. Please, try again.'));
			}
		}
		
		$this->set('sub_genres', $this->Song->SubGenre->find('list', array('order' => array('name ASC'))));
		$this->set('song', $results);
	}
	
	function admin_add($album_id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!empty($this->request->data)) {
			$this->loadModel('Album');
			$album = $this->Album->findById($album_id);
			
			
			$this->request->data['Song']['band_id'] = $album['Band']['id'];
			$song = $this->Song->add($this->request->data['Song'], array('name','band_id'), $album['Band']['name']);
			if ($song) {
				
				$this->Album->add_genre($album['Album']['id'],$song['Song']['sub_genre_id']);
				$this->loadModel('AlbumTrack');
				$track['album_id'] = $album['Album']['id'];
				$track['song_id'] = $song['Song']['id'];
				$this->AlbumTrack->add($track, array('album_id','song_id'));
				$this->Session->setFlash(__('The song has been added.'));
				$this->redirect(array('controller' => 'albums', 'action' => 'admin_view/'.$album['Album']['id']));
			} else {
				$this->Session->setFlash(__('The song could not be added. Please, try again.'));
			}
		}
		if(empty($album_id)){
				$this->Session->setFlash(__('Invalid album id.'));
				$this->redirect(Controller::referer());
		}
	   
		$this->set('album_id',$album_id);
		$sub_genres = $this->Song->SubGenre->find('list', array('order' => array('SubGenre.name ASC')));
		$this->set(compact('sub_genres'));
	}
	
	function admin_view($id){
		$this->set('styles',array('tables'));
		if(empty($id)){
			$this->Session->setFlash(__('Invalid album id.'));
			$this->redirect('admin_view_all');
		}
		//$this->Song->Behaviors->attach('Containable');
		//$this->Song->contain('AlbumImage', 'Genre', 'Song.Genre', 'Band', 'AlbumStat');
		//$this->set('album', $this->Song->findById($id));
	}
	
	function admin_edit($id = 0, $album_id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!$id && !$album_id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid album id or song id'));
			$this->redirect(Controller::referer());
		}
		
		if (!empty($this->request->data)) {
			$song = $this->Song->findById();
			
			$this->loadModel('Album');
			$album = $this->Album->findById($album_id);
					
			$song = $this->Song->save($this->request->data);
			if ($song) {
				$this->Album->add_genre($album['Album']['id'],$song['Song']['genre_id']);
				$this->loadModel('AlbumTrack');
				$this->AlbumTrack->create($album['Album']['id'],$song['Song']['id']);
				$this->Session->setFlash(__('The album has been saved.'));
				$this->redirect(array('controller' => 'albums', 'action' => 'admin_view/'.$album['Album']['id']));
			} else {
				$this->Session->setFlash(__('The album could not be saved. Please, try again.'));
			}
		}
		
		if (empty($this->request->data)) {
			$this->request->data = $this->Song->read(null, $id);
		}
	   
		$this->set('song_id',$id);
		$this->set('album_id',$album_id);
		$genres = $this->Song->SubGenre->find('list', array('order' => array('name ASC')));
		$this->set(compact('genres'));
	}
	
	function admin_delete($id = 0){
		// not yet tested, needs to delete all instances of album, including playlist entries charting etc, not availible for use in database due to problems it would cause with charting.
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for album'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Song->delete($id)) {
			$this->Session->setFlash(__('album deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('album deleted'));
		$this->redirect(array('action' => 'index'));
	}

}

?>