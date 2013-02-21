<?php

class RadioStaffMembersController extends AppController {

	var $name = 'RadioStaffMembers';
	
	public $page_limit = 30;
	
	public $presetVars = array(
		array('field' => 'first_name', 'type' => 'value'),
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
		$this->Auth->allow('search', 'view_by_radio', 'view', 'thanks');
	}
	
	function search(){
		$this->RadioStaffMember->Behaviors->attach('Containable');
		$this->RadioStaffMember->contain(array(
			'SubGenre.Genre', 'RadioStation'
		));

		$this->set('styles', array('tables', 'search_forms'));
		$this->set('scripts',array('jquery.search'));

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => $this->page_limit,
			'conditions' => array(
				$this->RadioStaffMember->parseCriteria($this->passedArgs)
			),
			'order' => array(
				'last_name' => 'ASC',
			),
		);
		
		$results = $this->paginate();
		$this->set('page_limit', $this->paginate['limit']);		
		$this->set('staff_members', $results);
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
		
		$this->set('options', array('radio'=>'RadioStaffMember','song'=>'Songs','genre'=>'Genre','label'=>'Labels', 'location' =>'Location'));
	}
	
	
	
	function import_rmr_reporters(){
		if(!empty($this->data)){
			if($this->data['RadioStaffMember']['submittedfile']['error']){
				$this->Session->setFlash('Error With File Upload - '.$this->upload_errors[$this->data['RadioStaffMember']['submittedfile']['error']]);
			}

			if(!$this->RadioStaffMember->check_file_type($this->data['RadioStaffMember']['submittedfile'])){
				$this->Session->setFlash('Wrong type of file uploaded, please check the file extention.');
			} else {
				$uploaded = $this->RadioStaffMember->process_file($this->data['RadioStaffMember']['submittedfile']);
			}
		}	
	
	}
	
	function determine_staff_genres(){
		$this->RadioStaffMember->Behaviors->attach('Containable');
		$this->RadioStaffMember->contain('RadioStaffPlaylist.Song.SubGenre', 'RadioStaffPlaylist.Album.SubGenre', 'SubGenre');
		
		$staffs = $this->RadioStaffMember->subQuery(array('in_model' => 'RadioStaffPlaylist', 'field' => 'radio_staff_member_id', 'operation' => '>=', 'value' => 1,)); //

		$sub_genres_to_add = array();
		
		
		foreach($staffs as $staff){
			$to_add = array();
			$exists = array();
			foreach($staff['SubGenre'] as $sub){
				if(!in_array($sub['name'], $exists)){
					$exists[$sub['id']] = $sub['name'];
				}
			}

			if(!empty($staff['RadioStaffPlaylist'])){
				
				foreach($staff['RadioStaffPlaylist'] as $list){
					foreach($list['Album']['SubGenre'] as $sub){
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
						'radio_staff_member_id' => $staff['RadioStaffMember']['id']
					);
				}
			}
		}
		$this->loadModel('RadioStaffMemberSubGenre');
		$result = $this->RadioStaffMemberSubGenre->saveAll($sub_genres_to_add);
		//pr($staffs);
	}
	
	function index(){
		$user_id = $this->Auth->user('id');
		$user_type = $this->Auth->user('type');
		if(!$user_id && $user_type != 'radiostaff'){
			$this->Session->setFlash(__('You are not authorized to view this page.'));
			$this->redirect(Controller::referer());
		}
		$staff = $this->RadioStaffMember->findByUserId($user_id);
		$this->set('staff', $staff);
		
		$this->set('staff_notes', $this->RadioStaffMember->get_staff_notes($staff));
		pr($staff);
		$this->set('user_notes', $this->RadioStaffMember->get_user_notes($user_id));
	}
	
	function admin_add($radio_id){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		if(!$radio_id){
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->request->data)) {			
			if ($this->RadioStaffMember->save($this->request->data)) {
				$this->Session->setFlash(__('The Staff Member has been added.'));
				$this->redirect(array('action' => 'admin_view/'.$this->RadioStaffMember->getLastInsertId()));
			} else {
				$this->Session->setFlash(__('The Staff Member  could not be added. Please, try again.'));
			}
		}
		
		$this->set('radio_id', $radio_id);
	}

	function admin_view_by_radio($radio_id = 0) {
		$this->set('styles',array('tables'));
		if(!$radio_id){
			$this->Session->setFlash(__('Invalid radio station id'));
			$this->redirect(array('action' => 'index'));
		}
		$this->RadioStaffMember->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'radio_station_id' => $radio_id
			),
			'order' => 'position DESC'
		);
		
		$this->set('staff', $this->paginate());
	}
	
	function view_by_radio($radio_id = 0) {
		$this->set('styles',array('tables'));
		if(!$radio_id){
			$this->Session->setFlash(__('Invalid radio station id'));
			$this->redirect(array('action' => 'index'));
		}
		$this->RadioStaffMember->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'radio_station_id' => $radio_id
			),
			'order' => 'position DESC'
		);
		
		$this->set('staff', $this->paginate());
	}
	
	function admin_view_all() {
		$this->set('styles',array('tables'));
		$this->RadioStaffMember->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
			),
		);
		
		$this->set('staff', $this->paginate());
	}
	
	function admin_view_unverified(){
		$this->set('styles',array('tables'));
		
		$this->paginate = array(
			'conditions' => array(
				'RadioStaffMember.verified' => '0'
		));
		
		$this->RadioStaffMember->recursive = 0;
		$this->set('staff', $this->paginate());
	}
	
	function admin_view_unapproved(){
		$this->set('styles',array('tables'));
		
		$this->paginate = array(
			'conditions' => array(
				'RadioStaffMember.approved' => '0'
		));
		
		$this->RadioStaffMember->recursive = 0;
		$this->set('staff', $this->paginate());
	}


	function view($id = null) {
		$this->set('styles',array('profiles'));
		$this->RadioStaffMember->Behaviors->attach('Containable');
		$this->RadioStaffMember->contain(array(
		  'RadioStaffLink',
		  'RadioStation',
		  'RadioStaffImage',
		  'RadioStaffAddress.City',
		  'RadioStaffAddress.Country',
		  'RadioStaffAddress.State',
		  'RadioStaffAddress.PostalCode',
		  'RadioStaffPhoneNumber'
		));

	 //  $this->set('scripts',array('jquery.forms'));
		if (!$id) {
			$this->Session->setFlash(__('Invalid radio staff member'));
			$this->redirect(array('action' => 'index'));
		}
		
		$staff = $this->RadioStaffMember->find('first', array(
			'conditions' => array(
				'RadioStaffMember.seo_name' => $id
			)
		));

		$this->set('staff', $staff);
		$this->set('title_for_layout', "Radio Airplay Reporter - Roots Music Report Radio Airplay Reporter Radio Station Profile");
		$this->set('keys_for_layout', "Radio Stuff");
		$this->set('desc_for_layout', "Radio Airplay Reporter - Roots Music Report Radio Airplay Reporter Radio Station Profile");
	}

	function edit($id = null) {

	}
	
	function admin_add_violation($id){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!empty($this->request->data)) {
			$this->request->data['RadioStaffMember']['id'] = $id;
			if($this->RadioStaffMember->save($this->request->data)){
				$this->Session->setFlash(__('The violation has been added.'));
			}
		}
		$this->loadModel('Violation');	
		$this->set('violations', $this->Violation->getViolationList());
	}

	function admin_index() {
		$this->RadioStaffMember->recursive = 0;
		$this->set('staff_members', $this->paginate());
		$this->set('styles',array('tables'));
	}

	function admin_view($id = null) {
	
		$this->set('styles',array('profiles'));
		$this->RadioStaffMember->Behaviors->attach('Containable');
		$this->RadioStaffMember->contain(array(
		  'RadioStaffLink',
		  'RadioStation',
		  'RadioStaffImage',
		  'RadioStaffAddress.City',
		  'RadioStaffAddress.Country',
		  'RadioStaffAddress.State',
		  'RadioStaffAddress.PostalCode',
		  'RadioStaffPhoneNumber'
		));

	 //  $this->set('scripts',array('jquery.forms'));
		if (!$id) {
			$this->Session->setFlash(__('Invalid radio staff member'));
			$this->redirect(array('action' => 'index'));
		}

		$staff = $this->RadioStaffMember->read(null, $id);
		$this->set('staff', $staff);
		$this->set('title_for_layout', "Radio Airplay Reporter - Roots Music Report Radio Airplay Reporter Radio Station Profile");
		$this->set('keys_for_layout', "Radio Stuff");
		$this->set('desc_for_layout', "Radio Airplay Reporter - Roots Music Report Radio Airplay Reporter Radio Station Profile");
	}
	
	

	function admin_edit($id = null) {
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for radio staff member'));
			$this->redirect(array('action' => 'admin_index'));
		}
		if ($this->RadioStaffMember->delete($id)) {
			$this->Session->setFlash(__('Radio staff member deleted'));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Radio staff member  was not deleted'));
		$this->redirect(array('action' => 'admin_index'));
	}

	function admin_create() {

	}
	
	function admin_verify($id = 0, $mode = NULL){
		if(!empty($mode)){
			if($mode == "approve"){
				$this->RadioStaffMember->approve($id);
				$this->RadioStaffMember->verify($id);
				$this->Session->setFlash('Radio Staff Approved');
				$this->redirect(array('controller' => 'RadioStaffMembers', 'action' => 'admin_view_all'));
			}
			if($mode == "deny"){
				$this->RadioStaffMember->deny($id);
				$this->RadioStaffMember->verify($id);
				$this->Session->setFlash('Radio Staff Denied');
				$this->redirect(array('controller' => 'RadioStaffMembers', 'action' => 'admin_view_all'));
			}		
		}
		$this->RadioStaffMember->Behaviors->attach('Containable');
		$results = $this->RadioStaffMember->find('first',array(
			'conditions' => array(
				'RadioStaffMember.id' => $id
			),
			'contain'=>array(
				'RadioStation',
			),
		));
		$this->set('staff', $results);
	}
	
	function main($id = 0){
		if(empty($id)){
			// redirect
		}
		
		$this->set('staff', $this->RadioStaffMember->findById($id));
		
	}

	function verify_all($verify = true, $approve = true){
		$conditions = array();
		$this->RadioStaffMember->recursive = -1;
		if($verify){
			$conditions['conditions']['verified'] = 0;
			$v = 1;
		} else {
			$conditions['conditions']['verified'] = 1;
			$v = 0;
		}
		if($approve){
			$conditions['conditions']['approved'] = 0;
			$a = 1;
		} else {
			$conditions['conditions']['approved'] = 1;
			$a = 0;
			
		}
		
		$results = $this->RadioStaffMember->find('all', array($conditions));
		$i = 0;
		foreach($results as $entry){
			$results[$i]['RadioStaffMember']['verified'] = $v;
			$results[$i]['RadioStaffMember']['approved'] = $a;
			$i++;
		}

		$saved = $this->RadioStaffMember->saveall($results, array('validate'=>false));
	}
	
	function finalise_all(){
		$conditions = array();
		$this->RadioStaffMember->recursive = -1;
		
		$results = $this->RadioStaffMember->find('all', array(
			'conditions' => array(
				'reported' => 1
			)
		));
		$i = 0;
		foreach($results as $entry){
			$results[$i]['RadioStaffMember']['playlist_finalised'] = 1;
			$i++;
		}

		$saved = $this->RadioStaffMember->saveall($results, array('validate'=>false));
	}
	
	function thanks($id = NULL){
		$this->loadModel('User');
		$this->set('user', $this->User->find('first', array('conditions'=>array('User.id'=>$id))));
	}
	
}

?>