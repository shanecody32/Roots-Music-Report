<?php

class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('User', 'UserDetail');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
		//$this->Auth->autoRedirect = false;
	}
	
	function login() {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		if($this->request->is('post')){
			if ($this->Auth->login()) {
				$user = $this->User->find('first', array(
					'conditions' => array(
						'username' => $this->request->data['User']['username'], 
					)
				));
				$this->User->Group->recursive = -1;
				$group = $this->User->Group->findById($user['User']['group_id']);
				$this->Session->write($group);
				$this->Cookie->write('login', $group, $encrypt = false, $expires = null);
				
				$aro = $this->Acl->Aro->find('first', array(
					'conditions' => array(
						'Aro.model' => 'Group',
						'Aro.foreign_key' => $user['User']['group_id'],
					),
				));
				$acos = $this->Acl->Aco->children();
				foreach($acos as $aco){
				$permission = $this->Acl->Aro->Permission->find('first', array(
					'conditions' => array(
						'Permission.aro_id' => $aro['Aro']['id'],
						'Permission.aco_id' => $aco['Aco']['id'],
					),
				));
				if(isset($permission['Permission']['id'])){
					if ($permission['Permission']['_create'] == 1 ||
						$permission['Permission']['_read'] == 1 ||
						$permission['Permission']['_update'] == 1 ||
						$permission['Permission']['_delete'] == 1) {
							$this->Session->write(
								'Auth.Permissions.'.$permission['Aco']['alias'],
								 true
							);
							if(!empty($permission['Aco']['parent_id'])){
								$parentAco = $this->Acl->Aco->find('first', array(
									'conditions' => array(
										'id' => $permission['Aco']['parent_id']
									)	
								));
								$this->Session->write(
									'Auth.Permissions.'.$permission['Aco']['alias']
									.'.'.$parentAco['Aco']['alias'], 
									true
								);
							}
						}
					}
				}
				if ($user['User']['activated'] == 0) {
					$this->Session->setFlash('Your account has not been activated yet!');
					$this->Auth->logout();
					$this->redirect('/users/login');
				} else {
					if(Controller::referer() == 'http://www.rootsmusicreport.com'.$this->here){
						$this->redirect(array('controller' => 'users', 'action' => 'index'));
					}
					return $this->redirect(Controller::referer());
					
				}
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'));
			}
		}
	}
	
	function index(){
		
		$this->layout = 'back-end';	
		$this->set('scripts',array('back-end'));
	}
	
	function logout(){
		$this->Session->delete('Auth');
		$this->Session->delete('Acl');
		$this->Session->delete('User');
		$this->Session->delete('Group');
		$this->Auth->logout();
		$this->Session->setFlash('You have been logged out.');
		$this->redirect('/users/login');
	}
	
	function account(){
			
	}
	
	function register($type = ''){
		if(!empty($this->request->data)){
			$type = $this->request->data['User']['type'];
		}
		if(!$type){
			$this->Session->setFlash(__('Invalid sign-up type'));
			$this->redirect(Controller::referer());
		}
	
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms', 'jquery.autocomplete'));
		
		if (!empty($this->request->data)) {
			$this->request->data['User']['username'] = $this->request->data['UserDetail']['email'];
			if($this->request->data['User']['type'] == 'radio'){
				$this->request->data['User']['group_id'] = 4;
			}
			if (!empty($this->request->data['UserAddress']['state'])) {
				$this->loadModel('State');
				$state = $this->State->findByName($this->request->data['UserAddress']['state']);
				if (!$state) {
					$state = $this->State->findByAbbrv($this->request->data['UserAddress']['state']);
					if (!$state) {
					   $state['State']['country_id'] = $this->request->data['UserAddress']['country_id'];
					   $state['State']['name'] = $this->request->data['UserAddress']['state'];
					   $state['State']['abbrv'] = '';
					   $state['State']['new'] = 1;
					   $this->State->save($state);
					   $state['State']['id'] = $this->State->getLastInsertID();
					}
				}
				if ($state) {
					$this->request->data['UserAddress']['state_id'] = $state['State']['id'];
				}
			}
			if ($this->request->data['UserAddress']['city']) {
				$this->loadModel('City');
				$city = $this->City->findByName($this->request->data['UserAddress']['city']);
				if ($city) {
					$this->request->data['UserAddress']['city_id'] = $city['City']['id'];
				} else {
					$cdata['City']['name'] = $this->request->data['UserAddress']['city'];
					if(!empty($this->request->data['UserAddress']['state_id'])){
						$cdata['City']['state_id'] = $this->request->data['UserAddress']['state_id'];
					}
					$cdata['City']['country_id'] = $this->request->data['UserAddress']['country_id'];
					$city = $this->City->save($cdata);
					$this->request->data['UserAddress']['city_id'] = $this->City->id;
				}
			}
			if ($this->request->data['UserAddress']['zip']) {
				$this->loadModel('PostalCode');
				$zip = $this->PostalCode->findByCode($this->request->data['UserAddress']['zip']);
				if ($zip) {
					$this->request->data['UserAddress']['postal_code_id'] = $zip['PostalCode']['id'];
				} else {
					$pdata['PostalCode']['code'] = $this->request->data['UserAddress']['zip'];
					$pdata['PostalCode']['city_id'] = $this->request->data['UserAddress']['city_id'];
					if(!empty($this->request->data['UserAddress']['state_id'])){
						$pdata['PostalCode']['state_id'] = $this->request->data['UserAddress']['state_id'];
					}
					$pdata['PostalCode']['country_id'] = $this->request->data['UserAddress']['country_id'];
					$zip = $this->PostalCode->save($pdata);
					$this->request->data['UserAddress']['postal_code_id'] = $this->PostalCode->id;
				}
			}
			if($this->User->saveAll($this->request->data)){
				$this->__sendActivationEmail($this->User->getLastInsertID());
				
				if($this->request->data['User']['type'] == 'radio'){
					$this->Session->setFlash('Your user account has been created. To become a reporter you must also complete a station application.');
					$this->redirect(array('controller' => 'RadioStations', 'action' => 'application', $this->User->getLastInsertID()));
				}
				if($this->request->data['User']['type'] == 'free'){
					$this->Session->setFlash('Your user account has been created. To become a reporter you must also complete a station application.');
					$this->redirect(array('controller' => 'Users', 'action' => 'thanks', $this->User->getLastInsertID()));
				}
				if($this->request->data['User']['type'] == 'silver'){
					$this->Session->setFlash('Your user account has been created. To become a reporter you must also complete a station application.');
					$this->redirect(array('controller' => 'Users', 'action' => 'payment', $this->User->getLastInsertID(), 'silver'));
				}
				$this->Session->setFlash('Your user account has been created. ');
				$this->redirect(array('controller' => 'Users', 'action' => 'thanks', $this->User->getLastInsertID()));
			}
		}
		$this->set('type', $type);	
		$this->loadModel('Country');
		$country = $this->Country->findById('225');
		$this->set(compact('country'));
		$countries = $this->Country->find('list');
		$this->set(compact('countries'));
	}
	
	function thanks($id = 0){
		if (!empty($id)){
			$this->User->id = $id;
			$this->User->read;
			$this->set('user', $this->User->findById($id));		
		}
	}
	
	/**
	 * Activates a user account from an incoming link
	 *
	 *  @param Int $user_id User.id to activate
	 *  @param String $in_hash Incoming Activation Hash from the email
	*/
	function activate($user_id = null, $in_hash = null) {
		$user = $this->User->findById($user_id);
		

		if ($user && ($in_hash == $this->User->getActivationHash($user)))
		{
			// Update the active flag in the database
			$data['User']['id'] = $user['User']['id'];
			$data['User']['activated'] = 1;
			$this->User->save($data);
			
			// Let the user know they can now log in!
			$this->Session->setFlash('Your account has been activated, please log in below');
			$this->redirect('login');
		}

		// Activation failed, render '/views/user/activate.ctp' which should tell the user.
	}
	
	function verify_email($id){
		$this->__sendActivationEmail($id);
		$this->set('user', $this->User->find('first', array('conditions'=>array('User.id'=>$id), 'contain'=>'UserDetail')));
	}
	
	function __sendActivationEmail($user_id) {
		$user = $this->User->findById($user_id);
		if ($user === false) {
			debug(__METHOD__." failed to retrieve User data for user.id: {$user_id}");
			return false;
		}
 
		// Set data for the "view" of the Email
		$this->set('activate_url', 'http://www.rootsmusicreport.com/rmr_test/users/activate/' . $user['User']['id'] . '/' . $this->User->getActivationHash($user));
		$this->set('user', $user);
 
		$this->Email->to = $user['UserDetail']['email'];
		$this->Email->subject = 'Roots Music Report - Please confirm your email address';
		$this->Email->from = 'noreply@rootsmusicreport.com';
		$this->Email->template = 'user_confirm';
		$this->Email->sendAs = 'both';   // you probably want to use both :)	
		return $this->Email->send();
	}
	
	function admin_add(){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if(!empty($this->request->data)){
			$this->request->data['User']['username'] = $this->request->data['UserDetail']['email'];
			if($this->User->saveAll($this->request->data)){
				$this->Session->setFlash(__('The User has been added.'));
			}
		}
		$this->set('group_opt', $this->User->Group->find('list'));
	}
	
	function admin_edit($id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!empty($this->request->data)) {
			if($this->User->save($this->request->data)){
				$this->Session->setFlash(__('The User has been saved.'));
			}
		}
		$this->set('group_opt', $this->User->Group->find('list'));
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
			$this->request->data['UserDetail']['email_check'] = $this->request->data['UserDetail']['email'];
		}
	}
	
	function admin_view_all(){
		$this->set('styles',array('tables'));
		
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_delete($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$user = $this->User->findById($id);
		if ($this->User->delete($id)) {
			$this->User->UserDetail->delete($user['UserDetail']['id']);
			$this->Session->setFlash(__('User Deleted'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'admin_view_all'));
	}
	
	function admin_view($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->set('user', $this->User->findById($id));
	}
	
	function admin_change_user_password($id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if ($this->request->is('post')) {
			$user = $this->User->findById($this->request->data['User']['id']);
			if(AuthComponent::password($this->request->data['User']['old_password']) == $user['User']['password']){
				if($this->User->save($this->request->data)){
					$this->Session->setFlash(__('The User has been saved.'));
				}
			} else {
				$this->Session->setFlash(__('Incorrect password'));
			}
		} 
		$this->set('group_opt', array(
			'artist'=>'Artist',
			'station'=>'Station', 
			'reporter'=>'Reporter', 
			'admin'=>'Administrator'
		));
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
			$this->request->data['User']['password'] = '';
		}
	
	}
	
	function logged_in(){}

	
	

}

?>