<?php

class ViolationsController extends AppController {

	var $name = 'Violations';
	
	
	function admin_add(){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if(!empty($this->request->data)){
			if($this->Violation->save($this->request->data)){
				$this->Session->setFlash(__('The Violation has been added.'));
			}
		}
		$this->set('group_opt', array(
			'user'=>'Users',
			'artist'=>'Artists',
			'station'=>'Stations', 
			'reporter'=>'Reporters', 
			'admin'=>'Administrators'
		));
		$this->set('type_opt', array(
			'warning'=>'Warning', 
			'error'=>'Error', 
			'critical'=>'Critical'
		));
	}
	
	function admin_edit($id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if ($this->request->is('post')) {
			if($this->Violation->save($this->request->data)){
				$this->Session->setFlash(__('The Violation has been saved.'));
			}
		}
		$this->set('group_opt', array(
			'user'=>'Users',
			'artist'=>'Artists',
			'station'=>'Stations', 
			'reporter'=>'Reporters', 
			'admin'=>'Administrators'
		));
		$this->set('type_opt', array(
			'warning'=>'Warning', 
			'error'=>'Error', 
			'critical'=>'Critical'
		));
		if (empty($this->request->data)) {
			$this->request->data = $this->Violation->read(null, $id);
		}
	}
	
	function admin_view_all(){
		$this->set('styles',array('tables'));
		
		$this->Violation->recursive = 0;
		$this->set('violations', $this->paginate());
	}

	function admin_delete($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Violation'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		if ($this->Violation->delete($id)) {
			$this->Session->setFlash(__('Violation Deleted'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->Session->setFlash(__('Violation was not deleted'));
		$this->redirect(array('action' => 'admin_view_all'));
	}
	
	function admin_view($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Violation'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->set('violation', $this->Violation->findById($id));
	}

}

?>