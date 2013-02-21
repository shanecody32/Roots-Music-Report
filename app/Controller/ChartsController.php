<?php 
class ChartsController extends AppController {
	var $name = "Charts";
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
		
	function view($type, $genre, $type2 = 'Genre', $time = "Weekly"){
		$this->set('styles', array('tables'));
		if(!$genre || !$type){
			$this->Session->setFlash(__('Invalid Chart'));
		//	$this->redirect($this->referer());
		}
		
		$chart = $this->Chart->getChart($type, $genre, $time, $type2);
		$this->set('model_name', $this->Chart->buildModelName($type, $time, $type2));
		$this->set('chart', $chart);
		$this->set('chart_title', $genre.' '.$type);
		$this->set('type', $type);
	}
	
	function show_charts(){
		$this->loadModel('SubGenre');
		$this->SubGenre->recursive = -1;
		$sub_genres = $this->SubGenre->find('all',array(
			'order' => array(
				'name' => 'ASC'
			)
		));
		
		$this->loadModel('Genre');
		$this->Genre->recursive = -1;
		$genres = $this->Genre->find('all',array(
			'order' => array(
				'name' => 'ASC'
			)
		));
		
		
		$this->set('genres', $genres);
		$this->set('sub_genres', $sub_genres);
	}
	
	function index(){
		$this->layout = 'index';
		$this->set('styles',array('chart_element', 'anythingslider', 'blues-deluxe-element', 'index'));
		$this->set('scripts',array('jquery.anythingslider.min', 'jquery.anythingslider.fx.min', 'slider'));
		$this->loadModel('Genre');
		$this->Genre->recursive = -1;
		$genres = $this->Genre->find('all',array(
			'order' => array(
				'name' => 'ASC'
			),
		));

		$charts = array();
		
		$i = 0;
		$genre_count = count($genres);
		foreach($genres as $genre){
			if($genre['Genre']['name'] != 'Unknown'){
				$charts[$i]['Chart'] = $this->Chart->getChart('album', $genre['Genre']['name'], 'Weekly', 'Genre', '10');
				$charts[$i]['Genre'] = $genre['Genre'];
				$charts[$i]['ModelName'] = $this->Chart->buildModelName('album', 'Weekly', "Genre");
					
				if(count($charts[$i]['Chart']) <= 9){
					$charts[$i] = '';
				}
				$i++;
			}
		}
		$actual_charts = array();
		foreach($charts as $chart){
			if(!empty($chart['Chart'])){
				$actual_charts[] = $chart;
			}
		}
		
		$this->loadModel('Band');
		$this->Band->Behaviors->attach('Containable');
		$band = $this->Band->find('first',array(
			'conditions' => array(
				'Band.hot_download' => 1
			),
			'contain'=>array(
				'BandImage'
			),

		));
		$this->set('band', $band);
		
		$this->loadModel('BandLink');
		$this->BandLink->recursive = -1;
		$link = $this->BandLink->find('first',array(
			'conditions' => array(
				'band_id' => $band['Band']['id'],
				'type' => 'radio_submit'
			),
		));
		$this->set('rs_link', $link['BandLink']['link']);
		
		$this->set('charts', $actual_charts);
		
		$this->loadModel('Review');
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
		$reviews = $this->Review->find('all',array(
			'conditions' => array(
				'Review.approved' => 1
			),
			'order' => array(
				'Review.created' => 'ASC'
			),
			'limit' => 5
		));
		$this->set('reviews', $reviews);
		
		$this->loadModel('Article');
		$this->Article->Behaviors->attach('Containable');
		$this->Article->contain(array(
				'SubGenre',
				'User.UserDetail',
				'Category',
				'Tag'
		));
		$articles = $this->Article->find('all',array(
			'conditions' => array(
				'Article.approved' => 1
			),
			'order' => array(
				'Article.created' => 'ASC'
			),
			'limit' => 10
		));
		$this->set('articles', $articles);
	}
	
	
	function show_chart(){
		
	}
	
}



?>
