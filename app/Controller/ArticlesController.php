<?php

class ArticlesController extends AppController {

	var $name = 'Articles';
	
	public $page_limit = 30;
	
	public $presetVars = array(
		array('field' => 'band_name', 'type' => 'value'),
		array('field' => 'album_name', 'type' => 'value'),
		array('field' => 'sub_genres', 'type' => 'value'),
		array('field' => 'genres', 'type' => 'value'),
		array('field' => 'categories', 'type' => 'value'),
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
		$this->set('styles',array('playlists', 'forms','jquery.autocomplete', 'jquery.tagit'));
		$this->set('scripts',array('jquery.autocomplete', 'jquery.forms', 'ckeditor', 'tag-it.min'));
		
		if(!empty($this->data)){
			if($article = $this->Article->save($this->data)){
				$tags = explode(',', $this->data['Tag']['tags']);
				$this->LoadModel('Tag');
				$new_tags = array();
				foreach($tags as $tag){
					$new_tags[] = $this->Tag->add($tag);
				}

				foreach($new_tags as $new_tag){
					//pr($new_tag['Tag']['id']);
					$this->LoadModel('ArticleTag');
					$this->ArticleTag->make($article['Article']['id'], $new_tag['Tag']['id']);	
				}
				
				$this->Session->setFlash(__('Article Saved'));
				$this->redirect(array('controller' => 'articles', 'action'=>'view', $article['Article']['id']));
			} else  {
				$this->Session->setFlash(__('Article Not Saved'));
				
			}
		}
		$this->loadModel('SubGenre');
		$this->set('subGenres', $this->SubGenre->find('list', array('order' => array('name ASC'))));
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('order' => array('name ASC'))));
	}
	
	public function edit($id = 0){$this->set('styles',array('forms'));
		$this->set('styles',array('playlists', 'forms','jquery.autocomplete', 'jquery.tagit'));
		$this->set('scripts',array('jquery.autocomplete', 'jquery.forms', 'ckeditor', 'tag-it.min'));
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid review id'));
			$this->redirect(Controller::referer());
		}
		$this->loadModel('AlbumImage');
		
		if(!empty($this->data)){
			if($article = $this->Article->save($this->data)){
				$this->loadModel('ArticleTag');
				
				$this->ArticleTag->deleteAll(array(
					'article_id' => $this->data['Article']['id']
				));
				$tags = explode(',', $this->data['Tag']['tags']);
				$this->LoadModel('Tag');
				$new_tags = array();
				foreach($tags as $tag){
					$new_tags[] = $this->Tag->add($tag);
				}
				foreach($new_tags as $new_tag){
					//pr($new_tag['Tag']['id']);
					$this->LoadModel('ArticleTag');
					$this->ArticleTag->make($article['Article']['id'], $new_tag['Tag']['id']);	
				}
				$this->redirect(array('controller' => 'articles', 'action'=>'view', $this->data['Article']['id']));
			}
			$this->set('tags', array());
		}
		
		if (empty($this->request->data)) {
			$this->request->data = $this->Article->read(null, $id);
			$tags = array();
			foreach($this->request->data['Tag'] as $tag) {
				$tags[] = $tag['name'];
			}
			$tags = implode(', ', $tags);
			$this->set('tags', $tags);
		}
		$this->loadModel('SubGenre');
		$this->set('subGenres', $this->SubGenre->find('list', array('order' => array('name ASC'))));
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('order' => array('name ASC'))));	
	}
	
	public function view($id){
		$this->set('styles',array('articles'));
		
		//$this->set('scripts',array(''));
		if (!$id) {
			$this->Session->setFlash(__('Invalid article id'));
			$this->redirect(Controller::referer());
		}
		$this->Article->Behaviors->attach('Containable');
		$article = $this->Article->find('first', array(
			'conditions'=> array(
				'Article.id' => $id
			),
			'contain' => array(
				'SubGenre',
				'User.UserDetail',
				'Category',
				'Tag'
				
			)
		));
		
		$facebook = array(
			'title' => 'Roots Music Report '.$article['Category']['name'].': '.$article['Article']['title'],
			'description'=>substr($article['Article']['article'], 0, 200)
		);
		$this->set('facebook', $facebook);
		$this->set('article', $article);
		$this->loadModel('Country');
	}
	
	
	public function admin_approve($id){
		$this->set('styles',array('articles'));
		
		//$this->set('scripts',array(''));
		if (!$id) {
			$this->Session->setFlash(__('Invalid article id'));
			$this->redirect(Controller::referer());
		}
		
		if(!empty($this->data)){
			if($this->data['Article']['user_id'] == $this->data['Article']['approved_by']){
				$this->Session->setFlash(__('The writer of a review cannot also approve the review.'));
			} else {
				$to_save = $this->data;
				$to_save['Article']['approved'] = 1;

				if($this->Article->save($to_save)){
					$this->Session->setFlash(__('Article Approved'));
					$this->redirect(array('controller'=>'articles', 'action'=>'view', $id, 'admin'=>false));	
				} else {
					$this->Session->setFlash(__('Review Approval Failed'));
				}
			}
		}
		
		$this->Article->Behaviors->attach('Containable');
		$article = $this->Article->find('first', array(
			'conditions'=> array(
				'Article.id' => $id
			),
			'contain' => array(
				'SubGenre',
				'User.UserDetail',
				'Category',
				'Tag'
				
			)
		));
		
		$facebook = array(
			'title' => 'Roots Music Report '.$article['Category']['name'].': '.$article['Article']['title'],
			'description'=>substr($article['Article']['article'], 0, 200)
		);
		$this->set('facebook', $facebook);
		$this->set('article', $article);
		$this->loadModel('Country');
	}
	
	function search(){
		$this->Article->Behaviors->attach('Containable');
		$this->Article->contain(array(
				'Article.Tag',
				'Article.Category',
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
		$this->Article->Behaviors->attach('Containable');
		$this->Article->contain(array(
				'Tag',
				'Category',
				'SubGenre',
				'User.UserDetail'
		));

		$this->set('styles', array('tables', 'articles'));
		$this->set('scripts',array('jquery.search'));

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				'Article.approved' => 1,
				$this->Article->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'created' => 'DESC',
			),
		);
		
		$results = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('articles', $results);
		$this->loadModel('SubGenre');
		$this->set('sub_genres', $this->SubGenre->find('list', array('order' => array('name ASC'))));
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('order' => array('name ASC'))));		
	}
	
	public function admin_unapproved(){
		$this->Article->Behaviors->attach('Containable');
		$this->Article->contain(array(
				'Tag',
				'Category',
				'SubGenre',
				'User.UserDetail'
		));

		$this->set('styles', array('tables', 'articles'));
		$this->set('scripts',array('jquery.search'));

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				'approved' => 0,
				$this->Article->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'created' => 'DESC',
			),
		);
		
		$results = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('articles', $results);
		$this->loadModel('SubGenre');
		$this->set('sub_genres', $this->SubGenre->find('list', array('order' => array('name ASC'))));
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('order' => array('name ASC'))));		
	}
	
	function admin_delete($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for article'));
			$this->redirect($this->referer());
		}
		if ($this->Article->delete($id)) {
			$this->loadModel('ArticleTag');
			$this->ArticleTag->deleteAll(array('article_id' => $id));
			$this->Session->setFlash(__('article deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('article not deleted'));
		$this->redirect($this->referer());
	}
}

?>