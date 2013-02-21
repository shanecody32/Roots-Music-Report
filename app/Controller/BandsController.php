<?php
class BandsController extends AppController {
	var $name = "Bands";
	
	public $page_limit = 30;
	
	private $stat_limit = 10;
	
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
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('stations_playing', 'stations_playing_by_week','search');
	}
	
	function search(){
		$this->Band->Behaviors->attach('Containable');
		$this->Band->contain(array(
			'SubGenre.Genre',
		));

		$this->set('styles', array('tables', 'search_forms'));
		$this->set('scripts',array('jquery.search'));

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				$this->Band->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'name' => 'ASC',
			),
		);
		
		$results = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('bands', $results);
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

	function admin_convert_from_roots(){
		if(!empty($this->data)){
			if($this->data['Band']['submittedfile']['error']){
				$this->Session->setFlash('Error With File Upload - '.$this->upload_errors[$this->data['Band']['submittedfile']['error']]);
			}

			if(!$this->Band->check_file_type($this->data['Band']['submittedfile'])){
				$this->Session->setFlash('Wrong type of file uploaded, please check the file extention.');
			} else {
				$uploaded = $this->Band->process_file($this->data['Band']['submittedfile']);
			}
		}	
	}

	function admin_verify($id = 0, $mode = NULL){
		$this->set('styles',array('forms', 'tables'));
		if(!empty($mode)){
			if($mode == "approve"){
				if(!empty($this->request->data)) {
					$this->request->data['seo_name'] = strtolower(Inflector::slug($this->request->data['name']));
					$this->Band->save($this->request->data['Band']);
				}
				$this->Band->approve($id);
				$this->Band->verify($id);
				$this->Session->setFlash('Band Approved');
				$this->redirect($this->origReferer(), null, true);
			}
			if($mode == "deny"){
				if(!empty($this->request->data)) {
					$this->request->data['seo_name'] = strtolower(Inflector::slug($this->request->data['name']));
					$this->Band->save($this->request->data['Band']);
				}
				$this->Band->deny($id);
				$this->Band->verify($id);
				$this->Session->setFlash('Band Denied');
				$this->redirect($this->origReferer(), null, true);
			}		
		}
		$this->Band->Behaviors->attach('Containable');
		$results = $this->Band->find('first',array(
			'conditions' => array(
				'id' => $id
			),
			'contain' => array(
				'Album.Label',
				'Album.AlbumStat',
				'Album.Song.SubGenre.Genre',
				'Album.Song.SongStat',
				'RadioStaffPlaylist.RadioStaffMember'
			)
		));
		if(empty($this->request->data)) {
			$this->request->data = $this->Band->read(null, $id);
		} else {
			if ($this->Band->save($this->request->data['Band'])) {
				$this->Session->setFlash(__('The band has been saved.'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The band could not be saved. Please, try again.'));
			}
		}
		
		$this->set('band', $results);
		$this->set('id',$id);
		$this->loadModel('Country');
		$this->set('countries', $this->Country->find('list'));
		$this->loadModel('State');
		$this->set('states', $this->State->find('list'));
	}

	function admin_view_all(){
		$this->set('styles',array('tables'));
		
		$this->set('bands', $this->paginate());
	}


	function admin_merge($merge_to, $delete){

		$merge_to = $this->Band->merge($merge_to, $delete);
		$this->Session->setFlash('Bands Merged');
		if(!$merge_to['Band']['approved'])
			$this->redirect(array('controller' => 'Bands', 'action' => 'admin_verify', $merge_to['Band']['id']));
		else
			$this->redirect(array('controller' => 'Bands', 'action' => 'admin_index')); 
	}

	function admin_find_comparisons($id){
		// search for close match to $id
		$this->setReferer();
		$band = $this->Band->findById($id);
		$this->set('band', $band);
		$to_compare = $this->Band->find('all',array(
			'conditions' => array(
				'Band.id NOT' => $id,
				'Band.name SOUNDS LIKE "'.$band['Band']['name'].'"'
			)
		));

		$comparison = $this->Band->lev_it($band, $to_compare, 'Band', 'name');

		if(empty($comparison)){
			$this->Session->setFlash('No close matches found in database.');
			$this->redirect(array('controller' => 'Bands', 'action' => 'admin_verify', $id));
		} elseif(!isset($comparison[0])){
			$this->Session->setFlash('Exact match found in database based on '. $comparison.'.');
			$this->redirect(array('controller' => 'Bands', 'action' => 'admin_compare', $id, $result['Band']['id']));
		} else {
			$this->set('compare_options', $comparison);
		}
	}

	function admin_compare($orig_id, $to_compare_id){
		$this->Band->Behaviors->attach('Containable');
		$original = $this->Band->find('first',array(
			'conditions' => array(
				'Band.id' => $orig_id
			),
			'contain'=>array(
				'Album.Label',
				'Album.AlbumStat',
				'Album.Song.SubGenre.Genre',
				'Album.Song.SongStat'
			),
		));
		$this->set('original', $original);

		$compare = $this->Band->find('first',array(
			'conditions' => array(
				'Band.id' => $to_compare_id
			),
			'contain'=>array(
				'Album.Label',
				'Album.AlbumStat',
				'Album.Song.SubGenre.Genre',
				'Album.Song.SongStat'
			),

		));
		$this->set('compare', $compare);
	}
	
	function admin_add(){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!empty($this->request->data)) {
			$this->Band->create();
			
			$band = $this->Band->add($this->request->data['Band'], 'name');
			
			if ($band) {
				$this->Session->setFlash(__('The band has been added.'));
				$this->redirect('admin_view/'.$band['Band']['id']);
			} else {
				$this->Session->setFlash(__('The band could not be added. Please, try again.'));
			}
		}	
		
		$this->loadModel('Country');
		$this->set('countries', $this->Country->find('list'));
		$this->loadModel('State');
		$this->set('states', $this->State->find('list'));
	}
	
	function admin_edit($id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid band id.'));
			$this->redirect($this->referer(), null, true);
		}
		
		if (!empty($this->request->data)) {
			if ($this->Band->save($this->request->data['Band'])) {
				$this->Session->setFlash(__('The band has been saved.'));
				$this->redirect($this->origReferer(), null, true);
			} else {
				$this->Session->setFlash(__('The band could not be saved. Please, try again.'));
			}
		}
		
		if (empty($this->request->data)) {
			$this->setReferer();
			$this->request->data = $this->Band->read(null, $id);
		}
	   
		$this->set('id',$id);
		$this->loadModel('Country');
		$this->set('countries', $this->Country->find('list'));
		$this->loadModel('State');
		$this->set('states', $this->State->find('list'));
	}
	
	function admin_delete($id = 0){
		// not yet tested, needs to delete all instances of band, including playlist entries charting etc. only to be used to delete erroneuos entries
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for band'));
			$this->redirect($this->referer());
		}
		if ($this->Band->delete($id)) {
			$this->Session->setFlash(__('band deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('band deleted'));
		$this->redirect($this->referer());
	}
	
	function admin_view_unverified(){
		$this->set('styles',array('tables'));
		
		$this->paginate = array(
			'conditions' => array(
				'Band.verified' => '0'
		));
		
		$this->Band->recursive = 0;
		$this->set('bands', $this->paginate());
	}
	
	function admin_view_unapproved(){
		$this->set('styles',array('tables'));
		
		$this->paginate = array(
			'conditions' => array(
				'Band.approved' => '0'
		));
		
		$this->Band->recursive = 0;
		$this->set('bands', $this->paginate());
	}
	
	function admin_view($id = null){
		$this->set('styles',array('tables', 'admin-profile'));
		if(empty($id)){
			$this->Session->setFlash(__('Invalid band id.'));
			$this->redirect('admin_index');
		}
		$this->Band->Behaviors->attach('Containable');
		$band = $this->Band->find('first',array(
			'conditions' => array(
				'Band.id' => $id
			),
			'contain'=>array(
				'Album.Label',
				'Album.SubGenre.Genre',
				'Album.AlbumStat',
				'Album.Song.SubGenre.Genre',
				'Album.Song.SongStat',
				'City',
				'State',
				'Country',
				'BandImage',
				'BandLink',
				'BandDetail'
			),

		));
		$this->set('band', $band);
	}

	function stations_playing($id = NULL){
		$this->set('styles',array('view_stations_playing'));
		$this->set('off_site_script', array('https://www.google.com/jsapi'));
		if(empty($id)){
			$this->Session->setFlash(__('Invalid band id.'));
			$this->redirect('admin_index');
		}
		$this->Band->Behaviors->attach('Containable');
		$band = $this->Band->find('first',array(
			'conditions' => array(
				'Band.seo_name' => $id
			),
			'contain'=>array(
				'Album.Label',
				'Album.SubGenre.Genre',
				'Album.AlbumStat',
				'Album.Song.SubGenre.Genre',
				'Album.Song.SongStat',
				'City',
				'State',
				'Country',
				'BandImage',
				'BandLink',
				'BandDetail',
			),
		));
		
		$this->LoadModel('RadioStationPlaylistArchive');
		$this->RadioStationPlaylistArchive->recursive = -1;
		$track_it_date = $this->RadioStationPlaylistArchive->find('first', array(
			'conditions' => array(
				'band_id' => $band['Band']['id'],
			),
			'order' => 'week_ending DESC',
		));
		$this->RadioStationPlaylistArchive->Behaviors->attach('Containable');
		
		$end_date = $track_it_date['RadioStationPlaylistArchive']['week_ending'];
		$start_date = date('Y-m-j', strtotime('-3 month', strtotime($end_date)));
		
		
		$track_it = $this->RadioStationPlaylistArchive->find('all', array(
			'conditions' => array(
				'RadioStationPlaylistArchive.band_id' => $band['Band']['id'],
			),
			'order' => 'RadioStationPlaylistArchive.week_ending ASC',
			'contain' => array(
				'RadioStation',
				'Album',
				'Song'
			),
		));
		$track_bands = $this->RadioStationPlaylistArchive->count_band_spins_by_week($track_it);
		$track_albums = $this->RadioStationPlaylistArchive->count_band_spins_by_week_and_album($track_it);
		$track_songs = $this->RadioStationPlaylistArchive->count_band_spins_by_week_and_song($track_it);
		$this->set('track_bands', $track_bands);
		$this->set('track_albums', $track_albums);
		$this->set('track_songs', $track_songs);
		$this->set('band', $band);	
		$this->set('dates', array('start_date' => $start_date, 'end_date'=>$end_date));
	}
	
	function stations_playing_by_week($id = NULL, $date = NULL){
		$this->set('styles',array('view_reporters_playing_by_week'));
		$this->set('off_site_script', array('https://www.google.com/jsapi'));
		if(empty($id)){
			$this->Session->setFlash(__('Invalid band id.'));
			$this->redirect('admin_index');
		}
		if(empty($date)){
			$this->Session->setFlash(__('Invalid date.'));
			$this->redirect('admin_index');
		}
		
		$this->Band->Behaviors->attach('Containable');
		$band = $this->Band->find('first',array(
			'conditions' => array(
				'Band.seo_name' => $id
			),
			'contain'=>array(
				'Album.Label',
				'Album.SubGenre.Genre',
				'Album.AlbumStat',
				'Album.Song.SubGenre.Genre',
				'Album.Song.SongStat',
				'City',
				'State',
				'Country',
				'BandImage',
				'BandLink',
				'BandDetail',
			),
		));
		
		$this->LoadModel('RadioStationPlaylistArchive');
		$this->RadioStationPlaylistArchive->Behaviors->attach('Containable');
		$details = $this->RadioStationPlaylistArchive->find('all', array(
			'conditions' => array(
				'RadioStationPlaylistArchive.band_id' => $band['Band']['id'],
				'RadioStationPlaylistArchive.week_ending' => $this->Format->date($date, 'mysql'),
			),
			'order' => 'RadioStationPlaylistArchive.radio_station_id DESC',
			'contain' => array(
				'RadioStation',
				'Album',
				'Song'
			),
		));

		$this->set('details', $details);
		$this->set('band', $band);	
		$this->set('date', $date);	
	}


}
?>
