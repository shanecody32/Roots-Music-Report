<?php

class ReviewsController extends AppController {

	var $name = 'Reviews';
	
	public $page_limit = 30;
	
	public $presetVars = array(
		array('field' => 'band_name', 'type' => 'value'),
		array('field' => 'album_name', 'type' => 'value'),
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
		$this->Auth->allow('*');
	}

	public function add(){
		$this->set('styles',array('playlists', 'forms','jquery.autocomplete'));
		$this->set('scripts',array('jquery.autocomplete', 'jquery.forms', 'ckeditor'));
		
		if(!empty($this->data)){
			if(empty($this->request->data['AlbumImage']['image']['tmp_name'])){
				$this->Session->setFlash(__('You must upload an album image to post a review.'));
			} else {
				$this->loadModel('AlbumImage');
				$image['path'] = $this->AlbumImage->createDirectory($this->data);
				if(!$image['path']){
					$this->Session->setFlash(__('Problem creating the directory for the album image.'));
					return false;
				}
				$review = $this->Review->create_review($this->data);
				if(!$review){
					$this->Session->setFlash(__('Album Review Failed - Please try again.'));
					return false;
				};
				$this->loadModel('AlbumImage');
				$image['album_id'] = $review['album_id'];
				$image['filename'] = Inflector::slug(strtolower($this->data['Album']['name'].' front cover'), '-');
				
				$uploaded = $this->JqImgcrop->uploadImage($this->request->data['AlbumImage']['image'], $image['path'], $image['filename']);
				$image['filename'] = $uploaded['imageName'];
				$image['width'] = $uploaded['imageWidth'];
				$image['height'] = $uploaded['imageHeight'];
				$existing_image = $this->AlbumImage->findByAlbumId($review['album_id']);
				if($existing_image){
					$image['id'] = $existing_image['AlbumImage']['id'];
				}
				if($this->AlbumImage->save($image)){
					$this->Session->setFlash(__('Album Review Succesfully Added'));
				} else {
					$this->Session->setFlash(__('Album Review Image Failed - Please edit your review and try to upload image again.'));
				};
			}
		}

		$this->loadModel('Country');
		$this->set('countries', $this->Country->find('list'));
		$this->loadModel('State');
		$this->set('states', $this->State->find('list'));
		$this->loadModel('SubGenre');
		$this->set('subGenres', $this->SubGenre->find('list', array('order' => array('name ASC'))));
	}
	
	public function edit($id = 0){$this->set('styles',array('forms'));
		$this->set('styles',array('playlists', 'forms','jquery.autocomplete'));
		$this->set('scripts',array('jquery.autocomplete', 'jquery.forms', 'ckeditor'));
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid review id'));
			$this->redirect(Controller::referer());
		}
		$this->loadModel('AlbumImage');
		
		if(!empty($this->data)){
			$image['path'] = $this->AlbumImage->createDirectory($this->data);
			if(!$image['path']){
				$this->Session->setFlash(__('Problem creating the directory for the album image.'));
				return false;
			}
			$review = $this->Review->create_review($this->data);
			if(!$review){
				$this->Session->setFlash(__('Album Review Failed - Please try again.'));
			};
			if(!empty($this->request->data['AlbumImage']['image']['tmp_name'])){
				$image['album_id'] = $review['album_id'];
				$image['filename'] = Inflector::slug(strtolower($this->data['Album']['name'].' front cover'), '-');
				
				$uploaded = $this->JqImgcrop->uploadImage($this->request->data['AlbumImage']['image'], $image['path'], $image['filename']);
				$image['filename'] = $uploaded['imageName'];
				$image['width'] = $uploaded['imageWidth'];
				$image['height'] = $uploaded['imageHeight'];
				$existing_image = $this->AlbumImage->findByAlbumId($review['album_id']);
				if($existing_image){
					$image['id'] = $existing_image['AlbumImage']['id'];
				}
				if($this->AlbumImage->save($image)){
					$this->Session->setFlash(__('Album Review Succesfully Added'));
				} else {
					$this->Session->setFlash(__('Album Review Image Failed - Please edit your review and try to upload image again.'));
				};
			}
			$this->loadModel('AlbumImage');
			$this->set('album_image', $this->AlbumImage->find('first', array('conditions'=> array('album_id'=>$review['album_id']))));
			if($review){
				$this->redirect(array('controller'=>'reviews', 'action'=>'view', $review['id']));
			}
		}
		
		if (empty($this->request->data)) {
			$this->request->data = $this->Review->read(null, $id);
			$this->loadModel('Label');
			$label = $this->Label->findById($this->request->data['Album']['label_id']);
			$this->request->data['Label']['name'] = $label['Label']['name'];
			$this->loadModel('BandLink');
			$label = $this->BandLink->findByBandId($this->request->data['Review']['band_id']);
			$this->request->data['BandLink']['link'] = $label['BandLink']['link'];
			$this->loadModel('AlbumImage');
			$this->set('album_image', $this->AlbumImage->find('first', array('conditions'=> array('album_id'=>$this->request->data['Album']['id']))));
		}

		$this->loadModel('Country');
		$this->set('countries', $this->Country->find('list'));
		$this->loadModel('State');
		$this->set('states', $this->State->find('list'));
		$this->loadModel('SubGenre');
		$this->set('subGenres', $this->SubGenre->find('list', array('order' => array('name ASC'))));	
	}
	
	public function view($id){
		$this->set('styles',array('reviews'));
		
		//$this->set('scripts',array(''));
		if (!$id) {
			$this->Session->setFlash(__('Invalid review id'));
			$this->redirect(Controller::referer());
		}
		$this->Review->Behaviors->attach('Containable');
		$review = $this->Review->find('first', array(
			'conditions'=> array(
				'Review.id' => $id
			),
			'contain' => array(
				'Album.Label',
				'Album.AlbumImage',
				'Band.BandLink',
				'Band.Country',
				'Band.State',
				'Album.SubGenre',
				'User.UserDetail'
				
			)
		));
		$facebook = array(
			'title' => 'Roots Music Report: Album Review',
			'image' => 'http://www.rootsmusicreport.com/rmr_test/img/'.$review['Album']['AlbumImage']['path'].$review['Album']['AlbumImage']['filename'],
			'description'=>'Album Review of '.$review['Album']['name']. ' by '. $review['Band']['name']
		);
		$this->set('facebook', $facebook);
		$this->set('review', $review);
		$this->loadModel('Country');
	}
	
	public function admin_approve($id){
		$this->set('styles',array('reviews'));
		
		//$this->set('scripts',array(''));
		if (!$id) {
			$this->Session->setFlash(__('Invalid review id'));
			$this->redirect(Controller::referer());
		}
		
		if(!empty($this->data)){
			if($this->data['Review']['user_id'] == $this->data['Review']['approved_by']){
				$this->Session->setFlash(__('The writer of a review cannot also approve the review.'));
			} else {
				$to_save = $this->data;
				$to_save['Review']['approved'] = 1;
				if($this->Review->save($to_save)){
					$this->Session->setFlash(__('Review Approved'));
					$this->redirect(array('controller'=>'reviews', 'action'=>'view', $id, 'admin'=>false));	
				} else {
					$this->Session->setFlash(__('Review Approval Failed'));
				}
			}
		}
		
		$this->Review->Behaviors->attach('Containable');
		$review = $this->Review->find('first', array(
			'conditions'=> array(
				'Review.id' => $id
			),
			'contain' => array(
				'Album.Label',
				'Album.AlbumImage',
				'Band.BandLink',
				'Band.Country',
				'Band.State',
				'Album.SubGenre',
				'User.UserDetail'
				
			)
		));
		$this->set('review', $review);
		$this->loadModel('Country');
	}
	
	
	
	function search(){
		$this->Review->Behaviors->attach('Containable');
		$this->Review->contain(array(
				'Album.Label',
				'Album.AlbumImage',
				'Band.BandLink',
				'Band.Country',
				'Band.State',
				'Album.SubGenre',
				'User.UserDetail'
		));

		$this->set('styles', array('tables', 'search_forms', 'reviews-search'));
		$this->set('scripts',array('jquery.search'));

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				'Review.approved' => 1,
				$this->Review->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'created' => 'DESC',
			),
		);
		
		$results = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('reviews', $results);
		$this->LoadModel('SubGenre');
		$sub_genres = $this->SubGenre->getAll();
		$this->LoadModel('Genre');
		$genres = $this->Genre->getAll();

		$this->set('genres', $genres);
		$this->set('sub_genres', $sub_genres);
		
		$this->set('options', array('radio'=>'RadioStaffMember','song'=>'Songs','genre'=>'Genre','label'=>'Labels', 'location' =>'Location'));
	}
	
	function admin_search(){
		$this->Review->Behaviors->attach('Containable');
		$this->Review->contain(array(
				'Album.Label',
				'Album.AlbumImage',
				'Band.BandLink',
				'Band.Country',
				'Band.State',
				'Album.SubGenre',
				'User.UserDetail'
		));

		$this->set('styles', array('tables', 'search_forms', 'reviews-search'));
		$this->set('scripts',array('jquery.search'));

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				$this->Review->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'created' => 'DESC',
			),
		);
		
		$results = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('reviews', $results);
		$this->LoadModel('SubGenre');
		$sub_genres = $this->SubGenre->getAll();
		$this->LoadModel('Genre');
		$genres = $this->Genre->getAll();

		$this->set('genres', $genres);
		$this->set('sub_genres', $sub_genres);
		
		$this->set('options', array('radio'=>'RadioStaffMember','song'=>'Songs','genre'=>'Genre','label'=>'Labels', 'location' =>'Location'));
	}
	public function index(){
		$this->Review->Behaviors->attach('Containable');
		$this->Review->contain(array(
			'Band.SubGenre.Genre, Album, User',
		));

		$this->set('styles', array('tables', 'search_forms'));
		$this->set('scripts',array('jquery.search'));

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				$this->Review->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'created' => 'ASC',
			),
		);
		
		$reviews = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('reviews', $results);
		$this->LoadModel('SubGenre');
		$sub_genres = $this->SubGenre->getAll();
		$this->LoadModel('Genre');
		$genres = $this->Genre->getAll();

		$this->set('genres', $genres);
		$this->set('sub_genres', $sub_genres);
		
		$this->set('options', array('band'=>'Band Name','album'=>'Album Title','genre'=>'Genre','label'=>'Label'));
	
	
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

?>