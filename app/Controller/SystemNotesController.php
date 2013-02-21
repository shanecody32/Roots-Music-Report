<?php

class SystemNotesController extends AppController {

	var $name = 'SystemNotes';
	
	
	function admin_add(){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if(!empty($this->request->data)){
			if($this->SystemNote->save($this->request->data)){
				$this->Session->setFlash(__('The system note has been added.'));
			}
		}
		$this->set('group_opt', array('all'=>'All', 'user'=>'Users', 'station'=>'Stations', 'reporter'=>'Reporters', 'admin'=>'Administrators'));
		$this->set('type_opt', array('maintenance'=>'System Maintenance', 'technical'=>'Technical', 'promotional'=>'Promotional'));
	}
	
	function admin_edit($id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if ($this->request->is('post')) {
			if($this->SystemNote->save($this->request->data)){
				$this->Session->setFlash(__('The system note has been saved.'));
			}
		}
		$this->set('group_opt', array('all'=>'All', 'user'=>'Users', 'station'=>'Stations', 'reporter'=>'Reporters', 'admin'=>'Administrators'));
		$this->set('type_opt', array('maintenance'=>'System Maintenance', 'technical'=>'Technical', 'promotional'=>'Promotional'));
		if (empty($this->request->data)) {
			$this->request->data = $this->SystemNote->read(null, $id);
		}
	}
	
	function admin_view_all(){
		$this->set('styles',array('tables'));
		
		$this->SystemNote->recursive = 0;
		$this->set('system_notes', $this->paginate());
	}

	function admin_delete($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for System Note'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		if ($this->SystemNote->delete($id)) {
			$this->Session->setFlash(__('System Note Deleted'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->Session->setFlash(__('System Note was not deleted'));
		$this->redirect(array('action' => 'admin_view_all'));
	}
	
	function admin_view($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for System Note'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->set('system_note', $this->SystemNote->findById($id));
	}

	
}

?>