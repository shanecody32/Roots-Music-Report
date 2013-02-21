<?php

class StatesController extends AppController {

	var $name = 'States';
		
	function admin_add(){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		if(!empty($this->request->data)){
			if($this->State->add($this->request->data['State'], array('name'))){
				$this->Session->setFlash(__('The State has been added.'));
			}
		}
		
		$this->set('countries', $this->State->Country->find('list'));

	}
	
	function admin_edit($id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid band id.'));
			$this->redirect($this->referer(), null, true);
		}
		
		if (!empty($this->request->data)) {
			$this->request->data['State']['new'] = 0;
			if($this->State->save($this->request->data)){
				$this->Session->setFlash(__('The State has been saved.'));
				$this->redirect($this->origReferer(), null, true);
			}
		}
		
		if (empty($this->request->data)) {
			$this->setReferer();
			$this->request->data = $this->State->read(null, $id);
		}
		$this->set('countries', $this->State->Country->find('list'));
	}
	
	function admin_view_all(){
		$this->set('styles',array('tables'));
		$this->set('states', $this->paginate());
		$this->set('page_limit', $this->paginate['limit']);	
	}

	function admin_delete($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for State'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		if ($this->State->delete($id)) {
			$this->Session->setFlash(__('State Deleted'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->Session->setFlash(__('State was not deleted'));
		$this->redirect(array('action' => 'admin_view_all'));
	}

}

?>