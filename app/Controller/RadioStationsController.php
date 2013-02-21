<?php
App::uses('CakeEmail', 'Network/Email');
class RadioStationsController extends AppController {

	public $name = 'RadioStations';

	public $presetVars = array(
		array('field' => 'search', 'type' => 'value'),
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
	
	// function variables
	
	public $page_limit = 30;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('search', 'view', 'application');
	}
	
	
	function determine_station_sub_genres(){
		$this->RadioStation->Behaviors->attach('Containable');
		$this->RadioStation->contain('SubGenre', 'RadioStaffMember.SubGenre');
		
		$stations = $this->RadioStation->subQuery(array('in_model' => 'RadioStaffMember', 'field' => 'radio_station_id', 'operation' => '>=', 'value' => 1,)); //

		$sub_genres_to_add = array();
		
		
		foreach($stations as $station){
			$to_add = array();
			$exists = array();
			foreach($station['SubGenre'] as $sub){
				if(!in_array($sub['name'], $exists)){
					$exists[$sub['id']] = $sub['name'];
				}
			}

			if(!empty($station['RadioStaffMember'])){
				foreach($station['RadioStaffMember'] as $member){
					foreach($member['SubGenre'] as $sub){
						if(!in_array($sub['name'], $to_add) && !in_array($sub['name'], $exists)){
							$to_add[$sub['id']] = $sub['name'];
						}
					}
				}
			}

			foreach($to_add as $key => $value){
				if($key != 35){
					$sub_genres_to_add[] = array(
						'sub_genre_id' => $key,
						'radio_station_id' => $station['RadioStation']['id']
					);
				}
			}
		}
		$this->loadModel('RadioStationSubGenre');
		$result = $this->RadioStationSubGenre->saveAll($sub_genres_to_add);
		//pr($sub_genres_to_add);
	}
	
	function determine_station_genres(){
		$this->RadioStation->Behaviors->attach('Containable');
		$this->RadioStation->contain('RadioStaffMember.SubGenre', 'Genre');
		
		$stations = $this->RadioStation->find('all'); //

		$genres_to_add = array();
		
		
		foreach($stations as $station){
			$to_add = array();
			$exists = array();
			foreach($station['Genre'] as $sub){
				if(!in_array($sub['name'], $exists)){
					$exists[$sub['id']] = $sub['name'];
				}
				pr($sub);
			}
			foreach($station['RadioStaffMember'] as $staff){
				foreach($staff['SubGenre'] as $genre){
					if(!in_array($genre['genre_id'], $to_add) && !in_array($genre['genre_id'], $exists)){
						$to_add[$genre['genre_id']] = $genre['genre_id'];
					}
				}
			}

			foreach($to_add as $key => $value){
				if($key != 16){
					$genres_to_add[] = array(
						'genre_id' => $key,
						'radio_station_id' => $station['RadioStation']['id']
					);
				}
			}
		}
		$this->loadModel('RadioStationGenre');
		$result = $this->RadioStationGenre->saveAll($genres_to_add);
		//pr($genres_to_add);
	}
	
	
	function search(){
		$this->RadioStation->Behaviors->attach('Containable');
		$this->RadioStation->contain(array(
			'SubGenre.Genre'
		));

		$this->set('styles', array('tables', 'search_forms'));
		$this->set('scripts',array('jquery.search'));
		
		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				$this->RadioStation->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'name' => 'ASC',
			),
		);
		
		$results = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('stations', $results);
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
		
		$this->set('options', array('radio'=>'RadioStation','song'=>'Songs','genre'=>'Genre','label'=>'Labels', 'location' =>'Location'));
	}
	
	
	function index() {
		$this->RadioStation->recursive = 0;
		$this->set('radioStations', $this->paginate());
		}

	function view($id = null) {
		$this->set('styles',array('profiles', 'tables'));
		$this->RadioStation->Behaviors->attach('Containable');
		$this->RadioStation->contain(array(
			'RadioAddress.State',
			'RadioAddress.City',
			'RadioAddress.PostalCode',
			'RadioAddress.Country',
			'RadioStationImage',
			'RadioEmail',
			'RadioLink',
			'RadioPhoneNumber',
			'RadioStaffMember',
			'RadioSyndicatedDetail.RadioSyndicatedStation',
			'RadioTerrestrialDetail',
			'RadioInternetDetail',
			'RadioSatelliteDetail'
		));

		//	$this->set('scripts',array('jquery.forms'));
		if (!$id) {
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect(array('action' => 'index'));
		}

		$radio = $this->RadioStation->find('first', array(
			'conditions' => array(
				'RadioStation.seo_name' => $id
			)
		));

		$this->set('radio', $radio);
		$this->set('title_for_layout', "Radio Airplay Reporter - Roots Music Report Radio Airplay Reporter Radio Station Profile");
		$this->set('keys_for_layout', "Radio Stuff");
		$this->set('desc_for_layout', "Radio Airplay Reporter - Roots Music Report Radio Airplay Reporter Radio Station Profile");


	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->RadioStation->save($this->request->data)) {
				$this->Session->setFlash(__('The radio station has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The radio station could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->RadioStation->read(null, $id);
		}
		$users = $this->RadioStation->User->find('list');
		$this->set(compact('users'));
		}

		function admin_index() {
		$this->set('styles',array('tables'));
		
		$this->RadioStation->recursive = 0;
		$this->set('radio_stations', $this->paginate());
	}
	
	function admin_view_all() {
		$this->set('styles',array('tables'));
		
		$this->RadioStation->recursive = 0;
		$this->set('radio_stations', $this->paginate());
	}
	
	function admin_view_unverified(){
		$this->set('styles',array('tables'));
		
		$this->paginate = array(
			'conditions' => array(
				'RadioStation.verified' => '0'
		));
		
		$this->RadioStation->recursive = 0;
		$this->set('radio_stations', $this->paginate());
	}
	
	function admin_view_unapproved(){
		$this->set('styles',array('tables'));
		
		$this->paginate = array(
			'conditions' => array(
				'RadioStation.approved' => '0'
		));
		
		$this->RadioStation->recursive = 0;
		$this->set('radio_stations', $this->paginate());
	}

	function admin_view($id = null) {
		$this->set('styles',array('profiles'));
		$this->RadioStation->Behaviors->attach('Containable');
		$this->RadioStation->contain(array(
			'RadioAddress.State',
			'RadioAddress.City',
			'RadioAddress.PostalCode',
			'RadioAddress.Country',
			'RadioStationImage',
			'RadioEmail',
			'RadioLink',
			'RadioPhoneNumber',
			'RadioStaffMember',
			'RadioSyndicatedDetail.RadioSyndicatedStation',
			'RadioTerrestrialDetail',
			'RadioInternetDetail',
			'RadioSatelliteDetail'
		));

		//	$this->set('scripts',array('jquery.forms'));
		if (!$id) {
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect(array('action' => 'index'));
		}

		$radio = $this->RadioStation->read(null, $id);
		$this->set('radio', $radio);
		$this->set('title_for_layout', "Radio Airplay Reporter - Roots Music Report Radio Airplay Reporter Radio Station Profile");
		$this->set('keys_for_layout', "Radio Stuff");
		$this->set('desc_for_layout', "Radio Airplay Reporter - Roots Music Report Radio Airplay Reporter Radio Station Profile");
	}

	function admin_edit($id = null) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect($this->referer());
		}
		if(!empty($this->request->data)) {
			switch ($this->request->data['RadioStation']['type']) {
				case 'terrestrial':
					unset($this->request->data['RadioInternetDetail']);
					unset($this->request->data['RadioSyndicatedDetail']);
					unset($this->request->data['RadioSatelliteDetail']);
					break;
				case 'internet':
					unset($this->request->data['RadioTerrestrialDetail']);
					unset($this->request->data['RadioSyndicatedDetail']);
					unset($this->request->data['RadioSatelliteDetail']);
					break;
				case 'syndicated':
					unset($this->request->data['RadioTerrestrialDetail']);
					unset($this->request->data['RadioInternetDetail']);
					unset($this->request->data['RadioSatelliteDetail']);
					break;
				case 'satellite':
					unset($this->request->data['RadioTerrestrialDetail']);
					unset($this->request->data['RadioInternetDetail']);
					unset($this->request->data['RadioSyndicatedDetail']);
					break;
			} 
			if ($this->RadioStation->saveAll($this->request->data)) {
				$this->Session->setFlash('The radio station has been saved.');
				$this->redirect($this->origReferer());
			}else {
				$this->Session->setFlash('Station Not Created');
			}; 
		}
		if (empty($this->request->data)) {
			$this->setReferer();
			$this->request->data = $this->RadioStation->read(null, $id);
			$this->loadModel('City');
			$city = $this->City->find('first', array(
				'conditions' => array(
					'City.id' => $this->request->data['RadioAddress'][0]['city_id']
				),
				'fields' => array('name')
			));
			$this->request->data['RadioAddress'][0]['city'] = $city['City']['name'];
			$this->loadModel('State');
			$state = $this->State->find('first', array(
				'conditions' => array(
					'State.id' => $this->request->data['RadioAddress'][0]['state_id']
				),
				'fields' => array('name')
			));
			$this->request->data['RadioAddress'][0]['state'] = $state['State']['name'];
			$this->loadModel('PostalCode');
			$zip = $this->PostalCode->find('first', array(
				'conditions' => array(
					'PostalCode.id' => $this->request->data['RadioAddress'][0]['postal_code_id']
				),
				'fields' => array('code')
			));
			$this->request->data['RadioAddress'][0]['zip'] = $zip['PostalCode']['code'];
				
		}
		//$users = $this->RadioStation->User->find('list');
		//$this->set(compact('users'));
		$this->loadModel('Country');
		$country = $this->Country->findById('225');
		$this->set(compact('country'));
		$countries = $this->Country->find('list');
		$this->set(compact('countries'));
		
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for radio station'));
			$this->redirect(array('action' => 'admin_index'));
		}
		if ($this->RadioStation->delete($id)) {
			$this->Session->setFlash(__('Radio station deleted'));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Radio station was not deleted'));
		$this->redirect(array('action' => 'admin_index'));
	}

	function admin_create() {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!empty($this->request->data)) {
			if ($this->RadioStation->add($this->request->data)) {
				//pr($this->request->data);
				$this->Session->setFlash('Station created.');
				//$this->redirect(array('controller' => 'RadioStations', 'action' => 'admin_index'));
			}else {
				$this->Session->setFlash('Station Not Created');
			}; 
		}
		$this->loadModel('Country');
		$country = $this->Country->findById('225');
		$this->set(compact('country'));
		$countries = $this->Country->find('list');
		$this->set(compact('countries'));
		}

	function application($user_id) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms', 'jquery.autocomplete'));
		
		if(!$user_id){
			$user_id = $this->Auth->user('id');
		}
		
		if (!empty($this->request->data) && $user_id) {
			$this->RadioStation->setData(&$this->request->data);
		
		
			if($radio = $this->RadioStation->save($this->request->data)){
				$this->loadModel('RadioStaffMember');
				$radio_staff = $this->RadioStaffMember->add($user_id, $this->RadioStation->getLastInsertID(), $this->request->data['RadioStaffMember']['position']);
				
				$this->Session->setFlash('Station application submitted.	You will be notified when your application is approved.');
				$this->__sendNotificationEmail($radio, $radio_staff);
				
				
				$this->redirect(array('controller' => 'RadioStaffMembers', 'action' => 'thanks', $user_id));
			} else {
				$this->Session->setFlash('Station Not Created' );
			} 
		}

		$this->loadModel('Country');
		$country = $this->Country->findById('225');
		$this->set(compact('country'));
		$countries = $this->Country->find('list');
		$this->set(compact('countries'));
	}
	
	function __sendNotificationEmail($radio, $radio_staff) {		
		$email = new CakeEmail();
		$email	->from(array('noreply@rootsmusicreport.com' => 'Roots Music Report'))
				->to('shanecody@rootsmusicreport.com')
				->subject('New RMR Reporter - '.$radio_staff['RadioStaffMember']['first_name'].' '.$radio_staff['RadioStaffMember']['last_name'].' - '. $radio['RadioStation']['name'])
				->emailFormat('both')
				->template('radio_notify')
				->viewVars(array('radio' => $radio, 'radio_staff'=> $radio_staff))
				->send();
				return true;
	}
	
	function admin_find_comparisons($id){
		// search for close match to $id
		$this->setReferer();
		$radio = $this->RadioStation->findById($id);
		$this->set('radio_station', $radio);
		$to_compare = $this->RadioStation->find('all',array(
			'conditions' => array(
				'RadioStation.id NOT' => $id,
				'RadioStation.name SOUNDS LIKE "'.$radio['RadioStation']['name'].'"'
			)
		));

		$comparison = $this->RadioStation->lev_it($radio, $to_compare, 'RadioStation', 'name');

		if(empty($comparison)){
			$this->Session->setFlash('No close matches found in database.');
			$this->redirect(array('controller' => 'RadioStations', 'action' => 'admin_verify', $id));
		} elseif(!isset($comparison[0])){
			$this->Session->setFlash('Exact match found in database based on '. $comparison.'.');
			$this->redirect(array('controller' => 'RadioStations', 'action' => 'admin_compare', $id, $result['Song']['id']));
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
				'RadioStaffMember',
			),
		));
		$this->set('original', $original);

		$compare = $this->$model->find('first',array(
			'conditions' => array(
				$model.'.id' => $to_compare_id
			),
			'contain'=>array(
				'RadioStaffMember',
			),

		));
		$this->set('compare', $compare);
	}
	
	function admin_merge($merge_to, $delete){
		$merge_to = $this->RadioStation->merge($merge_to, $delete);
		$this->Session->setFlash('Radio Stations Merged');
		if(!$merge_to['RadioStation']['approved'])
			$this->redirect(array('controller' => 'RadioStations', 'action' => 'admin_verify', $merge_to['RadioStation']['id']));
		else
			$this->redirect($this->origReferer());
	}
	
	function admin_verify($id = 0, $mode = NULL){
		if(!empty($mode)){
			if($mode == "approve"){
				$this->RadioStation->approve($id);
				$this->RadioStation->verify($id);
				$this->Session->setFlash('Radio Station Approved');
				$this->redirect($this->origReferer());
			}
			if($mode == "deny"){
				$this->RadioStation->deny($id);
				$this->RadioStation->verify($id);
				$this->Session->setFlash('Radio Station Denied');
				$this->redirect($this->origReferer());
			}		
		}
		$this->RadioStation->Behaviors->attach('Containable');
		$results = $this->RadioStation->find('first',array(
			'conditions' => array(
				'RadioStation.id' => $id
			),
			'contain'=>array(
				'RadioStaffMember',
			),
		));
		$this->set('radio_station', $results);
	}

}

?>