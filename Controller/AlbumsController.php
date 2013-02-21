<?php
class AlbumsController extends AppController {
	var $name = 'Albums';
	
	public $page_limit = 30;
	
	public $presetVars = array(
		array('field' => 'name', 'type' => 'value'),
		array('field' => 'last_name', 'type' => 'value'),
		array('field' => 'sub_genres', 'type' => 'value'),
		array('field' => 'genres', 'type' => 'value'),
		array('field' => 'exact', 'type' => 'value'),
		array('field' => 'starts_with', 'type' => 'value'),
		array('field' => 'country', 'type' => 'value'),
		array('field' => 'state', 'type' => 'value'),
		array('field' => 'city', 'type' => 'value'),
		array('field' => 'status', 'type' => 'value'),
		array('field' => 'not_approved', 'type' => 'value'),
		array('field' => 'approved', 'type' => 'value'),
	);
	
	function search(){
		$this->Album->Behaviors->attach('Containable');
		$this->Album->contain(array(
			'SubGenre.Genre', 'Band'
		));

		$this->set('styles', array('tables', 'search_forms'));
		$this->set('scripts',array('jquery.search'));

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				$this->Album->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'name' => 'ASC',
			),
		);
		
		$results = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('albums', $results);
		$this->LoadModel('SubGenre');
		$sub_genres = $this->SubGenre->getAll();
		$this->LoadModel('Genre');
		$genres = $this->Genre->getAll();
		$this->LoadModel('State');
		$this->set('states',$this->State->find('list'));
		$this->LoadModel('Country');
		$this->set('countries',$this->Country->find('list'));
		$this->LoadModel('City');
		$this->set('cities',$this->City->find('list'));

		$this->set('genres', $genres);
		$this->set('sub_genres', $sub_genres);
		
		$this->set('options', array('radio'=>'Band','song'=>'Songs','genre'=>'Genre','label'=>'Labels', 'location' =>'Location'));
	}

	
	function determine_genres_for_charting(){
		$this->Album->DetermineGenresForCharting();
	}
	
	function admin_add($band_id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!empty($this->request->data)) {
			$this->Album->create();
			
			$this->loadModel('Band');
			$band = $this->Band->findById($band_id);

			$this->loadModel('Label');
			if(empty($this->request->data['Label']['name'])){
				$this->request->data['Label']['name'] = 'Unknown';
			}
			$label = $this->Label->add($this->request->data['Label'], 'name');
			
			$this->request->data['Album']['label_id'] = $label['Label']['id'];
			$album = $this->Album->add($this->request->data['Album'], array('name','band_id'), $band['Band']['name']);
			if ($album) {
				$this->Session->setFlash(__('The album has been added.'));
				$this->redirect('admin_view/'.$album['Album']['id']);
			} else {
				$this->Session->setFlash(__('The album could not be added. Please, try again.'));
			}
		}
		if(empty($band_id)){
				$this->Session->setFlash(__('Invalid band id.'));
				$this->redirect(Controller::referer());
		}
	   
		$this->set('band_id',$band_id);
	}
	
	function admin_view($id){
		$this->set('styles',array('tables'));
		if(empty($id)){
			$this->Session->setFlash(__('Invalid album id.'));
			$this->redirect('admin_view_all');
		}
		$this->Album->Behaviors->attach('Containable');
		$this->Album->contain('AlbumImage', 'SubGenre', 'Song.SubGenre.Genre', 'Band', 'AlbumStat');
		$album = $this->Album->findById($id);
		$this->set('album', $album);
		$this->Album->SubGenre->recursive = -1; 
		$this->set('charts_as', $this->Album->SubGenre->findById($album['Album']['sub_genre_for_charting']));
	}
	
	function admin_edit($id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!$id && !$band_id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid album id or band id'));
			$this->redirect(Controller::referer());
		}
		
		if (!empty($this->request->data)) {
			$this->loadModel('Label');
			if(empty($this->request->data['Label']['name'])){
				$this->request->data['Label']['name'] = 'Unknown';
			}
			$label = $this->Label->add($this->request->data['Label'], 'name');
			
			$this->request->data['Album']['label_id'] = $label['Label']['id'];
			$album = $this->Album->save($this->request->data['Album']);
			if ($album) {
				$this->Session->setFlash(__('The album has been saved.'));
				$this->redirect('admin_view/'.$album['Album']['id']);
			} else {
				$this->Session->setFlash(__('The album could not be saved. Please, try again.'));
			}
		}
		
		if (empty($this->request->data)) {
			$this->request->data = $this->Album->read(null, $id);
		}
		
		$this->LoadModel('SubGenre');
		$sub_genres = $this->SubGenre->find('list', array('order' => array('name ASC')));
		$this->set(Compact('sub_genres'));
		$this->set('band_id',$this->Album->band_id);
		$this->set('album_id',$id);
	}
	
	function admin_delete($id = 0){
		// not yet tested, needs to delete all instances of album, including playlist entries charting etc, not availible for use in database due to problems it would cause with charting.
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for album'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Album->delete($id)) {
			$this->Session->setFlash(__('album deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('album deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_view_all(){
		$this->set('styles',array('tables'));
		
		$this->Album->recursive = 0;
		$this->set('albums', $this->paginate());
	}
	
	function admin_view_unverified(){
		$this->set('styles',array('tables'));
		
		$this->paginate = array(
			'conditions' => array(
				'Album.verified' => '0'
		));
		
		$this->Album->recursive = 0;
		$this->set('albums', $this->paginate());
	}
	
	function admin_view_unapproved(){
		$this->set('styles',array('tables'));
		
		$this->paginate = array(
			'conditions' => array(
				'Album.approved' => '0'
		));
		
		$this->Album->recursive = 0;
		$this->set('albums', $this->paginate());
	}
	
	
	function admin_find_comparisons($id){
		$this->setReferer();
		// search for close match to $id
		$album = $this->Album->findById($id);
		$this->set('album', $album);
		$to_compare = $this->Album->find('all',array(
			'conditions' => array(
				'Album.id NOT' => $id,
				'Album.name SOUNDS LIKE "'.$album['Album']['name'].'"',
				'Album.band_id' => $album['Album']['band_id']
			)
		));

		$comparison = $this->Album->lev_it($album, $to_compare, 'Album', 'name');

		if(empty($comparison)){
			$this->Session->setFlash('No close matches found in database.');
			$this->redirect(array('controller' => 'Albums', 'action' => 'admin_verify', $id));
		} elseif(!isset($comparison[0])){
			$this->Session->setFlash('Exact match found in database based on '. $comparison.'.');
			$this->redirect(array('controller' => 'Albums', 'action' => 'admin_compare', $id, $result['Song']['id']));
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
				'AlbumStat',
				'Song.SubGenre.Genre',
				'Song.SongStat',
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
				'AlbumStat',
				'Song.SubGenre.Genre',
				'Song.SongStat',
				'Band'
			),

		));
		$this->set('compare', $compare);
	}
	
	function admin_merge($merge_to, $delete){
		$merge_to = $this->Album->merge($merge_to, $delete);
		$this->Session->setFlash('Albums Merged');
		if(!$merge_to['Album']['approved'])
			$this->redirect(array('controller' => 'Albums', 'action' => 'admin_verify', $merge_to['Album']['id']));
		else
			$this->redirect(array('controller' => 'Albums', 'action' => 'admin_view_all'));
	}
	
	function admin_verify($id = 0, $mode = NULL){
		$this->set('styles', array('tables', 'forms'));
		if(!empty($mode)){
			if($mode == "approve"){
				$this->Album->approve($id);
				$this->Album->verify($id);
				$this->Session->setFlash('Album Approved');
				$this->redirect($this->origReferer());
			}
			if($mode == "deny"){
				$this->Album->deny($id);
				$this->Album->verify($id);
				$this->Session->setFlash('Album Denied');
				$this->redirect($this->origReferer());
			}		
		}
		$this->Album->Behaviors->attach('Containable');
		$results = $this->Album->find('first',array(
			'conditions' => array(
				'Album.id' => $id
			),
			'contain'=>array(
				'Band',
				'Label',
				'AlbumStat',
				'Song.SubGenre',
				'Song.SongStat',
				'RadioStaffPlaylist.RadioStaffMember'
			),
		));
		
		if(empty($this->request->data)) {
			$this->request->data = $this->Album->read(null, $id);
		} else {
			$this->loadModel('Label');
			if(empty($this->request->data['Label']['name'])){
				$this->request->data['Label']['name'] = 'Unknown';
			}
			$label = $this->Label->add($this->request->data['Label'], 'name');
			
			$this->request->data['Album']['label_id'] = $label['Label']['id'];
			$album = $this->Album->save($this->request->data['Album']);
			if ($album) {
				$this->Session->setFlash(__('The album has been saved.'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The album could not be saved. Please, try again.'));
			}
		}
		
		$this->LoadModel('SubGenre');
		$sub_genres = $this->SubGenre->find('list', array('order' => array('name ASC')));
		$this->set(Compact('sub_genres'));
		$this->set('album', $results);
		$this->set('id', $id);
	}
	
	function admin_track_order($id){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid album id or band id'));
			$this->redirect(Controller::referer());
		}
		$this->loadModel('AlbumTrack');
		if(!empty($this->request->data)){
			foreach($this->request->data as $track){
				unset($this->AlbumTrack);
				$this->AlbumTrack->save($track);
			}
			$this->redirect(array('controller' => 'albums', 'action' => 'admin_view/'.$id));
		}
		
		$this->set('album', $this->Album->findById($id));
	}
}
?>